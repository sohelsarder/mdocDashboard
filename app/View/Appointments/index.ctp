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
		'name',
		$this->Paginator->sort('temperature'),
		$this->Paginator->sort('color'),
		$this->Paginator->sort('respiration'),
		$this->Paginator->sort('dehydration'),						   
							
	));
	echo $tableHeaders;
	$rows = array();
	foreach ($values AS $value) {
	
	$action = $this->Form->postLink(__('', true), array(		
		'controller' => $this->request->params['controller'],
		'action' => 'delete',
		$value[$v]['id'],
		),array('class'=>'fa fa-times','escape' => false, 'confirm' => __('Want to delete?'))
	);
						
	
	//$action = ' '.$this->Html->link('', array('controller' => $this->request->params['controller'], 'action' => 'edit', $value[$v]['id']),array('class'=>'fa fa-pencil-square-o'));					
	$rows[] = array(
		$value['Patient']['name'],
		$value[$v]['temperature'],
		$color[$value[$v]['color']],
		$respiration[$value[$v]['respiration']],
		$dehydration[$value[$v]['dehydration']],
		//$action,
							
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
</table>