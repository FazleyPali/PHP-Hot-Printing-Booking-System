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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE produk SET nama_produk=%s, harga=%s, warna=%s, saiz=%s, huraian=%s, gambar=%s, id_categori=%s WHERE kod_produk=%s",
                       GetSQLValueString($_POST['nama_produk'], "text"),
                       GetSQLValueString($_POST['harga'], "int"),
                       GetSQLValueString($_POST['warna'], "text"),
                       GetSQLValueString($_POST['saiz'], "text"),
                       GetSQLValueString($_POST['huraian'], "text"),
                       GetSQLValueString($_POST['gambar'], "text"),
                       GetSQLValueString($_POST['id_categori'], "int"),
                       GetSQLValueString($_POST['kod_produk'], "text"));

  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  $Result1 = mysql_query($updateSQL, $SistemTempahan) or die(mysql_error());
}

$colname_rsProduk = "-1";
if (isset($_GET['kod_produk'])) {
  $colname_rsProduk = $_GET['kod_produk'];
}
mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsProduk = sprintf("SELECT * FROM produk WHERE kod_produk = %s", GetSQLValueString($colname_rsProduk, "text"));
$rsProduk = mysql_query($query_rsProduk, $SistemTempahan) or die(mysql_error());
$row_rsProduk = mysql_fetch_assoc($rsProduk);
$totalRows_rsProduk = mysql_num_rows($rsProduk);
?>
<?php require_once('Connections/SistemTempahan.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Produk</title>
<meta charset="utf-8">
<link rel="stylesheet" href="../css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="../css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="../admin/css/style.css" type="text/css" media="all">
<script type="text/javascript" src="js/jquery-1.6.js" ></script>
<script type="text/javascript" src="js/cufon-yui.js"></script>
<script type="text/javascript" src="js/cufon-replace.js"></script>
<script type="text/javascript" src="js/Swis721_Cn_BT_400.font.js"></script>
<script type="text/javascript" src="js/Swis721_Cn_BT_700.font.js"></script>
<script type="text/javascript" src="js/tabs.js"></script>
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
              <div id="apDiv1"><img src="images/logo.png" width="290" height="90" alt="logo"></div>
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
            <div style="border:2px solid#001100">
              <div style="border:2px solid#660000">
                <div style="border:2px solid#c60202">
                  <div style="border:2px solid#c60202">
                    <div style="border:2apx solid#003300">
                      <div style="border:2px solid#001100">
                        <div style="background-color:#CCC">
                          <p align="center">
  <center>
  </center>
                         
                      
                        <table width="909" border="1" align="center">
                          <tr>
                              
                              <td width="899" bgcolor="#666666"><p>&nbsp;</p>
                                <center><table width="874" align="center">
                                  <tr>
                                <td width="211" rowspan="6" bgcolor="#FFFFFF"><img src="_produk/<?php echo $row_rsProduk['gambar']; ?>" width="400" height="400"></td>
                                <td width="116" bgcolor="#FFFFFF">Nama_produk: </td>
                                <td width="525" bgcolor="#FFFFFF"><?php echo $row_rsProduk['nama_produk']; ?></td>
                              </tr>
                              <tr>
                                <td bgcolor="#FFFFFF">Kod_produk: </td>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['kod_produk']; ?></td>
                              </tr>
                              <tr>
                                <td bgcolor="#FFFFFF">Harga: </td>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['harga']; ?></td>
                              </tr>
                              <tr>
                                <td bgcolor="#FFFFFF">Warna:</td>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['warna']; ?></td>
                              </tr>
                              <tr>
                                <td bgcolor="#FFFFFF">Saiz:</td>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['saiz']; ?></td>
                              </tr>
                              <tr>
                                <td bgcolor="#FFFFFF">Huraian:</td>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsProduk['huraian']; ?>
                                  <p>&nbsp;</p>
                                  <p>&nbsp;</p>
                                  <p>&nbsp;</p></td>
                              </tr>
                        </table></center>
                          <font color="#FFFFFF"><center>
<a href="produk.php"><img src="images/player_back_button.png" width="69" height="69"></a><br>

                            *Sila log masuk untuk membuat tempahan. 
                          </center></font></td>
                          </tr>
                        </table>
                        <input type="hidden" name="MM_update" value="form2">
                        <input type="hidden" name="kod_produk" value="<?php echo $row_rsProduk['kod_produk']; ?>">
                        
                          </p>
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
