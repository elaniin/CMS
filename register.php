<?php
require_once 'global.inc.php'; 
if(isset($_POST['email'])) { 
  //retrieve the $_POST variables
  $name = $_POST['name'];
  $password = $_POST['password'];
  $password_confirm = $_POST['repassword'];
  $email = $_POST['email'];

  //initialize variables for form validation
  $success = true;
  $userTools = new UserTools();


  if($userTools->checkEmailExists($email))
  {
      $error = $lan["email_exists"];
      $success = false;
  }
  if($password != $password_confirm) {
      $error = $lan["password_not_match"];
      $success = false;
  }
  if($success)
  {
      
      $data['name'] = $name;
      $data['password'] = md5($password);
      $data['email'] = $email;
      $data['level'] = DEFAULT_LEVEL;
      $data['phone'] = "";
      $newUser = new User($data);
      $newUser->save(true);
      //send email
      $subject = $lan["register_email_subject"];
      $subject = str_replace("{name}", NAME, $subject);
      $content = $lan["register_email_content"];
      $content = str_replace("{email}", $email, $content);
      $content = str_replace("{name}", $name, $content);

      $functions->sendemail($email,$subject,$content);
      //login
      $userTools->login($email, $password);
      header("Location: index");
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
      <form action="<?=BASE_URL?>/register" method="POST">
        <div class="top">
          <h1><?=$lan["register_now"]?></h1>
          <h4><?=$lan["register_now_description"]?></h4>
        </div>
        <div class="form-area">
          <?php if ($error != "") { ?>
            <div class="kode-alert alert6">
              <a href="#" class="closed">×</a>
              <?=$error?>
            </div>
          <?php } ?>        
          <div class="group">
            <input type="text" name="name" class="form-control" placeholder="<?=$lan["name"]?>" value="<?=$_POST["name"]?>" required>
            <i class="fa fa-user"></i>
          </div>
          <div class="group">
            <input type="email" name="email" class="form-control" placeholder="<?=$lan["email"]?>" value="<?=$_POST["email"]?>" required>
            <i class="fa fa-envelope-o"></i>
          </div>
          <div class="group">
            <input type="password" name="password" class="form-control" placeholder="<?=$lan["password"]?>" required>
            <i class="fa fa-key"></i>
          </div>
          <div class="group">
            <input type="password" name="repassword" class="form-control" placeholder="<?=$lan["password_again"]?>" required>
            <i class="fa fa-key"></i>
          </div>
          <button type="submit" class="btn btn-default btn-block"><?=$lan["create_account"]?></button>
        </div>
      </form>
      <div class="footer-links row">
        <div class="col-xs-6"><a href="<?=BASE_URL?>/login"><i class="fa fa-sign-in"></i> <?=$lan["login"]?></a></div>
        <?php if (FORGOT_ENABLE == 1) { ?>
        <div class="col-xs-6 text-right"><a href="<?=BASE_URL?>/forgot-password"><i class="fa fa-lock"></i> <?=$lan["forgot_password"]?></a></div>
        <?php } ?>
      </div>
    </div>

</body>
</html>