<?php
App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class Prescription extends AppModel 
{
	public $name = 'Prescription';
	public $helpers = array('Html', 'Form');
	public $belongsTo = array('Appointment');
	
	public $validate = array(
		'appointment_id' => array(
			'isUnique' => array(
				'rule' => 'isUnique',
				'message' => 'Prescription already created .',
				'last' => true,
			),
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),
		),
		'paymentType' => array(			
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'This field cannot be left blank.',
				'last' => true,
			),
			
		),
	
	); 
	
}