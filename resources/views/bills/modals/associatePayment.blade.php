

<div class="modal" id="associatePayment">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >
      <div class="modal-header">
        <h4 class="modal-title">{{__("Associate payment")}}</h4>
        <button type="button" class="close quick-close" data-dismiss="modal">
          <span>&times;</span>
        </button>            
      </div>
      <form id="associate-payment-form"   autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')
        <div class="modal-body">
            <div id ='receipt-tab'>

            </div>
               
            <div class="row">
                <label class="col-sm-2 col-form-label">{{ __('Amount payable') }}</label>
                <div class="col-sm-7">
                  <div class="form-group">
                  {!! Form::number('amount_payable', null, [
                                              'class' => 'form-control',
                                              'step' => '0.01',
                                              'id' =>'input-amount-payable-associate',
                                              'readonly'=>true
                                              ]) !!}
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-2 col-form-label">{{ __('Amount') }}</label>
                <div class="col-sm-7">
                  <div class="form-group">
                  {!! Form::number('amount', 0, [
                                              'class' => 'form-control',
                                              'step' => '0.01',
                                              'id' =>'input-amount-associate',
                                              'required' => true,
                                              'readonly'=>true
                                              ]) !!}
                  </div>
                </div>
              </div>
              <div class="row">
                <label class="col-sm-2 col-form-label">{{ __('Remaining') }}</label>
                <div class="col-sm-7">
                  <div class="form-group">
                  {!! Form::number('remaining', null, [
                                              'class' => 'form-control',
                                              'step' => '0.01',
                                              'id' =>'input-remaining-associate',
                                              'required' => true,
                                              'readonly'=>true
                                              ]) !!}
                  </div>
                </div>
              </div>                              
        
      </div>
      <div class="modal-footer">
        <button type="button" id="associate-payment-button" class="btn btn-primary">{{ __('Save') }}</button>
        <button type="button" class="btn btn-default btn-close quick-close" data-dismiss="modal">{{ __('Close') }}</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        console.log('ddddddff');
        $('.id').click(function() {
    
 });
 paymentIds =[];
 jQuery(document).on('change', '.id', function() {
    if(this.checked) {
        let amount = $('#input-amount-associate').val();
        amount = parseFloat(amount)+ parseFloat($('#input-rest-'+$(this).val()).val());
        $('#input-amount-associate').val(amount);
        calculateRemainingAssouciteValue();
        paymentIds.push(parseInt($(this).val()));
        console.log(paymentIds);

     }else {
        let amount = $('#input-amount-associate').val();
        amount = parseFloat(amount)- parseFloat($('#input-rest-'+$(this).val()).val());
        $('#input-amount-associate').val(amount);
        calculateRemainingAssouciteValue();
        paymentIds.splice($.inArray(parseInt($(this).val()), paymentIds), 1);
        console.log(paymentIds);

     }
  });
  jQuery(document).on('click', '.quick-close', function() {
        $('#associatePayment').removeClass('show'); 
        $('#associatePayment').css("display","none");
  });
 

});
function calculateRemainingAssouciteValue(){
    if(jQuery('#input-amount-payable-associate').val() != '' && jQuery('#input-amount-associate').val() != ''){
      let amountPayable = jQuery('#input-amount-payable-associate').val();
      let amount = jQuery('#input-amount-associate').val();
      let remaining = amountPayable - amount;
      jQuery("#input-remaining-associate").val(remaining.toFixed(2));
  }
  }
</script> 