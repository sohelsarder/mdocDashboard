<?php
App::uses('AppController', 'Controller');

//App::import('Vendor', 'html2pdf', array('file' => 'html2pdf/html2pdf.class.php'));
App::import('Vendor','tcpdf/tcpdf');
App::import('Vendor','JWT');
App::import('Vendor','Vline');
App::import('Vendor', 'MPDF', array('file' => 'MPDF'.DS.'mpdf.php'));
class PrescriptionsController extends AppController {
	public $name = 'Prescriptions';
	public $uses = array('Prescription');
	public $components = array('RequestHandler');
	public function index(){ // prescription list
		$this->checkPermission();
		$v = $this->_model();
		$this->loadModel('User');
		$this->Prescription->Behaviors->attach('Containable');
		$this->set('title_for_layout', __('Prescription List'));
		$this->$v->recursive = 0;
		if($this->Session->read('Auth.User.role_id') ==2){
		$filter = array('fields'=>array('id','pdf','appointment_id','doctor_id'),'order'=>'Prescription.id desc','conditions'=>array('Prescription.doctor_id'=>$this->Session->read('Auth.User.id')),'contain'=>array('Appointment'=>array('fields'=> array('rmp_id','patient_id'))));
		$this->paginate = $filter;
		}else{
			$filter = array('fields'=>array('id','pdf','appointment_id','doctor_id'),'order'=>'Prescription.id desc','contain'=>array('Appointment'=>array('fields'=> array('rmp_id','patient_id'))));
			$this->paginate = $filter;
		}
		$values = $this->paginate($v);		
		$this->set(compact('values'));
	}
	public function add($patient_id = null,$appointment_id =null,$rmp_id = null){ // create prescription 
		$this->doctorPermission();
		$v = $this->_model();
		$this->loadModel('Appointment');
		$this->loadModel('User');
		$this->loadModel('UnitCost');
		$conditionforAppointment = array(			
			'Appointment.id' => $appointment_id,
			'Appointment.status' => 0,
		);
		$conditionforPrescription = array(			
			'Prescription.appointment_id' => $appointment_id,
		);
		if (!$this->$v->hasAny($conditionforPrescription)){
			if ($this->Appointment->hasAny($conditionforAppointment)){				
				$rmp_info = json_decode($this->_checkamount($rmp_id), true) ;
				//pr($rmp_info);
				$this->set('title_for_layout', __('Create Patient Prescription'));
				$this->Appointment->Behaviors->attach('Containable');
				$appointment = $this->Appointment->find('first',array('conditions'=>array('Appointment.id' => $appointment_id),'contain'=> array('Patient'=>array('fields' =>array('name','id','age','gender','phone','created','image')))));// get appointment information				
				
				if(!empty($appointment['Appointment']['is_followup'])){ 
					$unit_cost_id = FOLLOWUP;
				}else{
					$unit_cost_id = NEWAPP;
				}
				$unit_conts = $this->UnitCost->findById($unit_cost_id); // get unit cost according to appointment  type
				if($rmp_info['amount'] >= MINIMUM_BALANCE_RMP){	// if rmp credit limit+accountbalance bigger than unit cost price then	prescription created goes			
					$this->_addlogic($appointment,$appointment_id); // here some condition where check prescription alredy created or lock by a doctor
					$this->_setValue($appointment,$appointment_id,$patient_id);	// here value set for view			
					$this->_timeUpdate($appointment_id,$serial = 1,$appointment['Appointment']['spentTimeFrom']);				
				}else{
					$this->Session->setFlash(__('Insufficient account balance for rmp  '.$rmp_info['name'].'.... '));
					$this->redirect(array('controller'=>'Users','action' => 'index'));
				}
			}else{
				$this->Session->setFlash(__('Already prescription created' ), 'default', array('class' => 'success'));					
				$this->redirect(array('controller'=>'Users','action' => 'index'));
			}
		}else{
			$this->Session->setFlash(__('Already prescription created .... '));		
			$this->redirect(array('controller'=>'Users','action' => 'index'));
		}
	}
	function _age_calculation($age = null, $date = null){ // calculate age from specific format defined comes from mobile device as(23 year 3 Month 3 day)
		$year = '';
		$month = '';
		$day = '';
		$days ='';	
		$age = str_replace('null',0,$age);		
		$year = explode("Year(s)",$age);		
		$year1 = $year[0];		
		$month = explode("Month(s)",$year[1]);		
		@$day = explode("Day(s)",$month[1]);	
				
		$date = substr($date,0,10);		
		if(empty($month[0]) OR $month[0] == NULL){
		$monthss = 0;
		}else{
		$monthss = $month[0];
		}
		if(empty($day[0]) OR $day[0] == NULL){
		$dayes = 0;
		}else{
		$dayes  = $day[0];
		}
		
		$dob = strtotime("-$year1 years", strtotime($date));
		$dob =  date("Y-m-d", $dob);
		$dob = strtotime("-$monthss months", strtotime($dob));
		$dob =  date("Y-m-d", $dob);
		$dob = strtotime("-$dayes days", strtotime($dob));
		$dob = date("Y-m-d", $dob);

 
		//$dob = date('Y-m-d', strtotime($date .'-'.$days.' day'));
		$today = new DateTime();
		$dob = new DateTime($dob);
		$interval = $today->diff($dob);
		return 	json_encode($interval);
	}
	function _setValue($appointment=null,$appointment_id =null,$patient_id=null){ // set value for view
		$v = $this->_model();
		$this->loadModel('UnitCost');
		$age = $appointment['Patient']['age'];
		$date = $appointment['Patient']['created'];
		$dob = $this->_age_calculation($age, $date);
		$followup = $this->$v->find('first',array('conditions'=>array($v.'.appointment_id'=> $appointment['Appointment']['parent_id']))); // get follow up information 
		$prescription_list = $this->$v->query("SELECT id,created,followupstatus,is_followup from prescriptions as Prescription where Prescription.patient_id = $patient_id  order by id desc" ); // get all past prescription				
		$unit_cost = $this->UnitCost->find('list',array('fields'=>array('id','amount'))); // get unit costs list		
		$rmp = $this->$v->query("select name,id,phone from User where id = '".$appointment['Appointment']['rmp_id']."' limit 1");							
		$this->set(compact('followup','appointment','rmp','appointment_id','prescription_list','unit_cost','dob'));
	}
	function _checkamount($id = null){ // check rmp acoount balance
		$this->loadModel('Paramedic');
		$rmp = $this->Paramedic->findById($id); // get rmp account information
		$total_amount = $rmp['Paramedic']['currentBalance']+$rmp['Paramedic']['creditLimit'];
		$name = $rmp['Paramedic']['name'];
		$return = array();
		$return['amount'] = $total_amount;
		$return['name'] = $name;
		return json_encode($return);
	}
	function _addlogic($appointment = null,$appointment_id= null){
		$this->loadModel('Disease');
		$this->loadModel('System');
		$this->loadModel('User');
		if($appointment['Appointment']['lockby'] == 0){					
			$this->Appointment->id = $appointment_id;
			$this->Appointment->saveField("lockby",$this->Session->read('Auth.User.id'));
		}else if($appointment['Appointment']['status'] == 0 && $appointment['Appointment']['lockby'] == $this->Session->read('Auth.User.id')){		
			// same doctor can create prescription again if fail any case
		}else if($appointment['Appointment']['status'] == 1){					
			$doctor = $this->User->findById($appointment['Appointment']['lockby']);					
			$this->Session->setFlash(__('Sorry This Patient Under Process by '.$doctor['User']['name']. '   .....  ' ), 'default', array('class' => 'success'));					
			$this->redirect(array('controller'=>'Users','action' => 'index'));
		}else{
			$doctor = $this->User->findById($appointment['Appointment']['lockby']);					
			$this->Session->setFlash(__('Sorry This Patient Under Process by '.$doctor['User']['name']. '   .....  ' ), 'default', array('class' => 'success'));					
			$this->redirect(array('controller'=>'Users','action' => 'index'));
		}
	}
	function _timeUpdate($id = null,$serial= null,$value = null){ // how much time taken by a doctor to prescribe
		$this->loadModel('Appointment');
		if($serial ==1){
			if($value ='0000-00-00 00:00:00' OR empty($value)){				
				$this->Appointment->updateAll(array('Appointment.spentTimeFrom' => "'".date('Y-m-d H:i:s')."'"),array('Appointment.id' => $id));				
			}
		}else{
			$this->Appointment->updateAll(array('Appointment.spentTimeTo' => "'".date('Y-m-d H:i:s')."'"),array('Appointment.id' => $id));
		}
	}
	public function edit($id = null){ // edit prescription
		$this->loadModel('Disease');
		$this->loadModel('System');
		$this->loadModel('User');
		$this->loadModel('Appointment');
		$this->loadModel('UnitCost');
		$this->doctorPermission();
		if(empty($id)){
			$this->redirect(array('action' => 'index'));
		}
		$this->set('title_for_layout', __('Edit Patient'));		
		$v = $this->_model();
		$conditions = array(			
			$v.'.id' => $id,			
		);
		if ($this->$v->hasAny($conditions)){		
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
			$this->$v->recursive = 2;
			$this->Appointment->unBindModel(array('hasMany' => array('Prescription')));
			$this->request->data = $this->$v->read(null,$id);
			//echo '<pre>';
			//print_r($this->request->data);
			$appointment = $this->request->data;			
			$patient_id = $this->request->data['Appointment']['patient_id'];
			$patient = $this->User->find('first',array('conditions'=>array('User.id' => $patient_id)));
			$rmp_id = $this->request->data['Appointment']['rmp_id'];
			$unit_cost = $this->UnitCost->find('list',array('fields'=>array('id','amount'))); // get unit costs list
			$prescription_list = $this->$v->query("SELECT id,created,followupstatus,is_followup from prescriptions as Prescription where Prescription.patient_id = $patient_id AND  Prescription.id != $id order by id desc "); // get all past prescription				
			$rmp =  $this->$v->query("select name,id,phone from User where id = '".$rmp_id."' limit 1");
			$age = $appointment['Appointment']['Patient']['age'];
			$date = $appointment['Appointment']['Patient']['created'];
			$dob = $this->_age_calculation($age, $date);
			$this->set(compact('dob','prescription_list','unit_cost','diseases','systems','patient','appointment','rmp'));
		}else{
			$this->Session->setFlash(__('Does not exist ' ), 'default', array('class' => 'success'));
			$this->redirect(array('controller'=>'Prescriptions','action' => 'index'));
		}
	}
	public function reject() { // Reject appointment from doctor for invalid data		
		$this->loadModel('Appointment');
		$this->loadModel('UnitCost');
		$this->loadModel('Paramedic');
		$this->Appointment->recursive = -1;
		$this->layout = 'ajax';				
		if($this->request->is('get')) {
		    throw new MethodNotAllowedException();		
		}
		$data = $this->request->data;		
		if($this->Appointment->updateAll(array('Appointment.comments' => "'".$this->request->data['Appointment']['comments']."'",'Appointment.reject'=>1),array('Appointment.id' => $this->request->data['Appointment']['appointment_id']))) {
		    $this->Session->setFlash(
			__('The record has been Rejected.')
		    );
			$value = $this->Appointment->findById($this->request->data['Appointment']['appointment_id']);
			$unit_costs_amount = 0;
			if(!empty($follow_up)){
				$unit_cost_id = FOLLOWUP;
			}else{
				$unit_cost_id = NEWAPP;
			}
			$rmp_amount =$this->Paramedic->findById($value['Appointment']['rmp_id']); // get rmp amount				
			$unit_conts = $this->UnitCost->findById($unit_cost_id);
			$unit_costs_amount = $unit_conts['UnitCost']['mpower_amount'];
			$app_amount =$rmp_amount['Paramedic']['appAmount']-$unit_costs_amount;
			$this->Paramedic->updateAll(array('Paramedic.appAmount'=> $app_amount),array('Paramedic.id' => $value['Appointment']['rmp_id']));
			file_get_contents(APKURL.'/p/prescriptionDone/?rmpId='.$data['Paramedic']['rmp_id'].'&patientName='.str_replace(' ','_',$data['Paramedic']['name']).'');
				
		    echo 1;
		}else{
			echo 0;
		}		
		exit ;
	}
	public  function preview($id = null){	 // prescription preview from list when doctor click on past prescription	
		$this->layout = 'ajax';		
		$v = $this->_model();				
		$prescription = $this->$v->findById($id);
		$this->set(compact('prescription'));
	}
	
	function getimage($id = null){  // get run time image
		$this->layout = 'ajax';		
		$this->loadModel('Appointment');
		$this->Appointment->recursive = -1;
		$appointment = $this->Appointment->findById($id);
		$this->set(compact('appointment'));
	}
	public  function status($id = null,$value = null,$patient_id = null){	 // prescription followup status change	by doctor
		$this->layout = 'ajax';		
		$v = $this->_model();
		$this->$v->updateAll(
			array($v.'.followupstatus' => $value),
			array($v.'.id' => $id)
		);
		$prescription_list = $this->$v->query("SELECT id,created,followupstatus,is_followup from prescriptions as Prescription where Prescription.patient_id = $patient_id ");
		$this->set(compact('prescription_list','patient_id'));
	}
	
	public function addprescriptions(){	// create prescription	
		$v = $this->_model();
		$this->layout='ajax';
		$this->loadModel('Disease');
		$this->loadModel('Appointment');
		$this->loadModel('UnitCost');
		$data = $this->request->data;
		$amount = $this->UnitCost->findById($data['Prescription']['paymentType']);
		$view = new View($this, false);
		$data['UnitCost']=$amount['UnitCost'];
		$content =  $view->element('pdf/pdf',array('pdf'=>json_encode($data)));			
		$dataForSave = $this->request->data;
		
		$parent_id = $dataForSave['Prescription']['parent_id'];		
		$app_id = $dataForSave['Prescription']['appointment_id'];
		$name = trim($data['User']['name']);
		$name = str_replace(':','_',$name);
		$name = str_replace('.','_',$name);
		if(@$dataForSave['Prescription']['pdf'] !=''){ // decides the prescription file name
			$fname = explode('.pdf',$dataForSave['Prescription']['pdf']);
			$fileName = $fname[0];
		}else{
			$fileName = str_replace(' ','_',$name).'_'.$app_id;	
		}		
		$this->_pdf_create($content,$fileName);
		$data_original = $dataForSave;
		unset($dataForSave['User']);
		unset($dataForSave['Examination']);		
		$dataForSave['Prescription']['pdf'] = $fileName.'.pdf';
		$dataForSave['Prescription']['pdf'] = $fileName.'.pdf';
		$datasource = $this->$v->getDataSource();
		$datasource->begin(); 
		if (!empty($dataForSave)) {			
			$this->$v->create();			
			if ($this->$v->save($dataForSave)) {
				if(empty($dataForSave['Prescription']['id'])){
					$this->_timeUpdate($app_id,$serial = 0,'');					
				}
				$this->Appointment->id = $dataForSave['Prescription']['appointment_id'];
				$this->Appointment->saveField("status",1); // prescription status change from 0 to 1 indicates prescription created				
				if($parent_id !=0 OR $parent_id != null){ // prescription followupstatus change from 0 to 1 indicates prescription follow up taken by patient
					$this->$v->updateAll(
						array($v.'.followupstatus' => 1),
						array($v.'.appointment_id' => $parent_id)
					);
				}
				if(!empty($dataForSave['Prescription']['id'])){
					$ok = $this->_transaction($data_original,$dataForSave['Prescription']['id'],$datasource); // accounting section start where if success return null otherwise 1
				}else{
					$ok = $this->_transaction($data_original,'',$datasource);
				}
				if(empty($ok)){
				$this->Session->setFlash(__('Prescription Sent Successful'), 'default', array('class' => 'success'));				
				//file_get_contents(APKURL.'/p/prescriptionDone/?rmpId='.$data['User']['rmp_id'].'&appId='.$dataForSave['Prescription']['appointment_id'].'');
				echo 1;
				}else{
					$this->Session->setFlash(__('An Problem Occured Please Try Again'));
					echo 0;
				}
			} 
			else {
				$this->Session->setFlash(__('An Problem Occured Please Try Again'));
				echo 0;
			}
		} 
		
	       exit();
	}
	function _pdf_create($content = null,$fileName = null){ // create pdf by tcpdf 
		/*$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
		$pdf->SetCreator(PDF_CREATOR);
		$pdf->SetAuthor('Nicola Asuni');
		$pdf->SetTitle('TCPDF Example 001');
		$pdf->SetSubject('TCPDF Tutorial');
		$pdf->SetKeywords('TCPDF, PDF, example, test, guide');		
		$pdf->setFooterData(array(0,64,0), array(0,64,128));
		
		$pdf->SetPrintFooter(false);
		$pdf->SetPrintHeader(false);
		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);		
		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);		
		$pdf->setFontSubsetting(true);		
		$pdf->SetFont('times', '', 11, '', true);		
		$pdf->AddPage();
		$pdf->writeHTMLCell(0, 0, '', '', $content, 0, 1, 0, true, '', true);
		$pdf->Output(IMAGE_LOCATION.$fileName.'.pdf', 'F');*/
		$this->autoRender=false;
		$this->layout='ajax';
		error_reporting(0);
		$mpdf=new mPDF();
		$mpdf->useAdobeCJK = true;		
		$mpdf->SetAutoFont(AUTOFONT_ALL);		
		$mpdf->WriteHTML($content);		
		$mpdf->Output(IMAGE_LOCATION.$fileName.'.pdf','F');
		
	}
	function _transaction($dataForSave = null,$prescription_id = null,$datasource){
		$this->loadModel('UnitCost');
		$this->loadModel('Account');
		$amount = $this->UnitCost->findById($dataForSave['Prescription']['paymentType']); // get unit cost
		return $this->_account($dataForSave,$amount,$prescription_id,$datasource);
	}
	function _account($dataForSave =null,$total = null,$prescription_id = null,$datasource){ 		
		$this->loadModel('UnitCost');
		$this->loadModel('Account');
		$this->loadModel('Paramedic');
		$v = $this->_model();
		$app_amount = 0;
		$update_amount = 0; //  when prescription updated
		$unit_costs_amount = 0; // 
		$appAmountUpdate = 0;
		$rmp_return_amount = 0; // used when prescription update pait to free
		$rmp_amount =$this->Paramedic->findById($dataForSave['User']['rmp_id']); // get rmp amount
		if(!empty($prescription_id)){
			$accounts = $this->Account->find('first',array('conditions'=>array('Account.prescription_id'=>$prescription_id)));
			$data['Account']['id'] = $accounts['Account']['id'];
			$update_amount = $accounts['Account']['mpower_amount']; // return amount when prescription updated
			$rmp_return_amount = $accounts['Account']['rmp_amount'];
		}else{
			$data['Account']['prescription_id'] = $this->$v->getLastInsertId();
			/*if(!empty($dataForSave['User']['is_followup'])){ 
			$unit_cost_id = FOLLOWUP;
			}else{
				$unit_cost_id = NEWAPP;
			} */
			$unit_cost_id = $dataForSave['User']['paymentType'];
			$unit_conts = $this->UnitCost->findById($unit_cost_id); // get unit cost according to appointment  type				
			$unit_costs_amount = $unit_conts['UnitCost']['mpower_amount'];
		}
		$data['Account']['appointment_id'] = $dataForSave['Prescription']['appointment_id'];
		$data['Account']['rmp_id'] = $dataForSave['User']['rmp_id'];
		$data['Account']['date'] = date("Y-m-d");		
		$app_amount = $rmp_amount['Paramedic']['appAmount'] -$unit_costs_amount;
		
		if(!empty($total)){ // if prescription paid then goes here
			$current_balance =$rmp_amount['Paramedic']['currentBalance']+$update_amount-$total['UnitCost']['mpower_amount'];// calculate current balance			
			$data['Account']['unitcost'] = $total['UnitCost']['amount'];
			$data['Account']['mpower_amount'] = $total['UnitCost']['mpower_amount'];
			$data['Account']['rmp_amount'] = $total['UnitCost']['rmp_amount'];
		}else{ // if prescription free then goes here 
			$current_balance =$rmp_amount['Paramedic']['currentBalance']+$update_amount+$rmp_return_amount;			
			$data['Account']['unitcost'] = 0;
			$data['Account']['mpower_amount'] = 0;
			$data['Account']['rmp_amount'] = 0;
		}
		try{ 
		    if($this->Account->save($data)){ // save data into account table
			if($this->Paramedic->updateAll(	array('Paramedic.currentBalance' => $current_balance),array('Paramedic.id' => $dataForSave['User']['rmp_id']))){ // update current Balance and appAmount for rmp
			    $datasource->commit();
			}else{
			    throw new Exception();
			}
		    }else{
			throw new Exception();
		    }
		}catch(Exception $e) {			
			$datasource->rollback();
			return 1;			
			exit();
		}
	}
	public function getprescription($rmp_id = null, $patient_id =null){
		$this->layout = false;
		$this->loadModel('Appointment'); 
		if($rmp_id !='' && $patient_id != ''){			
			$appontmentId = $this->Appointment->find('first',array('fields'=>array('id'),'conditions'=> array('Appointment.rmp_id' => $rmp_id , 'Appointment.patient_id'=> $patient_id, 'Appointment.status'=> 1),'order'=>'Appointment.id desc'));						
			if(!empty($appontmentId)){				
				$appointmentId = $appontmentId['Appointment']['id'];
				$prescription = $this->Prescription->find('first',array('fields'=>array('pdf'),'conditions'=> array('Prescription.appointment_id'=>$appointmentId),'order'=> 'Prescription.id desc'));			
				$pdf = array();
				if(!empty($prescription)){
					$pdf['pdf'] = $prescription['Prescription']['pdf'];					
					return json_encode($pdf);
				}else{
					return 0;					
				}				
			}else{
				return 0;
			}			
		}else{
			return 0;			
		}
		exit();		
	}
	
	public function downloadpdf($appointId = null){ // download pdf from device
		$this->loadModel('Appointment');
		
		if(empty($appointId)){			
		}else{
			$prescription = $this->Prescription->find('first',array('conditions' => array('Prescription.appointment_id' => $appointId)));			
			if(!empty($prescription)){
				$pdf = $prescription['Prescription']['pdf'];				
				header('Content-Type: application/pdf');
				header("Content-Disposition: attachment; filename=$pdf");
				header('Content-Length: '.filesize(IMAGE_LOCATION.$pdf));
				readfile(IMAGE_LOCATION.$pdf);				
				$this->Appointment->id = $appointId;
				$this->Appointment->saveField("status",2);
			}
			
		}
		exit();
	}
	// call request to rmp
	function requestcall($rmp_id = null,$doctor_id = null,$frameRate =0,$resolutionX =0, $resolutionY =0,$doctorName =null, $patientName = null,$r_id =null,$patientId=null){		
		$this->loadModel('Call');
		$callparam = array();
		$callparam['rmp_id'] = $rmp_id;
		$callparam['doctor_id'] = $doctor_id;		
		$callparam['resolutionX'] = $resolutionX;
		$callparam['esolutionY'] = $resolutionY;
		//r_id is rmp actual id
		//rmp_id user for call initiate
		$doctorName = str_replace(' ','_',$doctorName);
		$patientName = str_replace(' ','_',$patientName);
		file_get_contents(APKURL.'/p/callingStart/?rId='.$r_id.'&rmpId='.$rmp_id.'&docId='.$doctor_id.'&doctorName='.$doctorName.'&patientName='.$patientName.'&frameRate='.$frameRate.'');
		// Call counter Section //
		$doctoIdForCallStatus = explode('doctor0',$doctor_id);
		$countNumber = $this->Call->find('count',array('conditions'=>array('Call.doctor_id' => $doctoIdForCallStatus[1],'Call.rmp_id'=>$r_id, 'Call.patient_id'=>$patientId)));
		if($countNumber == 0 || $countNumber == ''){
			$this->Call->create();
			$dataForSave['Call']['doctor_id'] = $doctoIdForCallStatus[1];
			$dataForSave['Call']['rmp_id'] = $r_id;
			$dataForSave['Call']['patient_id'] = $patientId;
			$dataForSave['Call']['status'] = 1;			
			if ($this->Call->save($dataForSave)) {				
				
			}
		}else{
			$CallId = $this->Call->find('first',array('conditions'=>array('Call.doctor_id' => $doctoIdForCallStatus[1],'Call.rmp_id'=>$r_id, 'Call.patient_id'=>$patientId)));
			$this->Call->id = $CallId['Call']['id'];			
			$this->Call->saveField("status",$CallId['Call']['status']+1);
		}
	       exit();
	}
	
	public function callcount($rmp_id = null){ //get call count information
		$this->layout = 'call';
		if($rmp_id !=''){
			$this->loadModel('Call');
			$this->Call->Behaviors->attach('Containable');		
			$this->Call->recursive = 0;
			$filter = array('fields'=>array('doctor_id','rmp_id','patient_id','id','status'),'limit' => 20,'order'=>'Call.id desc','conditions'=>array('Call.status !='=> 0),'contain'=>array('Patient'=>array('fields'=>array('name')),'User'=>array('fields'=>array('name'))));
			$this->paginate =$filter;
			$callRecords =  $this->paginate('Call');			
			$callRecordInArray = array();
			$doctorName = array();
			$patientName = array();
			$calcount= array();
			if(!empty($callRecords)){
				foreach($callRecords as $key=>$callRecord){
					$doctorName [$key] = str_replace(' ','_',$callRecord['User']['name']);
					$patientName[$key] = str_replace(' ','_',$callRecord['Patient']['name']);
					$calcount[$key]= $callRecord['Call']['status'];
				}
				$return = new stdClass();
				$return->docName = $doctorName;
				$return->patientName =$patientName;
				$return->callCount =$calcount;
				
				//pr(json_encode($return));
				echo json_encode($return);
				die;
				
			}else{
				return -1;
			}
			
		}else{
			echo 'Direct Access Not Allow';
		}
		exit;
	}
	
	function followUpList($id = null){ //sent followup list to rmp
		$v = $this->_model();
		$preday = strtotime("+7 day");
		$pastday = strtotime("-7 day");
		$predate = date('Y-m-d', $preday );
		$pastdate = date('Y-m-d', $pastday );
		$followup_lists = $this->$v->query("SELECT Prescription.id as pid,followupDate,followupstatus ,Prescription.is_followup as followup,Appointment.patient_id as patientID,Patient.id as paId,name, phone
		FROM prescriptions as Prescription left join patients as Patient
		on  Prescription.patient_id = Patient.id
		left join appointments as Appointment on Appointment.patient_id = Patient.id
		where Prescription.is_followup =1 AND Prescription.followupstatus =0 AND Appointment.rmp_id = $id
		AND followupDate between '$pastdate' AND '$predate' group by Prescription.id");
		
		$ret = array();
		$available_time = array();
		if(!empty($followup_lists)){
			foreach($followup_lists as $key => $value){
				$ret[] = str_replace(' ','_',str_replace(' ','_',$value['Patient']['name'])).":".$value['Patient']['phone'].":".$value['Prescription']['followupDate'];			
			}
		}
		$return = new stdClass();
		$return->data = $ret;		
		echo json_encode($return); 
		exit();	
	}
	function appointmentQty($id = null){ //sent to rmp how many appointment take after last transaction
		$this->loadModel('Appointment');
		$this->loadModel('Transaction');
		$appQty  = 0;
		$last_transaction = $this->Transaction->find('first',array('conditions'=>array('Transaction.rmp_id'=> $id),'order'=> 'Transaction.created desc '));
		$this->Appointment->recursive = -1;
		if(!empty($last_transaction['Transaction']['created'])){
			$appQty = $this->Appointment->find('count',array('conditions'=> array('Appointment.created >'=> $last_transaction['Transaction']['created'],'Appointment.rmp_id'=> $id)));
		}
		$return = new stdClass();
		$return->qty = $appQty+1;
		echo json_encode($return); 
		exit();
		
		
	}
	public function followUpCheck($id =null){ 
		$v = $this->_model();
		$id = $_GET['id'];
		
		$followup = $this->$v->query("SELECT  Prescription.id as pid,followupDate,followupstatus ,Prescription.is_followup followup,Prescription.patient_id as patientID,Patient.id as paId,name, phone ,code
		FROM prescriptions as Prescription left join patients as Patient on  Prescription.patient_id = Patient.id where Prescription.is_followup =1 AND Prescription.followupstatus =0 AND Patient.code = '$id' ");
		//$followup = $this->$v->find('count',array('conditions'=>array($v.'.patient_id'=> $id,$v.'.is_followup'=>1,$v.'.followupstatus'=>0))); // get follow up information
		//echo $followup+1;
		echo count($followup)+1;
		die;
	}
	public function deletecallcount($rmp_id = null){
		
		$this->loadModel('Call');
		if($rmp_id !=''){
			$this->Call->deleteAll(array('Call.rmp_id' => $rmp_id));
		}else{
			echo 'Direct Access Not Allow';
		}
		exit;
	}
}
