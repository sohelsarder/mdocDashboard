<?php
	$model =  Inflector::singularize($this->request->params['controller']);		  
	$v = ucfirst($model);
?>

<span class="titleLeft"><?php echo $title_for_layout ;?></span> <span class="addnew"><?php echo $this->Html->link('Add New', array('controller' => $this->request->params['controller'], 'action' => 'add'),array('class'=>'fa fa-plus-square','escape' => false)); ?></span>
<div class="clear"></div>
<div class="gap"></div>
<?php
if(!empty($values)){  ?>
<table cellpadding="0" cellspacing="0" class="table" >
<?php  
$tableHeaders =  $this->Html->tableHeaders(array(                   
	$this->Paginator->sort('name'),
	$this->Paginator->sort('email'),
	$this->Paginator->sort('phone'),
	$this->Paginator->sort('role_id'),
	
	'Actions',                	
												   
						
));
echo $tableHeaders;
$rows = array();
foreach ($values AS $value) {
						
	if($value['User']['role_id'] ==2){
		$role ='Doctor';
	}elseif($value['User']['role_id'] ==3){
		$role ='Patient';
	}else{
		$role ='RMP';
	}
	
	
	$action = $this->Html->link(' ', array('controller' =>$this->request->params['controller'], 'action' => 'edit', $value[$v]['id']),array('class'=>'fa fa-pencil-square-o'));					
	$action .= ' '.$this->Form->postLink(__('', true), array(		
		'controller' => $this->request->params['controller'],
		'action' => 'delete',
		$value[$v]['id'],
		),array('class'=>'fa fa-times','escape' => false, 'confirm' => __('Want to delete?'))
	);
	$action .= ' '.$this->Html->link(' Change Password', array('controller' =>$this->request->params['controller'], 'action' => 'changepassword', $value[$v]['id']));	
	
	$rows[] = array(
		$value[$v]['name'],
		$value[$v]['email'],
		$value[$v]['phone'],		
		$role,
		$action,
							
		);
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
