<?php
    if(!empty($data)){ ?>
	<div class="patient">
	    <h2>Chikitsha e-Prescription </h2>
		
		<br /><br /><br />
		<hr />
	 <table cellspacing="150">
	    <tr>
		    <th colspan="6"> Patient particulars </th>
		    <th colspan="6"><?php echo Date('dd/mm/yy'); ?> </th>
	    </tr>
	    <tr>
		<td>Name:</td>
		<td>Age:</td>
		<td>Gender:</td>
		<td>Weight:</td>
		<td>Phone:</td>
		<td> Doctor :</td>
		
	    </tr>
	    <tr>  
		<td> <?php echo $data['Patient']['name'] ?></td>
		<td> <?php echo $data['Patient']['age'] ?></td>
		<td> <?php echo $data['Patient']['gender'] ?></td>
		<td> <?php echo $data['Patient']['weight'] ?></td>
		<td> <?php echo $data['Patient']['phone'] ?></td>
		<td> <?php echo $this->Session->read('Auth.User.name'); ?></td>
	    </tr>
	</table>
	</div>
	<div>
	<table cellspacing="150">
	    <tr>
		<th>Chief Complaints</th>
		<th>On Examination</th>
	    </tr>
	    <tr>
		<td>  <?php echo $data['Prescription']['complain'] ?></td>
		<td>
		    
		    <table>
			<tr>
			    <td>
				<table>
				    <tr>
					<td>
					    Pulse:  <?php echo $data['Examination']['pulse'] ?>
					</td>
				    </tr>
				    <tr>
					<td>
					    BP: <?php echo $data['Examination']['bp'] ?>
					</td>
				    </tr>
				    <tr>	
					<td>
					    Temperature: <?php echo $data['Examination']['temperature'] ?>
					</td>
				    </tr>
				    <tr>	
					<td>
					    Respiration: <?php echo $data['Examination']['respiration'] ?>
					</td>
				    </tr>	
				</table>	
			    </td><td>
				<table>
				    <tr>
					<td>
					    Appearance: <?php echo $data['Examination']['appearance'] ?>
					</td>
				    </tr>
				    <tr>
					<td>
					    Color: <?php echo $data['Examination']['color'] ?>
					</td>
				    </tr>
				    <tr>	
					<td>
					    State of Consciousness:   <?php echo $data['Examination']['consciousness'] ?>
					</td>
				    </tr>
				    <tr>	
					<td>
					    Edema: <?php echo $data['Examination']['edema'] ?>
					</td>
				    </tr>
				     <tr>	
					<td>
					    Dehydration: <?php echo $data['Examination']['dehydration'] ?>
					</td>
				    </tr>
				      <tr>	
					<td>
					    Enlargement: <?php echo $data['Examination']['enlargement'] ?>
					</td>
				    </tr>
				</table>
			    
				
			    </td>
			</tr>
		    </table>
		</td>
	    </tr>  
	</table>
	    
	    
	</div>
	
	<div class="prescription">
	    <table>
		<tr>
		    <td style="width:40%"> Rx </td>
		    <td   style="width:30%"> Advice </td>
		    <td style="width:30%"> Investigations </td>
		</tr>
		<tr> 
			<td><?php
			if(!empty($data['Prescription']['prescription'])){
			    echo $data['Prescription']['prescription'] ;
			}
			?> </td>		
			<td><?php
			if(!empty($data['Prescription']['advice'])){
			    echo $data['Prescription']['advice'];
			
			}?> </td>
			<td><?php
			    if(!empty($data['Prescription']['advice'])){
				echo $data['Prescription']['investigations'] ;
			    }
			    ?> </td>
		</tr>
		   
		
	<?php 
	echo '</table>';
	echo '<hr /> <span style="float:right"> '.$this->Session->read('Auth.User.name').'</span> ';
	echo '</div>';
    }
    
    ?>

<?php echo $this->Form->submit('Save & Pdf', array('div'=> false,'id'=>'pdf')); ?>
   
    
  