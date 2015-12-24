<?php
App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class Patient extends AppModel 
{
	public $name = 'Patient';
	public $helpers = array('Html', 'Form');
	
	
}

