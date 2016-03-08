<?php require_once('../Connections/SistemTempahan.php'); ?>
<?php require_once('../Connections/SistemTempahan.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
//start
if (file_exists("../user/lakaran/" . $_FILES["gambar"]["name"]))
      {
     
      }
    else
      {
      move_uploaded_file($_FILES["gambar"]["tmp_name"],"../user/lakaran/" . $_FILES["gambar"]["name"]);
      $image =  $_FILES["gambar"]["name"];
      }
//end
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tempahan (no_mykad_pelanggan, kod_produk, tarikh_tempah, kuantiti, jumlah_harga, cara_bayaran, catatan, lakaran) VALUES (%s, %s, %s, %s, %s, %s, %s, '$image')",
                       GetSQLValueString($_POST['no_mykad_pelanggan'], "text"),
                       GetSQLValueString($_POST['kod_produk'], "text"),
                       GetSQLValueString($_POST['tarikh_tempah'], "date"),
                       GetSQLValueString($_POST['kuantiti'], "int"),
                       GetSQLValueString($_POST['jumlah_harga'], "double"),
                       GetSQLValueString($_POST['select'], "text"),
                       GetSQLValueString($_POST['catatan'], "text"),
                       GetSQLValueString($_POST['gambar']["name"], "text"));

  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  $Result1 = mysql_query($insertSQL, $SistemTempahan) or die(mysql_error());

  $insertGoTo = "senaraitempahan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
$query_rsTempahan = "SELECT no_tempahan, no_mykad_pelanggan, kod_produk, tarikh_tempah, kuantiti, cara_bayaran, status, catatan, lakaran FROM tempahan";
$rsTempahan = mysql_query($query_rsTempahan, $SistemTempahan) or die(mysql_error());
$row_rsTempahan = mysql_fetch_assoc($rsTempahan);
$totalRows_rsTempahan = mysql_num_rows($rsTempahan);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Tempahan</title>
<meta charset="utf-8">
<link rel="stylesheet" href="../css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="../css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<script type="text/javascript" src="../js/jquery-1.6.js" ></script>
<script type="text/javascript" src="../js/cufon-yui.js"></script>
<script type="text/javascript" src="../js/cufon-replace.js"></script>
<script type="text/javascript" src="../js/Swis721_Cn_BT_400.font.js"></script>
<script type="text/javascript" src="../js/Swis721_Cn_BT_700.font.js"></script>
<script type="text/javascript" src="../js/tabs.js"></script><script src="../SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

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
<link href="../SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
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
                <li id="nav1"><a href="indexadmin.php">halaman<span>utama</span></a></li>
              <li id="nav6"><a href="senaraipelanggan.php">senarai <span>pelanggan</span></a></li>
              <li id="nav2"><a href="senaraipekerja.php">senarai<span>pekerja</span></a></li>
              <li id="nav3"><a href="senaraiproduk.php">senarai<span>produk</span></a></li>
              <li id="nav4"><a href="senaraitempahan.php">senarai<span>tempahan</span></a></li>
              <li id="nav5"><a href="laporan.php">laporan<span>syarikat</span></a></li>
              <li id="nav7"><a href="../logout.php" onClick="return confirm('Anda pasti untuk keluar?')">log<span>keluar</span></a></li>
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
                      <h2 align="center">Tempahan</h2>
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
                        </center>
                        <p>&nbsp;</p>
                       <form name="form1" enctype="multipart/form-data" method="POST" action="<?php echo $editFormAction; ?>">
                          <center>
                            <p> 
                              <script>
function addDate(){
date = new Date();
var month = date.getMonth()+1;
var day = date.getDate();
var year = date.getFullYear();

if (document.getElementById('datetext').value == ''){
document.getElementById('datetext').value = year + '-' + month + '-' + day;
}
}
</script>
                              <center>
                              </center>
                            </p>
                            
                              <body onload="addDate();">
                            <table align="center" cellpadding="5" cellspacing="5">
                              <tr valign="baseline">
                                <td><table align="center" cellpadding="5" cellspacing="5">
                                  <tr valign="baseline">
                                    <td nowrap align="right">No Kad Pengenalan:</td>
                                    <td><input name="no_mykad_pelanggan" type="text" size="44" maxlength="12"></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td nowrap align="right">Kod Produk:</td>
                                    <td><input name="kod_produk" type="text" size="44"></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td nowrap align="right">Harga (RM):</td>
                                    <td><input type="text" name="jumlah_harga" size="44"></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td nowrap align="right">Tarikh Tempah:</td>
                                    <td><input name="tarikh_tempah" type="text" id="datetext" size="44"></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td nowrap align="right">Cara Bayaran:</td>
                                    <td><select name="select" id="select">
                                      <option value="Bayaran Tunai">Bayaran Tunai</option>
                                      <option value="Bayaran Bank">Bayaran Bank</option>
                                    </select></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td nowrap align="right">Kuantiti:</td>
                                    <td><span id="sprytextfield1">
                                      <input type="text" name="kuantiti" value="" size="44">
                                      * <span class="textfieldRequiredMsg">Sila isi.</span><span class="textfieldInvalidFormatMsg">Sila masukkan nombor.</span><span class="textfieldMinValueMsg">Tidak sah.</span></span></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td nowrap align="right">Lakaran:</td>
                                    <td><input name="gambar" type="file" id="gambar" size="44" maxlength="100"></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td nowrap align="right">Catatan:</td>
                                    <td><textarea name="catatan" cols="32" rows="5" id="catatan"></textarea></td>
                                  </tr>
                                  <tr valign="baseline">
                                    <td nowrap align="right">&nbsp;</td>
                                    <td><input type="submit" value="Tempah"></td>
                                  </tr>
                                </table></td>
                              </tr>
                            </table>
                          </center>
                          <input type="hidden" name="MM_insert" value="form1">
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
<p>&nbsp;</p>
<script>
$(document).ready(function() {
		tabs.init();
	})
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["blur"], minValue:1});
</script>
</body>
</html>
<?php
mysql_free_result($rsTempahan);

mysql_free_result($rsProduk);
?>
