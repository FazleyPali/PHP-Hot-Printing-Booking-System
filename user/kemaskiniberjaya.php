<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "pelanggan";
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

$MM_restrictGoTo = "../logmasukusergagal.php";
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
//initialize the session
if (!isset($_SESSION)) {
  session_start();
 
 
}?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pelanggan SET nama=%s, alamat=%s, no_telefon_pejabat=%s, no_fax=%s, no_telefon_bimbit=%s, email=%s, kata_laluan=%s WHERE no_mykad_pelanggan=%s",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['no_telefon_pejabat'], "text"),
                       GetSQLValueString($_POST['no_fax'], "text"),
                       GetSQLValueString($_POST['no_telefon_bimbit'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['kata_laluan'], "text"),
                       GetSQLValueString($_POST['no_mykad_pelanggan'], "text"));

  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  $Result1 = mysql_query($updateSQL, $SistemTempahan) or die(mysql_error());

  $updateGoTo = "kemaskiniberjaya.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE pelanggan SET nama=%s, alamat=%s, no_telefon_pejabat=%s, no_fax=%s, no_telefon_bimbit=%s, email=%s, kata_laluan=%s WHERE no_mykad_pelanggan=%s",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['no_telefon_pejabat'], "text"),
                       GetSQLValueString($_POST['no_fax'], "text"),
                       GetSQLValueString($_POST['no_telefon_bimbit'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['kata_laluan'], "text"),
                       GetSQLValueString($_POST['no_mykad_pelanggan'], "text"));

  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  $Result1 = mysql_query($updateSQL, $SistemTempahan) or die(mysql_error());
}

$colname_rsPelanggan = "-1";
if (isset($_SESSION['no_mykad_pelanggan'])) {
  $colname_rsPelanggan = $_SESSION['no_mykad_pelanggan'];
}
mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsPelanggan = sprintf("SELECT * FROM pelanggan WHERE no_mykad_pelanggan = %s", GetSQLValueString($colname_rsPelanggan, "text"));
$rsPelanggan = mysql_query($query_rsPelanggan, $SistemTempahan) or die(mysql_error());
$row_rsPelanggan = mysql_fetch_assoc($rsPelanggan);
$totalRows_rsPelanggan = mysql_num_rows($rsPelanggan);

//initialize the session
if (!isset($_SESSION)) {
  session_start(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Kemaskini Berjaya</title>
<meta charset="utf-8">
<link rel="stylesheet" href="../css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="../css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="../css/style.css" type="text/css" media="all">
<script type="text/javascript" src="../js/jquery-1.6.js" ></script>
<script type="text/javascript" src="../js/cufon-yui.js"></script>
<script type="text/javascript" src="../js/cufon-replace.js"></script>
<script type="text/javascript" src="../js/Swis721_Cn_BT_400.font.js"></script>
<script type="text/javascript" src="../js/Swis721_Cn_BT_700.font.js"></script>
<script type="text/javascript" src="../js/tabs.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
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
	position: absolute;
	width: 200px;
	height: 91px;
	z-index: 1;
	left: 110px;
	top: 35px;
}
#page3 .body3 .main .body3 .main .input div div div div div div div div center b {
	text-align: left;
}
#page3 .body3 .main .body3 .main .input div div div div div div div div center p strong {
	text-align: left;
}
#page3 .body3 .main .body3 .main .input div div div div div div div div {
}
#page3 .body3 .main .body3 .main .input div div div div div div div div {
}
-->
</style>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
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
                 <li id="nav1"><a href="indexuser.php">halaman<span>utama</span></a></li>
             <li id="nav6"><a href="kemaskiniprofil.php?no_mykad_pelanggan=<?php echo $_SESSION['MM_Username']; ?>"class="active">Kemaskini<span>Profil</span></a></li>
              <li id="nav2"><a href="produk.php">senarai<span>produk</span></a></li>
              <li id="nav3"><a href="semak_tempahan.php">SEMAK<span>TEMPAHAN</span></a></li>
              <li id="nav4"><a href="cara_bayaran.php">CARA<span>BAYARAN</span></a></li>
              <li id="nav5"><a href="../logout.php" onClick="return confirm('Anda pasti untuk keluar?')">log<span>keluar</span></a><</span></li>
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
                      <h2 align="center">Kemaskini Berjaya</h2>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div style="border:2px solid#001100">
            <div style="border:2px solid#660000">
              <div style="border:2px solid#c60202">
                <div style="border:2px solid#c60202">
                  <div style="border:2apx solid#003300">
                    <div style="border:2px solid#001100">
                      <div style="background-color:#CCC"><br>
                        <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                          <center>
                            <table border="1" align="center">
                              <tr valign="baseline">
                                <th width="156" align="right" nowrap bgcolor="#FFFFFF">No. Kad Pengenalan :</th>
                                <td width="275" bgcolor="#FFFFFF"><?php echo $row_rsPelanggan['no_mykad_pelanggan']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <th align="right" nowrap bgcolor="#FFFFFF">Nama:</th>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsPelanggan['nama']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <th height="64" align="right" nowrap bgcolor="#FFFFFF">Alamat:</th>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsPelanggan['alamat']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <th align="right" nowrap bgcolor="#FFFFFF">No. Tel. Pejabat :</th>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsPelanggan['no_telefon_pejabat']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <th align="right" nowrap bgcolor="#FFFFFF">No. Faks:</th>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsPelanggan['no_fax']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <th align="right" nowrap bgcolor="#FFFFFF">No. Tel. Bimbit :</th>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsPelanggan['no_telefon_bimbit']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <th align="right" nowrap bgcolor="#FFFFFF">Email:</th>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsPelanggan['email']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <th align="right" nowrap bgcolor="#FFFFFF">Kata Laluan :</th>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsPelanggan['kata_laluan']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td align="right" nowrap bgcolor="#CCCCCC">&nbsp;</td>
                                <td bgcolor="#CCCCCC"><a href="indexuser.php"><br>
                                <img src="../Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/Home.png" width="50" height="50" alt="Kembali"></a></td>
                              </tr>
                            </table>
                          </center>
                          <input type="hidden" name="MM_update" value="form1">
                          <input type="hidden" name="no_mykad_pelanggan" value="<?php echo $row_rsPelanggan['no_mykad_pelanggan']; ?>">
                      </form>
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
?>
