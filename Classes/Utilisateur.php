<?php
class Utilisateur{
    protected $id;
    protected $email;
    protected $password;

    public function __construct($email,$password , $id=0 ){
        $this->id = $id;
        $this->email = $email;
        $this->password = $password;
    }
// lecture => les getter
    public function getId(){
        return $this->id;
    }
    public function getEmail(){
        return $this->email;
    }
    public function getpassword(){
        return $this->password;
    }
// modification => les setters
    public function setEmail( $email){
        $this->email = $email;
    }
    public function setMotDePasse( $password){
        $this->password = $password;
    }
    public function __toString(){
        return "user :" . $this ->id . " , email: " . $this->email;
    }
}
