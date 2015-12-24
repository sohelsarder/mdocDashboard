<?php


App::uses('AppController', 'Controller');


class SystemsController extends AppController {
	
	public $name = 'Systems';
	public $uses = array('System');
	
	//  get list
	public function index(){
		$this->adminPermission();
		$v = $this->_model();
		$this->set('title_for_layout', __($v.'  List'));
		$this->$v->recursive = 0;		
		$this->paginate = array('fields'=> array('id','name'),'limit' => 20,'order'=>'id desc');		
		$this->set('values', $this->paginate($v));
		
	}
	// add action 
	public function add(){
		$this->adminPermission();
		$v = $this->_model();
		$this->set('title_for_layout', __($v.' Add'));
		
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
		
		$diseaes = $this->$v->Disease->find('list');
		
		$this->set(compact('diseaes'));
		
	}
	// edit action
	public function edit($id = null){
		$this->adminPermission();
		if(empty($id)){
			$this->redirect(array('action' => 'index'));
		}
		$v = $this->_model();
		$this->set('title_for_layout', __('Edit'.$v));
		
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
	// delete action
	public function delete($id) {
		$this->adminPermission();
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
