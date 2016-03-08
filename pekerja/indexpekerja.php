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
<!DOCTYPE html>
<html lang="en">
<head>
<title>Halaman Utama</title>
<meta charset="utf-8">
<link rel="stylesheet" href="../pekerja/css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="../pekerja/css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="..//admin/css/style.css" type="text/css" media="all">
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
#page1 .body3 .main #content .wrapper p {
	font-style: normal;
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
              <li id="nav1"><a href="indexpekerja.php">halaman<span>utama</span></a></li>
              <li id="nav6"><a href="senaraipelanggan(pekerja).php">senarai <span>pelanggan</span></a></li>
              <li id="nav3"><a href="produk.php">senarai<span>produk</span></a></li>
              <li id="nav4"><a href="senarai_tempahan.php">senarai<span>tempahan</span></a></li>
              <li id="nav2"><a href="cara_bayaran.php">cara<span>bayaran</span></a></li>
              <li id="nav7"><a href="../logout.php" onClick="return confirm('Anda pasti untuk keluar?')">log<span>keluar</span></a></span></li>
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
        <p><img src="../images/Untitled-2.png" alt="logo" width="359" height="135" class="articleImg"> Selamat datang <?php echo $_SESSION['nama']; ?> </p>
        <p>Syarikat HOT Printing &amp; Souveniers merupakan  salah sebuah syarikat 100% milik bumiputera yang menjalankan aktiviti  perniagaan seperti menjahit dan membekal barangan tekstil serta cenderamata di  sekitar kawasan negeri Selangor. Syarikat ini telah ditubuhkan pada 13 Julai  2010 yang berdaftar di bawah Suruhanjaya Komunikasi &amp; Multimedia  (IP0328982-P).</p>
      </div>
    </article>
  </div>
</div>
<div class="main"> 
  <!-- footer -->
  <footer> Copyright&copy; Mohd Mazlan &amp; Hafizi @ Politeknik Sultan Idris Shah</footer>
  <!-- footer end --> 
</div>
<script type="text/javascript"> Cufon.now(); </script>
</body>
</html>