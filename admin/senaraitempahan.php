<?php require_once('../Connections/SistemTempahan.php'); ?>
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

$maxRows_rsPekerja = 10;
$pageNum_rsPekerja = 0;
if (isset($_GET['pageNum_rsPekerja'])) {
  $pageNum_rsPekerja = $_GET['pageNum_rsPekerja'];
}
$startRow_rsPekerja = $pageNum_rsPekerja * $maxRows_rsPekerja;

mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsPekerja = "SELECT * FROM pekerja";
$query_limit_rsPekerja = sprintf("%s LIMIT %d, %d", $query_rsPekerja, $startRow_rsPekerja, $maxRows_rsPekerja);
$rsPekerja = mysql_query($query_limit_rsPekerja, $SistemTempahan) or die(mysql_error());
$row_rsPekerja = mysql_fetch_assoc($rsPekerja);

if (isset($_GET['totalRows_rsPekerja'])) {
  $totalRows_rsPekerja = $_GET['totalRows_rsPekerja'];
} else {
  $all_rsPekerja = mysql_query($query_rsPekerja);
  $totalRows_rsPekerja = mysql_num_rows($all_rsPekerja);
}
$totalPages_rsPekerja = ceil($totalRows_rsPekerja/$maxRows_rsPekerja)-1;

$maxRows_rsTempahan = 10;
$pageNum_rsTempahan = 0;
if (isset($_GET['pageNum_rsTempahan'])) {
  $pageNum_rsTempahan = $_GET['pageNum_rsTempahan'];
}
$startRow_rsTempahan = $pageNum_rsTempahan * $maxRows_rsTempahan;

mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsTempahan = "SELECT * FROM tempahan ORDER BY tarikh_tempah DESC";
$query_limit_rsTempahan = sprintf("%s LIMIT %d, %d", $query_rsTempahan, $startRow_rsTempahan, $maxRows_rsTempahan);
$rsTempahan = mysql_query($query_limit_rsTempahan, $SistemTempahan) or die(mysql_error());
$row_rsTempahan = mysql_fetch_assoc($rsTempahan);

if (isset($_GET['totalRows_rsTempahan'])) {
  $totalRows_rsTempahan = $_GET['totalRows_rsTempahan'];
} else {
  $all_rsTempahan = mysql_query($query_rsTempahan);
  $totalRows_rsTempahan = mysql_num_rows($all_rsTempahan);
}
$totalPages_rsTempahan = ceil($totalRows_rsTempahan/$maxRows_rsTempahan)-1;

mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsProduk = "SELECT * FROM produk";
$rsProduk = mysql_query($query_rsProduk, $SistemTempahan) or die(mysql_error());
$row_rsProduk = mysql_fetch_assoc($rsProduk);
$totalRows_rsProduk = mysql_num_rows($rsProduk);

mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsPelanggan = "SELECT * FROM pelanggan";
$rsPelanggan = mysql_query($query_rsPelanggan, $SistemTempahan) or die(mysql_error());
$row_rsPelanggan = mysql_fetch_assoc($rsPelanggan);
$totalRows_rsPelanggan = mysql_num_rows($rsPelanggan);
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
<title>Senarai Tempahan</title>
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
                        <h2 align="center">Senarai Tempahan</h2>
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
                            <table border="1" align="center" id="address">
                              <tr>
                                <th height="47" bgcolor="#999999">No Tempahan</th>
                                <th bgcolor="#999999">No. Kad Pengenalan</th>
                                <th bgcolor="#999999">Kod Produk</th>
                                <th bgcolor="#999999">Tarikh Tempah</th>
                                <th bgcolor="#999999">Kuantiti</th>
                                <th bgcolor="#999999"> Harga Seunit</th>
                                <th bgcolor="#999999">Jumlah Perlu Bayar</th>
                                <th bgcolor="#999999">Cara Bayaran</th>
                                <th bgcolor="#999999">Catatan</th>
                                <th bgcolor="#999999">No. Mykad Pekerja</th>
                                <th bgcolor="#999999">Lakaran</th>
                                <th bgcolor="#999999">Status</th>
                                <th bgcolor="#999999">&nbsp;</th>
                                <th bgcolor="#999999">&nbsp;</th>
                              </tr>
                              <?php do { ?>
                                <tr>
                                  <td height="38" bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['no_tempahan']; ?></td>
                                  <td bgcolor="#FFFFFF"><?php echo $row_rsTempahan['no_mykad_pelanggan']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center"><a href="butiranproduk.php?kod_produk=<?php echo $row_rsTempahan['kod_produk']; ?>"></a><a href="butiranproduk.php?kod_produk=<?php echo $row_rsTempahan['kod_produk']; ?>"><?php echo $row_rsTempahan['kod_produk']; ?></a></td>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['tarikh_tempah']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['kuantiti']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center">RM <?php echo $row_rsTempahan['jumlah_harga']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center">RM <?php echo $row_rsTempahan['jumlah_harga'] * $row_rsTempahan['kuantiti']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['cara_bayaran']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['catatan']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['no_mykad_pekerja']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center"><a href="../user/lakaran/<?php echo $row_rsTempahan['lakaran']; ?>"><img src="../user/lakaran/<?php echo $row_rsTempahan['lakaran']; ?>" width="100" height="100"></a></td>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['status']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center"><a href="kemaskinitempahan.php?no_tempahan=<?php echo $row_rsTempahan['no_tempahan']; ?>"><img src="images/Edit.png" width="29" height="29"></a></td>
                                  <td bgcolor="#FFFFFF" align="center"><a href="padamtempahan.php?no_tempahan=<?php echo $row_rsTempahan['no_tempahan']; ?>" onClick="return confirm('Anda pasti untuk padam?')"><img src="images/Bin.png" width="30" height="29"></a></td>
                                </tr>
                                <?php } while ($row_rsTempahan = mysql_fetch_assoc($rsTempahan)); ?>
                            </table>
                            <br/>
                          </center>
                          </p>
                          <center>
                            <table width="157" border="1" cellspacing="1" cellpadding="1" align="center">
                              <tr>
                                <td width="71"><a href="tambahtempahan.php"><img src="images/Button Add.png" alt="tambah" width="81" height="80"></a></td>
                                <td width="116">&nbsp;</td>
                              </tr>
                            </table>
                          </center>
                          </p>
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
mysql_free_result($rsPekerja);

mysql_free_result($rsTempahan);

mysql_free_result($rsProduk);

mysql_free_result($rsPelanggan);
?>
