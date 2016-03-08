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
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Produk</title>
<meta charset="utf-8">
<link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="css/style.css" type="text/css" media="all">
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
	position: absolute;
	width: 200px;
	height: 91px;
	z-index: 1;
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
                <li id="nav1"><a href="index.php">halaman<span>utama</span></a></li>
                <li id="nav6"><a href="logmasuk.php">log <span>masuk</span></a></li>
                <li id="nav2"><a href="pendaftaran.php" >pendaftaran<span>baru</span></a></li>
                <li id="nav3"><a href="produk.php" class="active">senarai<span>produk</span></a></li>
                <li id="nav4"><a href="carabayaran.php">cara<span>bayaran</span></a></li>
                <li id="nav5"><a href="hubungi.php">hubungi<span>kami</span></a></li>
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
                          <td><table >
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
                                      <td><a href="detailroduk.php?kod_produk=<?php echo $row_rsProduk['kod_produk']; ?>"><img src="_produk/<?php echo $row_rsProduk['gambar']; ?>" width="200" height="198" alt="<?php echo $row_rsProduk['nama_produk']; ?>"></a><br>
                                        <center><?php echo $row_rsProduk['nama_produk']; ?><br>
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
                            </table>
                         <br>
                         <?php if ($pageNum_rsProduk > 0) { // Show if not first page ?>
                           <a href="<?php printf("%s?pageNum_rsProduk=%d%s", $currentPage, max(0, $pageNum_rsProduk - 1), $queryString_rsProduk); ?>"><img src="Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/Arrow Right 2.png" width="50" height="50"></a>
                           <?php } // Show if not first page ?>                          </td>
                          <?php if ($pageNum_rsProduk == 0) { // Show if first page ?>
  <a href="<?php printf("%s?pageNum_rsProduk=%d%s", $currentPage, min($totalPages_rsProduk, $pageNum_rsProduk + 1), $queryString_rsProduk); ?>"><img src="Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/Arrow Left 2.png" width="50" height="50"></a>
  <?php } // Show if first page ?>
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
  <div class="main"> 
  
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
mysql_free_result($rsProduk);
?>
