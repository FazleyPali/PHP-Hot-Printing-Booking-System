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

if ((isset($_GET['kod_produk'])) && ($_GET['kod_produk'] != "")) {
  $deleteSQL = sprintf("DELETE FROM produk WHERE kod_produk=%s",
                       GetSQLValueString($_GET['kod_produk'], "text"));

  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  $Result1 = mysql_query($deleteSQL, $SistemTempahan) or die(mysql_error());

  $deleteGoTo = "senaraiproduk.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

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
<title>Senarai pelanggan</title>
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
                <li id="nav2"><a href="senaraipekerja.php" class="active">senarai<span>pekerja</span></a></li>
                <li id="nav3"><a href="../produk.php">senarai<span>produk</span></a></li>
                <li id="nav4"><a href="../galeri.php">senarai<span>tempahan</span></a></li>
                <li id="nav5"><a href="../hubungi.php">laporan<span>syarikat</span></a></li>
                <li id="nav7">log<span>keluar</span></li>
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
                          <img src="images/Users.png" width="128" height="128" alt="user">
                           
                            <p>&nbsp;</p>
                            <table border="1">
                              <tr>
                                <th bgcolor="#999999">kod_produk</th>
                                <th width="100" bgcolor="#999999">nama_produk</th>
                                <th width="80" bgcolor="#999999">harga</th>
                                <th width="80" bgcolor="#999999">warna</th>
                                <th width="80" bgcolor="#999999">saiz</th>
                                <th width="300" bgcolor="#999999">huraian</th>
                                <th width="100" bgcolor="#999999">gambar</th>
                                <th bgcolor="#999999">&nbsp;</th>
                                <th bgcolor="#999999">&nbsp;</th>
                                <th bgcolor="#999999">&nbsp;</th>
                              </tr>
                              <tr>
                                <td bgcolor="#FFFFFF"></td>
                                <td bgcolor="#FFFFFF"></td>
                                <td bgcolor="#FFFFFF">RM </td>
                                <td bgcolor="#FFFFFF"></td>
                                <td bgcolor="#FFFFFF"></td>
                                <td bgcolor="#FFFFFF"></td>
                                <td bgcolor="#FFFFFF"><table width="126" border="1">
                                  <tr>
                                    <td><img width="100" height="100" alt="df"></td>
                                  </tr>
                                  <tr>
                                    <td>&nbsp;</td>
                                  </tr>
                                </table>
                                  <p>&nbsp;</p></td>
                                <td bgcolor="#FFFFFF"><a>detail</a></td>
                                <td bgcolor="#FFFFFF"><a>kemaskini</a></td>
                                <td bgcolor="#FFFFFF">padam</td>
                              </tr>
                            </table>
                          </center>
                          <p><br/>
                            </p>
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