<?php
App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class Disease extends AppModel 
{
	public $name = 'Disease';
	public $helpers = array('Html', 'Form');
	
	public $belongsTo = array('System');
	
	public $validate = array(
		'name' => array(		
		    
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),
			 'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'The name has already been taken.',
				'last' => true,
			),
	
		),
		
		'system_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),				
		),
	);
}