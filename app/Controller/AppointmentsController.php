<?php
App::uses('AppController', 'Controller');
class AppointmentsController extends AppController {
	
	public $name = 'Appointments';
	public $uses = array('Appointment');
	
	public function index(){
		$this->loadModel('User');
		$this->adminPermission();
		$v = $this->_model();
		$this->Appointment->Behaviors->attach('Containable');
		$this->set('title_for_layout', __('Appointment List'));
		$this->$v->recursive = 0;		
		$filter = array('fields'=>array('rmp_id','patient_id','created','temperature','color','respiration','dehydration','id'),'limit' => 20,'order'=>'Appointment.id asc','contain'=>array('Patient'=>array('fields'=>array('name'))));		
		$this->paginate =$filter;
		$values =  $this->paginate($v);
		
		$this->set(compact('values'));
		
	}
	
	public function add(){
		$this->adminPermission();
		$this->set('title_for_layout', __('Add Appointment'));
		$v = $this->_model();
		if (!empty($this->request->data)) {
			$patient = explode('__',$this->request->data['Appointment']['patient_id']);
			$conditions = array(			
				$v.'.rmp_id' => $this->request->data['Appointment']['rmp_id'],
				$v.'.patient_id' => $patient[1],			
			
			);
			if ($this->$v->hasAny($conditions)){
				
				$this->Session->setFlash(__('Already Taken Appointment'), 'default', array('class' => 'error'));
			}else{
				$this->$v->create();
							
				$this->request->data['Appointment']['patient_id'] = $patient[1];
				
				if ($this->$v->save($this->request->data)) {				
					$this->Session->setFlash(__('Success'), 'default', array('class' => 'success'));				
					$this->redirect(array('action' => 'index'));
				} 
				else {
					$this->Session->setFlash(__('Does Not Save'), 'default', array('class' => 'error'));
				}
			}
		}
		$this->loadModel('User');
		$users = $this->User->find('all',array('conditions'=>array('User.role_id' => 3)));
		$userName = '';
		foreach($users as $val){			
					
			$userName .= "'".$val['User']['name'].'-'.$val['User']['phone'].'__'.$val['User']['id']."'".',';
				
		}
		
		$this->set(compact('userName'));	
		
	}
	
	
	public function edit($id = null){
		$this->loadModel('User');
		$this->adminPermission();
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
			$patient = explode('__',$this->request->data['Appointment']['patient_id']);
			$this->request->data['Appointment']['patient_id'] = $patient[1];
			if ($this->$v->save($this->request->data)) {
				
				$this->Session->setFlash(__('Success'), 'default', array('class' => 'success'));
				
				$this->redirect(array('action' => 'index'));
			} 
			else {
				$this->Session->setFlash(__($this->save_msg_error), 'default', array('class' => 'error'));
			}
		}
		
		$this->request->data = $this->$v->read(null,$id);
		$users = $this->User->find('first',array('fields'=>array('name','id','phone'),'conditions'=>array('User.id'=> $this->request->data['Appointment']['patient_id'])));
		$this->request->data['Appointment']['patient_id'] = $users['User']['name'].'-'.$users['User']['phone'].'__'.$users['User']['id'];
		$this->loadModel('User');
		$users = $this->User->find('all',array('conditions'=>array('User.role_id' => 3)));
		$userName = '';
		foreach($users as $val){			
					
			$userName .= "'".$val['User']['name'].'-'.$val['User']['phone'].'__'.$val['User']['id']."'".',';
				
		}
		
		$this->set(compact('userName'));
		
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
	
	public function prescriptionlist($userId =null){
		
		
	}
	
	
}
