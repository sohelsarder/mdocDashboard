<?php //pr($values);
	$model =  Inflector::singularize($this->request->params['controller']);		  
	$v = ucfirst($model);
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
	$this->Paginator->sort('transaction_id'),
	$this->Paginator->sort('amount'),
	$this->Paginator->sort('created'),
	               	
												   
						
));
echo $tableHeaders;
$rows = array();
foreach ($values AS $value) {		
	$rows[] = array(
		$value['Paramedic']['name'],
		$value[$v]['transaction_id'],
		$value[$v]['amount'].' '.$currency,
		$value[$v]['created'],
		
							
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
