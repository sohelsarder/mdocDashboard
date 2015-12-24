<?php


App::uses('AppController', 'Controller');

App::import('Vendor','JWT');
App::import('Vendor','Vline');
class VideosController extends AppController {

	public $uses = array();

	public function index(){
		
		$this->redirect(array('controller'=>'Homes','action' => 'index'));
	}
	public function call($rmp_id = null,$doctor_id = null,$frame = 1) {
		
		$this->layout ='call';
		$rmp_id = trim($rmp_id);
		
		$rmpIdForCallStatus = explode('RMP00',$rmp_id);		
		$this->loadModel('Call');
		$this->Call->deleteAll(array('Call.rmp_id' => $rmpIdForCallStatus[1]));
		
		
		$doctor_id = trim($doctor_id);
		
		$frame = trim($frame);
		$doctorIdExplode = explode('0',$doctor_id);
		
		$this->loadModel('User');
		$doctorIdArray = $this->User->findById($doctorIdExplode[1]);
		$doctorName = $doctorIdArray['User']['name'];
		
		if($rmp_id =='' || $doctor_id ==''){
			
			$this->redirect(array('controller'=>'Homes','action' => 'index'));
		}else{		
			$this->set(compact('rmp_id','doctor_id','frame','doctorName'));
		}
	}
	public function callend(){
		
	}
}
