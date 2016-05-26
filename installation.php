<?php
error_reporting(0);
require_once 'version.php'; 
include("language/en.php");


$defaultzone = date_default_timezone_get();
$baseurl = 'http://'. $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$baseurl = str_replace("/installation", "", $baseurl);

if(isset($_POST['submit-form'])) {
  if ($_POST) {
  foreach ($_POST as $param_name => $param_val) {
      $$param_name = $param_val;
    }
  }
  //check if DB works
  $connection = mysql_connect($DATABASE_HOST,$DATABASE_USER,$DATABASE_PASS);  
  if (mysql_select_db($DATABASE_NAME) == true) {
    //add initial data
    $templine = '';
    $lines = file("installation.txt");
    foreach ($lines as $line){
      if (substr($line, 0, 2) == '--' || $line == '')
          continue;
      $templine .= $line;
      if (substr(trim($line), -1, 1) == ';')
      {
          mysql_query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
          $templine = '';
      }
    }
     
    //create the files
        //create config file
        $fp = fopen('config.php','w');
        $data = "<?php
/*
  Configurations
*/

//General
define('BASE_URL', '$BASE_URL');
define('NAME', '$NAME');
define('SLOGAN', '$SLOGAN');
define('P_EMAIL', '$P_EMAIL');
define('LOGO', '$LOGO');
define('FAVICON', ' ');
define('COLOR', '$COLOR');
define('LANGUAGE', '$LANGUAGE');

define('COPYRIGHT', ' ');
define('TIMEZONE', '$TIMEZONE');

define('FORCE_HTTPS', $FORCE_HTTPS);
define('AUTO_UPDATE', $AUTO_UPDATE);

//Database Info
define('DATABASE_NAME', '$DATABASE_NAME'); 
define('DATABASE_USER', '$DATABASE_USER');
define('DATABASE_PASS', '$DATABASE_PASS');
define('DATABASE_HOST', '$DATABASE_HOST'); 

//Mail
define('MAIL_TYPE', 1);  // 1 = Server Default / 2 = Mandrill / 3 = SendGrid
define('MAIL_MANDRILL_KEY', '');
define('MAIL_SENDGRID_KEY', '');

//Normal Register
define('NLOGIN_ENABLE', $NLOGIN_ENABLE);
define('REGISTER_ENABLE', $REGISTER_ENABLE);
define('FORGOT_ENABLE', $FORGOT_ENABLE);

//Google Login
//You can get it from: https://console.developers.google.com/
define('GLOGIN_ENABLE', $GLOGIN_ENABLE);
define('GLOGIN_CLIENT_ID', '$GLOGIN_CLIENT_ID');
define('GLOGIN_CLIENT_SECRET', '$GLOGIN_CLIENT_SECRET');

//Facebook Login
//You can get it from: https://developers.facebook.com/
define('FLOGIN_ENABLE', $FLOGIN_ENABLE);
define('FLOGIN_APP_ID', '$FLOGIN_APP_ID');
define('FLOGIN_APP_SECRET', '$FLOGIN_APP_SECRET');

//Advance Settings
//If you not sure what happend here not change nothing.
define('DEFAULT_MODULE', 'general');
define('DEFAULT_PAGE', 'home');
define('DEFAULT_LEVEL', '1');

?>";
          fwrite($fp, $data);
          fclose($fp);
        //create backups directory
        if (!file_exists('backups')) {
            mkdir('backups', 0777, true);
        }
        //create custom directory
        if (!file_exists('custom')) {
            mkdir('custom', 0777, true);
        }
        //create custom css
        $fp = fopen('custom/custom.css','w');
        fwrite($fp, "");
        fclose($fp);
        //create custom jss
        $fp = fopen('custom/custom.js','w');
        fwrite($fp, "");
        fclose($fp);

        //create custom php functions
        $fp = fopen('custom/custom.class.php','w');
        $customphp = "<?php
/* 

  Custom Functions Class 

*/
class CustomFunctions
{



}";
        fwrite($fp, $customphp);
        fclose($fp);
        //create home
        $fp = fopen('modules/general/home.php','w');
        $home = '<!-- //////////////////////////////////////////////////////////////////////////// --> 
        <!-- START CONTENT -->
        <div class="content">

          <!-- Start Page Header -->
          <div class="page-header">
            <h1 class="title">Dashboard</h1>
              <ol class="breadcrumb">
                <li class="active">Dashboard</li>
              </ol>

            <!-- Start Page Header Right Div -->
            <div class="right">
              <div class="btn-group" role="group" aria-label="...">
                <a href="<?=BASE_URL?>" class="btn btn-light">Dashboard</a>
                <a href="#" class="btn btn-light"><i class="fa fa-refresh"></i></a>
                <a href="#" class="btn btn-light"><i class="fa fa-search"></i></a>
                <a href="#" class="btn btn-light" id="topstats"><i class="fa fa-line-chart"></i></a>
              </div>
            </div>
            <!-- End Page Header Right Div -->

          </div>
          <!-- End Page Header -->

         <!-- //////////////////////////////////////////////////////////////////////////// --> 
        <!-- START CONTAINER -->
        <div class="container-default">


        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>



        </div>
        <!-- END CONTAINER -->
        <!-- //////////////////////////////////////////////////////////////////////////// --> ';
        fwrite($fp, $home);
        fclose($fp);
        //remove files
        unlink("installation.php");
        unlink("installation.txt");
        //redirect to login
        header("Location: login");
  }else{
      $msg = '
          <div class="margin-t-10">
          <div class="kode-alert kode-alert-icon alert5">
            <i class="fa fa-warning"></i>
            <a href="#" class="closed">×</a>
            Error with the <strong>database</strong> connection information. Try Again.
          </div>
        </div>';  
  }




}

?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE?>">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=CMS_NAME?> <?=CMS_VERSION?></title>

  <!-- ========== Css Files ========== -->
  <link href="assets/css/root.css" rel="stylesheet">
  <style type="text/css">
    body{background: #F5F5F5;}
  </style>
  </head>
<body>

<!-- START CONTENT -->
<div class="container">

  <div class="row presentation">

      <div class="col-lg-8 col-md-6 titles">
        <span class="icon color2-bg"><i class="fa fa-cog"></i></span>
        <h1><?=$lan["installation"]?></h1>
        <h4><?=$lan["conf_details"]?></h4>
          <?=$msg?>
      </div>

      <div class="col-lg-4 col-md-6">

      </div>

  </div>  


<!-- START CONTAINER -->
<div class="container-padding  margin-b-50">
    <div class="row">
<div class="col-md-12 padding-0">
      <div class="panel panel-transparent" style="margin-top:-87px;">
            <div class="panel-body">
              
                <div role="tabpanel">

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab" aria-expanded="true" class="active">General</a></li>
                    <li role="presentation" class=""><a href="#database" aria-controls="database" role="tab" data-toggle="tab" class="" aria-expanded="false"><?=$lan["database"]?></a></li>
                    <li role="presentation" class=""><a href="#users" aria-controls="users" role="tab" data-toggle="tab" class="" aria-expanded="false"><?=$lan["users"]?></a></li>
                  </ul>

                  <!-- Tab panes -->
                  <form action="installation" method="POST">
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="general">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Base Url</label>
                            <input type="text" class="form-control" name="BASE_URL" value="<?=$baseurl?>">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Name</label>
                            <input type="text" class="form-control" name="NAME" >
                          </div>
                        </div>
                         <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Slogan</label>
                            <input type="text" class="form-control" name="SLOGAN" >
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Principal email</label>
                            <input type="email" class="form-control" name="P_EMAIL" >
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Logo Url</label>
                            <input type="text" class="form-control" name="LOGO" >
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Favicon (PNG URL)</label>
                            <input type="text" class="form-control" name="FAVICON" >
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Principal Color</label>
                            <input type="text" class="form-control" name="COLOR" value="#399bff">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Language</label>
                            <select class="selectpicker form-control" name="LANGUAGE">
                              <option value="en" selected >English</option>
                              <option value="es">Español</option>
                            </select> 
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Copyright</label>
                            <input type="text" class="form-control" name="COPYRIGHT">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Timezone</label>
                            <input type="text" class="form-control" name="TIMEZONE" value="<?=$defaultzone?>">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Force HTTPS</label>
                            <select class="selectpicker form-control" name="FORCE_HTTPS">
                              <option value="1">Yes</option>
                              <option value="0" selected>No</option>
                            </select> 
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Auto Updates</label>
                            <select class="selectpicker form-control" name="AUTO_UPDATE">
                              <option value="1" selected>Yes</option>
                              <option value="0">No</option>
                            </select> 
                          </div>
                        </div>
                        
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="database">
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="input1" class="form-label">Database Name</label>
                            <input type="text" class="form-control" name="DATABASE_NAME" required>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="input1" class="form-label">Database User</label>
                            <input type="text" class="form-control" name="DATABASE_USER" required>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="input1" class="form-label">Database Password</label>
                            <input type="password" class="form-control" name="DATABASE_PASS" required>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="input1" class="form-label">Database Host</label>
                            <input type="text" class="form-control" name="DATABASE_HOST" value="localhost" required>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="users">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Enable normal login?</label>
                            <select class="selectpicker form-control" name="NLOGIN_ENABLE">
                              <option value="1" selected >Yes</option>
                              <option value="0">No</option>
                            </select> 
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Enable register option?</label>
                            <select class="selectpicker form-control" name="REGISTER_ENABLE">
                              <option value="1" selected >Yes</option>
                              <option value="0">No</option>
                            </select> 
                          </div>
                        </div>
                         <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Enable forgot password option?</label>
                            <select class="selectpicker form-control" name="FORGOT_ENABLE">
                              <option value="1" selected >Yes</option>
                              <option value="0">No</option>
                            </select> 
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Enable Google Login?</label>
                            <select class="selectpicker form-control" name="GLOGIN_ENABLE">
                              <option value="1">Yes</option>
                              <option value="0" selected >No</option>
                            </select> 
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Google Client ID</label>
                            <input type="text" class="form-control" name="GLOGIN_CLIENT_ID">
                          </div>
                        </div>
                         <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Google Client Secret</label>
                            <input type="text" class="form-control" name="GLOGIN_CLIENT_SECRET">
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Enable Facebook Login?</label>
                            <select class="selectpicker form-control" name="FLOGIN_ENABLE">
                              <option value="1">Yes</option>
                              <option value="0" selected >No</option>
                            </select> 
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Facebook App ID</label>
                            <input type="text" class="form-control" name="FLOGIN_APP_ID" >
                          </div>
                        </div>
                         <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Facebook App Secret</label>
                            <input type="text" class="form-control" name="FLOGIN_APP_SECRET" >
                          </div>
                        </div>
                      </div>
                    </div>



                  </div>

                </div>              

            </div>
            <div class="panel-footer">
              <button type="submit" name="submit-form" class="btn btn-default"><?=$lan["save"]?></button>
              </form>
            </div>

      </div>
    </div>
    </div>

</div>
<!-- END CONTAINER -->

<!-- ================================================
jQuery Library
================================================ -->
<script type="text/javascript" src="assets/js/jquery.min.js"></script>

<!-- ================================================
Bootstrap Core JavaScript File
================================================ -->
<script src="assets/js/bootstrap/bootstrap.min.js"></script>

<!-- ================================================
Plugin.js - Some Specific JS codes for Plugin Settings
================================================ -->
<script type="text/javascript" src="assets/js/plugins.js"></script>
<!-- ================================================
Bootstrap Select
================================================ -->
<script type="text/javascript" src="assets/js/bootstrap-select/bootstrap-select.js"></script>
</body>
</html>