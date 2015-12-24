<?php
App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class Condition extends AppModel 
{
	public $name = 'Condition';
	public $helpers = array('Html', 'Form');
	
}