<?php


App::uses('AppController', 'Controller');


class CreditLimitsController extends AppController {
	
	public $name = 'CreditLimits';
	public $uses = array('Paramedic');
	
	public function index(){
		$this->adminPermission();
		$v = 'Paramedic';
		$this->set('title_for_layout', __('RMP List'));
		$this->$v->recursive = 0;		
		$this->paginate = array('fields'=> array('id','name','currentBalance','creditLimit','location','phone'),'conditions'=>array('Paramedic.role_id'=>4),'limit' => 20,'order'=>'id desc');		
		$this->set('values', $this->paginate($v));		
	}
	
	public function edit($id = null){
		
		$this->adminPermission();
		if(empty($id)){
			$this->redirect(array('action' => 'index'));
		}	
		
		$this->set('title_for_layout', __('Edit Credit Limits'));
		
		if (!$id) {			
			
			$this->Session->setFlash(__('Invalid id for  '.$v), 'default', array('class' => 'error'));			
			$this->redirect(array('action' => 'index'));
		}
		$v = 'Paramedic';
		
		if (!empty($this->request->data)) {
			$value = $this->request->data[$v]['creditLimit'];			
			$this->$v->create();
			if($this->$v->updateAll(array($v.'.creditLimit' => $value),array($v.'.id' => $id))){
				$this->Session->setFlash(__('Success'), 'default', array('class' => 'success'));				
				$this->redirect(array('action' => 'index'));	
			}			
			else {
				$this->Session->setFlash(__($this->save_msg_error), 'default', array('class' => 'error'));
			}
		}			
		$this->request->data = $this->$v->read(null,$id);
			
	}
	
}
