<?php require_once('../Connections/SistemTempahan.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "admin";
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

$MM_restrictGoTo = "../logmasukadmin.php";
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
<script src="../SpryAssets/SpryTooltip.js" type="text/javascript"></script>

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
<link href="../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css">
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
<div id="apDiv3">
  <form name="form2" method="get" action="senaraipekerja2.php">
    <label for="ic">Carian : </label>
    <input type="text" name="ic" id="ic">
    <input type="submit" name="button" id="button" value="Carian">
  </form>
</div>
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
                        <h2 align="center">Senarai Pekerja</h2>
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
                          <img src="../Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/User.png" width="128" height="128" alt="user"><br/>
                          </center>
                          <table width="100%" border="1">
                            <tr>
                              <th width="100" bgcolor="#999999">No Mykad Pekerja</th>
                              <th width="180" bgcolor="#999999">Nama</th>
                              <th width="200" bgcolor="#999999">Alamat</th>
                              <th width="100" bgcolor="#999999">Email</th>
                              <th width="70" bgcolor="#999999">Jawatan</th>
                              <th width="80" bgcolor="#999999">Kata Laluan</th>
                              <td width="30" bgcolor="#999999">&nbsp;</td>
                              <td width="30" bgcolor="#999999">&nbsp;</td>
                            </tr>
                            <?php do { ?>
                              <tr>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsPekerja['no_mykad_pekerja']; ?></td>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsPekerja['nama']; ?></td>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsPekerja['alamat']; ?></td>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsPekerja['email']; ?></td>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsPekerja['jawatan']; ?></td>
                                <td bgcolor="#FFFFFF"><?php echo $row_rsPekerja['kata_laluan']; ?></td>
                                <td bgcolor="#FFFFFF"><a href="kemaskinipekerja.php?no_mykad_pekerja=<?php echo $row_rsPekerja['no_mykad_pekerja']; ?>"><img src="images/Edit.png" alt="edit" width="29" height="30" id="sprytrigger1"></a></td>
                                <td bgcolor="#FFFFFF"><a href="padampekerja.php?no_mykad_pekerja=<?php echo $row_rsPekerja['no_mykad_pekerja']; ?>" onClick="return confirm('Anda pasti untuk padam?')"><img src="images/Bin.png" alt="padam" width="29" height="30" id="sprytrigger2"></a></td>
                              </tr>
                              <?php } while ($row_rsPekerja = mysql_fetch_assoc($rsPekerja)); ?>
                          </table>
</p>
                           <center>
                             <table width="157" border="1" cellspacing="1" cellpadding="1" align="center">
                               <tr>
                                 <td width="71"><a href="tambahpekerja.php"><img src="images/Button Add.png" alt="tambah" width="81" height="80" id="sprytrigger3"></a></td>
                                 <td width="116"><a href="print/printsenaraipekerja2.php" target="_blank"><img src="images/Printer.png" alt="cetak" width="81" height="80" id="sprytrigger4"></a></td>
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
<div class="tooltipContent" id="sprytooltip4">Cetak senarai pekerja.</div>
<div class="tooltipContent" id="sprytooltip3">Tambah pekerja baru.</div>
<div class="tooltipContent" id="sprytooltip2">Padam pekerja.</div>
<div class="tooltipContent" id="sprytooltip1">Kemaskini butiran pekerja.</div>
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
var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip1", "#sprytrigger1", {followMouse:true});
var sprytooltip2 = new Spry.Widget.Tooltip("sprytooltip2", "#sprytrigger2", {followMouse:true});
var sprytooltip3 = new Spry.Widget.Tooltip("sprytooltip3", "#sprytrigger3", {followMouse:true});
var sprytooltip4 = new Spry.Widget.Tooltip("sprytooltip4", "#sprytrigger4", {followMouse:true});
</script>
</body>
</html>
<?php
mysql_free_result($rsPekerja);
?>
