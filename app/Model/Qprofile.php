<?php

// app/Model/User.php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

// app/Model/User.php
class Qprofile extends AppModel {

 /*public $hasOne = array(
        'Qaddress' => array
        (
            'className'  => 'Qaddress',
            'foreignKey' => 'addressID',
            'dependent'  => true
        )

    );*/
public $useTable = 'Qprofiles';
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
        'userName' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A username is required'
				
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A password is required'
            )
        ),
		'firstName' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A first name is required'
            )
        ),
		'lastName' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A first name is required'
            )
        ),
		'emailAddress' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A first name is required'
            )
        ),
		'dateCreated' => array(
            'required' => array(
                'rule' => array('notEmpty')
            )
        ),
		'dateOfBirth' => array(
            'required' => array(
                'rule' => array('notEmpty'),
				'message' => 'A date of birth is required'
            )
        ),
        'role' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'user')),
                'message' => 'Please enter a valid role',
                'allowEmpty' => false
            )
        ),
		'maleFemale' => array(
            'valid' => array(
                'rule' => array('inList', array('1', '0')),
                'message' => 'Must be a male or female cant be both or can you....',
                'allowEmpty' => false
            )
            ),
		'profilePic' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A profile image is required'
            )
        ),
		
    );
}

?>