<?php
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $datarow = $db->select("users","id = $id");
    $name = $datarow[0]['name'];
    $email = $datarow[0]['email'];
    $level_id = $datarow[0]['level'];
    $phone = $datarow[0]['phone'];
}

?>

<div class="content">

  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title"><?=$name?></h1>
      <ol class="breadcrumb">
        <li><a href="<?=BASE_URL?>/m/users/list"><?=$lan["users_title"]?></a></li>
        <li class="active"><?=$name?></li>
      </ol>

    <!-- Start Page Header Right Div -->
    <div class="right">
      <div class="btn-group" role="group" aria-label="...">
        <a href="<?=BASE_URL?>/m/users/list" class="btn btn-light"><?=$lan["cancel"]?></a>
      </div>
    </div>
    <!-- End Page Header Right Div -->

  </div>
  <!-- End Page Header -->

<!-- START CONTAINER -->
<div class="container-padding margin-b-50">
    <div class="row">
<div class="col-md-12 padding-0">
      <div class="panel panel-transparent">
            <div class="panel-body">
              
                <div role="tabpanel">

                  <!-- Nav tabs -->
                  <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#general" aria-controls="general" role="tab" data-toggle="tab" aria-expanded="true" class="active"><?=$lan["general"]?></a></li>
                    <li role="presentation"><a href="#level" aria-controls="level" role="tab" data-toggle="tab" aria-expanded="true" class="active"><?=$lan["level"]?></a></li>
                    
                  </ul>

                  <!-- Tab panes -->
                  <form action="<?=BASE_URL?>/m/users/list" method="POST">
                  <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="general">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label"><?=$lan["name"]?></label>
                            <input type="text" class="form-control" name="account_name" value="<?=$name?>" required>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label"><?=$lan["email"]?></label>
                            <input type="email" class="form-control" name="account_email" value="<?=$email?>" required>
                          </div>
                        </div>
                         <div class="col-md-4">
                          <div class="form-group">
                            <label for="input1" class="form-label"><?=$lan["phone"]?></label>
                            <input type="text" class="form-control" name="account_phone" value="<?=$phone?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="level">
                      <div class="row">
                        <div class="col-md-12">
                          
                            <div class="form-group">
                                <label for="input1" class="form-label"><?=$lan["level"]?></label>
                                <select class="selectpicker form-control" name="account_level">
                                    <?php
                                    $datarow = $db->select("levels","id > 0");
                                    foreach ($datarow as $key => $value) {
                                      $sele = "";
                                      if ($level_id == $datarow[$key]["id"]) {
                                        $sele = "selected";
                                      }
                                      echo "<option value='".$datarow[$key]["id"]."' $sele >".$datarow[$key]["name"]."</option>";
                                    }
                                  ?>
                                </select> 
                            </div>
                        </div>
                        
                      </div>
                    </div>
                   
                  </div> 
                </div>              

            </div>
            <div class="panel-footer">
                <input type="hidden" name="account_id" value="<?=$id?>">
              <button type="submit" name="submit-form" class="btn btn-default"><?=$lan["save"]?></button>
              </form>
            </div>

      </div>
    </div>
    </div>

</div>
<!-- END CONTAINER -->