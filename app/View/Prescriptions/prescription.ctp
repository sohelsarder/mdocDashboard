<script type="text/javascript">
    $(document).ready(function () {
	$("#DiseaseListDiseaseId").on("change", function (event) {
	    var disease =  $("#DiseaseListDiseaseId").val();
		$.ajax({
		    async:true,		   
		    dataType: "html",
		    url:siteurl+"Patients/medicineName/"+disease,
		    success:function (data) {					
			$("#medicine").html(data);
		    },
		    type:"post"
				
		});			
		return false; 
	});
    });

</script>

<script type="text/javascript">
    $(function() {
	
	
	$(document.body).on('change', '#MedicineListMedicineId' ,function() {	    
	    var medicine =  $("#MedicineListMedicineId").val();
	    
		$.ajax({
		    async:true,		   
		    dataType: "html",
		    url:siteurl+"Patients/rule/"+medicine,
		    success:function (data) {					
			$("#rightAdvise").html(data);
		    },
		    type:"post"
				
		});			
		return false; 
	});
	
	
    });

</script>

<script type="text/javascript">
    $(document).ready(function () {
	$("#submit").on("click", function (event) {	    
	    var data = $("#PatientPrescriptionForm").serialize();
	   
	    $.ajax({
		async:true,		   
		dataType: "html",
		data: data,
		url:siteurl+"Patients/prescriptions/",
		success:function (data) {					
		    $("#medicines").html(data);
		    
		},
		type:"post"
				
	    });			
	    return false; 
	});
    });


</script>
<?php $model =  Inflector::singularize($this->request->params['controller']); 	$v = ucfirst($model); ?>
<h2><?php echo $title_for_layout ;?></h2>

<?php echo $this->Form->create($v); ?>
<table class="presscribe"><tr><td class="leftside">

<?php 
    echo $this->Form->input('name');
    echo $this->Form->input('age',array('label'=>'Age (Year)'));
    echo $this->Form->input('gender',array('options'=> array('Male'=>'Male','Female'=>'Female')));
    echo $this->Form->input('height',array('label'=>' Height (Inch)'));
    echo $this->Form->input('weight',array('label'=>'Weight(Kg)'));
    echo $this->Form->input('complain');

?>

</td><td class="rigthside">

<?php 
echo $this->Form->input('DiseaseList.disease_id',array('options'=>$diseases,'multiple'=>'multiple','label'=>'Disease'));

?>
<div id="medicine">    
    
</div>
<div id="rightAdvise">    
    
</div>
<?php echo $this->Form->input('Prescription.advice'); ?>
</td></tr></table>

<div id="medicines">    
    
</div>

<?php
    echo $this->Form->submit('Create Prescription', array('div'=> false,'id'=>'submit'));
    echo $this->Html->link(__('Cancel'), array(
	'action' => 'index'
    ), array(
	'class' => 'cancel',
    ));
		
    echo $this->Form->end();
?>
