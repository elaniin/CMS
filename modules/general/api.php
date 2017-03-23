<?php

if (!file_exists("credentials.php")) {
  $account_key = $functions->randomString();
  $secret_token = $functions->randomString();
  $fp=fopen('credentials.php','w');
  $data = "<?php
  /*
    API Credentials
  */

  define('ACCOUNT_KEY', '$account_key');
  define('SECRET_TOKEN', '$secret_token');
  ?>";
  fwrite($fp, $data);
  fclose($fp);
}
require_once 'credentials.php'; 
$account_key = ACCOUNT_KEY;
$secret_token = SECRET_TOKEN;

$mode = $_GET['mode'];
if($mode=="reset"){
  $fp=fopen('credentials.php','w');
  $secret_token = $functions->randomString();
  $data = "<?php
/*
  API Credentials
*/

  define('ACCOUNT_KEY', '$account_key');
  define('SECRET_TOKEN', '$secret_token');
?>";
      fwrite($fp, $data);
      fclose($fp);

}





?>
<!-- START CONTENT -->
<div class="content">

  <div class="row presentation">

      <div class="col-lg-8 col-md-6 titles">
        <span class="icon color2-bg"><i class="fa fa-code-fork"></i></span>
        <h1>Rest API</h1>
        <h4><?=$lan["api_details"]?></h4>
        <h5><a href="<?=BASE_URL?>/api/" target="_blank"><?=BASE_URL?>/api/</a></h5>
      </div>

      <div class="col-lg-4 col-md-6">

      </div>

  </div>  


<!-- START CONTAINER -->
<div class="container-default margin-b-50">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-title">
            <?=$lan["credentials"]?>
          </div>
              <div class="panel-body">
                <div class="row">
                  <div class="col-md-6">
                    <h4>Account Key</h4>
                    <div class="lead"> <?=$account_key?></div>
                  </div>
                  <div class="col-md-6">
                    <h4>Secret Token</h4>
                    <div class="lead"> <?=$secret_token?></div>
                    <a href="javascript:confirmDelete('<?=BASE_URL?>/m/general/api&mode=reset')">Reset Secret Token</a>
                  </div>
                </div>
              </div>
        </div>
      </div>
    </div>

</div>
<!-- END CONTAINER -->
