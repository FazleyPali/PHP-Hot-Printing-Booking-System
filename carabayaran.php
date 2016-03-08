<?php require_once('Connections/SistemTempahan.php'); ?>
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
  $MM_redirectLoginSuccess = "user/logmasukberjaya.php";
  $MM_redirectLoginFailed = "logmasukusergagal.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_SistemTempahan, $SistemTempahan);
  
  $LoginRS__query=sprintf("SELECT no_mykad_pelanggan, kata_laluan FROM pelanggan WHERE no_mykad_pelanggan=%s AND kata_laluan=%s",
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
<title>Cara Bayaran</title>
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
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
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
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
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
                <li id="nav2"><a href="pendaftaran.php" >pendaftaran<span>baru</span></a></li>
                <li id="nav3"><a href="produk.php" >senarai<span>produk</span></a></li>
                <li id="nav4"><a href="carabayaran.php" class="active">cara<span>bayaran</span></a></li>
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
        <form ACTION="<?php echo $loginFormAction; ?>" method="POST" name="form1" class="input">
          <div style="border:2px solid#001100">
            <div style="border:2px solid#660000">
              <div style="border:2px solid#c60202">
                <div style="border:2px solid#c60202">
                  <div style="border:2px solid#c60202">
                    <div style="border:2px solid#c60202">
                      <div style="border:2apx solid#003300">
                        <h2 align="center">Cara Bayaran</h2>
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
                          <table width="793" border="1" cellspacing="5" cellpadding="5" >
                          <tr>
                                    <td width="694" height="153">Pelanggan perlu membayar produk-produk yang telah ditempah dalam masa yang terdekat untuk memastikan segala urusan dan proses pembuatan produk berjalan dengan lancar. Setiap pelanggan yang menempah harus membayar jumlah penuh tempahan. <br>
                                    Harap Maklum.</td>
                          </tr>
                                  <tr>
                                    <td><b>- Cara pembayaran boleh dilakukan dengan caraberikut :</b></td>
                                  </tr>
                                  <tr>
                                    <td>1. Bayaran secara tunai</td>
                                  </tr>
                                  <tr>
                                    <td height="49">2. Bayaran ke akuan <br>
                                      </td>
                                  </tr>
                                  <tr>
                                    <td><img src="images/maybank.jpg" width="300" height="39"><br>
                                      <br>
                                      Nombor akaun maybank : 339012108299 <br>
                                      Atas nama : HOT & PRINTING<br>
                                    <br>
                                    <br>Jika pembayaran ke akuan sila sms jumlah pembayaran, tarikh dan No. tempahan ke 
                                    017-2634933 (En. Hafiz).<br>
                                    *Pelanggan perlu mendaftar terlebih dahulu untuk membuat sebarang tempahan
                                    <br>
                                    *Pelanggan akan dihubungi semula setelah tempahan siap</td>
                                  </tr>
                        </table>
                          </center>
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