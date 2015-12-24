<?php
App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class Medicine extends AppModel 
{
	public $name = 'Medicine';
	public $helpers = array('Html', 'Form');
	
	public $belongsTo = array('Disease');
	
}