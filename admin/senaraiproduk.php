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

$maxRows_rsProduk = 10;
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

$query_rsPelanggan = "SELECT * FROM pelanggan ORDER BY nama ASC";
$rsPelanggan = mysql_query($query_rsPelanggan, $SistemTempahan) or die(mysql_error());
$row_rsPelanggan = mysql_fetch_assoc($rsPelanggan);
$totalRows_rsPelanggan = mysql_num_rows($rsPelanggan);
$query_rsPelanggan = "SELECT * FROM pelanggan ORDER BY nama ASC";
$rsPelanggan = mysql_query($query_rsPelanggan, $SistemTempahan) or die(mysql_error());
$row_rsPelanggan = mysql_fetch_assoc($rsPelanggan);
$totalRows_rsPelanggan = mysql_num_rows($rsPelanggan);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Senarai Produk</title>
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
	position:absolute;
	width:200px;
	height:91px;
	z-index:1;
	left: 110px;
	top: 35px;
}
#apDiv2 {
	position: absolute;
	left: 282px;
	top: 130px;
	width: 303px;
	height: 102px;
	z-index: 2;
	background-color: #999999;
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
        <form method="POST" name="form1" class="input">
          <div style="border:2px solid#001100">
            <div style="border:2px solid#660000">
              <div style="border:2px solid#c60202">
                <div style="border:2px solid#c60202">
                  <div style="border:2px solid#c60202">
                    <div style="border:2px solid#c60202">
                      <div style="border:2apx solid#003300">
                        <h2 align="center">Senarai Produk</h2>
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
Jumlah produk keseluruhan: <?php echo $totalRows_rsProduk ?>
<p>&nbsp;</p>
                            <table border="1">
                              <tr>
                                <th bgcolor="#999999">Kod Produk</th>
                                <th width="100" bgcolor="#999999">Nama Produk</th>
                                <th width="80" bgcolor="#999999">Harga</th>
                                <th width="80" bgcolor="#999999">Warna</th>
                                <th width="80" bgcolor="#999999">Saiz</th>
                                <th width="300" bgcolor="#999999">Huraian</th>
                                <th width="100" bgcolor="#999999">Gambar</th>
                                <th bgcolor="#999999">&nbsp;</th>
                                <th bgcolor="#999999">&nbsp;</th>
                                <th bgcolor="#999999">&nbsp;</th>
                              </tr>
                              <?php do { ?>
                                <tr>
                                  
                                  <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['kod_produk']; ?></td>
                                  <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['nama_produk']; ?></td>
                                  <td bgcolor="#FFFFFF">RM <?php echo $row_rsProduk['harga']; ?></td>
                                  <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['warna']; ?></td>
                                  <td bgcolor="#FFFFFF"><center><?php echo $row_rsProduk['saiz']; ?></center></td>
                                  <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['huraian']; ?></td>
                                  <td bgcolor="#FFFFFF"><table width="242" border="1">
                                    <tr>
                                      <td width="86"><img src="../_produk/<?php echo $row_rsProduk['gambar']; ?>" width="50" height="50" alt="df"></td>
                                      <td width="140"><?php echo $row_rsProduk['gambar']; ?></td>
                                    </tr>
                                    <tr>
                                      <td>&nbsp;</td>
                                      <td>&nbsp;</td>
                                    </tr>
                                  </table></td>
                                  <td bgcolor="#FFFFFF"><a href="butiranproduk.php?kod_produk=<?php echo $row_rsProduk['kod_produk']; ?>"><img src="images/Clipboard.png" width="30" height="29" alt="info"></a></td>
                                  <td bgcolor="#FFFFFF"><a href="kemaskiniproduk.php?kod_produk=<?php echo $row_rsProduk['kod_produk']; ?>"><img src="images/Edit.png" width="30" height="29"></a></td>
                                  <td bgcolor="#FFFFFF"><a href="padamproduk.php?kod_produk=<?php echo $row_rsProduk['kod_produk']; ?>" onClick="return confirm('Anda pasti untuk padam?')"><img src="images/Bin.png" width="30" height="29"></a></td>
                                </tr>
                                <?php } while ($row_rsProduk = mysql_fetch_assoc($rsProduk)); ?>
                            </table>
                            <?php if ($pageNum_rsProduk >= $totalPages_rsProduk) { // Show if last page ?>
                              <a href="<?php printf("%s?pageNum_rsProduk=%d%s", $currentPage, max(0, $pageNum_rsProduk - 1), $queryString_rsProduk); ?>"><img src="../Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/Arrow Right 1.png" width="40" height="40"></a>
                              <?php } // Show if last page ?>
 
<?php if ($pageNum_rsProduk == 0) { // Show if first page ?>
  <a href="<?php printf("%s?pageNum_rsProduk=%d%s", $currentPage, min($totalPages_rsProduk, $pageNum_rsProduk + 1), $queryString_rsProduk); ?>"><img src="../Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/Arrow Left 1.png" width="40" height="40"></a>
  <?php } // Show if first page ?>
<br/>
                          </center>
                            </p>
                           <center>
                             <table width="157" border="1" cellspacing="1" cellpadding="1" align="center">
                               <tr>
                                 <td width="71"><a href="tambahproduk.php"><img src="images/Button Add.png" alt="tambah" width="81" height="80"></a></td>
                                 <td width="116"><a href="cetak.php" target="_blank"><img src="images/Printer.png" width="81" height="80" alt="cetak"></a></td>
                               </tr>
                             </table>
                           </center></p>
                          <p>&nbsp;</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
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
?>
