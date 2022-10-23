

<div class="modal" id="addPayment">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >
      <div class="modal-header">
        <h4 class="modal-title">{{__("Add payment")}}</h4>
        <button type="button" class="close quick-close" data-dismiss="modal">
          <span>&times;</span>
        </button>            
      </div>
      <form id="add-payment-form"   autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')
        <div class="modal-body">
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Reference') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      {!! Form::input('text','reference',null,[
                        'class' => 'form-control',
                        'id'=>'input-reference'
                        ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Date') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      {!! Form::input('date','payment_date',date('Y-m-d'),[
                        'class' => 'form-control',
                        'id'=>'input-payment-date'
                        ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Amount payable') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('amount_payable', null, [
                                                'class' => 'form-control',
                                                'step' => '0.01',
                                                'id' =>'input-amount-payable',
                                                'readonly'=>true
                                                ]) !!}
                    </div>
                  </div>
                </div>  
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Amount') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('amount', null, [
                                                'class' => 'form-control',
                                                'step' => '0.01',
                                                'id' =>'input-amount',
                                                'onchange'=>'calculateRemainingValue(this.value)',
                                                'required' => true,
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
                                                'id' =>'input-remaining',
                                                'required' => true,
                                                ]) !!}
                    </div>
                  </div>
                </div>
             
                {!! Form::number('third_party_id', null, [
                                                'id' =>'input-third-party',
                                                'required' => true,
                                                'hidden' => true,
                                                ]) !!}
                {!! Form::number('payment_type', \App\Enums\PaymentTypeEnum::Receipt, [
                                                'id' =>'input-payment-type',
                                                'required' => true,
                                                'hidden' => true,
                                                ]) !!}                                
        
      </div>
      <div class="modal-footer">
        <button type="button" id="add-payment-button" class="btn btn-primary">{{ __('Save') }}</button>
        <button type="button" class="btn btn-default btn-close quick-close" data-dismiss="modal">{{ __('Close') }}</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
  
  jQuery(document).on('click', '.quick-close', function() {
        $('#addPayment').removeClass('show'); 
        $('#addPayment').css("display","none");
  });
 

});
</script> 