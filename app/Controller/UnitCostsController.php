<?php


App::uses('AppController', 'Controller');


class UnitCostsController extends AppController {
	
	public $name = 'UnitCosts';
	public $uses = array('UnitCost');
	
	public function index(){
		$this->adminPermission();
		$v = 'UnitCost';
		$this->set('title_for_layout', __('Unit Cost Name '));
		$this->$v->recursive = 0;		
		$this->paginate = array('limit' => 20,'order'=>'id desc');		
		$this->set('values', $this->paginate($v));		
	}
	public function add(){
		$this->adminPermission();
		$this->set('title_for_layout', __('Add Unit Cost Name'));
		$v = 'UnitCost';
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
		$this->adminPermission();
		if(empty($id)){
			$this->redirect(array('action' => 'index'));
		}
		$this->set('title_for_layout', __('Edit Unit Cost Name'));
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for  '.$v), 'default', array('class' => 'error'));			
			$this->redirect(array('action' => 'index'));
		}
		$v = 'UnitCost';		
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
		$this->adminPermission();
		$v = 'UnitCost';
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
	
	function getUnitCost($id =null){ // sent to rmp account information
		$v = 'UnitCost';		
		$this->loadModel('Appointment');
		$this->loadModel('Transaction');
		$appQty  = 0;
		$last_transaction = $this->Transaction->find('first',array('conditions'=>array('Transaction.rmp_id'=> $id),'order'=> 'Transaction.created desc '));
		$this->Appointment->recursive = -1;
		if(!empty($last_transaction['Transaction']['created'])){
			$appQtyFollowUp = $this->Appointment->find('count',array('conditions'=> array('Appointment.created >'=> $last_transaction['Transaction']['created'],'Appointment.rmp_id'=> $id,'Appointment.is_followup'=> 1))); // foloowup quantity after a transaction
			$appQtyNew = $this->Appointment->find('count',array('conditions'=> array('Appointment.created >'=> $last_transaction['Transaction']['created'],'Appointment.rmp_id'=> $id,'Appointment.is_followup'=> 0))); // appointmet quantity after a transaction
		}
		$return = new stdClass();
		$return->qtyNew = $appQtyNew+1;
		$return->qtyFolluUp = $appQtyFollowUp+1;		
		$unit_costs = $this->$v->find('all');
		$cost_name = array();
		$cost = array();
		$cost_id = array();
		foreach($unit_costs as $key => $value){
			$cost_name[$key]= $value['UnitCost']['name'];
			$cost_id[$key]= $value['UnitCost']['id'];
			$cost[$key] = $value['UnitCost']['mpower_amount'];
		}
		
		$return->id = $cost_id;
		$return->costName = $cost_name;
		$return->cost = $cost;
		echo json_encode($return);
		die;
	}
}
