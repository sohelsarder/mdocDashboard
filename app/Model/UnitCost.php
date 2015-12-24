<?php
App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class UnitCost extends AppModel 
{
	public $name = 'UnitCost';
	public $helpers = array('Html', 'Form');
	
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
		'amount' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),				
		),
	);
}