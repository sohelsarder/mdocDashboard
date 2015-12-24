$(function() {
    $( "#slider" ).slider({
    orientation: "horizontal",
    range: "min",
    min: 1,
    max: 30,
    value: 15,
    animate:true,
    slide: function( event, ui ) {
    $("#frame").val(ui.value);
    //step1();
    }
    });
    $( "#frame" ).val( $( "#slider" ).slider( "value" ) );
    });
    $(function() {
    $( "#range-slider" ).slider({
    orientation: "horizontal",
    range: "min",
    min: 160,
    max: 640,
    step:160,
    animate: true,
    value: 320,
    slide: function( event, ui ) {
    $("#resX").val(ui.value);
    
    var resY = +ui.value * 3/4;
    $("#resY").val(resY);
    
    //step1();
    }
    });
    $( "#resX" ).val( $( "#range-slider" ).slider( "value" ) );
    $( "#resY" ).val( +$( "#range-slider" ).slider( "value" ) * 3/4);
    
    $("#audioControl").change(function(){
      
      //step1();
      
    })
});
