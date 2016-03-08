<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
            "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Upload an image</title>
</head>
<body> 
<cfif isdefined ("form.InsertIt")> 
  <p align="center">You inserted the image name <cfoutput>#Form.image#</cfoutput> in to your database.<br> 
    Upload another image.</p> 
  <cfoutput> 
    <input name="Image" type="hidden" value="#form.image#"> 
  </cfoutput> 
  <cfinsert datasource="#datasource#"
		     tablename ="Images"
			 formfields="Image"> 
</cfif> 
<cfif isdefined ("form.image1")> 
  <cfelse> 
  <form action="file:///C|/Users/Mazlan/AppData/Local/Temp/Rar$DI03.982/uploadfileandinsertname.cfm" method="post" enctype="multipart/form-data" name="upload_form" id="upload_form"> 
    <table width="450" border="1" align="center" cellpadding="5" cellspacing="0" bgcolor="#FFFFFF"> 
      <tr bgcolor="#BACAE4"> 
        <td>Upload An Image</td> 
      </tr> 
      <tr> 
        <td align="center"> </td> 
      </tr> 
      <tr> 
        <td align="center"><input type="file" name="Image1" id="Image1"> 
          <input name="upload_now" type="submit" class="button" value="Upload the image"> </td> 
      </tr> 
    </table> 
  </form> 
</cfif> 
<cfif isdefined("form.Image1")> 
  <!---  The uploadfile destination path is declared as a variable in the application.cfm file you may need to verify the precise path with your host ---> 
  <cffile action="upload" filefield="Image1" destination="#uploadfolder#" nameconflict="overwrite" accept="image/*" > 
  <cfset uploadedfile = "c:\inetpub\wwwroot\test\images\#file.serverfile#"> 
  <br> 
  <br> 
  <p align="center">Click the confirm button to insert into the database</p> 
  <table width="450" border="1" align="center" cellpadding="6" cellspacing="0"> 
    <tr valign="top"> 
      <td><cfoutput><img src="images/#file.serverfile#"></cfoutput></td> 
      <td><cfoutput>#file.ServerFile#</cfoutput> <cfoutput> 
          <form action="file:///C|/Users/Mazlan/AppData/Local/Temp/Rar$DI03.982/uploadfileandinsertname.cfm" method="post"> 
              <br> 
              <br> 
              <input type="submit" name="InsertIt" value="Click to confirm"> 
              <input name="Image" type="hidden" value="#file.ServerFile#"> 
            </form> 
        </cfoutput> </td> 
    </tr> 
  </table> 
</cfif> 
</body>
</html>
