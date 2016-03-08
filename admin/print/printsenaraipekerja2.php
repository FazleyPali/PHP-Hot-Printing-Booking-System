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

$maxRows_rspekerja = 10;
$pageNum_rspekerja = 0;
if (isset($_GET['pageNum_rspekerja'])) {
  $pageNum_rspekerja = $_GET['pageNum_rspekerja'];
}
$startRow_rspekerja = $pageNum_rspekerja * $maxRows_rspekerja;

mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rspekerja = "SELECT * FROM pekerja";
$query_limit_rspekerja = sprintf("%s LIMIT %d, %d", $query_rspekerja, $startRow_rspekerja, $maxRows_rspekerja);
$rspekerja = mysql_query($query_limit_rspekerja, $SistemTempahan) or die(mysql_error());
$row_rspekerja = mysql_fetch_assoc($rspekerja);

if (isset($_GET['totalRows_rspekerja'])) {
  $totalRows_rspekerja = $_GET['totalRows_rspekerja'];
} else {
  $all_rspekerja = mysql_query($query_rspekerja);
  $totalRows_rspekerja = mysql_num_rows($all_rspekerja);
}
$totalPages_rspekerja = ceil($totalRows_rspekerja/$maxRows_rspekerja)-1;

$query_rsPekerja = "SELECT * FROM pelanggan ORDER BY nama ASC";
$rsPekerja = mysql_query($query_rsPekerja, $SistemTempahan) or die(mysql_error());
$row_rsPekerja = mysql_fetch_assoc($rsPekerja);
$totalRows_rsPekerja = mysql_num_rows($rsPekerja);
$query_rsPekerja = "SELECT * FROM pelanggan ORDER BY nama ASC";
$rsPekerja = mysql_query($query_rsPekerja, $SistemTempahan) or die(mysql_error());
$row_rsPekerja = mysql_fetch_assoc($rsPekerja);
$totalRows_rsPekerja = mysql_num_rows($rsPekerja);
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
      <td width="258" bgcolor="#999999">No Myad Pekerja</td>
      <td width="144" bgcolor="#999999">Nama</td>
      <td width="154" bgcolor="#999999">Alamat</td>
      <td width="143" bgcolor="#999999">Email</td>
      <td width="164" bgcolor="#999999">Jawatan</td>
      <td width="195" bgcolor="#999999">Kata Laluan</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php echo $row_rspekerja['no_mykad_pekerja']; ?></td>
        <td><?php echo $row_rspekerja['nama']; ?></td>
        <td><?php echo $row_rspekerja['alamat']; ?></td>
        <td><?php echo $row_rspekerja['email']; ?></td>
        <td><?php echo $row_rspekerja['jawatan']; ?></td>
        <td><?php echo $row_rspekerja['kata_laluan']; ?></td>
      </tr>
      <?php } while ($row_rspekerja = mysql_fetch_assoc($rspekerja)); ?>
  </table>
<br/><center><input type="button" value="Cetak" onclick="printpage()"></center>
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
mysql_free_result($rspekerja);
?>
