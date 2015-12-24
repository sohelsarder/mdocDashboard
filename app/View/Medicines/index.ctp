<?php
	$model =  Inflector::singularize($this->request->params['controller']);		  
	$v = ucfirst($model);
?>


<?php
if(!empty($values)){  ?>
<table cellpadding="0" cellspacing="0" class="table" >
<?php  
$tableHeaders =  $this->Html->tableHeaders(array(                   
	$this->Paginator->sort('name'),	
	'Actions',                	
												   
						
));
echo $tableHeaders;
$rows = array();
foreach ($values AS $value) {
	
	$action = $this->Form->postLink(__('Delete', true), array(		
		'controller' => $this->request->params['controller'],
		'action' => 'delete',
		$value[$v]['id'],
	),array('escape' => false), null, __('Are you sure?', true));
						
	$name  = $this->Html->link($value[$v]['name'], array('controller' => $this->request->params['controller'], 'action' => 'edit', $value[$v]['id']));
	$action .= ' '.$this->Html->link('Edit', array('controller' => $this->request->params['controller'], 'action' => 'edit', $value[$v]['id']));					
	$rows[] = array(
		$name,
		$action,
							
	);
}
echo $this->Html->tableCells($rows);

echo $this->Paginator->numbers();
}				
?>	
</table>