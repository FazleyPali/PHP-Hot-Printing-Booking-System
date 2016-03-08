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

mysql_select_db($database_SistemTempahan, $SistemTempahan);
$query_rsPelanggan = "SELECT no_mykad_pelanggan, nama, alamat, no_telefon_bimbit, email FROM pelanggan ORDER BY nama ASC";
$rsPelanggan = mysql_query($query_rsPelanggan, $SistemTempahan) or die(mysql_error());
$row_rsPelanggan = mysql_fetch_assoc($rsPelanggan);
$totalRows_rsPelanggan = mysql_num_rows($rsPelanggan);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['ic'])) {
  $loginUsername=$_POST['ic'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "logmasukberjaya.php";
  $MM_redirectLoginFailed = "../logmasukusergagal.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  
  $LoginRS__query=sprintf("SELECT email, kata_laluan FROM pelanggan WHERE email=%s AND kata_laluan=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $SistemTempahan) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>Pendaftaran</title>
<meta charset="utf-8">
<link rel="stylesheet" href="../css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="../css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="../css/style.css" type="text/css" media="all">
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
                <li id="nav1"><a href="../index.php">halaman<span>utama</span></a></li>
                <li id="nav6"><a href="../logmasuk.php">log <span>masuk</span></a></li>
                <li id="nav2"><a href="../pendaftaran.php" class="active">pendaftaran<span>baru</span></a></li>
                <li id="nav3"><a href="../produk.php">produk<span>popular</span></a></li>
                <li id="nav4"><a href="../galeri.php">galeri<span>gambar</span></a></li>
                <li id="nav5"><a href="../hubungi.php">hubungi<span>kami</span></a></li>
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
        <form ACTION="<?php echo $loginFormAction; ?>" method="POST" name="form1" class="input">
          <div style="border:2px solid#001100">
            <div style="border:2px solid#660000">
              <div style="border:2px solid#c60202">
                <div style="border:2px solid#c60202">
                  <div style="border:2px solid#c60202">
                    <div style="border:2px solid#c60202">
                      <div style="border:2apx solid#003300">
                        <h2 align="center">Log masuk pengguna berjaya</h2>
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
                          <img src="../images/page2_img6.png" width="87" height="98" alt="user">
                           
                            <p>&nbsp;</p>
                          </center>
                          <table width="100%" align="center">
                            <tr>
                              <th width="90" height="44" bgcolor="#999999" style="word-spacing: 1em; background-color: #999;"><em>No. Kad Pengenalan</em></th>
                              <th width="180" bgcolor="#999999" style="background-color: #999;"><em>Nama</em></th>
                              <th width="250" bgcolor="#999999" style="background-color: #999;"><em>Alamat</em></th>
                              <th width="80" bgcolor="#999999"><em>NO. HP</em></th>
                              <th width="125" bgcolor="#999999"><em>Email</em></th>
                              <th width="48" bgcolor="#999999">&nbsp;</th>
                              <th width="48" bgcolor="#999999">&nbsp;</th>
                              <th width="56" bgcolor="#999999">&nbsp;</th>
                            </tr>
                            <?php do { ?>
                              <tr bgcolor="#FFFFFF">
                                <td><?php echo $row_rsPelanggan['no_mykad_pelanggan']; ?></td>
                                <td><?php echo $row_rsPelanggan['nama']; ?></td>
                                <td><?php echo $row_rsPelanggan['alamat']; ?></td>
                                <td><?php echo $row_rsPelanggan['no_telefon_bimbit']; ?></td>
                                <td><?php echo $row_rsPelanggan['email']; ?></td>
                                <td><img src="images/1.png" width="50" height="50" alt="butiran penuh"></td>
                                <td><img src="images/6.png" width="50" height="50" alt="update"></td>
                                <td><img src="images/111.png" width="50" height="50" alt="delete"></td>
                              </tr>
                              <?php } while ($row_rsPelanggan = mysql_fetch_assoc($rsPelanggan)); ?>
                          </table>
<br/>
                          </p>
                          </p>
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
mysql_free_result($rsPelanggan);
?>
