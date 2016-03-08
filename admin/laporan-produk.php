<?php require_once('../Connections/SistemTempahan.php'); ?>
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

$maxRows_rsjumlahproduk = 20;
$pageNum_rsjumlahproduk = 0;
if (isset($_GET['pageNum_rsjumlahproduk'])) {
  $pageNum_rsjumlahproduk = $_GET['pageNum_rsjumlahproduk'];
}
$startRow_rsjumlahproduk = $pageNum_rsjumlahproduk * $maxRows_rsjumlahproduk;

mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsjumlahproduk = "SELECT t.kod_produk, p.nama_produk,  p.harga, count(t.kod_produk) FROM tempahan t,produk p WHERE t.kod_produk = p.kod_produk GROUP BY t. kod_produk ORDER BY count(t.kod_produk) desc";
$query_limit_rsjumlahproduk = sprintf("%s LIMIT %d, %d", $query_rsjumlahproduk, $startRow_rsjumlahproduk, $maxRows_rsjumlahproduk);
$rsjumlahproduk = mysql_query($query_limit_rsjumlahproduk, $SistemTempahan) or die(mysql_error());
$row_rsjumlahproduk = mysql_fetch_assoc($rsjumlahproduk);

if (isset($_GET['totalRows_rsjumlahproduk'])) {
  $totalRows_rsjumlahproduk = $_GET['totalRows_rsjumlahproduk'];
} else {
  $all_rsjumlahproduk = mysql_query($query_rsjumlahproduk);
  $totalRows_rsjumlahproduk = mysql_num_rows($all_rsjumlahproduk);
}
mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsjumlahproduk = "SELECT tempahan.kod_produk, produk.nama_produk, tempahan.jumlah_harga, count(tempahan.kod_produk) FROM tempahan, produk GROUP BY tempahan.kod_produk ORDER BY tempahan.kod_produk";
$rsjumlahproduk = mysql_query($query_rsjumlahproduk, $SistemTempahan) or die(mysql_error());
$row_rsjumlahproduk = mysql_fetch_assoc($rsjumlahproduk);
$totalRows_rsjumlahproduk = mysql_num_rows($rsjumlahproduk);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Senarai pekerja</title>
<meta charset="utf-8">
<link rel="stylesheet" href="../css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="../css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="../admin/css/style.css" type="text/css" media="all">
<script type="text/javascript" src="../js/jquery-1.6.js" ></script>
<script type="text/javascript" src="../js/cufon-yui.js"></script>
<script type="text/javascript" src="../js/cufon-replace.js"></script>
<script type="text/javascript" src="../js/Swis721_Cn_BT_400.font.js"></script>
<script type="text/javascript" src="../js/Swis721_Cn_BT_700.font.js"></script>
<script type="text/javascript" src="../js/tabs.js"></script><!--[if lt IE 9]>
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
<style type="text/css">
#apDiv3 {
	position: absolute;
	left: 856px;
	top: 449px;
	width: 262px;
	height: 32px;
	z-index: 2;
}
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
                        <h2 align="center">Laporan Tempahan Produk</h2>
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
                            <table width="100%" border="1" align="center">
                              <tr>
                                <td align="center" bgcolor="#999999"><h1>Kod Produk</h1></td>
                                <td align="center" bgcolor="#999999"><h1>Nama Produk</h1></td>
                                <td align="center" bgcolor="#999999"><h1>Harga Seunit</h1></td>
                                <td align="center" bgcolor="#999999"><h1>Bi. Produk Dijual</h1></td>
                              </tr>
                              <?php do { ?>
                                <tr>
                                  <td align="center" bgcolor="#FFFFFF"><?php echo $row_rsjumlahproduk['kod_produk']; ?></td>
                                  <td align="center" bgcolor="#FFFFFF"><?php echo $row_rsjumlahproduk['nama_produk']; ?></td>
                                  <td align="center" bgcolor="#FFFFFF"><?php echo $row_rsjumlahproduk['jumlah_harga']; ?></td>
                                  <td align="center" bgcolor="#FFFFFF"><?php echo $row_rsjumlahproduk['count(tempahan.kod_produk)']; ?></td>
                                </tr>
                                <?php } while ($row_rsjumlahproduk = mysql_fetch_assoc($rsjumlahproduk)); ?>
                            </table>
<br/>
                          </center>
                          </p>
                           <center>
                             <table width="218" border="1" cellspacing="1" cellpadding="1" align="center">
                               <tr>
                                
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
<table border="1">
  <tr>
    <td>kod_produk</td>
    <td>nama_produk</td>
    <td>harga</td>
    <td>count(t.kod_produk)</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?php echo $row_rsTempahan['count(t.kod_produk)']; ?></td>
  </tr>
</table>
<script>
$(document).ready(function() {
		tabs.init();
	})
</script>
</body>
</html>
<?php
mysql_free_result($rsjumlahproduk);
?>
