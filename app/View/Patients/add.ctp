<?php $model =  Inflector::singularize($this->request->params['controller']); 	$v = ucfirst($model); ?>
<h2><?php echo $title_for_layout ;?></h2>
<?php echo $this->Form->create($v);

echo $this->Form->input('name');
echo $this->Form->input('age');
echo $this->Form->input('gender',array('options'=> array('Male','Female')));
echo $this->Form->input('phone');
echo $this->Form->input('weight');

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
