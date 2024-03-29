jQuery(document ).ready(function(){

  $('.third-party-select2').select2();
  $('.truck-select2').select2();
  $('.driver-select2').select2();
  $('.block-select2').select2();
  $('.room-select2').select2();
  let ids =[];
  jQuery(document).on('click', '.row-table', function() {
    //let id = $(this).data('id');
    ids.push(jQuery(this).data('id'));
    console.log(ids)
  }); 


  
  jQuery('#input-block').change(function () {
            let blockId = jQuery(this).val();
            
           // let url = base_path +"{{ route('bills.getRoomsByBlockId' , ':blockId') }}";
           // url = url.replace(':blockId', blockId);
           let url = base_path +"bills/"+blockId+"/getRoomsByBlockId/";
           
              jQuery('#div-room').load(url , function(){
                
                  });
          });

            
    jQuery("#external-origin").on("change", function() {
            let origin = jQuery(this).val();
            let url = "{{ route('bills.getSelectByOrigin' , ':origin') }}";
            url = url.replace(':origin', origin);
            console.log(url);
              jQuery('#div-origin').load(url , function(){
                
                  });
      }) ;   
      jQuery("#internal-origin").on("change", function() {
            let origin = jQuery(this).val();
            let url = "{{ route('bills.getSelectByOrigin' , ':origin') }}";
            url = url.replace(':origin', origin);
              jQuery('#div-origin').load(url , function(){
                    
                  });
      }) ;

      $("#input-weight-discount-percentage").focusout(function(e) {
        e.stopImmediatePropagation();
      })

      $("#input-weight-discount-percentage").change(function(e) {
        e.stopImmediatePropagation();
        calculateNetValueWithWeightDiscountPercentage();
      })

      $("#input-net").focusout(function(e) {
        e.stopImmediatePropagation();
      })

      $("#input-net").change(function(e) {
        e.stopImmediatePropagation();
        calculateNetPayableValue();
      })

      $("#input-unit-price").focusout(function(e) {
        e.stopImmediatePropagation();
      })

      $("#input-unit-price").change(function(e) {
        e.stopImmediatePropagation();
        calculateNetPayableValue();
      })

      $("#input-discount-value").focusout(function(e) {
        e.stopImmediatePropagation();
      })

      $("#input-discount-value").change(function(e) {
        e.stopImmediatePropagation();
        calculateNetPayableValueWithDiscountValue();
      })

      $("#input-stored-quantity").focusout(function(e) {
        e.stopImmediatePropagation();
      })

      $("#input-stored-quantity").change(function(e) {
        e.stopImmediatePropagation();
        calculateWeightlossValue();
      })
      $("#input-unstocked-quantity").focusout(function(e) {
        e.stopImmediatePropagation();
      })

      $("#input-unstocked-quantity").change(function(e) {
        e.stopImmediatePropagation();
        calculateWeightlossValue();
      })
      $("#input-damaged-quantity").focusout(function(e) {
        e.stopImmediatePropagation();
      })

      $("#input-damaged-quantity").change(function(e) {
        e.stopImmediatePropagation();
        calculateWeightlossValue();
      })
  });
  function getParcelsByThirdPartyId(){
      
        let thirdPartyId = jQuery('#input-third-party').val();
            let url = "{{ route('bills.getParcelsByThirdPartyId' , ':thirdPartyId') }}";
            url = url.replace(':thirdPartyId', thirdPartyId);
              jQuery('#div-parcel').load(url , function(){
                
                  });
      }
  function calculateNetValue(){
  
    
      let numberBoxes = jQuery('#input-number-boxes').val();
      
      let raw = jQuery('#input-raw').val();
      
      let tare = jQuery('#input-tare').val();
      
    if (jQuery('#input-number-boxes').val() != '' && jQuery('#input-raw').val() != '' && jQuery('#input-tare').val() != ''){
    let net = parseFloat(raw)-parseFloat(tare)-(parseInt(numberBoxes)*2);
    jQuery("#input-net").val(net);
    jQuery("#input-net-weight-discount").val(net);
    } 
  }
  
  function calculateNetPayableValue(){
    let net = jQuery('#input-net-weight-discount').val();
      
    let unitPrice = jQuery('#input-unit-price').val();
    
  if (jQuery('#input-net').val() != '' && jQuery('#input-unit-price').val() != '' ){
  let netPayable = parseFloat(net)*parseFloat(unitPrice);
  jQuery("#input-net-payable").val(netPayable.toFixed(2));
  }

  function calculateNetValueWithWeightDiscountPercentage (){
            let net = jQuery('#input-net').val();
            let weightDiscountPercentage = jQuery('#input-weight-discount-percentage').val();
           
    if(jQuery('#input-net').val() != '' && jQuery('#input-weight-discount-percentage').val() != ''){
            
            let weightDiscount = (parseFloat(net)* parseFloat(weightDiscountPercentage))/100;
            net = net -weightDiscount ;
            console.log(net);
            jQuery("#input-net-weight-discount").val(net.toFixed(2));
    }
  }

  function calculateNetPayableValueWithDiscountValue(){
    if(jQuery('#input-net-payable').val() != '' && jQuery('#input-discount-value').val() != ''){
        let netPayable = jQuery('#input-net-payable').val();
        let discountValue = jQuery('#input-discount-value').val();
        netPayable = netPayable - discountValue;
        jQuery("#input-net-payable").val(netPayable.toFixed(2));
    }
  }

  function calculateRemainingValue(){
    if(jQuery('#input-amount-payable').val() != '' && jQuery('#input-amount').val() != ''){
      let amountPayable = jQuery('#input-amount-payable').val();
      let amount = jQuery('#input-amount').val();
      let remaining = amountPayable - amount;
      jQuery("#input-remaining").val(remaining.toFixed(2));
  }
  }


  function calculateVolumeValue(){
    if(jQuery('#length-id').val() != '' && 
      jQuery('#width-id').val() != '' && 
      jQuery('#height-id').val() != ''){
      let length = jQuery('#length-id').val();
      let width = jQuery('#width-id').val();
      let height =  jQuery('#height-id').val();
      let volume = length * width * height;

      jQuery("#volume-id").val(volume.toFixed(2));
    }
  }

function calculateWeightlossValue(){
  if(jQuery('#input-stored-quantity').val() != '' && 
  jQuery('#input-unstocked-quantity').val() != '' && 
  jQuery('#input-damaged-quantity').val() != ''){
  let storedQuantity = jQuery('#input-stored-quantity').val();
  let unstockedQuantity = jQuery('#input-unstocked-quantity').val();
  let damagedQuantity =  jQuery('#input-damaged-quantity').val();
  console.log(storedQuantity);
  console.log(unstockedQuantity);
  console.log(damagedQuantity);
  let weightlossValue = parseInt(storedQuantity) - (parseInt(unstockedQuantity) + parseInt(damagedQuantity)) ;
    console.log(weightlossValue);
  jQuery("#input-weightloss-value").val(weightlossValue.toFixed(2));  
  let lossValue = parseInt(weightlossValue) + parseInt(damagedQuantity);
  jQuery("#input-loss-value").val(lossValue.toFixed(2));
  let lossPercentage = (parseInt(lossValue) * 100)/storedQuantity;
  jQuery("#input-loss-percentage").val(lossPercentage.toFixed(2));
}
}


function getRoomsByBlock(){
 
  let blockId= jQuery('#input-block-search').val();
  let url = base_path +"rooms/getRoomsByBlock/"+blockId;
  $.ajax({
    url : url,
    type: 'get',
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
    data :{
        blockId:blockId
    },
    success:function(response){
          console.log(response);
          if(response) {
                  $('#input-room-search').empty();
                  msg = "<?php echo __('Select room') ?>";
                  $("#input-room-search").append("<option>"+response.placeholder+"</option>");
                      $.each(response.rooms,function(key,value){
                        
                         $('#input-room-search').append( '<option value="'+key+'">'+value+'</option>' )
                                
                      });
          }
        },
        error: function(error) {
          console.log(error);
        }
  });
}

function getTrucksByThirdPartyId(){
  let thidPartyId = $('#input-third-party').val();
  let url = base_path +"trucks/getTrucksByThirdPartyId/"+thidPartyId;
  $.ajax({
    url : url,
    type: 'get',
    headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
    data :{
      thidPartyId:thidPartyId
    },
    success:function(response){
          console.log(response);
          if(response) {
            $('#input-truck').empty();
                  $("#input-truck").append('<option>'+response.placeholder+'</option>');
                 
                      $.each(response.trucks,function(key,value){
                        // $('#input-third-party').append($("<option/>", {
                        //      value: key,
                        //      text: value,
                        //   }));
                        
                          $("#input-truck").append( '<option value="'+key+'">'+value+'</option>' )
                        
                         
                      });
          }
        },
        error: function(error) {
          console.log(error);
        }
  });
}



  }

