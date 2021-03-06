
$(document).ready(function () {	
    $(document.body).on("change",'#PrescriptionIsFollowup', function (event) {
	
	var value = $("#PrescriptionIsFollowup").val();
	if (value == 1) {
	   $("#follow").css("display","block")
	}else{
	     $("#follow").css("display","none")
	}	
    });	
});


///     prscription followup status change           ////
$(document).ready(function () {	
    $(document.body).on("click",'.status_list', function (event) {
	var this_id = $(this).attr("id");
	var id = this_id.split("_"); // prescripion id	
	$.ajax({
	    async:true,		   
	    dataType: "html",	   
	    url:siteurl+"Prescriptions/status/"+id[1]+"/"+id[2]+"/"+id[3],
	    success:function (data) {		
		$("#past_prescription").html(data);
	    },
	    type:"post"
				
	});			
	return false; 
    
    });
	
});
$(document).ready(function () {
	
    $(document.body).on("change",'#PrescriptionDiseaseId', function (event) {
	$("#wait").css('display','block');
	var disease =  $("#PrescriptionDiseaseId").val();
	    $.ajax({
		async:true,		   
		dataType: "html",
		url:siteurl+"Prescriptions/disease/"+disease,
		success:function (data) {
		    $("#wait").css('display','none');
		    $("#medicine").html(data);
		},
		type:"post"
				
	    });			
	return false; 
    });
	
});


$(document).ready(function () {
	
    $(document.body).on("change",'#PrescriptionPaymentType', function (event) {
	var value = $("#PrescriptionPaymentType").val();
	if (value == 'Paid') {
	   $("#deduct").css("display","block")
	}else{
	     $("#deduct").css("display","none")
	}
	
    });
	
});

// get disease information with disease id
$(document).ready(function () {
	
    $(document.body).on("change",'#PrescriptionDiseaseId', function (event) {
	$("#wait").css('display','block');
	var disease =  $("#PrescriptionDiseaseId").val();
	    $.ajax({
		async:true,		   
		dataType: "html",
		url:siteurl+"Prescriptions/disease/"+disease,
		success:function (data) {
		    $("#wait").css('display','none');
		    $("#medicine").html(data);
		},
		type:"post"
				
	    });			
	return false; 
    });
	
});


// delete appointment
$(document).ready(function () {
	
    $(document.body).on("click",'#delete', function (event) {
	var data = $("#AppointmentAddForm").serialize();	
	    $.ajax({
		async:true,		   
		dataType: "html",
		data: data,
		url:siteurl+"Prescriptions/reject/",
		success:function (data) {
		    $("#wait").css('display','none');
		    if (data ==1) {
			 window.location.href = siteurl+"Users/appointment"; 
		    }
		},
		type:"post"
				
	    });			
	return false; 
    });
	
});


// request call 
$(document).ready(function () {
	
    $(document.body).on("click",'#make-call', function (event) {
      
	$("#wait").css('display','block');
	// rmp_id for call initiate id
	
	var rmp_id =  $("#callto-id").val();
        var doctor_id =  $("#doctorId").val();
	var frame = $("#frame").val();
        var resolutionX = $("#resX").val();
        var resolutionY = $("#resY").val();
	var doctorName = $("#PrescriptionName").val();
	var patientName = $("#UserName").val();
        if (patientName== 'undefined' || patientName.length==0) {
	    patientName = 'Not given';
	    //code
	}
	// r_id for rmp actural id
	var r_id = $("#UserRmpId").val();
        var patientId = $("#PrescriptionPatientId").val();
        
        
        $("#reply").css("display","block");    
        $.ajax({
	    async:true,		   
	    dataType: "html",
	    url:siteurl+"Prescriptions/requestcall/"+rmp_id+'/'+doctor_id+'/'+frame+'/'+resolutionX+'/'+resolutionY+'/'+doctorName+'/'+patientName+'/'+r_id+'/'+patientId,
	    success:function (data) {
		$("#wait").css('display','none');
		
	    },
	    type:"post"
				
	});	 		
	return false; 
    });
	
});


// get disease list  with corresponds symtomp id

$(function() {	
    $(document.body).on('change', '#PrescriptionSystemId' ,function() {
	$("#waits").css('display','block');
	var system =  $("#PrescriptionSystemId").val();	    
	$.ajax({
	    async:true,		   
	    dataType: "html",
	    url:siteurl+"Prescriptions/system/"+system,
	    success:function (data) {
		$("#waits").css('display','none');
		$("#diseaseNameList").html(data);
	    },
	    type:"post"
				
	});			
	return false; 
    });	
	
});

//  create prescription 

 $(document).ready(function () {
    $("#submit").on("click", function (event) {	    
	var data = $("#PrescriptionAddForm").serialize();	
	var payment_type = $("#PrescriptionPaymentType").val();
	var PrescriptionIsFollowup = $("#PrescriptionIsFollowup").val();
	var PrescriptionPaymentType = $("#PrescriptionPaymentType").val();
	
	if (PrescriptionIsFollowup =='' || PrescriptionPaymentType =='' ) {
	    alert('Please select payment type ');
	    return false
	}	    
	$.ajax({
	    async:true,		   
	    dataType: "html",
	    data: data,
	    url:siteurl+"Prescriptions/addprescriptions/",
	    beforeSend: function(){
		$("#ajaxcircle").css("display", "block");
	    },
	    success:function (data) {
		$("#ajaxcircle").css("display", "none");
		if (data == 1) {
		   window.location.href = siteurl+"Prescriptions"; 
		}else{
		   window.location.href = siteurl+"Users";
		}
		   
	    },
	    type:"post"
                                    
        });			
	return false; 
    });
    $(document.body).on("click",'.prescription_list', function (event) { // get prescription list
	var this_id = $(this).attr("id");
	var id = this_id.split("_"); // prescripion id	
	$.ajax({
	    async:true,		   
	    dataType: "html",	   
	    url:siteurl+"Prescriptions/preview/"+id[1],
	    success:function (data) {
		$("#containt_prescription").html();
		$("#containt_prescription").html(data);
		
	    },
	    type:"post"
				
	});			
	return false;  
    
    });
    
    $(document.body).on("click",'.get_images', function (event) { // get more image 
	var this_id = $(this).attr("id");
	
	var id = this_id.split("_"); // appointment id	
	$.ajax({
	    async:true,		   
	    dataType: "html",	   
	    url:siteurl+"Prescriptions/getimage/"+id[1],
	    success:function (data) {
		$("#disseas_image").html(data);
	    },
	    type:"post"
				
	});			
	return false;  
    
    });
    
    
});

$(document).ready(function() {		
		$('.fancybox').fancybox();
		$(".fancybox-effects-a").fancybox({
			helpers: {
				title : {
					type : 'outside'
				},
				overlay : {
					speedOut : 0
				}
			}
		});
		$(".fancybox-effects-b").fancybox({
			openEffect  : 'none',
			closeEffect	: 'none',

			helpers : {
				title : {
					type : 'over'
				}
			}
		});
		$(".fancybox-effects-c").fancybox({
			wrapCSS    : 'fancybox-custom',
			closeClick : true,

			openEffect : 'none',

			helpers : {
				title : {
					type : 'inside'
				},
				overlay : {
					css : {
						'background' : 'rgba(238,238,238,0.85)'
					}
				}
			}
		});
		$(".fancybox-effects-d").fancybox({
			padding: 0,

			openEffect : 'elastic',
			openSpeed  : 150,

			closeEffect : 'elastic',
			closeSpeed  : 150,

			closeClick : true,

			helpers : {
				overlay : null
			}
		});
		$('.fancybox-buttons').fancybox({
			openEffect  : 'none',
			closeEffect : 'none',
			prevEffect : 'none',
			nextEffect : 'none',
			closeBtn  : false,
			helpers : {
				title : {
					type : 'inside'
				},
				buttons	: {}
			},
			afterLoad : function() {
				this.title = 'Image ' + (this.index + 1) + ' of ' + this.group.length + (this.title ? ' - ' + this.title : '');
			}
		});
	});

 $(document).ready( function() {    
        // When site loaded, load the Popupbox First
	$("#reject").click(function(){
	    
	     loadPopupBox();
	     return false;
	});
         
        $('#popupBoxClose').click( function() {            
            unloadPopupBox();
        });
        
        function unloadPopupBox() {    // TO Unload the Popupbox
            $('#popup_box').fadeOut("slow");
            $("#container").css({ // this is just for style        
                "opacity": "1"  
            }); 
        } 
        function loadPopupBox() {    // To Load the Popupbox
            $('#popup_box').fadeIn("slow");
            $("#container").css({ // this is just for style
                "opacity": "1"  
            });
	    
        }        
    });
