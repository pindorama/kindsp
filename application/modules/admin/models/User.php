<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author pindorama
 */
class Model_User {

    protected $_id;
    protected $_username;
    protected $_email;
    protected $_password;
    protected $_gender;
    protected $_role;
    protected $_mapper;


    //construct
    public function __construct($options = null) {
            if(is_array($options)){
                $this->setOptions($options);
            }
        }
        
    
   public function setOptions(array $options) {
       $methods = get_class_methods($this);
       foreach ($options as $key => $value) {
           $method = 'set'.ucfirst($key);
           if(in_array($method, $methods)) {
               $this->$method($value);
           }
           
       }
   }
   
       public function __get($name) {
        $method = 'get' . ucfirst($name);
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception("Ungueltige Getter-Methode fuer Eigenschaft '$method'");
        }
        return $this->$method();
    }
    
    public function __set($name, $value) {
        $method = 'set' . ucfirst($name);
        if ('mapper' == $name || !method_exists($this, $method)) {
            throw new Exception("Ungueltige Setter-Methode fuer Eigenschaft '$name'");
        }
        return $this->$method($value);
    }

 
   
   public function getId(){
       return $this->_id;
   }
    public function getUsername(){
       return $this->_username;
   }

    public function getEmail(){
       return $this->$_email;
   }
 public function getPassword(){
       return $this->_password;
   }
 public function getGender(){
       return $this->_gender;
   }
 public function getRole(){
       return $this->_role;
   }

  public function getMapper(){
       if(null === $this->_mapper){
           $this->_mapper = new Model_User();
       }
       return $this->_mapper;
       
   }

   

   public function setId($id) {
       $this->_id = (int) $id;
       return $this;
   }
   public function setUserName($value) {
        $this->_username = (string) $value;
       return $this;
   }
   public function setEmail($value) {
        $this->_email = (string) $value;
       return $this;
   }
   public function setPassword($value) {
        $this->_password = (string) $value;
       return $this;
   }
   public function setGender($value) {
        $this->_gender = (string) $value;
       return $this;
   }
   public function setRole($value) {
        $this->_role = (string) $value;
       return $this;
   }
   public function setMapper($mapper){
        $this->_mapper =  $mapper;
       return $this;
   }


}
?>
