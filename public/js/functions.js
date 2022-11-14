jQuery(document ).ready(function(){

 
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

  function checkIfNameThirdPartyExist(){

}

