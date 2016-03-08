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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tempahan SET no_mykad_pelanggan=%s, kod_produk=%s, tarikh_tempah=%s, kuantiti=%s, jumlah_harga=%s, cara_bayaran=%s, status=%s, no_mykad_pekerja=%s, catatan=%s, lakaran=%s WHERE no_tempahan=%s",
                       GetSQLValueString($_POST['no_mykad_pelanggan'], "text"),
                       GetSQLValueString($_POST['kod_produk'], "text"),
                       GetSQLValueString($_POST['tarikh_tempah'], "date"),
                       GetSQLValueString($_POST['kuantiti'], "int"),
                       GetSQLValueString($_POST['jumlah_harga'], "int"),
                       GetSQLValueString($_POST['cara_bayaran'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['no_mykad_pekerja'], "int"),
                       GetSQLValueString($_POST['catatan'], "text"),
                       GetSQLValueString($_POST['lakaran'], "text"),
                       GetSQLValueString($_POST['no_tempahan'], "int"));

  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  $Result1 = mysql_query($updateSQL, $SistemTempahan) or die(mysql_error());
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

mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsTempahan = "SELECT * FROM tempahan WHERE no_tempahan = no_tempahan";
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
                        <h2 align="center">Tempahan Berjaya.</h2>
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
  <p>&nbsp;</p>
*Tempahan telah berjaya. Sila buat pembayaran terlebih dahulu sebelum menyemak status tempahan.
</center>                          
<form method="get" name="form1" action="<?php echo $editFormAction; ?>">
                            <p>&nbsp;</p>
                         <center>
                          <table border="1" align="center" cellpadding="5" cellspacing="5">
                              <tr valign="baseline">
                                <td width="125" align="right" nowrap>No Tempahan:</td>
                                <td width="288"><?php echo $row_rsTempahan['no_tempahan']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">No. Kad Pengenalan :</td>
                                <td><?php echo $row_rsTempahan['no_mykad_pelanggan']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Kod Produk :</td>
                                <td><?php echo $row_rsTempahan['kod_produk']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Tarikh Tempah:</td>
                                <td><?php echo $row_rsTempahan['tarikh_tempah']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Kuantiti:</td>
                                <td><?php echo $row_rsTempahan['kuantiti']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Jumlah Perlu Bayar :</td>
                                <td>RM <?php echo $row_rsTempahan['jumlah_harga'] * $row_rsTempahan['kuantiti'] ; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Cara Bayaran :</td>
                                <td><?php echo $row_rsTempahan['cara_bayaran']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Catatan:</td>
                                <td><?php echo $row_rsTempahan['catatan']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Lakaran:</td>
                                <td><?php echo $row_rsTempahan['lakaran']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Status:</td>
                                <td><label for="textfield"></label>
                                *Sila semak kemudian</td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><img src="../images/check-icon.png" width="43" height="32"><img src="../images/button_cancel.png" width="35" height="35"></td>
                              </tr>
                            </table>
                            </center>
                          <input type="hidden" name="MM_update" value="form1">
                            <input type="hidden" name="no_tempahan" value="<?php echo $row_rsTempahan['no_tempahan']; ?>">
                          </form>
                            <p>&nbsp;</p>
                          
                          
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
