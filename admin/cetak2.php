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

mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsPelanggan = "SELECT no_mykad_pelanggan, nama, alamat, no_telefon_bimbit, email FROM pelanggan ORDER BY nama ASC";
$rsPelanggan = mysql_query($query_rsPelanggan, $SistemTempahan) or die(mysql_error());
$row_rsPelanggan = mysql_fetch_assoc($rsPelanggan);
$totalRows_rsPelanggan = mysql_num_rows($rsPelanggan);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script language="Javascript1.2">
  <!--
  function printpage() {
  window.print();
  }
  //-->
</script>
<body>
<form method="POST" name="form1" class="input">
  <center>
    <p>&nbsp;</p>
    <p><img src="images/Untitled-2.png" width="268" height="100" alt="user"></p>
    <p>&nbsp; </p>
    <fieldset style="width:auto">
      <legend>Senarai Pelanggan</legend>
      <p>&nbsp; </p>
    
    <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td bgcolor="#999999" style="word-spacing: 1em; background-color: #999;"><em>No. Kad Pengenalan</em></td>
        <td bgcolor="#999999" style="background-color: #999;"><em>Nama</em></td>
        <td bgcolor="#999999" style="background-color: #999;"><em>Alamat</em></td>
        <td bgcolor="#999999"><em>NO. HP</em></td>
        <td bgcolor="#999999">No. Faks</td>
        <td bgcolor="#999999">No. Tel. Pejabat</td>
        <td bgcolor="#999999"><em>Email</em></td>
      </tr>
      <?php do { ?>
        <tr bgcolor="#FFFFFF">
          <td><?php echo $row_rsPelanggan['no_mykad_pelanggan']; ?></td>
          <td><?php echo $row_rsPelanggan['nama']; ?></td>
          <td><?php echo $row_rsPelanggan['alamat']; ?></td>
          <td><?php echo $row_rsPelanggan['no_telefon_bimbit']; ?></td>
          <td><?php echo $row_rsPelanggan['no_fax']; ?></td>
          <td><?php echo $row_rsPelanggan['no_telefon_pejabat']; ?></td>
          <td><a href="kemaskinipelanggan.php?no_mykad_pelanggan=<?php echo $row_rsPelanggan['no_mykad_pelanggan']; ?>"><?php echo $row_rsPelanggan['email']; ?></a></td>
        </tr>
        <?php } while ($row_rsPelanggan = mysql_fetch_assoc($rsPelanggan)); ?>
    </table>
    </fieldset>
  </center>
  
  <center>
    <p><input type="button" value="Cetak" onclick="window.print();"></p>
    <p>&nbsp;</p>
  </center>
</form>
</body>
</html>