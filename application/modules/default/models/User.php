<?php

class Application_Model_User {

    protected $_id;
    protected $_username;
    protected $_email;
    protected $_password;
    protected $_gender;
    protected $_role;
    protected $_mapper;
    protected $_messageCount;

    public function __construct($options = null) {
        if (is_array($options)) {
            $this->setOptions($options);
        }
    }

    public function setOptions(array $options) {
        $methods = get_class_methods($this);
        foreach ($options as $key => $value) {
            $method = 'set' . ucfirst($key);
            if (in_array($method, $methods)) {
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

    public function getMapper() {
        if (null === $this->_mapper) {
            $this->_mapper = new Application_Model_UserMapper();
        }
        return $this->_mapper;
    }

    public function setMapper($mapper) {
        $this->_mapper = $mapper;
        return $this;
    }

    public function getId() {
        return $this->_id;
    }

    public function setId($value) {
        $this->_id = (int) $value;
        return $this;
    }

    public function getUsername() {
        return $this->_username;
    }

    public function setUsername($value) {
        $this->_username = (string) $value;
        return $this;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function setEmail($value) {
        $this->_email = (string) $value;
        return $this;
    }

    public function getPassword() {
        return $this->_password;
    }

    public function setPassword($value) {
        $this->_password = (string) $value;
        return $this;
    }

    public function getGender() {
        return $this->_gender;
    }

    public function setGender($value) {
        $this->_gender = (string) $value;
        return $this;
    }
    
        public function getRole() {
        return $this->_role;
    }

    public function setRole($value) {
        $this->_role = (string) $value;
        return $this;
    }

    public function getMessageCount() {
        return $this->_messageCount;
    }

    public function setMessageCount($value) {
        $this->_messageCount = (int) $value;
        return $this;
    }

}
