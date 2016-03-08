<?php require_once('../../Connections/SistemTempahan.php'); ?>
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
$query_rsTempahan = "SELECT no_tempahan, no_mykad_pelanggan, kod_produk, tarikh_tempah, kuantiti, jumlah_harga, cara_bayaran, catatan, lakaran FROM tempahan";
$rsTempahan = mysql_query($query_rsTempahan, $SistemTempahan) or die(mysql_error());
$row_rsTempahan = mysql_fetch_assoc($rsTempahan);
$totalRows_rsTempahan = mysql_num_rows($rsTempahan);

$query_rsTempahan = "SELECT * FROM pelanggan ORDER BY nama ASC";
$rsTempahan = mysql_query($query_rsTempahan, $SistemTempahan) or die(mysql_error());
$row_rsTempahan = mysql_fetch_assoc($rsTempahan);
$totalRows_rsTempahan = mysql_num_rows($rsTempahan);
$query_rsTempahan = "SELECT * FROM pelanggan ORDER BY nama ASC";
$rsTempahan = mysql_query($query_rsTempahan, $SistemTempahan) or die(mysql_error());
$row_rsTempahan = mysql_fetch_assoc($rsTempahan);
$totalRows_rsTempahan = mysql_num_rows($rsTempahan);
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
 <table width="100%" border="1">
   <tr>
     <td>no_tempahan</td>
     <td>no_mykad_pelanggan</td>
     <td>kod_produk</td>
     <td>tarikh_tempah</td>
     <td>kuantiti</td>
     <td>jumlah_harga</td>
     <td>cara_bayaran</td>
     <td>catatan</td>
     <td>lakaran</td>
   </tr>
   <?php do { ?>
   <tr>
     <td><?php echo $row_rsTempahan['no_tempahan']; ?></td>
     <td><?php echo $row_rsTempahan['no_mykad_pelanggan']; ?></td>
     <td><?php echo $row_rsTempahan['kod_produk']; ?></td>
     <td><?php echo $row_rsTempahan['tarikh_tempah']; ?></td>
     <td><?php echo $row_rsTempahan['kuantiti']; ?></td>
     <td><?php echo $row_rsTempahan['jumlah_harga']; ?></td>
     <td><?php echo $row_rsTempahan['cara_bayaran']; ?></td>
     <td><?php echo $row_rsTempahan['catatan']; ?></td>
     <td><?php echo $row_rsTempahan['lakaran']; ?></td>
   </tr>
   <?php } while ($row_rsTempahan = mysql_fetch_assoc($rsTempahan)); ?>
 </table>
 <p>&nbsp;</p>
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
<?php
mysql_free_result($rsTempahan);
?>
