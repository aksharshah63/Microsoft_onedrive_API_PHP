<?php
    $authorizationcode_error = ''; 
    $userid_error = ''; 
    $allData = array();
    $kay = 0;
    if(isset($_REQUEST['submit']))
    {
       if($_POST['client_id'] == "" || $_POST['client_id'] == null)
       {
            $client_id_error = "client_id  is Required";
       }
       else
       {
            $client_id = $_POST['client_id'];
       }
       if($_POST['client_secret'] == "" || $_POST['client_secret'] == null)
       {
            $client_secret_error = "client_secret is Required";
       }
       else
       {
            $client_secret = $_POST['client_secret'];
       }
       if($_POST['redUri'] == "" || $_POST['redUri'] == null)
       {
            $redUri_error = "redUri is Required";
       }
       else
       {
            $redUri = $_POST['redUri'];
       }
       if($_POST['code'] == "" || $_POST['code'] == null)
       {
            $code_error = "code is Required";
       }
       else
       {
            $code = $_POST['code'];
       }
      if($_POST['client_id']!="" && $_POST['redUri']!="" && $_POST['client_secret']!="" && $_POST['code']!="")
      {
      
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://login.microsoftonline.com/common/oauth2/v2.0/token',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => 'client_id='.$client_id.'&redirect_uri='.$redUri.'&client_secret='.$client_secret.'&code='.$code.'&grant_type=authorization_code',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
          ),
        ));
        
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

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
	<title>Get Access token and Refresh token</title>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
	<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body>
	<div class="container" style="margin-top : 30px">
		
		<div class="panel panel-info">
			
            <div class="panel-heading">
                <div class="panel-title">Get Access token and Refresh token</div>
            </div>  
            <div class="panel-body" >
            	<form method="post" action="">
                <div id="user_id" class="form-group required">
                  <label for="user_id" class="control-label col-md-4  requiredField">Client ID</label>
                  <div class="controls col-md-8 ">
                      <input class="input-md  textinput textInput form-control" id="user_id"  name="client_id" style="margin-bottom: 10px" type="text" value="c4c38b7a-e3e5-4c57-b92f-a4bf8183e010"/>
                       <p class="text-danger"><?php echo $client_id_error; ?></p>
                  </div>
                </div>
                <div id="user_id" class="form-group required">
                  <label for="user_id" class="control-label col-md-4  requiredField">Client secret</label>
                  <div class="controls col-md-8 ">
                      <input class="input-md  textinput textInput form-control" id="user_id"  name="client_secret" style="margin-bottom: 10px" type="text" value="4r~8Q~j0bGU9m_eUi16oh~SIqs7AjVYRHw4nvdiW" placeholder="1" />
                       <p class="text-danger"><?php echo $client_secret_error; ?></p>
                  </div>
                </div>
                <div id="user_id" class="form-group required">
                  <label for="user_id" class="control-label col-md-4  requiredField">Redirect Uri</label>
                  <div class="controls col-md-8 ">
                      <input class="input-md  textinput textInput form-control" id="user_id"  name="redUri" style="margin-bottom: 10px" type="text" value="https://google.com" placeholder="1" />
                       <p class="text-danger"><?php echo $redUri_error; ?></p>
                  </div>
                </div>
                <div id="user_id" class="form-group required">
                  <label for="user_id" class="control-label col-md-4  requiredField">Code</label>
                  <div class="controls col-md-8 ">
                      <input class="input-md  textinput textInput form-control" id="user_id"  name="code" style="margin-bottom: 10px" type="text" value="" placeholder="1" />
                       <p class="text-danger"><?php echo $code_error; ?></p>
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

