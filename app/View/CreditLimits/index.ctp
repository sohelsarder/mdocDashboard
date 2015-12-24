<?php	  
$v = 'Paramedic';	
?>
<span class="titleLeft"><?php echo $title_for_layout ;?></span> 
<div class="clear"></div>
<div class="gap"></div>
<?php
if(!empty($values)){  ?>
<table cellpadding="0" cellspacing="0" class="table" >
<?php  
$tableHeaders =  $this->Html->tableHeaders(array(                   
	$this->Paginator->sort('name'),
	$this->Paginator->sort('currentBalance'),
	$this->Paginator->sort('creditLimit'),
	$this->Paginator->sort('location'),
	$this->Paginator->sort('phone'),		
	'Actions', 				
));
echo $tableHeaders;
$rows = array();
foreach ($values AS $value) {					
	$name  = $this->Html->link($value[$v]['name'], array('controller' => $this->request->params['controller'], 'action' => 'edit', $value[$v]['id']));
	$action = ' '.$this->Html->link(' Edit Credit Limit ', array('controller' => $this->request->params['controller'], 'action' => 'edit', $value[$v]['id']));					
	$rows[] = array(
		$name,
		$value[$v]['currentBalance'].' '.$currency,
		$value[$v]['creditLimit'].' '.$currency,
		$value[$v]['location'],
		$value[$v]['phone'],
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
		<div class="counter"><?php echo $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%'))); ?></div>
		<?php endif; ?>
	<?php endif; 
}				
?>	
