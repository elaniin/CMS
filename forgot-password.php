<?php
require_once 'global.inc.php'; 
if(isset($_POST['email'])) {  
    //check if the email exist
    $email = $_POST['email'];
    $rowdata = $db->select("users","email = '$email'");
    if ($rowdata[0]["email"] == "$email") {
        
        $name = $rowdata[0]["name"];
        $passtemp = time().rand(99, 1000);

        $newpassword = md5("$passtemp");
        $data = array( 
          "password" => "'$newpassword'",
        );
        $db->update($data, "users", "email = '$email'");
        $content = $lan["reset_password_content"];
        $content = str_replace("{name}", $name, $content);
        $content = str_replace("{passtemp}", $passtemp, $content);
        $subject = $lan["reset_password_subject"];
        
        $functions->sendemail($email,$subject,$content);
        $error = $lan["reset_password_success"];
    }
    else{
      $error = $lan["reset_password_error"];
    }
  
} 

?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE?>">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=NAME?> - <?=SLOGAN?></title>

  <!-- ========== Css Files ========== -->
  <link href="assets/css/root.css" rel="stylesheet">
  <style type="text/css">
    body{background: #F5F5F5;}
  </style>
  </head>
  <body>

    <div class="login-form">
      <form action="<?=BASE_URL?>/forgot-password" method="POST">
        <div class="top">
          <h1><?=$lan["forgot_password"]?></h1>
          <h4><?=$lan["forgot_password_description"]?></h4>
        </div>
        <div class="form-area">
          <?php if ($error != "") { ?>
            <div class="kode-alert alert6">
              <a href="#" class="closed">×</a>
              <?=$error?>
            </div>
          <?php } ?>        
          <div class="group">
            <input type="email" name="email" class="form-control" placeholder="<?=$lan["email"]?>" required>
            <i class="fa fa-envelope-o"></i>
          </div>
          <button type="submit" class="btn btn-default btn-block"><?=$lan["reset_password"]?></button>
        </div>
      </form>
      <div class="footer-links row">
        <div class="col-xs-6"><a href="<?=BASE_URL?>/login"><i class="fa fa-sign-in"></i> <?=$lan["login"]?></a></div>
        <?php if (REGISTER_ENABLE == 1) { ?>
        <div class="col-xs-6 text-right"><a href="<?=BASE_URL?>/register"><i class="fa fa-external-link"></i> <?=$lan["register_now"]?></a></div>
        <?php } ?>
      </div>
    </div>

</body>
</html>