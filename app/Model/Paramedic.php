<?php
App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class Paramedic extends AppModel 
{
	public $useTable = 'User';
	public $name = 'Paramedic';
	public $helpers = array('Html', 'Form');
	
	
}

