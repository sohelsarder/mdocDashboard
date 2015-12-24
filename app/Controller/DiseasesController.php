<?php


App::uses('AppController', 'Controller');


class DiseasesController extends AppController {
	
	public $name = 'Diseases';
	public $uses = array('Disease');
	
	public function index(){
		$this->adminPermission();
		$v = $this->_model();
		$this->set('title_for_layout', __('Disease List'));
		$this->$v->recursive = 0;		
		$this->paginate = array('fields'=> array('id','name'),'limit' => 20,'order'=>'id desc');		
		$this->set('values', $this->paginate($v));		
	}
	
	public function add(){
		$this->adminPermission();
		$this->set('title_for_layout', __('Add Disease'));
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
		$systems = $this->Disease->System->find('list');
		$this->set(compact('systems'));
	}
	
	public function edit($id = null){
		
		$this->adminPermission();
		if(empty($id)){
			$this->redirect(array('action' => 'index'));
		}	
		
		$this->set('title_for_layout', __('Edit Disease'));
		
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
		$systems = $this->Disease->System->find('list');
		$this->set(compact('systems'));		
	}
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
