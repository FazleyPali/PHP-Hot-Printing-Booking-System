<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}
?>
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

$colname_Recordset1 = "-1";
if (isset($_SESSION['nama'])) {
  $colname_Recordset1 = $_SESSION['nama'];
}
mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_Recordset1 = sprintf("SELECT * FROM pelanggan WHERE nama = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $SistemTempahan) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Halaman Utama</title>
<meta charset="utf-8">
<link rel="stylesheet" href="../css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="../css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="../css/style.css" type="text/css" media="all">
<script type="text/javascript" src="../js/jquery-1.6.js" ></script>
<script type="text/javascript" src="../js/cufon-yui.js"></script>
<script type="text/javascript" src="../js/cufon-replace.js"></script>
<script type="text/javascript" src="../js/Swis721_Cn_BT_400.font.js"></script>
<script type="text/javascript" src="../js/Swis721_Cn_BT_700.font.js"></script>
<script type="text/javascript" src="../js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="../js/tms-0.3.js"></script>
<script type="text/javascript" src="../js/tms_presets.js"></script>
<script type="text/javascript" src="../js/jcarousellite.js"></script>
<script type="text/javascript" src="../js/script.js"></script>
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
	height: 115px;
	z-index: 2;
	left: 110px;
	top: 35px;
}
#apDiv2 {
	position: absolute;
	width: 694px;
	height: 34px;
	z-index: 3;
	left: 381px;
	top: 168px;
}
#apDiv3 {
	position: absolute;
	width: 1167px;
	height: 50px;
	z-index: 4;
	left: -6px;
	top: 585px;
	background-color: #000000;
}
#apDiv4 {
	position: absolute;
	width: 235px;
	height: 37px;
	z-index: 3;
	left: 875px;
	top: 596px;
}
-->
</style>
</head>
<body id="page1">
<div class="body1">
  <div class="body2">
    <div class="main"> 
      <!-- header -->
      <header>
        <div class="wrapper">
          <nav>
            <div id="apDiv1"><img src="../images/logo.png" width="290" height="90" alt="LOGO"></div>
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
        <div class="wrapper">
          <div class="slider">
            <ul class="items">
              <li><img src="../images/img1.jpg" alt=""></li>
              <li><img src="../images/img2.jpg" alt=""></li>
              <li><img src="../images/img3.jpg" alt=""></li>
              <li><img src="../images/img4.jpg" alt=""></li>
            </ul>
          </div>
        </div>
      </header>
      <div class="ic">More Website Templates  at TemplateMonster.com!</div>
      <!-- header end--> 
    </div>
  </div>
</div>
<div class="body3">
  <div class="main"> 
    <!-- content -->
    <article id="content">
      <div class="wrapper"> 
        <p><img src="../images/stussy-las-vegas-haze-tshirts.jpg" alt="logo" width="300" height="224" class="articleImg">
        </p><p> Selamat datang <?php echo $_SESSION['nama']; ?><br>
          <br>
          Syarikat HOT Printing &amp; Souveniers merupakan  salah sebuah syarikat 100% milik bumiputera yang menjalankan aktiviti  perniagaan seperti menjahit dan membekal barangan tekstil serta cenderamata di  sekitar kawasan negeri Selangor. Syarikat ini telah ditubuhkan pada 13 Julai  2010 yang berdaftar di bawah Suruhanjaya Komunikasi &amp; Multimedia  (IP0328982-P). </p>
        <p>Kami menawarkan pelbagai produk untuk tempahan seperti t shirt, baju korporat (F1), jaket korporat, topi, bag serta pelbagai cenderahati korporat untuk kelab, persatuan,   sekolah, kolej, universiti serta organisasi swasta dan kerajaan.</p>
      </div>
    </article>
  </div>
</div>
<div class="main"> 
  <!-- footer -->
  <footer> Copyright Mohd Mazlan &amp; Hafizi @ Politeknik Sultan Idris Shah</footer>
  <!-- footer end --> 
</div>
<script type="text/javascript"> Cufon.now(); </script>
</body>
</html>
<?php
mysql_free_result($Recordset1);

mysql_free_result($rsPelanggan);

mysql_free_result($Recordset1);
?>
