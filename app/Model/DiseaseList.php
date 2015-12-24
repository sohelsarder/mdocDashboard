<?php
App::uses('Model', 'Model');
App::uses('AuthComponent', 'Controller/Component');

class DiseaseList extends AppModel 
{
	public $name = 'DiseaseList';
	public $helpers = array('Html', 'Form');
	
}