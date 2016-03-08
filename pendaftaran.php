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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO pelanggan (no_mykad_pelanggan, nama, alamat, no_telefon_pejabat, no_fax, no_telefon_bimbit, email, kata_laluan) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['no_mykad_pelanggan'], "text"),
                       GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['alamat'], "text"),
                       GetSQLValueString($_POST['no_telefon'], "text"),
                       GetSQLValueString($_POST['nofax'], "text"),
                       GetSQLValueString($_POST['nofon'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['Kata_Laluan'], "text"));

  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  $Result1 = mysql_query($insertSQL, $SistemTempahan) or die(mysql_error());

  $insertGoTo = "pendaftaranberjaya.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Pendaftaran</title>


<script type="text/javascript">
function capitalize(form) {
value = form.value;
newValue = '';
value = value.split(' ');
for(var i = 0; i < value.length; i++) {
newValue += value[i].substring(0,1).toUpperCase() +
value[i].substring(1,value[i].length) + ' ';
}
form.value = newValue;
}
</script>

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
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script><script src="SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>

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
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
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
                <li id="nav2"><a href="pendaftaran.php" class="active">pendaftaran<span>baru</span></a></li>
                <li id="nav3"><a href="produk.php">senarai<span>produk</span></a></li>
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
        <form action="<?php echo $editFormAction; ?>" method="POST" name="form1" class="input">
          <div style="border:2px solid#001100">
            <div style="border:2px solid#660000">
              <div style="border:2px solid#c60202">
                <div style="border:2px solid#c60202">
                  <div style="border:2px solid#c60202">
                    <div style="border:2px solid#c60202">
                      <div style="border:2apx solid#003300">
                        <h2 align="center"><b>Pendaftaran</b> </h2>
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
                            <table width="634" align="center">
                              <tr valign="baseline">
                                <td width="160" align="right" nowrap>Nama<em> :</em></td>
                                <td width="462"><span id="spryNama">
                                  <input name="nama" type="text" class="input" id="sprytrigger1" value="" onBlur="capitalize(this)" size="38" maxlength="100">
                                <span class="textfieldRequiredMsg">Sila penuhkan.</span></span> *</td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right"><em>No Kad Pengenalan :</em></td>
                                <td><span id="spryIc">
                                  <input name="no_mykad_pelanggan" type="text" class="input" id="sprytrigger2" value="" size="38" maxlength="12">
                                <span class="textfieldRequiredMsg">Sila penuhkan.</span><span class="textfieldInvalidFormatMsg">Format tidak sah.</span><span class="textfieldMinCharsMsg">Had minimum 12.</span></span>* 920517105553</td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right"><em>Alamat:</em></td>
                                <td><span id="sprytextarea2">
                                  <textarea name="alamat" cols="28" rows="5" class="input" id="sprytrigger3"></textarea>
                                <span class="textareaRequiredMsg">Sila penuhkan.</span></span></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right"><em>No Telefon (R):</em></td>
                                <td><input name="no_telefon" type="text" id="sprytrigger4" size="38" maxlength="10">
                                  0332891234 </td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">No Faks:</td>
                                <td><label>
                                    <input name="nofax" type="text" id="nofax" size="38" maxlength="10">
                                  </label>
                                  0332891598</td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">No. Telefon (HP) :</td>
                                <td><span id="spryHp">
                                  <label>
                                    <input name="nofon" type="text" id="nofon" size="38" maxlength="10">
                                  </label>
                                <span class="textfieldRequiredMsg">Sila penuhkan.</span><span class="textfieldInvalidFormatMsg">format tidak sah.</span><span class="textfieldMinValueMsg">Had minimum 10.</span></span>* 0173567758</td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right"><em>Email :</em></td>
                                <td><span id="sprytextfield4">
                                  <input name="email" type="text" value="" size="38" maxlength="30">
                                <span class="textfieldRequiredMsg">Sila penuhkan.</span><span class="textfieldInvalidFormatMsg">Format tidak sah.</span></span>* lan@psis.com</td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right"><em>Kata Laluan :</em></td>
                                <td><span id="sprypassword1">
                                <label for="Kata_Laluan"></label>
                                <input name="Kata_Laluan" type="password" id="Kata_Laluan" size="38" maxlength="20">
                                <span class="passwordRequiredMsg">Sila penuhkan.</span><span class="passwordMinCharsMsg">Had minimum 6.</span><span class="passwordMaxCharsMsg">Had maksimum 20.</span></span>* Had minimum 6.</td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">Taip Semula Kata Laluan: </td>
                                <td><span id="spryconfirm1">
                                  <label for="retype_password"></label>
                                  <input name="retype_password" type="password" id="retype_password" size="38" maxlength="20">
                                <span class="confirmRequiredMsg">Sila penuhkan.</span><span class="confirmInvalidMsg">Tidak sepadan.</span></span></td>
                              </tr>
                              <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" name="button" id="button" value="Daftar" ></td>
                              </tr>
                            </table>
                            <br>
                            * Ruang yang wajib di isi.                          
                          </center>
                         <br/>
                         
                          </p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <input type="hidden" name="MM_insert" value="form1">
        </form>
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
var sprytextfield3 = new Spry.Widget.ValidationTextField("spryNama", "none", {validateOn:["blur"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("spryIc", "integer", {validateOn:["blur"], minChars:12});
var sprytextfield2 = new Spry.Widget.ValidationTextField("spryHp", "integer", {validateOn:["blur"], minValue:10});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "email", {validateOn:["blur"]});
var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip1", "#nofax", {followMouse:true});
var sprytooltip2 = new Spry.Widget.Tooltip("sprytooltip2", "#sprytrigger4", {followMouse:true});
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2", {validateOn:["blur"]});
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {validateOn:["blur"], minChars:6, maxChars:20});
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "Kata_Laluan", {validateOn:["blur"]});
</script>
</body>
</html>