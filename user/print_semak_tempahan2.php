<?php require_once('../Connections/SistemTempahan.php'); ?>
<?php
if (!isset($_SESSION)) {
session_start();
}
$MM_authorizedUsers = "pelanggan";
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

$MM_restrictGoTo = "../index.php";
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

$colname_rsProduk = "-1";
if (isset($_GET['kod_produk'])) {
  $colname_rsProduk = $_GET['kod_produk'];
}
mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsProduk = sprintf("SELECT * FROM produk WHERE kod_produk = %s", GetSQLValueString($colname_rsProduk, "text"));
$rsProduk = mysql_query($query_rsProduk, $SistemTempahan) or die(mysql_error());
$row_rsProduk = mysql_fetch_assoc($rsProduk);
$totalRows_rsProduk = mysql_num_rows($rsProduk);

$colname_rsTempahan = "-1";
if (isset($_SESSION['no_mykad_pelanggan'])) {
  $colname_rsTempahan = $_SESSION['no_mykad_pelanggan'];
}
mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsTempahan = sprintf("SELECT * FROM tempahan WHERE no_mykad_pelanggan LIKE %s", GetSQLValueString("%" . $colname_rsTempahan . "%", "text"));
$rsTempahan = mysql_query($query_rsTempahan, $SistemTempahan) or die(mysql_error());
$row_rsTempahan = mysql_fetch_assoc($rsTempahan);
$totalRows_rsTempahan = mysql_num_rows($rsTempahan);

$colname_rsPelanggan = "-1";
if (isset($_SESSION['no_mykad_pelanggan'])) {
  $colname_rsPelanggan = $_SESSION['no_mykad_pelanggan'];
}
mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsPelanggan = sprintf("SELECT * FROM pelanggan WHERE no_mykad_pelanggan LIKE %s", GetSQLValueString("%" . $colname_rsPelanggan . "%", "text"));
$rsPelanggan = mysql_query($query_rsPelanggan, $SistemTempahan) or die(mysql_error());
$row_rsPelanggan = mysql_fetch_assoc($rsPelanggan);
$totalRows_rsPelanggan = mysql_num_rows($rsPelanggan);

mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_Recordset1 = "SELECT SUM( tempahan.kuantiti * tempahan.jumlah_harga) FROM tempahan WHERE no_mykad_pelanggan = no_mykad_pelanggan GROUP BY no_mykad_pelanggan";
$Recordset1 = mysql_query($query_Recordset1, $SistemTempahan) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

//initialize the session
if (!isset($_SESSION)) {
session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Tempahan Berjaya</title>

<script>
function printpage()
  {
  window.print()
  }
</script>


<meta charset="utf-8">

<link rel="stylesheet" href="../css/layout.css" type="text/css" media="all">

<script type="text/javascript" src="../js/jquery-1.6.js" ></script>
<script type="text/javascript" src="../js/cufon-yui.js"></script>
<script type="text/javascript" src="../js/cufon-replace.js"></script>
<script type="text/javascript" src="../js/Swis721_Cn_BT_400.font.js"></script>
<script type="text/javascript" src="../js/Swis721_Cn_BT_700.font.js"></script>
<script type="text/javascript" src="../js/tabs.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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
#page3 .body3 .main .body3 .main .input div div div div div div div div center b {
	text-align: left;
}
#page3 .body3 .main .body3 .main .input div div div div div div div div center p strong {
	text-align: left;
}
#page3 .body3 .main .body3 .main .input div div div div div div div div {
}
#page3 .body3 .main .body3 .main .input div div div div div div div div {
}
-->
</style>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="../SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
  var win=null;
  function printIt(printThis)
  {
    win = window.open();
    self.focus();
    win.document.open();
    win.document.write('<'+'html'+'><'+'head'+'><'+'style'+'>');
    win.document.write('body, td { font-family: Verdana; font-size: 10pt;}');
    win.document.write('<'+'/'+'style'+'><'+'/'+'head'+'><'+'body'+'>');
    win.document.write(printThis);
    win.document.write('<'+'/'+'body'+'><'+'/'+'html'+'>');
    win.document.close();
    win.print();
    win.close();
  }
</script>
</head>

   
        
         
                         

                   
    <div id="printme">                    
<center>
  <table>
    <tr>
      <td><img src="../images/logo.png" width="290" height="90" alt="logo"></td>
      <td><h5>Syarikat Hot Printing & SouvenierNo 13, (Ground Floor), Pusat Perniagaan Sungai Lias,<br>
          45300 Sungai Besar, Selangor. TEL: +6017-2634933 (EN. HAFIZ) / 05-6212739<br>
          FAX: 05-6212739<br>
      NO. PEJABAT: 03-32241687 (SUHAILA)</h5></td>
    </tr>
  </table>
  <table align="left" bordercolor="#000000">
    <tr>
      <th colspan="2">&nbsp;</th>
    </tr>
    <tr>
      <th align="left"><pre>Nama</pre></th>
      <td bgcolor="#FFFFFF"><pre>:<?php echo $_SESSION['nama']; ?></pre></td>
    </tr>
    <tr>
      <th><pre>No. Kad Pengenalan</pre></th>
      <td bgcolor="#FFFFFF"><pre>:<?php echo $_SESSION['no_mykad_pelanggan']; ?></pre></td>
    </tr>
</table>
  <br>
  <br>
    <table width="198" align="right">
    <tr>
      <td width="58"><pre><strong>No. Invois</strong></pre></td>
      <td width="33"><pre>:<?php echo $row_rsTempahan['no_tempahan']; ?></pre></td>
    </tr>
    <tr>
      <td><pre><strong>No. Telefon</strong></pre></td>
      <td><pre>:<?php echo $row_rsPelanggan['no_telefon_bimbit']; ?></pre></td>
    </tr>
  </table>
    <br>
</center>
<blockquote>
  <blockquote>
    <blockquote>
      <p>
        <center>
          <br>
          <br>
        </center>
      </p>
    </blockquote>
  </blockquote>
</blockquote>
<blockquote>
  <blockquote>
    <blockquote>
      <p>
        <center>
          <br>
        </center>
      </p>
    </blockquote>
  </blockquote>
</blockquote>                          
<form method="get" name="form1">
  <center>
    <table width="100%" border="1" cellpadding="0">
                            <tr>
                                <th width="70" bgcolor="#999999"><pre>No. Tempahan</pre></th>
                                <th bgcolor="#999999"><pre>Kod Produk</pre></th>
                                <th width="100" bgcolor="#999999"><pre>Tarikh Tempah</pre></th>
                                <th width="50" bgcolor="#999999"><pre>Kuantiti</pre></th>
                                <th width="80" bgcolor="#999999"><pre>Harga Produk</pre></th>
                                <th bgcolor="#999999"><pre>Cara Bayaran</pre></th>
                                <th bgcolor="#999999"><pre>Jumlah Perlu Bayar</pre></th>
                            </tr>
                            <?php do { ?>
                                <tr>
                                  <td align="center" bgcolor="#FFFFFF"><?php echo $row_rsTempahan['no_tempahan']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['kod_produk']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['tarikh_tempah']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['kuantiti']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center">RM <?php echo $row_rsTempahan['jumlah_harga']; ?></td>
                                  <td bgcolor="#FFFFFF" align="center"><?php echo $row_rsTempahan['cara_bayaran']; ?></td>
                                  <td bgcolor="#FFFFFF"><center>
                                    RM <?php echo $row_rsTempahan['jumlah_harga'] * $row_rsTempahan['kuantiti'] ; ?>
                                  </center></td>
                            </tr>
                                <?php } while ($row_rsTempahan = mysql_fetch_assoc($rsTempahan)); ?>
    </table>

  </center>
</form><center>
  <table width="100%" border="1">
    <tr>
      <td width="68%" align="right" bgcolor="#FFFFFF"><strong>Jumlah Keseluruhan</strong></td>
      <td width="32%" align="center" bgcolor="#FFFFFF"><strong>RM <?php echo $row_Recordset1['SUM( tempahan.kuantiti * tempahan.jumlah_harga)']; ?></strong></td>
    </tr>
  </table></div>
  <a href="#" onclick="printIt(document.getElementById('printme').innerHTML); return false"  target="_blank"><br>
  <img src="../Icon for Web Design/Reflection Icons/Reflection Icons/Reflection Icons png files/Printer.png" width="40" height="40" onclick="printpage()"></a>
                          </center>
                          
     
<?php
mysql_free_result($rsProduk);

mysql_free_result($rsTempahan);

mysql_free_result($rsPelanggan);

mysql_free_result($Recordset1);

?>
</body>
</html>

