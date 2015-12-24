<?php
	$model =  Inflector::singularize($this->request->params['controller']);		  
	$v = ucfirst($model);
?>

<h2><?php echo $title_for_layout ;?></h2>
<?php echo $this->Form->create($v);

	echo $this->Form->input('id');
	echo $this->Form->input('name');
	echo $this->Form->input('advice');
	echo $this->Form->label('Medicine Taken Rule');
	echo $this->Form->input('morning',array('div'=>false));
	echo $this->Form->input('afternoon',array('div'=>false));
	echo $this->Form->input('night',array('div'=>false));
 
 ?>


<?php
    echo $this->Form->submit('Save', array('div'=> false));
    echo $this->Html->link(__('Cancel'), array(
	'action' => 'index'
    ), array(
	'class' => 'cancel',
    ));
		
    echo $this->Form->end();
?>
