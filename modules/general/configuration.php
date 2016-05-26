<?php
if(isset($_POST['submit-form'])) {
//save the config file
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
define('FAVICON', '$FAVICON');
define('COLOR', '$COLOR');
define('LANGUAGE', '$LANGUAGE');

define('COPYRIGHT', '$COPYRIGHT');
define('TIMEZONE', '$TIMEZONE');

define('FORCE_HTTPS', $FORCE_HTTPS);
define('AUTO_UPDATE', $AUTO_UPDATE);

//Database Info
define('DATABASE_NAME', '$DATABASE_NAME'); 
define('DATABASE_USER', '$DATABASE_USER');
define('DATABASE_PASS', '$DATABASE_PASS');
define('DATABASE_HOST', '$DATABASE_HOST'); 

//Mail
define('MAIL_TYPE', $MAIL_TYPE);  // 1 = Server Default / 2 = Mandrill / 3 = SendGrid
define('MAIL_MANDRILL_KEY', '$MAIL_MANDRILL_KEY');
define('MAIL_SENDGRID_KEY', '$MAIL_SENDGRID_KEY');

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
define('DEFAULT_MODULE', '$DEFAULT_MODULE');
define('DEFAULT_PAGE', '$DEFAULT_PAGE');
define('DEFAULT_LEVEL', '$DEFAULT_LEVEL');

?>";
  fwrite($fp, $data);
  fclose($fp);

//save the custom css
$fp = fopen('custom/custom.css','w');
fwrite($fp, $custom_css);
fclose($fp);
//save the custom js
$fp = fopen('custom/custom.js','w');
fwrite($fp, $custom_js);
fclose($fp);

echo ' <script> location.replace("configuration"); </script>';

}


$custom_css = file_get_contents("custom/custom.css");
$custom_js = file_get_contents("custom/custom.js");

/*check updates
$update = file_get_contents("http://toolboxsv.com/api/CMS/version.php");
$update = json_decode($update);
*/

?>
<!-- START CONTENT -->
<div class="content">

  <div class="row presentation">

      <div class="col-lg-8 col-md-6 titles">
        <span class="icon color2-bg"><i class="fa fa-cog"></i></span>
        <h1><?=$lan["conf"]?></h1>
        <h4><?=$lan["conf_details"]?></h4>
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
                    <li role="presentation" class=""><a href="#mail" aria-controls="mail" role="tab" data-toggle="tab" class="" aria-expanded="false"><?=$lan["mail"]?></a></li>
                    <li role="presentation" class=""><a href="#advance" aria-controls="advance" role="tab" data-toggle="tab" class="" aria-expanded="false"><?=$lan["advance"]?></a></li>
                    <li role="presentation" class=""><a href="#css" aria-controls="css" role="tab" data-toggle="tab" class="" aria-expanded="false">CSS</a></li>
                    <li role="presentation" class=""><a href="#js" aria-controls="js" role="tab" data-toggle="tab" class="" aria-expanded="false">JS</a></li>
                  </ul>

                  <!-- Tab panes -->
                  <form action="<?=BASE_URL?>/m/general/configuration" method="POST">
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="general">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Base Url</label>
                            <input type="text" class="form-control" name="BASE_URL" value="<?=BASE_URL?>">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Name</label>
                            <input type="text" class="form-control" name="NAME" value="<?=NAME?>">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Slogan</label>
                            <input type="text" class="form-control" name="SLOGAN" value="<?=SLOGAN?>">
                          </div>
                        </div>
                        
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Principal email</label>
                            <input type="email" class="form-control" name="P_EMAIL" value="<?=P_EMAIL?>">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Logo Url</label>
                            <input type="text" class="form-control" name="LOGO" value="<?=LOGO?>">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Favicon (PNG URL)</label>
                            <input type="text" class="form-control" name="FAVICON" value="<?=FAVICON?>">
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Principal Color</label>
                            <input type="text" class="form-control" name="COLOR" value="<?=COLOR?>">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Language</label>
                            <input type="text" class="form-control" name="LANGUAGE" value="<?=LANGUAGE?>">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Copyright</label>
                            <input type="text" class="form-control" name="COPYRIGHT" value="<?=COPYRIGHT?>">
                          </div>
                        </div>
                        
                        
                        
                      </div>
                      <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                              <label for="input1" class="form-label">Timezone</label>
                              <input type="text" class="form-control" name="TIMEZONE" value="<?=TIMEZONE?>">
                            </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Force HTTPS</label>
                            <select class="selectpicker form-control" name="FORCE_HTTPS">
                              <option value="1" <?php if (FORCE_HTTPS == 1) { echo "selected"; }?> >Yes</option>
                              <option value="0" <?php if (FORCE_HTTPS == 0) { echo "selected"; }?> >No</option>
                            </select> 
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Auto Updates</label>
                            <select class="selectpicker form-control" name="AUTO_UPDATE">
                              <option value="1" <?php if (AUTO_UPDATE == 1) { echo "selected"; }?> >Yes</option>
                              <option value="0" <?php if (AUTO_UPDATE == 0) { echo "selected"; }?> >No</option>
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
                            <input type="text" class="form-control" name="DATABASE_NAME" value="<?=DATABASE_NAME?>">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="input1" class="form-label">Database User</label>
                            <input type="text" class="form-control" name="DATABASE_USER" value="<?=DATABASE_USER?>">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="input1" class="form-label">Database Password</label>
                            <input type="password" class="form-control" name="DATABASE_PASS" value="<?=DATABASE_PASS?>">
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="form-group">
                            <label for="input1" class="form-label">Database Host</label>
                            <input type="text" class="form-control" name="DATABASE_HOST" value="<?=DATABASE_HOST?>">
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
                              <option value="1" <?php if (NLOGIN_ENABLE == 1) { echo "selected"; }?> >Yes</option>
                              <option value="0" <?php if (NLOGIN_ENABLE == 0) { echo "selected"; }?> >No</option>
                            </select> 
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Enable register option?</label>
                            <select class="selectpicker form-control" name="REGISTER_ENABLE">
                              <option value="1" <?php if (REGISTER_ENABLE == 1) { echo "selected"; }?> >Yes</option>
                              <option value="0" <?php if (REGISTER_ENABLE == 0) { echo "selected"; }?> >No</option>
                            </select> 
                          </div>
                        </div>
                         <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Enable forgot password option?</label>
                            <select class="selectpicker form-control" name="FORGOT_ENABLE">
                              <option value="1" <?php if (FORGOT_ENABLE == 1) { echo "selected"; }?> >Yes</option>
                              <option value="0" <?php if (FORGOT_ENABLE == 0) { echo "selected"; }?> >No</option>
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
                              <option value="1" <?php if (GLOGIN_ENABLE == 1) { echo "selected"; }?> >Yes</option>
                              <option value="0" <?php if (GLOGIN_ENABLE == 0) { echo "selected"; }?> >No</option>
                            </select> 
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Google Client ID</label>
                            <input type="text" class="form-control" name="GLOGIN_CLIENT_ID" value="<?=GLOGIN_CLIENT_ID?>">
                          </div>
                        </div>
                         <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Google Client Secret</label>
                            <input type="text" class="form-control" name="GLOGIN_CLIENT_SECRET" value="<?=GLOGIN_CLIENT_SECRET?>">
                          </div>
                        </div>
                      </div>
                      <hr>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Enable Facebook Login?</label>
                            <select class="selectpicker form-control" name="FLOGIN_ENABLE">
                              <option value="1" <?php if (FLOGIN_ENABLE == 1) { echo "selected"; }?> >Yes</option>
                              <option value="0" <?php if (FLOGIN_ENABLE == 0) { echo "selected"; }?> >No</option>
                            </select> 
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Facebook App ID</label>
                            <input type="text" class="form-control" name="FLOGIN_APP_ID" value="<?=FLOGIN_APP_ID?>">
                          </div>
                        </div>
                         <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Facebook App Secret</label>
                            <input type="text" class="form-control" name="FLOGIN_APP_SECRET" value="<?=FLOGIN_APP_SECRET?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="mail">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Default Mail</label>
                            <select class="selectpicker form-control" name="MAIL_TYPE">
                            <option value="1"  <?php if ($MAIL_TYPE == 1 OR MAIL_TYPE == 1) { echo "selected"; }?>  >Server Default</option>
                            <option value="2"  <?php if ($MAIL_TYPE == 2 OR MAIL_TYPE == 2) { echo "selected"; }?>  >Mandrill</option>
                            <option value="3"  <?php if ($MAIL_TYPE == 3 OR MAIL_TYPE == 3) { echo "selected"; }?>  >SendGrid</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Mandrill Key</label>
                            <input type="text" class="form-control" name="MAIL_MANDRILL_KEY" value="<?=MAIL_MANDRILL_KEY?>">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">SendGrid Key</label>
                            <input type="text" class="form-control" name="MAIL_SENDGRID_KEY" value="<?=MAIL_SENDGRID_KEY?>">
                          </div>
                        </div>
                        
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="advance">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Default module</label>
                            <input type="text" class="form-control" name="DEFAULT_MODULE" value="<?=DEFAULT_MODULE?>">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Default page</label>
                            <input type="text" class="form-control" name="DEFAULT_PAGE" value="<?=DEFAULT_PAGE?>">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label">Default level</label>
                            <select class="selectpicker form-control" name="DEFAULT_LEVEL">
                              <?php
                                $datarow = $db->select("levels","name <> ''");
                                foreach ($datarow as $key => $value) {
                              ?>
                                <option value="<?=$datarow[$key]["id"]?>" <?php if ($datarow[$key]["id"] == DEFAULT_LEVEL OR $DEFAULT_LEVEL == $datarow[$key]["id"]) { echo "selected"; }?> ><?=$datarow[$key]["name"]?></option>
                              <?php
                                }
                              ?>
                            </select> 

                                  
                          </div>
                        </div>
                      </div>
                    </div>


                    <div role="tabpanel" class="tab-pane" id="css">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <label for="input1" class="form-label">Custom CSS</label>
                            <textarea class="form-control" name="custom_css" rows="20"><?=$custom_css?></textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="js">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                          <label for="input1" class="form-label">Custom JS</label>
                            <textarea class="form-control" name="custom_js" rows="20"><?=$custom_js?></textarea>
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
