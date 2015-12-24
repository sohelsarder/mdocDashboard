<?php  
	$v = 'Appointment';
	$count = count($values);
?>
<div id="appointmentList">
	<?php //pr($values);
	if(!empty($values)){  ?>
	<table cellpadding="0" cellspacing="0" class="table" >
		<?php  
		$tableHeaders =  $this->Html->tableHeaders(array(                   
			'RMP name',
			'Patient name',
			'Appointment time',
			'Appointment date',			
			'Currently in session with',
			' ',              	
														   
								
		));
		echo $tableHeaders;
		$rows = array();
		foreach ($values AS $value) {
			
			$action = $this->Form->postLink(__('Delete', true), array(		
				'controller' => $this->request->params['controller'],
				'action' => 'delete',
				$value[$v]['id'],
			),array('escape' => false), null, __('Are you sure?', true));
								
			$class = '';					
			$today = new DateTime();
			if(!empty($value[$v]['created'])){
				$created = new DateTime($value[$v]['created']);
				$interval = $today->diff($created);
				
				$diffTime = json_decode(json_encode($interval), true);
			
				if($diffTime['y'] <= 0  && $diffTime['m'] <= 0 && $diffTime['d'] <= 0  && $diffTime['h'] == 0 && $diffTime['i'] <= 59){
					$class = 'green';
				}else if($diffTime['y'] <= 0  && $diffTime['m'] <= 0 && $diffTime['d'] <= 0  && $diffTime['h'] == 1 && $diffTime['i'] <= 59){
					$class = 'yellow';
				}else if($diffTime['y'] <= 0  && $diffTime['m'] <= 0 && $diffTime['d'] <= 0  && $diffTime['h'] == 2 && $diffTime['i'] <= 59){
					$class = 'red';
				}else{
					$class = 'red';
				}
				if(!empty($value['User']['name'])){
					$class = 'blue';
					
				}
			}
			$action = ' '.$this->Html->link('Create Prescription', array('controller' => 'Prescriptions', 'action' => 'add', $value[$v]['patient_id'],$value[$v]['id'],$value[$v]['rmp_id']),array('class'=>'fa fa-plus-square btn','escape' => false,'target'=> '_blank'));					
			
			echo '<tr class = '.$class.'>
			<td>'. $value['Paramedic']['name'].'</td>
			<td>'. $value['Patient']['name'].'</td>
			
			<td>'. substr($value[$v]['created'],-8).'</td>
			<td>'. substr($value[$v]['created'],0,-9).'</td>
			
			<td><b>'. $value['User']['name'].'</b></td>
			<td>'. $action.'</td>
			
			';
			
			echo '</tr>';
		}
		echo '</table>';
		//echo $this->Html->tableCells($rows);
		
		echo $this->Paginator->numbers();
	}				
		?>	
	</table>
</div>

<script type="text/javascript">	
	
	$(function() {
		var currentRow = <?php echo $count ?>;
		var previousRow = $("#count").val();
		
		$("#count").val(<?php echo $count ?>)
		
		if (currentRow > previousRow ) {
			
			
			$.ajax({
				async:true,					
				dataType: "html",
				url:siteurl+"Users/audio/",
				success:function (data) {						
					$("#sound").html(data);
				},
				type:"post"				
			});				
			return false;
		}else{
			
			
			$("#sound").html('');
			
			
		}
		
		
	});
</script>