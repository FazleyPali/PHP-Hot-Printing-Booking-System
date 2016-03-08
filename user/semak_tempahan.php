<?php require_once('../Connections/SistemTempahan.php'); ?>
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

$MM_restrictGoTo = "../index.php";
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

$colname_rsProduk = "-1";
if (isset($_GET['kod_produk'])) {
$colname_rsProduk = $_GET['kod_produk'];
}
mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsProduk = sprintf("SELECT * FROM produk WHERE kod_produk = %s", GetSQLValueString($colname_rsProduk, "text"));
$rsProduk = mysql_query($query_rsProduk, $SistemTempahan) or die(mysql_error());
$row_rsProduk = mysql_fetch_assoc($rsProduk);
$totalRows_rsProduk = mysql_num_rows($rsProduk);

$colname_rsTempahan = "-1";
if (isset($_SESSION['no_mykad_pelanggan'])) {
  $colname_rsTempahan = $_SESSION['no_mykad_pelanggan'];
}
mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsTempahan = sprintf("SELECT * FROM tempahan WHERE no_mykad_pelanggan LIKE %s", GetSQLValueString("%" . $colname_rsTempahan . "%", "text"));
$rsTempahan = mysql_query($query_rsTempahan, $SistemTempahan) or die(mysql_error());
$row_rsTempahan = mysql_fetch_assoc($rsTempahan);
$totalRows_rsTempahan = mysql_num_rows($rsTempahan);

//initialize the session
if (!isset($_SESSION)) {
session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Tempahan Berjaya</title>
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
	position:absolute;
	width:200px;
	height:91px;
	z-index:1;
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
                <li id="nav6"><a href="kemaskiniprofil.php?no_mykad_pelanggan=<?php echo $_SESSION['MM_Username']; ?>">Kemaskini <span>Profil</span></a></li>
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
                        <h2 align="center">Semak Tempahan</h2>
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
                        <div style="background-color:#CCC">
                          
                         

                   
                        
<center>
  <h6><br>
    Status tempahan untuk pelanggan:<br>
  </h6>
  <table border="1">
    <tr>
      <th bgcolor="#999999">Nama</th>
      <td bgcolor="#FFFFFF">:<?php echo $_SESSION['nama']; ?></td>
    </tr>
    <tr>
      <th bgcolor="#999999">No. Kad Pengenalan</th>
      <td bgcolor="#FFFFFF">:<?php echo $_SESSION['no_mykad_pelanggan']; ?></td>
    </tr>
</table>
<br>
    <br>
    Sila semak status tempahan anda dalam tempoh 3 hari dari tarikh tempahan dibuat.<br>Sila klik pautan <a href="cara_bayaran.php" class="link1">cara bayaran</a> untuk mengetahui cara bayaran. 
</center>                          
<form method="get" name="form1">
  <center>
    <table width="100%" border="3" cellpadding="2" cellspacing="2">
                            <tr>
                                <th width="70" bgcolor="#999999">No. Tempahan</th>
                                <th bgcolor="#999999">Kod Produk</th>
                                <th width="100" bgcolor="#999999">Tarikh Tempah</th>
                                <th width="50" bgcolor="#999999">Kuantiti</th>
                                <th width="80" bgcolor="#999999">Harga Produk</th>
                                <th bgcolor="#999999">Cara Bayaran</th>
                                <th width="80" bgcolor="#999999">Jumlah Perlu Bayar</th>
                                <th bgcolor="#999999">Lakaran</th>
                                <th width="32" height="32" bgcolor="#999999">Padam</th>
                                <th bgcolor="#999999">Status</th>
                            </tr>
                            <?php do { ?>
                                <tr>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['no_tempahan']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['kod_produk']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['tarikh_tempah']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['kuantiti']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center">RM <?php echo $row_rsTempahan['jumlah_harga']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['cara_bayaran']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center">RM <?php echo $row_rsTempahan['jumlah_harga'] * $row_rsTempahan['kuantiti'] ; ?></td>
                                  <td bgcolor="#FFFFFF"><center><img src="lakaran/<?php echo $row_rsTempahan['lakaran']; ?>" width="150" height="150"></center></td>
                                  <td bgcolor="#FFFFFF"><a href="padamtempahan.php?no_tempahan=<?php echo $row_rsTempahan['no_tempahan']; ?>" onClick="return confirm('Anda pasti untuk padam?')"><center><img src="../admin/images/Bin.png" width="40" height="40"></center></a></td>
                                  <td height="32" bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['status']; ?></td>
                                </tr>
                                <?php } while ($row_rsTempahan = mysql_fetch_assoc($rsTempahan)); ?>
                            </table>

                   </center>
</form><center>
 <img src="../Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/Arrow Right 1.png" width="70" height="70"> <a href="print_semak_tempahan.php" target="_blank"><img src="../Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/Printer.png" width="70" height="70"></a>
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

mysql_free_result($rsPelanggan);
?>
