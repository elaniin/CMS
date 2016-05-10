<?php
if(isset($_POST['submit-form'])) {
    $data = array( 
        "name" => "'$account_name'", 
        "email" => "'$account_email'", 
        "phone" => "'$account_phone'", 
    );
    $db->update($data, "users", "id = $userid");
    $user = $_SESSION['user']; 
    $user->name = $account_name;
    $user->email = $account_email;
    $user->phone = $account_phone;
    $_SESSION['user'] = $user;
}
?>
<!-- START CONTENT -->
<div class="content">

  <div class="row presentation">

      <div class="col-lg-8 col-md-6 titles">
        <span class="icon color2-bg"><i class="fa fa-square"></i></span>
        <h1><?=$lan["my_account"]?></h1>
        <h4><?=$lan["my_account_details"]?></h4>
      </div>

      <div class="col-lg-4 col-md-6">

      </div>

  </div>  


<!-- START CONTAINER -->
<div class="container-padding">
    <div class="row">
<div class="col-md-12 padding-0">
      <div class="panel panel-transparent" style="margin-top:-87px;">
            <div class="panel-body">
              
                <div role="tabpanel">

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab" aria-expanded="true" class="active"><?=$lan["my_account"]?></a></li>
                    
                  </ul>

                  <!-- Tab panes -->
                  <form action="<?=BASE_URL?>/m/general/my-account" method="POST">
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="general">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label"><?=$lan["name"]?></label>
                            <input type="text" class="form-control" name="account_name" value="<?=$user->name?>" required>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label"><?=$lan["email"]?></label>
                            <input type="email" class="form-control" name="account_email" value="<?=$user->email?>" required>
                          </div>
                        </div>
                         <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label"><?=$lan["phone"]?></label>
                            <input type="text" class="form-control" name="account_phone" value="<?=$user->phone?>">
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
