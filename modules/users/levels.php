<?php
$modetype = "add";
if(isset($_POST['submit-form'])) {
    
        $levelmodules = json_encode($levelmodules);
        $data = array( 
            "name" => "'$name'",
            "modules" => "'$levelmodules'",
        );
        if ($mode == "add") {
            $db->insert($data, "levels");
            $msg = "<div class='kode-alert kode-alert-icon alert3'><i class='fa fa-check'></i><a href='#' class='closed'>×</a>".$lan["add_success"]."</div>";
        }
        if ($mode == "update") {
            $db->update($data, "levels", "id = $levelid");
            $msg = "<div class='kode-alert kode-alert-icon alert3'><i class='fa fa-check'></i><a href='#' class='closed'>×</a>".$lan["update_success"]."</div>";
        }
}
if(isset($_GET['mode'])) {
    $mode = $_GET['mode'];
    $levelid = $_GET['id'];

  if($mode=="delete"){
    $db->delete("levels", "id = $levelid");
      $msg = "<div class='kode-alert kode-alert-icon alert3'><i class='fa fa-check'></i><a href='#' class='closed'>×</a>".$lan["delete_success"]."</div>";
  }
  if($mode=="updateform"){
    //get the info
    $modetype = "update";
        $datarow = $db->select("levels","id = $levelid");
        $levelname = $datarow[0]['name'];
        $levelmodules_update = $datarow[0]['modules'];
        $levelmodules_update = json_decode($levelmodules_update);
        foreach ($levelmodules_update as $key => $value) {
            $levelmodules_update[$value] = $value;
        }
  }
}
?>
<!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTENT -->
<div class="content">

  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title"><?=$lan["levels_title"]?></h1>
      <ol class="breadcrumb">
        <li><a href="<?=BASE_URL?>">Dashboard</a></li>
        <li><a href="<?=BASE_URL?>/m/users/list"><?=$lan["users"]?></a></li>
        <li class="active"><?=$lan["levels_title"]?></li>
      </ol>
  </div>
  <!-- End Page Header -->

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTAINER -->
<div class="container-default">
    <?php  
        if($msg != ""){         
            echo "
            <div class='row'>
                <div class='col-md-12'>
                    $msg
                </div>
            </div>";
        }  
    ?>  
  <div class="row">
    <div class="col-md-8">
      <div class="panel panel-default">
        <div class="panel-body table-responsive">

            <table id="example0" class="table display">
                <thead>
                    <tr>
                        <th><?=$lan["name"]?></th>
                        <th><?=$lan["modules"]?></th>
                        <th></th>
                        
                    </tr>
                </thead>
             
                <tbody>
                <?php
                
                $datarow = $db->select("levels","id > 0");
                foreach ($datarow as $key => $value) {
                        $id = $datarow[$key]['id'];
                        $levelmodules = "";
                        $name = $datarow[$key]['name'];
                        $levelmodules = $datarow[$key]['modules'];
                        $levelmodules = json_decode($levelmodules);

                    echo "
                        <tr>
                            <td><span class='label label-success'>$name</span></td>
                            <td>";
                            foreach ($levelmodules as $key => $value) {
                              echo "$value <br>";
                            }
                    echo "</td>
                            <td>
                            <center>
                                <div class='btn-group' role='group' aria-label='...'>
                                    <a href='".BASE_URL."/m/users/levels&mode=updateform&id=$id' class='btn btn-light btn-xs'><i class='fa fa-pencil'></i></a>";
                    if (in_array("Delete", $modulesthislevel) AND $id != 1 AND $id != 2) {      
                        echo "<a href=\"javascript:confirmDelete('".BASE_URL."/m/users/levels&mode=delete&id=".$id."')\" class='btn btn-light btn-xs'><i class='fa fa-remove'></i></a>";
                    }
                    echo "                                    
                                </div>
                            </center>
                                
                            </td>
                        </tr>                
                    ";
                }

                ?>                


                </tbody>
            </table>


        </div>

      </div>        
    </div>
    <div class="col-md-4">
        <div class="panel panel-default">

            <div class="panel-title">
              <?=$lan["add_new"]?>
              <ul class="panel-tools">
                <li><a class="icon expand-tool"><i class="fa fa-expand"></i></a></li>
              </ul>
            </div>

                <div class="panel-body">
                  <form method="POST" action="<?=BASE_URL?>/m/users/levels">
                    <div class="form-group">
                      <label for="input1" class="form-label"><?=$lan["name"]?></label>
                      <input type="text" name="name" class="form-control" required value="<?=$levelname?>">
                    </div>
                    <div class="form-group">
                        <label for="input1" class="form-label"><?=$lan["modules"]?></label>
                        <select class="form-control selectpicker" name="levelmodules[]" multiple >
                            <?php
                                $sele = "";
                                if (in_array("Admin",$levelmodules_update)) {
                                    $sele = "selected";
                                }
                                echo "<option value='Admin' $sele >Admin Power</option>";
                                $sele = "";
                                if (in_array("Delete",$levelmodules_update)) {
                                    $sele = "selected";
                                }
                                echo "<option value='Delete' $sele >Delete Power</option>";
                                foreach ($allmodule as $key => $value) {
                                    $sele = "";
                                    if (in_array($key,$levelmodules_update)) {
                                        $sele = "selected";
                                    }
                                    echo "<option value='$key' $sele >$key</option>";
                                }
                            ?>
                        </select>
                    </div>
                    <input type="hidden" name="mode" value="<?=$modetype?>">
                    <input type="hidden" name="levelid" value="<?=$levelid?>">
                    <button type="submit" name="submit-form" class="btn btn-default"><?=$lan["save"]?></button>
                  </form>

                </div>

        </div>
    </div>

  </div>



</div>
<!-- END CONTAINER -->
<!-- //////////////////////////////////////////////////////////////////////////// --> 