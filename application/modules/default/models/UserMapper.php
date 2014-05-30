<?php

class Application_Model_UserMapper
{
    protected $_dbTable;
	
    public function getDbTable() {
    	if (null === $this->_dbTable) {
            $this->setDbTable('Application_Model_DbTable_Users');
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

    public function save(Application_Model_User $user) {
    	$data = array(
    		'id'			=> $user->getId(),
    		'username'		=> $user->getUsername(),
                'email'			=> $user->getEmail(),
    		'password'		=> $user->getPassword(),
                'gender'                => $user->getGender(),
                'role'                  => $user->getRole()
    	);
    	if (null === $user->getId()) {
    		unset($data['id']);
    		$data['created_at'] = time();
    		$user->setId($this->getDbTable()->insert($data));
    	}
    	else {
    		$data['updated_at'] = time();
    		$this->getDbTable()->update($data, array('id = ?' => $data['id']));
    	}
    	return $this;
    }
    
    public function find($id, Application_Model_User $user) {
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
     public function fetchAll($where = null, 
    							$order = null, 
    							$count = null, 
    							$offset = null) {
    	$resultSet = $this->getDbTable()->fetchAll($where, $order, $count, $offset);
    	$entries = array();
    	foreach ($resultSet as $row) {
    		$entry = new Application_Model_User();
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
    
    public function fetchOne($where = null, 
    							$order = null, 
    							$count = null, 
    							$offset = null) {
    	$resultSet = $this->fetchAll($where, $order, $count, $offset);
    	return count($resultSet) > 0 ? $resultSet[0] : null;
    }

    
   
	


}
