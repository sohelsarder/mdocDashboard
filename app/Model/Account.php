<?php
App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class Account extends AppModel 
{
	public $name = 'Account';
	public $helpers = array('Html', 'Form');
	
	public $belongsTo = array('Paramedic' => array( 'className'=> 'Paramedic', 'foreignKey'=> 'rmp_id'));
}