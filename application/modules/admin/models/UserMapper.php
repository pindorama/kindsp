<?php

class Model_UserMapper
{
protected $_dbTable;
	
    public function getDbTable() {
    	if (null === $this->_dbTable) {
            $this->setDbTable('Model_DbTable_Users');
        }
    	return $this->_dbTable;
    }
    
    public function setDbTable($dbTable) {
        if (is_string($dbTable)) {
            $dbTable = new $dbTable();
        }
    	if (!$dbTable instanceof Zend_Db_Table_Abstract) {
            throw new Exception('Ungueltige Gateway-Klasse fuer Tabellendaten');
        }
    	$this->_dbTable = $dbTable;
    }

    public function save(Model_User $user) {
    	$data = array(
    		'id'		=> $user->getId(),
    		'username'	=> $user->getUsername(),
    		'email'		=> $user->getEmail(),
    		'password'	=> $user->getPassword(),		
                'gender'	=> $user->getGender(),
                'role'          => $user->getRole()
    		
    	);
    	if (null === $user->getId()) {
    		unset($data['id']);
    		$data['created'] = time();
    		$user->setId($this->getDbTable()->insert($data));
    	}
    	else {
    		$data['modified'] = time();
    		$this->getDbTable()->update($data, array('id = ?' => $data['id']));
    	}
    	return $this;
    }
    
    public function find($id, Model_User $user) {
    	$result = $this->getDbTable()->find($id);
    	if (0 == count($result)) {
    		return null;
    	}
    	$row = $result->current();
    	$user->setId($row['id'])
    		
    		->setUsername($row['username'])
    		->setEmail($row['email'])
                ->setPassword($row['password'])
                ->setGender($row['gender'])
                ->setRole($row['role']);
                
    }
    
    public function fetchAll() {
    	$resultSet = $this->getDbTable()->fetchAll();
    	$entries = array();
    	foreach ($resultSet as $row) {
    		$entry = new Model_User();
    		$entry->setId($row['id'])
	    		->setUsername($row['username'])
	    		->setEmail($row['email'])
                        ->setPassword($row['password'])
                        ->setGender($row['gender'])
                        ->setRole($row['role']);
    		$entries[] = $entry;
    	}
    	return $entries;
    }

}
