<?php
$allData = array();
if(isset($_REQUEST['submit']))
{
   if($_POST['access_token'] == "" || $_POST['access_token'] == null)
   {
        $access_token_error = "access_token is Required";
   }
   else
   {
        $access_token = $_POST['access_token'];
   }
   if($_POST['folder_id'] == "" || $_POST['folder_id'] == null)
   {
        $folder_id_error = "folder_id is Required";
   }
   else
   {
        $folder_id = $_POST['folder_id'];
   }
   if($_FILES['file']['tmp_name'] == "" || $_FILES['file']['tmp_name'] == null)
   {
        $file_error = "file is Required";
   }
   else
   {
        $file = $_FILES['file']['tmp_name'];
   }

   if($access_token !='' && $folder_id !='' && $file !='')
  {
    $filePath = $_FILES['file']['tmp_name']; // Path to the file you want to upload
    $originalFileName = $_FILES['file']['name']; // Get the original file name
    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION); // Get the file extension
    $destinationFileName = uniqid() . '.' . $extension; // Generate a unique file name with the original extension
    
    $uploadUrl = 'https://graph.microsoft.com/v1.0/me/drive/items/' . $folder_id . ':/' . $destinationFileName . ':/content';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $uploadUrl);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $access_token,
        'Content-Type: application/octet-stream'
    ));
    
    $fileContent = file_get_contents($filePath);
    
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fileContent);
    
    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);
    
    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        $allData = $response;
    }
  }

}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Upload File</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>
	<div class="container" style="margin-top : 30px">
		
		<div class="panel panel-info">
			
            <div class="panel-heading">
                <div class="panel-title">Upload File</div>
            </div>  
            <div class="panel-body" >
            	<form method="post" action="" enctype="multipart/form-data">
                <div id="user_id" class="form-group required">
                  <label for="user_id" class="control-label col-md-4  requiredField">Access Token</label>
                  <div class="controls col-md-8 ">
                      <input class="input-md  textinput textInput form-control" id="api_key"  name="access_token" style="margin-bottom: 10px" type="text" value=""/>
                       <p class="text-danger"><?php echo $access_token_error; ?></p>
                  </div>
                </div>
                <div id="user_id" class="form-group required">
                  <label for="user_id" class="control-label col-md-4  requiredField">Folder Id</label>
                  <div class="controls col-md-8 ">
                      <input class="input-md  textinput textInput form-control" id="api_key"  name="folder_id" style="margin-bottom: 10px" type="text" value=""/>
                       <p class="text-danger"><?php echo $folder_id_error; ?></p>
                  </div>
                </div>
                <div id="user_id" class="form-group required">
                  <label for="user_id" class="control-label col-md-4  requiredField">File</label>
                  <div class="controls col-md-8 ">
                      <input class="input-md  textinput textInput form-control" id="user_id"  name="file" style="margin-bottom: 10px" type="file"/>
                       <p class="text-danger"><?php echo $file_error; ?></p>
                  </div>
                </div>
                <div class="form-group"> 
                    <div class="aab controls col-md-4 "></div>
                    <div class="controls col-md-8 ">
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary btn btn-info" id="submit-id-signup" />
                    </div>
                </div> 
            	</form>	
            </div>
        </div>
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="panel-title">Result</div>
            </div>
            <div class="panel-body" >
                <?php
                    echo $allData;
                ?>
            </div>
        </div>
	</div>
</body>
</html>