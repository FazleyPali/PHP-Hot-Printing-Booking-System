<?php require_once('../Connections/SistemTempahan.php'); ?>
<?php require_once('../Connections/SistemTempahan.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE tempahan SET kod_produk=%s, kuantiti=%s, jumlah_harga=%s, cara_bayaran=%s, status=%s, no_mykad_pekerja=%s, catatan=%s WHERE no_tempahan=%s",
                       GetSQLValueString($_POST['kod_produk'], "text"),
                       GetSQLValueString($_POST['kuantiti'], "int"),
                       GetSQLValueString($_POST['jumlah_harga'], "double"),
                       GetSQLValueString($_POST['cara_bayaran'], "text"),
                       GetSQLValueString($_POST['select'], "text"),
                       GetSQLValueString($_POST['no_mykad_pekerja'], "int"),
                       GetSQLValueString($_POST['catatan'], "text"),
                       GetSQLValueString($_POST['no_tempahan'], "int"));

  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  $Result1 = mysql_query($updateSQL, $SistemTempahan) or die(mysql_error());

  $updateGoTo = "senaraitempahan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
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

$maxRows_rsTempahan = 10;
$pageNum_rsTempahan = 0;
if (isset($_GET['pageNum_rsTempahan'])) {
  $pageNum_rsTempahan = $_GET['pageNum_rsTempahan'];
}
$startRow_rsTempahan = $pageNum_rsTempahan * $maxRows_rsTempahan;

$colname_rsTempahan = "-1";
if (isset($_GET['no_tempahan'])) {
  $colname_rsTempahan = $_GET['no_tempahan'];
}
mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsTempahan = sprintf("SELECT * FROM tempahan WHERE no_tempahan = %s", GetSQLValueString($colname_rsTempahan, "int"));
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
        <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="input">
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
                            
                            <table align="center" cellpadding="5" cellspacing="5">
                              <tr valign="baseline">
                                <td nowrap align="right">No. Tempahan:</td>
                                <td><?php echo $row_rsTempahan['no_tempahan']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">No. Mykad Pelanggan</td>
                                <td><?php echo $row_rsTempahan['no_mykad_pelanggan']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Kod Produk</td>
                                <td><input type="text" name="kod_produk" value="<?php echo htmlentities($row_rsTempahan['kod_produk'], ENT_COMPAT, 'utf-8'); ?>" size="44"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Tarikh Tempah</td>
                                <td><?php echo $row_rsTempahan['tarikh_tempah']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Kuantiti:</td>
                                <td><input type="text" name="kuantiti" value="<?php echo htmlentities($row_rsTempahan['kuantiti'], ENT_COMPAT, 'utf-8'); ?>" size="44"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Harga Seunit</td>
                                <td><input type="text" name="jumlah_harga" value="<?php echo htmlentities($row_rsTempahan['jumlah_harga'], ENT_COMPAT, 'utf-8'); ?>" size="44"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Cara Bayaran</td>
                                <td><input type="text" name="cara_bayaran" value="<?php echo htmlentities($row_rsTempahan['cara_bayaran'], ENT_COMPAT, 'utf-8'); ?>" size="44"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Catatan:</td>
                                <td><textarea name="catatan" cols="32" rows="5"><?php echo htmlentities($row_rsTempahan['catatan'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">No. Mykad Pekerja</td>
                                <td><input type="text" name="no_mykad_pekerja" value="<?php echo htmlentities($row_rsTempahan['no_mykad_pekerja'], ENT_COMPAT, 'utf-8'); ?>" size="44"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Status:</td>
                                <td><label for="select"></label>
                                <select name="select" id="select">
                                  <option value="Lulus">Lulus</option>
                                  <option value="Belum Diproses">Belum Diproses</option>
                                </select></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Kemaskini"></td>
                              </tr>
                            </table>
                            <input type="hidden" name="MM_update" value="form1">
                            <input type="hidden" name="no_tempahan" value="<?php echo $row_rsTempahan['no_tempahan']; ?>">
                            <br/>
                          </center>
                          </p>
                           <center>
                           </center>
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
mysql_free_result($rsTempahan);

mysql_free_result($rsPekerja);

mysql_free_result($rsTempahan);

mysql_free_result($rsProduk);

mysql_free_result($rsPelanggan);
?>
