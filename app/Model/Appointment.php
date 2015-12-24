<?php
App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class Appointment extends AppModel 
{
	public $name = 'Appointment';
	public $helpers = array('Html', 'Form');
	
	public $validate = array(	
		 'patient_id' => array(		
            
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),
		),
		'age' => array(		
            
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),
		),
		'bp' => array(		
            
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),
		),
		
		'temperature' => array(		
            
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),
		),
		
		'pulse' => array(		
            
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),
		),
		'appearance' => array(		
            
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),
		),
		
		'color' => array(		
            
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),
		),
		
		'consciousness' => array(		
            
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),
		),

		'edema' => array(		
            
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),
		),
		
		'dehydration' => array(		
            
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),
		),
		
		'enlargement' => array(		
            
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),
		),
		'respiration' => array(		
            
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),
		),
	
	
	);
	
	public $hasMany =array('Prescription');
	public $belongsTo =array('Patient','User' => array( 'className'=> 'User', 'foreignKey'=> 'lockby'),'Paramedic' => array( 'className'=> 'Paramedic', 'foreignKey'=> 'rmp_id'));
	
	
}

