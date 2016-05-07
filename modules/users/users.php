<?php 
$current_page = "users";
//initialize php variables used in the form
$username = "";
$password = "";
$password_confirm = "";
$email = "";
$level = "";
$error = "";

//check to see that the form has been submitted
if(isset($_POST['submit-form'])) { 

  //retrieve the $_POST variables
  $username = $_POST['username'];
  $name = $_POST['name'];
  $password = $_POST['password'];
  $password_confirm = $_POST['repassword'];
  $email = $_POST['email'];
  $level = $_POST['level'];
  $cellphone = $_POST['cellphone'];

  //initialize variables for form validation
  $success = true;
  $userTools = new UserTools();

  //validate that the form was filled out correctly
  //check to see if user name already exists
  if($userTools->checkEmailExists($email))
  {
      $msg .= $lan["users_emailexist"];
      $success = false;
  }

  //check to see if passwords match
  if($password != $password_confirm) {
      $msg .= "Passwords do not match.<br/> \n\r";
      $success = false;
  }

  if($success)
  {
      //prep the data for saving in a new user object
      $data['username'] = $username;
      $data['name'] = $name;
      $data['password'] = md5($password); //encrypt the password for storage
      $data['email'] = $email;
      $data['level'] = $level;
      $data['cellphone'] = $cellphone;

      //create the new user object
      $newUser = new User($data);
    //save the new user to the database
      $newUser->save(true);
        $functions = new Functions();
        $functions->addactivity("user"," add a <b>new user</b>  to the system. ");
    $msg =$lan["users_success"];
      

  }

}
if(isset($_GET['mode'])) {
$mode = $_GET['mode'];
$id = $_GET['id'];
  }
  if($mode=="delete"){
    $db->delete("lup_companies_user", "company = $lc AND user = $id");
    $msg =$lan["users_deleted"];
  }
  if($mode=="update"){
$level = $_POST['level'];


      $data = array( 
        "levels" => "'$level'",
            );
    $db->update($data, "lup_users_levels", "company = $lc AND users = $id");
    $msg =$lan["users_updated"];    
  }

?>

              <div class='row'>
                <div class='col-sm-12'>
                  <div class='page-header'>
                    <h1 class='pull-left'>
                      <i class='icon-bookmark'></i>
                      <span><?=$lan["users_title"]?></span>
                    </h1>
                    <div class='pull-right'>
                      <ul class='breadcrumb'>
                        Dashboard
                        <li class='separator'>
                          <i class='icon-angle-right'></i>
                        </li>
                        <li class='active'><?=$lan["users_title"]?></li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>

              <div class='row'>
                <div class='col-sm-12'>
            <?php  
              if($msg != "")  
              {         
                echo "<div class='alert alert-success'>".$msg."</div>";  
              }  
            ?>                      
                  <div class='box bordered-box orange-border' style='margin-bottom:0;'>
                    <div class='box-header muted-background'>
                      <div class='title'><?=$lan["users_title"]?></div>
                      <div class='actions'>
                        <a href="<?= $crm_settings["baseurl"]?>m/users/users-invite"><button class="btn btn-success" type="button"><?=$lan["addnew"]?></button></a>
                      </div>
                    </div>
                    <div class='box-content box-no-padding'>
                      <div class='responsive-table'>
                        <div class='scrollable-area'>
                        <table class='data-table2 table table-bordered table-striped' style='margin-bottom:0;'>
                                <thead>
                              <tr>
                                <th><?=$lan["levels_title"]?></th>
                                <th>Username</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th><?=$lan["users_cellphone"]?></th>
                                <th></th>
                              </tr>
                            </thead>
                            <tbody>
                <?php
               $companyusers = $db->select("lup_companies_user","company = $lc");
                foreach ($companyusers as $key => $value) {
                $usercompid = $value["user"];
                $datarow = $db->select("users","id = $usercompid");
                

                        $id = $datarow[0]['id'];
                        $username = $datarow[0]['username'];
                        $name = $datarow[0]['name'];
                        //get level id
                        $datarowx = $db->select("lup_users_levels","company = $lc AND users = $id");
                        $level = $datarowx[0]["levels"];

                        $email = $datarow[0]['email'];
                        $cellphone = $datarow[0]['cellphone'];
                          $datalevels = $db->select("levels","id = $level");
                          $levelname = $datalevels[0]['name'];

                        echo "
                              <tr>
                                <td>$levelname</td>
                                <td><span class='label label-inverse'>$username</span></td>
                                <td>$name</td>
                                <td>$email</td>
                                <td>$cellphone</td>
                                <td>
                                  <div class='text-right'>
                                    <a class='btn btn-warning btn-xs' href='".$crm_settings["baseurl"]."m/users/users-form&mode=update&id=$id'><i class='icon-pencil'></i></a>";

                        if (in_array("Delete", $modulesthislevel)) { 
                          echo "
                                <a class='btn btn-danger btn-xs' href=\"javascript:confirmDelete('".$crm_settings["baseurl"]."m/users/users&mode=delete&id=".$id."')\" >
                                        <i class='icon-remove'></i>
                                </a>
                          ";
                        }
                        echo "
                                  </div>
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
                  </div>
                </div>
              </div>
