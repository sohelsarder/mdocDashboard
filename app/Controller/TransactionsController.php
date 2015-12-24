<?php


App::uses('AppController', 'Controller');


class TransactionsController extends AppController {
	
	public $name = 'Transactions';
	public $uses = array('Transaction');
	
	public function index(){
		$this->adminPermission();
		$v = $this->_model();
		$this->set('title_for_layout', __('Transactions'));
		$this->$v->recursive = 1;		
		$this->paginate = array('limit' => 20,'order'=>'Transaction.id desc');		
		$this->set('values', $this->paginate($v));		
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
}
