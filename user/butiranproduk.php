<?php require_once('../Connections/SistemTempahan.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
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

  $updateGoTo = "kemaskiniberjaya.php?no_mykad_pelanggan=" . $row_rsPelanggan['no_mykad_pelanggan'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO produk (kod_produk, nama_produk, harga, warna, saiz, huraian, gambar, id_categori) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['kod_produk'], "text"),
                       GetSQLValueString($_POST['nama_produk'], "text"),
                       GetSQLValueString($_POST['harga'], "int"),
                       GetSQLValueString($_POST['warna'], "text"),
                       GetSQLValueString($_POST['saiz'], "text"),
                       GetSQLValueString($_POST['huraian'], "text"),
                       GetSQLValueString($_POST['gambar'], "text"),
                       GetSQLValueString($_POST['id_categori'], "int"));

  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  $Result1 = mysql_query($insertSQL, $SistemTempahan) or die(mysql_error());
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
                <li id="nav6"><a href="kemaskiniprofil.php?no_mykad_pelanggan=<?php echo $_SESSION['no_mykad_pelanggan']; ?>">Kemaskini <span>Profil</span></a></li>
                <li id="nav2"><a href="produk.php" class="active">Produk<span>terkini</span></a></li>
                <li id="nav3"><a href="semak_tempahan.php">SEMAK<span>TEMPAHAN</span></a></li>
              <li id="nav4"><a href="cara_bayaran.php">CARA<span>BAYARAN</span></a></li>
                <li id="nav5"><a href="<?php echo $logoutAction ?>">log<span>keluar</span></a></li>
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
                         
                         
                          <form method="post" name="form1" action="<?php echo $editFormAction; ?>">
                           <center>
                             <table width="909" border="1" align="center">
                               <tr>
                                 <td width="899" bgcolor="#CCCCCC"><p>&nbsp;</p>
                                   <center>
                                     <table width="874" align="center">
                                       <tr>
                                         <td width="211" rowspan="6" bgcolor="#FFFFFF"><img src="../_produk/<?php echo $row_rsProduk['gambar']; ?>" alt="" width="400" height="400"></td>
                                         <td width="116" bgcolor="#FFFFFF">Nama Produk: </td>
                                         <td width="525" bgcolor="#FFFFFF"> <?php echo $row_rsProduk['nama_produk']; ?></td>
                                       </tr>
                                       <tr>
                                         <td bgcolor="#FFFFFF">Kod Produk: </td>
                                         <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['kod_produk']; ?></td>
                                       </tr>
                                       <tr>
                                         <td bgcolor="#FFFFFF">Harga: </td>
                                         <td bgcolor="#FFFFFF">RM <?php echo $row_rsProduk['harga']; ?></td>
                                       </tr>
                                       <tr>
                                         <td bgcolor="#FFFFFF">Warna:</td>
                                         <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['warna']; ?></td>
                                       </tr>
                                       <tr>
                                         <td bgcolor="#FFFFFF">Pilihan Saiz :</td>
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
                                         <a href="produk.php">                                         </a>
                                       <table border="1">
                                           <tr>
                                             <td align="center"><font color="#FFFFFF"><a href="produk.php"><img src="../Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/Arrow Right 1.png" width="70" height="70" alt="kembali"><br>
                                               Kembali
                                             </a></font></td>
                                             <td align="center"><a href="tempahan_bayaran.php?kod_produk=<?php echo $row_rsProduk['kod_produk']; ?>"><img src="../Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/Shopping Cart.png" width="70" height="70" alt="tempah"><br>
                                               Tempah
                                             </a></td>
                                           </tr>
                                         </table>
                                     </center>
                                   </font></td>
                               </tr>
                           </table>
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
