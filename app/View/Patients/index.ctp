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
	$this->Paginator->sort('age'),
	$this->Paginator->sort('phone'),
	$this->Paginator->sort('weight'),
	$this->Paginator->sort('gender'),
	'Actions',                	
												   
						
));
echo $tableHeaders;
$rows = array();
foreach ($values AS $value) {
	if($value['Patient']['gender'] ==0){
		$gender ='Male';
	}else{
		$gender = 'Female';
	}
	$action = $this->Form->postLink(__('Delete', true), array(		
		'controller' => $this->request->params['controller'],
		'action' => 'delete',
		$value[$v]['id'],
	),array('escape' => false), null, __('Are you sure?', true));
						
	$name  = $this->Html->link($value[$v]['name'], array('controller' => $this->request->params['controller'], 'action' => 'edit', $value[$v]['id']));
	$action .= ' '.$this->Html->link('Edit', array('controller' => $this->request->params['controller'], 'action' => 'edit', $value[$v]['id']));					
	$rows[] = array(
		$name,
		$value[$v]['age'],
		$value[$v]['phone'],
		$value[$v]['weight'],
		$gender,
		$action,
							
	);
}
echo $this->Html->tableCells($rows);

echo $this->Paginator->numbers();
}				
?>	
</table>