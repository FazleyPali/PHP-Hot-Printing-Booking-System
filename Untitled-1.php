 <?php 
// function to get file extension
function getExtension($str) {

         $i = strrpos($str,".");
         if (!$i) { return ""; } 
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
}
// define max file size, change to suit your own maximum file size
define ("MAX_SIZE","1000");
$errors=0;
//get the original file from form
if($_SERVER["REQUEST_METHOD"] == "POST")
{
$image          =    $_FILES["file"]["name"];// from your upload form
$uploadedfile = $_FILES['file']['tmp_name'];// from your upload form
// check for correct file extension
if ($image) 
{
$filename  = stripslashes($_FILES['file']['name']);
$extension = getExtension($filename);
$extension = strtolower($extension);
if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
{
echo ' Unknown Image extension! ';// build your own error handling here
$errors = 1;
}
// check for correct file size
else
{
$size=filesize($_FILES['file']['tmp_name']);
 
if ($size > MAX_SIZE*1024)
{
 echo "You have exceeded the size limit";// build your own error handling here
 $errors = 1;
}
// check which extension we have and create file
if($extension=="jpg" || $extension=="jpeg" )
{
$uploadedfile = $_FILES['file']['tmp_name'];
$src = imagecreatefromjpeg($uploadedfile);
}
else if($extension=="png")
{
$uploadedfile = $_FILES['file']['tmp_name'];
$src = imagecreatefrompng($uploadedfile);
}
else 
{
$src = imagecreatefromgif($uploadedfile);
}
//resize image and create thumbs and small thumbs 
list($width,$height)=getimagesize($uploadedfile);
//for main images, this keeps the width at 300px regardless of portrait or landscape
$newwidth=300;
$newheight=($height/$width)*$newwidth;
$tmp=imagecreatetruecolor($newwidth,$newheight);
//for thumbnails, change the $newwidth variable to what ever size you need
if($width > $height){//landscape
$newwidth1=100;
$newheight1=($height/$width)*$newwidth1;
$tmp1=imagecreatetruecolor($newwidth1,$newheight1);
}elseif($width < $height){//portrait
$newheight1=100;
$newwidth1=($width/$height)*$newheight1;
$tmp1=imagecreatetruecolor($newwidth1,$newheight1);
}
//for smaller thumbnails, my site required this smaller thumb. Delete this section if you dont need it
if($width > $height){//landscape
$newwidth2=50;
$newheight2=($height/$width)*$newwidth2;
$tmp2=imagecreatetruecolor($newwidth2,$newheight2);
}elseif($width < $height){//portrait
$newheight2=50;
$newwidth2=($width/$height)*$newheight2;
$tmp2=imagecreatetruecolor($newwidth2,$newheight2);
}
// create new resized files
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);

imagecopyresampled($tmp2,$src,0,0,0,0,$newwidth2,$newheight2,$width,$height);
//declare destinations
$filename  = "Images/Gallery/Test/". $_FILES['file']['name'];                    //
$filename1 = "Images/Gallery/Test/Test_Thumbs/". $_FILES['file']['name'];        // your destination paths here
$filename2 = "Images/Gallery/Test/Test_Thumbs/Small/". $_FILES['file']['name'];    //
//write files to folders
imagejpeg($tmp,$filename,100);
imagejpeg($tmp1,$filename1,100);
imagejpeg($tmp2,$filename2,100);
//destroy temps to save memory
imagedestroy($src);
imagedestroy($tmp);
imagedestroy($tmp1);
imagedestroy($tmp2);
}
}
}
//If no errors registered, print the success message
if(isset($_POST['Submit']) && !$errors) 
{
echo "Image Uploaded Successfully!";
}
?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Upload Image Files and Resize</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="upload" enctype="multipart/form-data" method="post" action="<?php $_SERVER['PHP_SELF']; ?>">
  <input type="file" name="file" id="file" >
  <input type="submit" name="Submit" id="Submit" value="Upload Image">
</form>
</body>
</html>