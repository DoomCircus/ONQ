<?php

// app/Model/User.php
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');

// app/Model/User.php
class Qprofile extends AppModel {

	public function beforeSave($options = array()) {
	//debug("in beforesave");
		
		return true;
	}
	
	
	
    public $validate = array(
       
		'typeName' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'A first name is required'
            )
        )
		
    );
}

?>