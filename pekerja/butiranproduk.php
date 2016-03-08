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
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start(); 
}
?>
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

$maxRows_rsProduk = 12;
$pageNum_rsProduk = 0;
if (isset($_GET['pageNum_rsProduk'])) {
  $pageNum_rsProduk = $_GET['pageNum_rsProduk'];
}
$startRow_rsProduk = $pageNum_rsProduk * $maxRows_rsProduk;

$colname_rsProduk = "-1";
if (isset($_GET['kod_produk'])) {
  $colname_rsProduk = $_GET['kod_produk'];
}
mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsProduk = sprintf("SELECT * FROM produk WHERE kod_produk = %s", GetSQLValueString($colname_rsProduk, "text"));
$query_limit_rsProduk = sprintf("%s LIMIT %d, %d", $query_rsProduk, $startRow_rsProduk, $maxRows_rsProduk);
$rsProduk = mysql_query($query_limit_rsProduk, $SistemTempahan) or die(mysql_error());
$row_rsProduk = mysql_fetch_assoc($rsProduk);

if (isset($_GET['totalRows_rsProduk'])) {
  $totalRows_rsProduk = $_GET['totalRows_rsProduk'];
} else {
  $all_rsProduk = mysql_query($query_rsProduk);
  $totalRows_rsProduk = mysql_num_rows($all_rsProduk);
}
$totalPages_rsProduk = ceil($totalRows_rsProduk/$maxRows_rsProduk)-1;

mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsTempahan = "SELECT * FROM tempahan";
$rsTempahan = mysql_query($query_rsTempahan, $SistemTempahan) or die(mysql_error());
$row_rsTempahan = mysql_fetch_assoc($rsTempahan);
$totalRows_rsTempahan = mysql_num_rows($rsTempahan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Butiran Produk</title>
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
          <div style="border:2px solid#001100">
            <div style="border:2px solid#660000">
              <div style="border:2px solid#c60202">
                <div style="border:2px solid#c60202">
                  <div style="border:2apx solid#003300">
                    <div style="border:2px solid#001100">
                      <div style="background-color:#CCC">
                        <center>
                          <form method="post" name="form1">
                            <center>
                              <p>&nbsp;</p>
                              <table width="909" border="1" align="center">
                                <tr>
                                  <td width="899" bgcolor="#666666"><p>&nbsp;</p>
                                    <center>
                                      <table width="874" align="center">
                                        <tr>
                                          <td width="211" rowspan="6" bgcolor="#FFFFFF"><img src="../_produk/<?php echo $row_rsProduk['gambar']; ?>" alt="" width="400" height="400"></td>
                                          <td width="116" bgcolor="#FFFFFF">Nama Produk: </td>
                                          <td width="525" bgcolor="#FFFFFF"><?php echo $row_rsProduk['nama_produk']; ?></td>
                                        </tr>
                                        <tr>
                                          <td bgcolor="#FFFFFF">Kod Produk: </td>
                                          <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['kod_produk']; ?></td>
                                        </tr>
                                        <tr>
                                          <td bgcolor="#FFFFFF">Harga: </td>
                                          <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['harga']; ?></td>
                                        </tr>
                                        <tr>
                                          <td bgcolor="#FFFFFF">Warna:</td>
                                          <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['warna']; ?></td>
                                        </tr>
                                        <tr>
                                          <td bgcolor="#FFFFFF">Saiz:</td>
                                          <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['saiz']; ?></td>
                                        </tr>
                                        <tr>
                                          <td bgcolor="#FFFFFF">Huraian:</td>
                                          <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['huraian']; ?>
                                            <p>&nbsp;</p>
                                            <p>&nbsp;</p>
                                            <p>&nbsp;</p></td>
                                        </tr>
                                      </table>
                                    </center>
                                    <font color="#FFFFFF">
                                    <center>
                                      <br>
                                      <a href="produk.php">
                                      <input type="button" name="Kembali" id="Kembali" value="Kembali">
                                      </a> <a href="tempahan_bayaran.php?kod_produk=<?php echo $row_rsProduk['kod_produk']; ?>">
                                      <input type="button" name="button" id="button" value="Tempah">
                                      </a>
                                      <p>&nbsp;</p>
                                    </center>
                                    </font></td>
                                </tr>
                              </table>
                              <p>&nbsp;</p>
                            </center>
                          </form>
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
mysql_free_result($rsProduk);

mysql_free_result($rsTempahan);
?>
