<?php
App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class Transaction extends AppModel 
{
	public $name = 'Transaction';
	public $helpers = array('Html', 'Form');
	public $belongsTo = array('Paramedic' => array( 'className'=> 'Paramedic', 'foreignKey'=> 'rmp_id'));
}