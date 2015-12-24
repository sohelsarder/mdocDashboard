<?php
	$model =  Inflector::singularize($this->request->params['controller']);		  
	$v = ucfirst($model);
?>
<span class="titleLeft"><?php echo $title_for_layout ;?></span> 
<div class="gap"></div>
<div id="appointmentList">
<?php //pr($values);
if(!empty($values)){  ?>
<table cellpadding="0" cellspacing="0" class="table" >
<?php
	if($this->Session->read('Auth.User.role_id') ==2){
		$tableHeaders =  $this->Html->tableHeaders(array(
			'Patient Name',
			'Doctor Name',
			$this->Paginator->sort('pdf','Prescription'),	
			'Edit Prescription',                	
														   
								
		));
	}else{
		$tableHeaders =  $this->Html->tableHeaders(array(
			'Patient Name',
			'Doctor Name',
			$this->Paginator->sort('pdf','Prescription'),	
			                	
														   
								
		));
		
	}
	echo $tableHeaders;
	$rows = array();
		foreach ($values AS $value) {
		
		/*$action = $this->Form->postLink(__('', true), array(		
			'controller' => $this->request->params['controller'],
			'action' => 'delete',
			$value[$v]['id'],
			),array('class'=>'fa fa-times','escape' => false, 'confirm' => __('Want to delete?'))
		); */
		
		$userName  = $this->requestAction('Users/getusername/'.$value['Prescription']['doctor_id'].'/'.$value['Appointment']['patient_id']);
		$userName = json_decode($userName, true);
														
		$pdf  = '<a  download="'.$value['Prescription']['pdf'].'" href="'. $this->request->webroot.'img/pdf/'.$value['Prescription']['pdf'].'"> '.$value['Prescription']['pdf'].' </a>';
		$action = '    '.$this->Html->link('', array('controller' => $this->request->params['controller'], 'action' => 'edit', $value[$v]['id']),array('class'=>'fa fa-pencil-square-o'));					
		
		if($this->Session->read('Auth.User.role_id') ==2){
			$rows[] = array(
				$userName['patient'],
				$userName['doctor'],
				$pdf,
				$action,
									
			);
		}else{			
			$rows[] = array(
				$userName['patient'],
				$userName['doctor'],
				$pdf,
				
									
			);
		}
	}
	echo $this->Html->tableCells($rows);
	
	echo '</table>';
	 if ($pagingBlock = $this->fetch('paging')): ?>
		<?php echo $pagingBlock; ?>
		<?php else: ?>
		<?php if (isset($this->Paginator) && isset($this->request['paging'])): ?>
			<div class="paging">
			<?php echo $this->Paginator->first('< ' . __('First')); ?>						
			<?php echo $this->Paginator->numbers(); ?>						
			<?php echo $this->Paginator->last(__('Last') . ' >'); ?>
			</div>
			
		<?php endif; ?>
	<?php endif; 
}				
?>	
</div>