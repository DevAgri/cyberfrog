$(document).ready(function() {
    $('select').material_select();
    
    $('#bt-load').click(function(e){
        e.stopPropagation();
        loadStation();
    });
    
    $('#bt-load-prague').click(function(e){
        e.stopPropagation();
        loadPrague();
    });
    
});


function loadStation(){
    var station = $("#station-select").val();
    $.ajax("dispatcher.php", {
        method: 'GET',
        data: 'do=load-station&station='+station,
        success: function( data ){
            $("#data-table > tbody").html(data);
        },
        error: function( err1,err2,err3 ){
            console.log(err1);
            console.log(err2);
            console.log(err3);
        },
        complete: function(){
            
        }
    });
    
}

function loadPrague(){
    var prague = $("#prague-select").val();
    $.ajax("dispatcher.php", {
        method: 'GET',
        data: 'do=show-analise&prague='+prague,
        success: function( data ){
            $("#data-table > tbody").html(data);
            grafico();
        },
        error: function( err1,err2,err3 ){
            console.log(err1);
            console.log(err2);
            console.log(err3);
        },
        complete: function(){
            
        }
    });
}

var $myFuelGauge;

//function grafico () {
//    $myFuelGauge = $("div#fuel-gauge").dynameter({
//        width: 100,
//        label: 'fuel',
//        value: 7.5,
//        min: 0.0,
//        max: 15.0,
//        unit: 'gal',
//        regions: {// Value-keys and color-refs
//            0: 'error',
//            .5: 'warn',
//            1.5: 'normal'
//        }
//    });
//
//    // jQuery UI slider widget
//    $('div#fuel-gauge-control').slider({
//        min: 0.0,
//        max: 15.0,
//        value: 7.5,
//        step: .1,
//        slide: function (evt, ui) {
//            $myFuelGauge.changeValue((ui.value).toFixed(1));
//        }
//    });
//}
 