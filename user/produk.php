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

$currentPage = $_SERVER["PHP_SELF"];

$colname_rsPelanggan = "-1";
if (isset($_SESSION['no_mykad_pelanggan'])) {
  $colname_rsPelanggan = $_SESSION['no_mykad_pelanggan'];
}
mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsPelanggan = sprintf("SELECT * FROM pelanggan WHERE no_mykad_pelanggan = %s", GetSQLValueString($colname_rsPelanggan, "text"));
$rsPelanggan = mysql_query($query_rsPelanggan, $SistemTempahan) or die(mysql_error());
$row_rsPelanggan = mysql_fetch_assoc($rsPelanggan);
$totalRows_rsPelanggan = mysql_num_rows($rsPelanggan);

$maxRows_rsProduk = 9;
$pageNum_rsProduk = 0;
if (isset($_GET['pageNum_rsProduk'])) {
  $pageNum_rsProduk = $_GET['pageNum_rsProduk'];
}
$startRow_rsProduk = $pageNum_rsProduk * $maxRows_rsProduk;

mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsProduk = "SELECT * FROM produk";
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

$queryString_rsProduk = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_rsProduk") == false && 
        stristr($param, "totalRows_rsProduk") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_rsProduk = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_rsProduk = sprintf("&totalRows_rsProduk=%d%s", $totalRows_rsProduk, $queryString_rsProduk);


?>



<!DOCTYPE html>
<html lang="en">
<head>
<title>Produk</title>
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
                        <h2 align="center">Produk</h2>
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
<table >
  <tr>
    <?php
$rsProduk_endRow = 0;
$rsProduk_columns = 3; // number of columns
$rsProduk_hloopRow1 = 0; // first row flag
do {
    if($rsProduk_endRow == 0  && $rsProduk_hloopRow1++ != 0) echo "<tr>";
   ?>
    <td><table width="200" border="1">
      <tr>
        <td><a href="butiranproduk.php?kod_produk=<?php echo $row_rsProduk['kod_produk']; ?>"><img src="../_produk/<?php echo $row_rsProduk['gambar']; ?>" width="200" height="200" alt="<?php echo $row_rsProduk['nama_produk']; ?>"></a>
          <center>
          <?php echo $row_rsProduk['nama_produk']; ?><br>

          RM <?php echo $row_rsProduk['harga']; ?></center></td>
      </tr>
    </table></td>
    <?php  $rsProduk_endRow++;
if($rsProduk_endRow >= $rsProduk_columns) {
  ?>
  </tr>
  <?php
 $rsProduk_endRow = 0;
  }
} while ($row_rsProduk = mysql_fetch_assoc($rsProduk));
if($rsProduk_endRow != 0) {
while ($rsProduk_endRow < $rsProduk_columns) {
    echo("<td>&nbsp;</td>");
    $rsProduk_endRow++;
}
echo("</tr>");
}?>
</table> <?php if ($pageNum_rsProduk > 0) { // Show if not first page ?>
                           <a href="<?php printf("%s?pageNum_rsProduk=%d%s", $currentPage, max(0, $pageNum_rsProduk - 1), $queryString_rsProduk); ?>"><img src="../Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/Arrow Right 2.png" width="40" height="40"></a>
                           <?php } // Show if not first page ?>                          </td>
                          <?php if ($pageNum_rsProduk == 0) { // Show if first page ?>
  <a href="<?php printf("%s?pageNum_rsProduk=%d%s", $currentPage, min($totalPages_rsProduk, $pageNum_rsProduk + 1), $queryString_rsProduk); ?>"><img src="../Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/Arrow Left 2.png" width="40" height="40"></a>
  <?php } // Show if first page ?>
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

mysql_free_result($rsProduk);
?>
