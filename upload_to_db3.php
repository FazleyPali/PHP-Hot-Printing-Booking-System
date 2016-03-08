<?php define ('MAX_FILE_SIZE', 1024 * 50); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "uploadImage")) {
  
  // make sure it's a genuine file upload
  if (is_uploaded_file($_FILES['image']['tmp_name'])) {
  
	// replace any spaces in original filename with underscores
	$filename = str_replace(' ', '_', $_FILES['image']['name']);
	// get the MIME type
	$mimetype = $_FILES['image']['type'];
	if ($mimetype == 'image/pjpeg') {
		$mimetype= 'image/jpeg';
	}
	// create an array of permitted MIME types
	$permitted = array('image/gif', 'image/jpeg', 'image/png');
	
	// upload if file is OK
	if (in_array($mimetype, $permitted) 
		&& $_FILES['image']['size'] > 0 
		&& $_FILES['image']['size'] <= MAX_FILE_SIZE) {
	  switch ($_FILES['image']['error']) {
		case 0:
		  // get the file contents
		  $image = file_get_contents($_FILES['image']['tmp_name']);
		  // get the width and height
		  $size = getimagesize($_FILES['image']['tmp_name']);
		  $width = $size[0];
		  $height = $size[1];

  
  $insertSQL = sprintf("INSERT INTO images (filename, mimetype, caption, image, width, height) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($filename, "text"),
                       GetSQLValueString($mimetype, "text"),
                       GetSQLValueString($_POST['caption'], "text"),
                       GetSQLValueString($image, "text"),
                       GetSQLValueString($width, "int"),
                       GetSQLValueString($height, "int"));

  mysql_select_db($database_testConn, $testConn);
  $Result1 = mysql_query($insertSQL, $testConn) or die(mysql_error());
		  if ($Result1) {
			$result = "$filename uploaded successfully.";
		  } else {
			$result = "Error uploading $filename. Please try again.";
		  }
		  break;
		case 3:
		case 6:
		case 7:
		case 8:
		  $result = "Error uploading $filename. Please try again.";
		  break;
		case 4:
		  $result = "You didn't select a file to be uploaded.";
	  }
	} else {
	  $result = "$filename is either too big or not an image.";
	}
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>File upload to database</title>
</head>

<body>
<?php
// if the form has been submitted, display result
if (isset($result)) {
  echo "<p><strong>$result</strong></p>";
  }
?>
<form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="uploadImage" id="uploadImage">
    <p>
		<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_FILE_SIZE; ?>" />
        <label for="image">Upload image:</label>
        <input type="file" name="image" id="image" /> 
    </p>
    <p>
      <label for="caption">Caption:</label>
      <input type="text" name="caption" id="caption" />
    </p>
    <p>
        <input type="submit" name="upload" id="upload" value="Upload" />
    </p>
    <input type="hidden" name="MM_insert" value="uploadImage" />
</form>
</body>
</html>
