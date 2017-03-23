<?php
require_once 'global.inc.php'; 
if(isset($_POST['email'])) {  
 
    $email = $_POST['email']; 
    $password = $_POST['password'];  
    if($userTools->login($email, $password)){  
        //success go to index
        header("Location: index");
    }else{  
        $error = 1;  
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
      <form action="<?=BASE_URL?>/login" method="POST">
        <div class="top">
          <img src="<?=LOGO?>" alt="Logo <?=NAME?>" class="icon">
          <h1><?=NAME?></h1>
          <h4><?=SLOGAN?></h4>
        </div>
        <div class="form-area">
        <?php if (GLOGIN_ENABLE == 1) { ?>
          <div class="group">
            <a href="<?=BASE_URL?>/auth-google" class="btn btn-danger btn-block sociallogin"><i class="fa fa-google"></i><?=$lan["sign_in_with"]?> Google</a>
          </div>
        <?php } ?>
        <?php if (FLOGIN_ENABLE == 1) { ?>
          <div class="group">
            <a href="<?=BASE_URL?>/auth-facebook" class="btn btn-primary btn-block sociallogin"><i class="fa fa-facebook"></i><?=$lan["sign_in_with"]?> Facebook</a>
          </div>
        <?php } ?>
        
        <?php if (FLOGIN_ENABLE == 1 || GLOGIN_ENABLE == 1) { ?>
        <hr> 
        <?php } ?>

        <?php if ($error == 1) { ?>
          <div class="kode-alert alert6">
            <a href="#" class="closed">×</a>
            <?=$lan["login_error_message"]?>
          </div>
        <?php } ?>
        
        <?php if (NLOGIN_ENABLE == 1) { ?>
          <div class="group">
            <input type="email" name="email" class="form-control" placeholder="<?=$lan["email"]?>" required>
            <i class="fa fa-user"></i>
          </div>
          <div class="group">
            <input type="password" name="password" class="form-control" placeholder="<?=$lan["password"]?>" required>
            <i class="fa fa-key"></i>
          </div>
          <button type="submit" class="btn btn-default btn-block"><?=$lan["login"]?></button>
        <?php } ?>
          

        </div>
      </form>
      <div class="footer-links row">
        <?php if (REGISTER_ENABLE == 1) { ?>
        <div class="col-xs-6"><a href="<?=BASE_URL?>/register"><i class="fa fa-external-link"></i> <?=$lan["register_now"]?></a></div>
        <?php } ?>
        <?php if (FORGOT_ENABLE == 1) { ?>
        <div class="col-xs-6 text-right"><a href="<?=BASE_URL?>/forgot-password"><i class="fa fa-lock"></i> <?=$lan["forgot_password"]?></a></div>
        <?php } ?>
      </div>
      <div class="margin-t-40"></div>
    </div>

</body>
</html>