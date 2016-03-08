<?php require_once('../Connections/SistemTempahan.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "pekerja";
$MM_donotCheckaccess = "false";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../logmasukadmingagal.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php require_once('../Connections/SistemTempahan.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

if ((isset($_GET['no_mykad_pelanggan'])) && ($_GET['no_mykad_pelanggan'] != "")) {
  $deleteSQL = sprintf("DELETE FROM pelanggan WHERE no_mykad_pelanggan=%s",
                       GetSQLValueString($_GET['no_mykad_pelanggan'], "text"));

  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  $Result1 = mysql_query($deleteSQL, $SistemTempahan) or die(mysql_error());

  $deleteGoTo = "senaraipelanggan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO pelanggan (no_mykad_pelanggan, nama, alamat, no_telefon_pejabat, no_fax, no_telefon_bimbit, email, kata_laluan) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['no_mykad_pelanggan'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['no_telefon_pejabat'], "text"),
                       GetSQLValueString($_POST['no_fax'], "text"),
                       GetSQLValueString($_POST['no_telefon_bimbit'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['kata_laluan'], "text"));

  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  $Result1 = mysql_query($insertSQL, $SistemTempahan) or die(mysql_error());

  $insertGoTo = "senaraipelanggan(pekerja).php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_rsPelanggan = "-1";
if (isset($_GET['no_mykad_pelanggan'])) {
  $colname_rsPelanggan = $_GET['no_mykad_pelanggan'];
}
mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsPelanggan = sprintf("SELECT * FROM pelanggan WHERE no_mykad_pelanggan = %s ORDER BY nama ASC", GetSQLValueString($colname_rsPelanggan, "text"));
$rsPelanggan = mysql_query($query_rsPelanggan, $SistemTempahan) or die(mysql_error());
$row_rsPelanggan = mysql_fetch_assoc($rsPelanggan);
$totalRows_rsPelanggan = mysql_num_rows($rsPelanggan);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Pendaftaran</title>
<meta charset="utf-8">
<link rel="stylesheet" href="../css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="../css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="../admin/css/style.css" type="text/css" media="all">
<script type="text/javascript" src="../js/jquery-1.6.js" ></script>
<script type="text/javascript" src="../js/cufon-yui.js"></script>
<script type="text/javascript" src="../js/cufon-replace.js"></script>
<script type="text/javascript" src="../js/Swis721_Cn_BT_400.font.js"></script>
<script type="text/javascript" src="../js/Swis721_Cn_BT_700.font.js"></script>
<script type="text/javascript" src="../js/tabs.js"></script>
<!--[if lt IE 9]>
  	<script type="text/javascript" src="js/html5.js"></script>
	<style type="text/css">
		.bg{ behavior: url(js/PIE.htc); }
	</style>
  <![endif]-->
<!--[if lt IE 7]>
		<div style=' clear: both; text-align:center; position: relative;'>
			<a href="http://www.microsoft.com/windows/internet-explorer/default.aspx?ocid=ie6_countdown_bannercode"><img src="http://www.theie6countdown.com/images/upgrade.jpg" border="0"  alt="" /></a>
		</div>
	<![endif]-->
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	width:200px;
	height:91px;
	z-index:1;
	left: 110px;
	top: 35px;
}
-->
</style>
</head>
<body id="page3">
<div class="body1">
  <div class="body2">
    <div class="body5">
      <div class="main">
        <!-- header -->
        <header>
          <div class="wrapper">
            <nav>
              <div id="apDiv1"><img src="../images/logo.png" width="290" height="90" alt="logo"></div>
              <ul id="menu">
                <li id="nav1"><a href="indexpekerja.php">halaman<span>utama</span></a></li>
              <li id="nav6"><a href="senaraipelanggan(pekerja).php">senarai <span>pelanggan</span></a></li>
              <li id="nav3"><a href="produk.php">senarai<span>produk</span></a></li>
              <li id="nav4"><a href="senarai_tempahan.php">senarai<span>tempahan</span></a></li>
              <li id="nav2"><a href="cara_bayaran.php">cara<span>bayaran</span></a></li>
              <li id="nav7"><a href="../logout.php" onClick="return confirm('Anda pasti untuk keluar?')">log<span>keluar</span></a></span></li>
              </ul>
            </nav>
          </div>
        </header>
        <div class="ic">More Website Templates  at TemplateMonster.com!</div>
        <!-- header end-->
      </div>
    </div>
  </div>
</div>
<div class="body3">
  <div class="main">
    <!-- content -->
    <div class="body3">
      <div class="main">
        <div style="border:2px solid#001100">
          <div style="border:2px solid#660000">
            <div style="border:2px solid#c60202">
              <div style="border:2px solid#c60202">
                <div style="border:2px solid#c60202">
                  <div style="border:2px solid#c60202">
                    <div style="border:2apx solid#003300">
                      <h2 align="center">Tambah Pelanggan</h2>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div style="background-color: #999; border:2px solid#001100">
            <div style="border:2px solid#660000">
              <div style="border:2px solid#c60202">
                <div style="border:2px solid#c60202">
                  <div style="border:2apx solid#003300">
                    <div style="border:2px solid#001100">
                      <div style="background-color:#CCC">
                        <center>
                          <p>&nbsp;</p>
                          <img src="../Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/Button Add.png" width="128" height="128" alt="user">
                          <p>&nbsp;</p>
                        </center>
                       <center>
                         <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
                           <table align="center">
                             <tr valign="baseline">
                               <td nowrap align="right">No. Kad Pengenalan:</td>
                               <td><input type="text" name="no_mykad_pelanggan" value="" size="32"></td>
                              </tr>
                             <tr valign="baseline">
                               <td nowrap align="right">Nama:</td>
                               <td><input type="text" name="nama" value="" size="32"></td>
                              </tr>
                             <tr valign="baseline">
                               <td nowrap align="right">Alamat:</td>
                               <td><textarea name="alamat" cols="32" rows="5"></textarea></td>
                              </tr>
                             <tr valign="baseline">
                               <td nowrap align="right">No.Tel.Pejabat:</td>
                               <td><input type="text" name="no_telefon_pejabat" value="" size="32"></td>
                              </tr>
                             <tr valign="baseline">
                               <td nowrap align="right">No. Faks:</td>
                               <td><input type="text" name="no_fax" value="" size="32"></td>
                              </tr>
                             <tr valign="baseline">
                               <td nowrap align="right">No. Tel. Bimbit:</td>
                               <td><input type="text" name="no_telefon_bimbit" value="+6" size="32"></td>
                              </tr>
                             <tr valign="baseline">
                               <td nowrap align="right">Emel:</td>
                               <td><input type="text" name="email" value="" size="32"></td>
                              </tr>
                             <tr valign="baseline">
                               <td nowrap align="right">Kata Laluan:</td>
                               <td><input type="text" name="kata_laluan" value="" size="32"></td>
                              </tr>
                             <tr valign="baseline">
                               <td nowrap align="right">&nbsp;</td>
                               <td><input type="submit" value="Tambah"></td>
                              </tr>
                            </table>
                           <input type="hidden" name="MM_insert" value="form2">
                         </form>
                         <p>&nbsp;</p>
<p>&nbsp;</p>
                       </center>
                       
                       
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="main">
  <!-- footer -->
  <footer> Copyright by Mohd Mazlan &amp; Hafizi @ Politeknik Sultan Idris Shah</footer>
  <!-- footer end -->
</div>
<script type="text/javascript"> Cufon.now(); </script>
<script>
$(document).ready(function() {
		tabs.init();
	})
</script>
</body>
</html>
<?php
mysql_free_result($rsPelanggan);

mysql_free_result($rsPelanggan);
?>
