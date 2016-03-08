<?php require_once('Connections/SistemTempahan.php'); ?>
<?php require_once('Connections/SistemTempahan.php'); ?>
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['textfield'])) {
  $loginUsername=$_POST['textfield'];
  $password=$_POST['textfield2'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "user/indexuser.php";
  $MM_redirectLoginFailed = "logmasukusergagal.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  
  $LoginRS__query=sprintf("SELECT no_mykad_pelanggan, kata_laluan FROM pelanggan WHERE no_mykad_pelanggan=%s AND kata_laluan=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $SistemTempahan) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Halaman Utama</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
<script type="text/javascript" src="js/jquery-1.6.js" ></script>
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/cufon-replace.js"></script>
<script type="text/javascript" src="js/Swis721_Cn_BT_400.font.js"></script>
<script type="text/javascript" src="js/Swis721_Cn_BT_700.font.js"></script>
<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="js/tms-0.3.js"></script>
<script type="text/javascript" src="js/tms_presets.js"></script>
<script type="text/javascript" src="js/jcarousellite.js"></script>
<script type="text/javascript" src="js/script.js"></script><!--[if lt IE 9]>
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
	height:115px;
	z-index:2;
	left: 110px;
	top: 35px;
}
#apDiv2 {
	position:absolute;
	width:694px;
	height:34px;
	z-index:3;
	left: 381px;
	top: 168px;
}
#apDiv3 {
	position:absolute;
	width:1167px;
	height:50px;
	z-index:4;
	left: -6px;
	top: 585px;
	background-color: #000000;
}
#page1 .body3 .main #content .wrapper p {
	font-style: normal;
}
#apDiv4 {
	position:absolute;
	width:630px;
	height:25px;
	z-index:3;
	left: 722px;
	top: 548px;
}
#apDiv5 {
	position: absolute;
	left: 83px;
	top: 970px;
	width: 225px;
	height: 23px;
	z-index: 4;
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
            <div id="apDiv1"><img src="images/logo.png" width="290" height="90" alt="LOGO"></div>
            <ul id="menu">
              <li id="nav1"><a href="index.php" class="active">halaman<span>utama</span></a></li>
                <li id="nav6"><a href="logmasuk.php">log <span>masuk</span></a></li>
                <li id="nav2"><a href="pendaftaran.php" >pendaftaran<span>baru</span></a></li>
                <li id="nav3"><a href="produk.php" >senarai<span>produk</span></a></li>
                <li id="nav4"><a href="carabayaran.php" >cara<span>bayaran</span></a></li>
                <li id="nav5"><a href="hubungi.php">hubungi<span>kami</span></a></li>
            </ul>
          </nav>
        </div>
        <div class="wrapper">
          <div class="slider">
            <ul class="items">
              <li><img src="images/img1.jpg" alt=""></li>
              <li><img src="images/img2.jpg" alt=""></li>
              <li><img src="images/img3.jpg" alt=""></li>
              <li><img src="images/img4.jpg" alt=""></li>
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
        <p><img src="images/stussy-las-vegas-haze-tshirts.jpg" alt="logo" width="291" height="215" class="articleImg"> </p>
        <p>Syarikat HOT Printing &amp; Souveniers merupakan  salah sebuah syarikat 100% milik bumiputera yang menjalankan aktiviti  perniagaan seperti menjahit dan membekal barangan tekstil serta cenderamata di  sekitar kawasan negeri Selangor. Syarikat ini telah ditubuhkan pada 13 Julai  2010 yang berdaftar di bawah Suruhanjaya Komunikasi &amp; Multimedia  (IP0328982-P). </p>
        <p>Kami menawarkan pelbagai produk untuk tempahan seperti t shirt, baju korporat (F1), jaket korporat, topi, bag serta pelbagai cenderahati korporat untuk kelab, persatuan,   sekolah, kolej, universiti serta organisasi swasta dan kerajaan.</p>
      </div>
    </article>
  </div>
</div>
<div class="main">
  <!-- footer -->
  <footer> Copyright&copy; Mohd Mazlan &amp; Hafizi @ Politeknik Sultan Idris Shah</footer>
  <!-- footer end -->
</div>
<script type="text/javascript">
Cufon.now();
</script>
</body>
</html>
<?php
mysql_free_result($rsProduk);
?>
