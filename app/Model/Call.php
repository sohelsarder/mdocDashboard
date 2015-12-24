<?php
App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class Call extends AppModel {
	
	public $name = 'Call';
	public $helpers = array('Html', 'Form');
	public $belongsTo =array('Patient','User' => array( 'className'=> 'User', 'foreignKey'=> 'doctor_id'),'Paramedic' => array( 'className'=> 'Paramedic', 'foreignKey'=> 'rmp_id'));
	
	
}

