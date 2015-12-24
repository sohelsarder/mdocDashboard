<?php


App::uses('AppController', 'Controller');


class PatientsController extends AppController {
	
	public $name = 'Patients';
	public $uses = array('Patient');
	
	public function index(){
		$this->checkPermission();
		$v = $this->_model();
		$this->set('title_for_layout', __('Patient List'));
		$this->$v->recursive = 0;		
		$this->paginate = array('limit' => 20,'order'=>'id desc');		
		$this->set('values', $this->paginate($v));
		
	}
	
	public function add(){
		$this->checkPermission();
		$this->set('title_for_layout', __('Add Patient'));
		$v = $this->_model();
		if (!empty($this->request->data)) {			
			$this->$v->create();			
			if ($this->$v->save($this->request->data)) {				
				$this->Session->setFlash(__('Success'), 'default', array('class' => 'success'));				
				$this->redirect(array('action' => 'index'));
			} 
			else {
				$this->Session->setFlash(__($this->save_msg_error), 'default', array('class' => 'error'));
			}
		}		
		
	}
	
	
	public function edit($id = null){
		$this->checkPermission();
		if(empty($id)){
			$this->redirect(array('action' => 'index'));
		}
		$this->set('title_for_layout', __('Edit Patient'));
		
		if (!$id) {			
			
			$this->Session->setFlash(__('Invalid id for  '.$v), 'default', array('class' => 'error'));
			
			$this->redirect(array('action' => 'index'));
		}
		$v = $this->_model();
		
		if (!empty($this->request->data)) {
			
			$this->$v->create();
			
			if ($this->$v->save($this->request->data)) {
				
				$this->Session->setFlash(__('Success'), 'default', array('class' => 'success'));
				
				$this->redirect(array('action' => 'index'));
			} 
			else {
				$this->Session->setFlash(__($this->save_msg_error), 'default', array('class' => 'error'));
			}
		}
		
		$this->request->data = $this->$v->read(null,$id);	
		
	}
	public function delete($id) {
		$this->checkPermission();
		$v = $this->_model();
		if ($this->request->is('get')) {
		    throw new MethodNotAllowedException();
		}
	    
		if ($this->$v->delete($id)) {
		    $this->Session->setFlash(
			__('This has been deleted.')
		    );
		    return $this->redirect(array('action' => 'index'));
		}
	}
}
