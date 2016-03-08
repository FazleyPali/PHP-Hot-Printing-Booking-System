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

if ((isset($_GET['no_mykad_pelanggan'])) && ($_GET['no_mykad_pelanggan'] != "")) {
  $deleteSQL = sprintf("DELETE FROM pelanggan WHERE no_mykad_pelanggan=%s",
                       GetSQLValueString($_GET['no_mykad_pelanggan'], "text"));

  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  $Result1 = mysql_query($deleteSQL, $SistemTempahan) or die(mysql_error());

  $deleteGoTo = "senaraipelanggan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form2")) {
  $insertSQL = sprintf("INSERT INTO pelanggan (no_mykad_pelanggan, nama, alamat, no_telefon_pejabat, no_fax, no_telefon_bimbit, email, kata_laluan) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['no_mykad_pelanggan'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['no_telefon_pejabat'], "text"),
                       GetSQLValueString($_POST['no_fax'], "text"),
                       GetSQLValueString($_POST['no_telefon_bimbit'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['kata_laluan'], "text"));

  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  $Result1 = mysql_query($insertSQL, $SistemTempahan) or die(mysql_error());

  $insertGoTo = "senaraipelanggan.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

$colname_rsPelanggan = "-1";
if (isset($_GET['no_mykad_pelanggan'])) {
  $colname_rsPelanggan = $_GET['no_mykad_pelanggan'];
}
mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsPelanggan = sprintf("SELECT * FROM pelanggan WHERE no_mykad_pelanggan = %s ORDER BY nama ASC", GetSQLValueString($colname_rsPelanggan, "text"));
$rsPelanggan = mysql_query($query_rsPelanggan, $SistemTempahan) or die(mysql_error());
$row_rsPelanggan = mysql_fetch_assoc($rsPelanggan);
$totalRows_rsPelanggan = mysql_num_rows($rsPelanggan);
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
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<script src="../SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>

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
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
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
                <li id="nav6"><a href="senaraipelanggan.php">senarai<span>pelanggan</span></a></li>
                <li id="nav2"><a href="senaraipekerja.php">senarai<span>pekerja</span></a></li>
                <li id="nav3"><a href="../produk.php">senarai<span>produk</span></a></li>
                <li id="nav4"><a href="../galeri.php">senarai<span>tempahan</span></a></li>
                <li id="nav5"><a href="../hubungi.php">laporan<span>syarikat</span></a></li>
                <li id="nav7"><a href="<?php echo $logoutAction ?>">log<span>keluar</span></a></li>
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
                      <h2 align="center">Tambah Pelanggan</h2>
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
                          <img src="../Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/Button Add.png" width="128" height="128" alt="user">
                          <p>&nbsp;</p>
                        </center>
                       <center>
                         <form method="post" name="form2" action="<?php echo $editFormAction; ?>">
                           <table align="center" cellspacing="5">
                           <tr valign="baseline">
                             <td><table align="center" cellspacing="3">
                               <tr valign="baseline">
                                 <td nowrap align="right">No Kad Pengenalan :</td>
                                 <td><span id="sprytextfield5">
                                 <input name="no_mykad_pelanggan" type="text" value="" size="41" maxlength="12">
                                 <span class="textfieldRequiredMsg">Sila penuhkan.</span><span class="textfieldInvalidFormatMsg">Format tidak sah.</span></span></td>
                               </tr>
                               <tr valign="baseline">
                                 <td nowrap align="right">Nama:</td>
                                 <td><span id="sprytextfield2">
                                   <input name="nama" type="text" value="" size="41" maxlength="200">
                                   <span class="textfieldRequiredMsg">Sila penuhkan.</span></span></td>
                               </tr>
                               <tr valign="baseline">
                                 <td nowrap align="right">Alamat:</td>
                                 <td><span id="sprytextarea1">
                                   <textarea name="alamat" cols="30" rows="5"></textarea>
                                   <span class="textareaRequiredMsg">Sila penuhkan.</span></span></td>
                               </tr>
                               <tr valign="baseline">
                                 <td nowrap align="right">No. Tel Pejabat :</td>
                                 <td><input name="no_telefon_pejabat" type="text" id="sprytrigger1" value="" size="41" maxlength="12"></td>
                               </tr>
                               <tr valign="baseline">
                                 <td nowrap align="right">No. Faks :</td>
                                 <td><input name="no_fax" type="text" id="sprytrigger2" value="" size="41" maxlength="12"></td>
                               </tr>
                               <tr valign="baseline">
                                 <td nowrap align="right">No. Tel. Bimbit :</td>
                                 <td><span id="sprytextfield3">
                                 <input name="no_telefon_bimbit" type="text" value="+6" size="41" maxlength="12">
                                 <span class="textfieldRequiredMsg">Sila penuhkan.</span><span class="textfieldMaxCharsMsg">Tidak sah.</span></span></td>
                               </tr>
                               <tr valign="baseline">
                                 <td nowrap align="right">Email:</td>
                                 <td><span id="sprytextfield4">
                                 <input name="email" type="text" value="" size="41" maxlength="200">
                                 <span class="textfieldRequiredMsg">Sila penuhkan.</span><span class="textfieldInvalidFormatMsg">Format tidak sah.</span></span></td>
                               </tr>
                               <tr valign="baseline">
                                 <td nowrap align="right">Kata Laluan :</td>
                                 <td><span id="sprypassword1">
                                 <input name="kata_laluan" type="password" value="" size="41" maxlength="20">
                                 <span class="passwordRequiredMsg">Sila penuhkan.</span><span class="passwordMinCharsMsg">Had minimum 6.</span><span class="passwordMaxCharsMsg">Had maksimum 20.</span></span></td>
                               </tr>
                               <tr valign="baseline">
                                 <td nowrap align="right">&nbsp;</td>
                                 <td><input type="submit" value="Tambah"></td>
                               </tr>
                             </table></td>
                           </tr>
                           </table>
                           <input type="hidden" name="MM_insert" value="form2">
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
<div class="tooltipContent" id="sprytooltip2">- jika tiada.</div>
<div class="tooltipContent" id="sprytooltip1">- jika tiada.</div>
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
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "integer", {validateOn:["blur"], minChars:12, maxChars:12});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1", {validateOn:["blur"]});
var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip1", "#sprytrigger1", {followMouse:true});
var sprytooltip2 = new Spry.Widget.Tooltip("sprytooltip2", "#sprytrigger2", {followMouse:true});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {maxChars:12, validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "email", {validateOn:["blur"]});
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {validateOn:["blur"], minChars:6, maxChars:20});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "integer", {validateOn:["blur"]});
</script>
</body>
</html>
<?php
mysql_free_result($rsPelanggan);

mysql_free_result($rsPelanggan);
?>
