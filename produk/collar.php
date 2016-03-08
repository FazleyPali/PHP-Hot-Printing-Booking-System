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

$maxRows_rsKategori = 9;
$pageNum_rsKategori = 0;
if (isset($_GET['pageNum_rsKategori'])) {
  $pageNum_rsKategori = $_GET['pageNum_rsKategori'];
}
$startRow_rsKategori = $pageNum_rsKategori * $maxRows_rsKategori;

mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsKategori = "SELECT * FROM categori";
$query_limit_rsKategori = sprintf("%s LIMIT %d, %d", $query_rsKategori, $startRow_rsKategori, $maxRows_rsKategori);
$rsKategori = mysql_query($query_limit_rsKategori, $SistemTempahan) or die(mysql_error());
$row_rsKategori = mysql_fetch_assoc($rsKategori);

if (isset($_GET['totalRows_rsKategori'])) {
  $totalRows_rsKategori = $_GET['totalRows_rsKategori'];
} else {
  $all_rsKategori = mysql_query($query_rsKategori);
  $totalRows_rsKategori = mysql_num_rows($all_rsKategori);
}
$totalPages_rsKategori = ceil($totalRows_rsKategori/$maxRows_rsKategori)-1;
?>
<?php require_once('../Connections/SistemTempahan.php'); ?>
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
              <div id="apDiv1"><img src="../images/logo.png" width="290" height="90" alt="logo"></div>
              <ul id="menu">
                <li id="nav1"><a href="../index.php">halaman<span>utama</span></a></li>
                <li id="nav6"><a href="../logmasuk.php">log <span>masuk</span></a></li>
                <li id="nav2"><a href="../pendaftaran.php" class="active">pendaftaran<span>baru</span></a></li>
                <li id="nav3"><a href="../produk.php">produk<span>popular</span></a></li>
                <li id="nav4"><a href="../galeri.php">galeri<span>gambar</span></a></li>
                <li id="nav5"><a href="../hubungi.php">hubungi<span>kami</span></a></li>
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
                        <h2 align="center"><b>Produk</b> </h2>
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
                          <p align="center">
  <center>
  </center>
                         
                        <center>
                          <table >
                            <tr>
                              <?php
$rsKategori_endRow = 0;
$rsKategori_columns = 3; // number of columns
$rsKategori_hloopRow1 = 0; // first row flag
do {
    if($rsKategori_endRow == 0  && $rsKategori_hloopRow1++ != 0) echo "<tr>";
   ?>
                              <td><table width="200" border="1" align="center">
                                <tr>
                                  <td bgcolor="#FFFFFF"><img src="images/kategori/<?php echo $row_rsKategori['gambar_categori']; ?>" width="200" height="181" alt="<?php echo $row_rsKategori['nama_categori']; ?>"></td>
                                </tr>
                                <tr>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsKategori['nama_categori']; ?></td>
                                </tr>
                              </table></td>
                              <?php  $rsKategori_endRow++;
if($rsKategori_endRow >= $rsKategori_columns) {
  ?>
                            </tr>
                            <?php
 $rsKategori_endRow = 0;
  }
} while ($row_rsKategori = mysql_fetch_assoc($rsKategori));
if($rsKategori_endRow != 0) {
while ($rsKategori_endRow < $rsKategori_columns) {
    echo("<td>&nbsp;</td>");
    $rsKategori_endRow++;
}
echo("</tr>");
}?>
                          </table>
                          <p align="center"><br/>
                  </p>
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
mysql_free_result($rsKategori);

mysql_free_result($rsProduk);
?>
