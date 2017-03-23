<?php  
//User.class.php  
  
  
  
class User {  
  
    public $id;  
    public $username;  
    public $name;  
    public $hashedPassword;  
    public $level;  
    public $email;  
    public $phone;  
    public $joinDate;  
    public $google_id;  
    public $google_link;  
    public $google_picture;  
    public $facebook_id;  
    public $facebook_link;  
    public $facebook_picture;  
  
    //Constructor is called whenever a new object is created.  
    //Takes an associative array with the DB row as an argument.  
    function __construct($data) {  
        $this->id = (isset($data['id'])) ? $data['id'] : "";  
        $this->name = (isset($data['name'])) ? $data['name'] : "";  
		$this->level = (isset($data['level'])) ? $data['level'] : "";  
        $this->hashedPassword = (isset($data['password'])) ? $data['password'] : "";  
        $this->email = (isset($data['email'])) ? $data['email'] : "";  
        $this->phone = (isset($data['phone'])) ? $data['phone'] : "";  
        $this->joinDate = (isset($data['join_date'])) ? $data['join_date'] : "";  
        $this->google_id = (isset($data['google_id'])) ? $data['google_id'] : "";  
        $this->google_link = (isset($data['google_link'])) ? $data['google_link'] : "";  
        $this->google_picture = (isset($data['google_picture'])) ? $data['google_picture'] : "";  
        $this->facebook_id = (isset($data['facebook_id'])) ? $data['facebook_id'] : "";  
        $this->facebook_link = (isset($data['facebook_link'])) ? $data['facebook_link'] : "";  
        $this->facebook_picture = (isset($data['facebook_picture'])) ? $data['facebook_picture'] : "";  
    }  
  
    public function save($isNewUser = false) {  
        //create a new database object.  
        $db = new DB();  
          
        //if the user is already registered and we're  
        //just updating their info.  
        if(!$isNewUser) {  
            //set the data array  
            $data = array(  
                "name" => "'$this->name'",  
                "password" => "'$this->hashedPassword'",  
				"level" => "'$this->level'",  
                "email" => "'$this->email'", 
                "phone" => "'$this->phone'", 
                                );  
              
            //update the row in the database  
            $db->update($data, 'users', 'id = '.$this->id); 
        }else { 
        //if the user is being registered for the first time. 
            $data = array( 
                "name" => "'$this->name'", 
                "password" => "'$this->hashedPassword'", 
                "level" => "'$this->level'", 
                "email" => "'$this->email'", 
                "phone" => "'$this->phone'", 
                "join_date" => "'".date("Y-m-d H:i:s",time())."'"
            );  
              
            $this->id = $db->insert($data, 'users');  
            $this->joinDate = time();  
        }  
        return true;  
    }  
      
}  
  
?>