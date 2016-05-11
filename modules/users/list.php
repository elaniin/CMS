<?php
if(isset($_GET['mode'])) {
    $mode = $_GET['mode'];
    $userid = $_GET['id'];

  if($mode=="delete"){
    $db->delete("users", "id = $userid");
      $msg = "<div class='kode-alert kode-alert-icon alert3'><i class='fa fa-check'></i><a href='#' class='closed'>×</a>".$lan["delete_success"]."</div>";
  }
}

if(isset($_POST['submit-form'])) {
    $data = array( 
        "name" => "'$account_name'", 
        "email" => "'$account_email'", 
        "phone" => "'$account_phone'", 
        "level" => "'$account_level'", 
    );
    $db->update($data, "users", "id = $account_id");
    $msg = "<div class='kode-alert kode-alert-icon alert3'><i class='fa fa-check'></i><a href='#' class='closed'>×</a>".$lan["update_success"]."</div>";

}

?>

<div class="content">

  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title"><?=$lan["users_title"]?></h1>
      <ol class="breadcrumb">
        <li><a href="<?=BASE_URL?>">Dashboard</a></li>
        <li class="active"><?=$lan["users_title"]?></li>
      </ol>



  </div>
  <!-- End Page Header -->


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

  <!-- Start Row -->
  <div class="row">

    <!-- Start Panel -->
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-body table-responsive">

            <table id="example0" class="table display">
                <thead>
                    <tr>
                        <th><?=$lan["name"]?></th>
                        <th><?=$lan["level"]?></th>
                        <th><?=$lan["email"]?></th>
                        <th><?=$lan["phone"]?></th>
                        <th><?=$lan["join_date"]?></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        //list of levels
                        $datarow = $db->select("levels","id > 0");
                        foreach ($datarow as $key => $value) {
                            $alllevels[$datarow[$key]["id"]] = $datarow[$key]["name"];
                        }
                        //get all users
                        $list_users = $db->select("users","id > 0 ORDER BY id ASC");
                        foreach ($list_users as $key => $value) {


                            if (!empty($list_users[$key]["google_picture"])) {
                                $avatar = $list_users[$key]["google_picture"]; 
                            }elseif (!empty($list_users[$key]["facebook_picture"])) {
                                $avatar = $list_users[$key]["facebook_picture"];
                            }else{
                                $avatar = BASE_URL."/img/avatar_default.jpg";
                            }
                            
                            $id = $list_users[$key]["id"];
                        echo "
                            <tr>
                                <td><img src='$avatar' class='avatarlist'> ".$list_users[$key]["name"]."</td>
                                <td>".$alllevels[$list_users[$key]["level"]]."</td>
                                <td>".$list_users[$key]["email"]."</td>
                                <td>".$list_users[$key]["phone"]."</td>
                                <td>".$list_users[$key]["join_date"]."</td>";
                        echo "  <td>
                                <center>
                                    <div class='btn-group' role='group' aria-label='...'>
                                        <a href='".BASE_URL."/m/users/update&id=$id' class='btn btn-light btn-xs'><i class='fa fa-pencil'></i></a>";
                        if (in_array("Delete", $modulesthislevel)) {      
                            echo "<a href=\"javascript:confirmDelete('".BASE_URL."/m/users/list&mode=delete&id=".$id."')\" class='btn btn-light btn-xs'><i class='fa fa-remove'></i></a>";
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
    <!-- End Panel -->
  </div>



</div>