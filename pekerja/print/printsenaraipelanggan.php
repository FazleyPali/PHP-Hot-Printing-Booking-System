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
<title>Senarai pelanggan</title>
<meta charset="utf-8">

<link rel="stylesheet" href="../css/layout.css" type="text/css" media="all">
<script>
function printpage()
  {
  window.print()
  }
</script>

</head>

<div class="body1">
  <div class="main">
    <!-- content -->
    <div class="body3">
      <div class="main">
<form method="POST" name="form1" class="input">
          
 <p><div><center>
    <p><img src="../images/logo.png" width="290" height="90" alt="logo"></p>
    <h4>Syarikat Hot Printing & Souvenier</h4>
      No 13, (Ground Floor), Pusat Perniagaan Sungai Lias,<br>
      45300 Sungai Besar, Selangor.            
    
    
    <p>TEL: +6017-2634933 (EN. HAFIZ) / 05-6212739<br>
      FAX: 05-6212739<br>
      NO. PEJABAT: 03-32241687 (SUHAILA)        
    </p>
  </center></div>






                         
                       
          <table width="100%" border="1" align="center">
                            <tr>
                              <th width="90" height="44" bgcolor="#999999" style="word-spacing: 1em; background-color: #999;"><em>No. Kad Pengenalan</em></th>
                              <th width="200" bgcolor="#999999" style="background-color: #999;"><em>Nama</em></th>
                              <th width="250" bgcolor="#999999" style="background-color: #999;"><em>Alamat</em></th>
                              <th width="90" bgcolor="#999999"><em>NO. HP</em></th>
                              <th width="130" bgcolor="#999999"><em>Email</em></th>
                            </tr>
                            <?php do { ?>
                              <tr bgcolor="#FFFFFF">
                                <td><?php echo $row_rsPelanggan['no_mykad_pelanggan']; ?></td>
                                <td><?php echo $row_rsPelanggan['nama']; ?></td>
                                <td><?php echo $row_rsPelanggan['alamat']; ?></td>
                                <td width="50"><?php echo $row_rsPelanggan['no_telefon_bimbit']; ?></td>
                                <td><?php echo $row_rsPelanggan['email']; ?></td>
                              </tr>
                              <?php } while ($row_rsPelanggan = mysql_fetch_assoc($rsPelanggan)); ?>
                          </table>
                          <p><center><input type="button" value="Cetak" onclick="printpage()"></center><br/>
          </p>
                            </p>
                           <center>
                           </center></p>
  <p>&nbsp;</p>
</form>
      </div>
    </div>
  </div>
</div>


</body>
</html>
