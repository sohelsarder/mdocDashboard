<?php	  
	$v = 'UnitCost';
	
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
	$this->Paginator->sort('amount'),
	$this->Paginator->sort('mpower_amount'),
	$this->Paginator->sort('rmp_amount'),
	'Actions',                	
												   
						
));
echo $tableHeaders;
$rows = array();
foreach ($values AS $value) {		
	$name  = $this->Html->link($value[$v]['name'], array('controller' => $this->request->params['controller'], 'action' => 'edit', $value[$v]['id']));
	$action = ' '.$this->Html->link(' ', array('controller' => $this->request->params['controller'], 'action' => 'edit', $value[$v]['id']),array('class'=>'fa fa-pencil-square-o'));					
	$rows[] = array(
		$name,
		$value[$v]['amount'].' '.$currency,
		$value[$v]['mpower_amount'].' '.$currency,
		$value[$v]['rmp_amount'].' '.$currency,
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
		<div class="counter"><?php //echo $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%'))); ?></div>
		<?php endif; ?>
	<?php endif; 
}				
?>	
