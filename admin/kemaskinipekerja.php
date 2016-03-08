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

$colname_rsPekerja = "-1";
if (isset($_GET['no_mykad_pekerja'])) {
  $colname_rsPekerja = $_GET['no_mykad_pekerja'];
}
mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsPekerja = sprintf("SELECT * FROM pekerja WHERE no_mykad_pekerja = %s", GetSQLValueString($colname_rsPekerja, "text"));
$rsPekerja = mysql_query($query_rsPekerja, $SistemTempahan) or die(mysql_error());
$row_rsPekerja = mysql_fetch_assoc($rsPekerja);
$totalRows_rsPekerja = mysql_num_rows($rsPekerja);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form2")) {
  $updateSQL = sprintf("UPDATE pekerja SET nama=%s, alamat=%s, email=%s, jawatan=%s, kata_laluan=%s WHERE no_mykad_pekerja=%s",
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['textfield'], "text"),
                       GetSQLValueString($_POST['kata_laluan'], "text"),
                       GetSQLValueString($_POST['no_mykad_pekerja'], "text"));

  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  $Result1 = mysql_query($updateSQL, $SistemTempahan) or die(mysql_error());

  $updateGoTo = "senaraipekerja.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Pendaftaran</title>
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
	width: 200px;
	height: 115px;
	z-index: 2;
	left: 172px;
	top: 422px;
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
        <div style="border:2px solid#001100">
          <div style="border:2px solid#660000">
            <div style="border:2px solid#c60202">
              <div style="border:2px solid#c60202">
                <div style="border:2px solid#c60202">
                  <div style="border:2px solid#c60202">
                    <div style="border:2apx solid#003300">
                      <h2 align="center">Kemaskini Pekerja</h2>
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
                          <img src="../Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/Edit.png" width="128" height="128" alt="user">
                        </center>
                        <center>
                          <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
                            <table width="456" align="center">
                              <tr valign="baseline">
                                <td nowrap align="right">No. Kad Pengenalan :</td>
                                <td><?php echo $row_rsPekerja['no_mykad_pekerja']; ?></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Nama :</td>
                                <td><input type="text" name="nama" value="<?php echo htmlentities($row_rsPekerja['nama'], ENT_COMPAT, 'utf-8'); ?>" size="40"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Alamat :</td>
                                <td><textarea name="alamat" cols="30" rows="5"><?php echo htmlentities($row_rsPekerja['alamat'], ENT_COMPAT, 'utf-8'); ?></textarea></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Email :</td>
                                <td><input type="text" name="email" value="<?php echo htmlentities($row_rsPekerja['email'], ENT_COMPAT, 'utf-8'); ?>" size="40"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Jawatan :</td>
                                <td>
                                  <label for="textfield"></label>
                                <input name="textfield" type="text" id="textfield" value="<?php echo $row_rsPekerja['jawatan']; ?>" size="40"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Kata Laluan :</td>
                                <td><input type="text" name="kata_laluan" value="<?php echo htmlentities($row_rsPekerja['kata_laluan'], ENT_COMPAT, 'utf-8'); ?>" size="40"></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Kemaskini"></td>
                              </tr>
                            </table>
                            <input type="hidden" name="MM_update" value="form2">
                            <input type="hidden" name="no_mykad_pekerja" value="<?php echo $row_rsPekerja['no_mykad_pekerja']; ?>">
                          </form>
                          <p>&nbsp;</p>
                          <p>&nbsp;</p>
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
mysql_free_result($rsPekerja);

mysql_free_result($rsPelanggan);
?>
