<?php  
//UserTools.class.php  
  
class UserTools {  
  
    //Log the user in. First checks to see if the   
    //email and password match a row in the database.  
    //If it is successful, set the session variables  
    //and store the user object within.  
    public function login($email, $password)  
    {  
  
        $hashedPassword = md5($password);  
        $result = mysql_query("SELECT * FROM users WHERE email = '$email' AND password = '$hashedPassword'");  
  
        if(mysql_num_rows($result) == 1)  
        {  
            $_SESSION["user"] = new User(mysql_fetch_assoc($result));  
            $_SESSION["login_time"] = time();  
            $_SESSION["logged_in"] = 1;  
            return true;  
        }else{  
            return false;  
        }  
    }  
      
    //Log the user out. Destroy the session variables.  
    public function logout() {  
        unset($_SESSION['user']);  
        unset($_SESSION['login_time']);  
        unset($_SESSION['logged_in']);  
        unset($_SESSION['company_id']);  
        unset($_SESSION['company_data']);  
        session_destroy();  
    }  
  
    //Check to see if a username exists.  
    //This is called during registration to make sure all user names are unique.  
    public function checkUsernameExists($username) {  
        $result = mysql_query("select id from users where username='$username'");  
        if(mysql_num_rows($result) == 0)  
        {  
            return false;  
        }else{  
            return true;  
        }  
    }

    //Check to see if a email exists.  
    //This is called during registration to make sure all email are unique.  
    public function checkEmailExists($email) {  
        $result = mysql_query("select id from users where email='$email'");  
        if(mysql_num_rows($result) == 0)  
        {  
            return false;  
        }else{  
            return true;  
        }  
    }  
      
    //get a user  
    //returns a User object. Takes the users id as an input  
    public function get($id)  
    {  
        $db = new DB();  
        $result = $db->select('users', "id = $id");  
          
        return new User($result);  
    }  
      
}  
  
?>