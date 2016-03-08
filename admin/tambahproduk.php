<?php require_once('../Connections/SistemTempahan.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
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

$MM_restrictGoTo = "../logmasukadmin.php";
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

//start
if (file_exists("lakaran/" . $_FILES["gambar"]["name"]))
      {
      
      }
    else
      {
      move_uploaded_file($_FILES["gambar"]["tmp_name"],"lakaran/" . $_FILES["gambar"]["name"]);
      $image =  $_FILES["gambar"]["name"];
      }
//end

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO produk (kod_produk, nama_produk, harga, warna, saiz, huraian, gambar) VALUES (%s, %s, %s, %s, %s, %s, '$image')",
                       GetSQLValueString($_POST['kod_produk'], "text"),
                       GetSQLValueString($_POST['nama_produk'], "text"),
                       GetSQLValueString($_POST['harga'], "int"),
                       GetSQLValueString($_POST['select'], "text"),
                       GetSQLValueString($_POST['select2'], "text"),
                       GetSQLValueString($_POST['huraian'], "text"),
                       GetSQLValueString($_POST['gambar']["name"], "text"));

  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  $Result1 = mysql_query($insertSQL, $SistemTempahan) or die(mysql_error());

  $insertGoTo = "senaraiproduk.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Tambah produk</title>
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
	position: absolute;
	width: 200px;
	height: 91px;
	z-index: 1;
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
                      <h2 align="center">Tambah Produk</h2>
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
                      <img src="../Images/product_560.jpg" width="200" height="154" alt="user">
                        
                          <p>&nbsp;</p>
                        </center>
                        <center>
                          <form method="post" name="form1" action="<?php echo $editFormAction; ?>" enctype="multipart/form-data">
                            <table width="432" align="center" cellpadding="7" cellspacing="7">
                              <tr valign="baseline">
                                <td nowrap align="right">Kod Produk :</td>
                                <td><input type="text" name="kod_produk" value="" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Nama Produk :</td>
                                <td><input type="text" name="nama_produk" value="" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Harga:</td>
                                <td><input type="text" name="harga" value="" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Warna:</td>
                                <td><label for="select"></label>
                                  <select name="select" id="select">
                                    <option value="Black">Black</option>
                                    <option value="Navy Blue">Navy Blue</option>
                                    <option value="Red">Red</option>
                                    <option value="Orange">Orange</option>
                                    <option value="White">White</option>
                                    <option value="Yellow">Yellow</option>
                                    <option value="Blue">Blue</option>
                                    <option value="Pink">Pink</option>
                                    <option value="Green">Green</option>
                                    <option value="Grey">Grey</option>
                                  </select></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Saiz:</td>
                                <td><label for="select2"></label>
                                  <select name="select2" id="select2">
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="XXL">XXL</option>
                                  </select></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Huraian:</td>
                                <td><input type="text" name="huraian" value="" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Gambar:</td>
                                <td><input type="file" name="gambar" value="" size="32"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td>&nbsp;</td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Tambah" ></td>
                              </tr>
                            </table>
                            <input type="hidden" name="MM_insert" value="form1">
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
mysql_free_result($rsPelanggan);

mysql_free_result($rsPelanggan);
?>
