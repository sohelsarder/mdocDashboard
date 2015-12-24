<?php
App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class MedicineList extends AppModel 
{
	public $name = 'MedicineList';
	public $helpers = array('Html', 'Form');
	
}