<?php

// app/Model/User.php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

// app/Model/User.php
class QAddress extends AppModel {

 public $belongsTo = 'Qprofile';
 	public $useTable = 'QAddresses';

	public function beforeSave($options = array()) {
	//debug("in beforesave");
		if (isset($this->data[$this->alias]['password'])) {
			$passwordHasher = new SimplePasswordHasher();
			$this->data[$this->alias]['password'] = $passwordHasher->hash(
				$this->data[$this->alias]['password']
				
			);
		}
		return true;
	}
	
	
	
    public $validate = array(
        'unitNumber' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
				
            )
        ),
        'streetNumber' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
		'streetName' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A first name is required'
            )
        ),
		'stateProvince' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A first name is required'
            )
        ),
		'postalCode' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A first name is required'
            )
        )
		
    );
}

?>