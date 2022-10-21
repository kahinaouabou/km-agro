@extends('layouts.app', ['activePage' => 'product', 'titlePage' => __('Add product')])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

      <form id="add-payment-form" method="post" action="{{ route('payments.store') }}" autocomplete="off" class="form-horizontal">
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
                  <label class="col-sm-2 col-form-label">{{ __('Amount') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('amount', null, [
                                                'class' => 'form-control',
                                                'step' => '0.1',
                                                'id' =>'input-amount',
                                                'required' => true,
                                                ]) !!}
                                                {!! Form::number('payment_type', 1, [
                                                'class' => 'form-control',
                                                'step' => '0.1',
                                                'required' => true,
                                                ]) !!} 
                                                {!! Form::number('third_party_id', 1, [
                                                'class' => 'form-control',
                                                'step' => '0.1',
                                                'required' => true,
                                                ]) !!}                             
                    </div>
                  </div>
                </div>  
        
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
        <button type="button" class="btn btn-default btn-close quick-close" data-dismiss="modal">{{ __('Close') }}</button>
      </div>
      </form>
 
</div>
      </div>
      
    </div>
  </div>
@endsection
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript">
  jQuery(document).on('click', '.quick-close', function() {
        $('#addPayment').removeClass('show'); 
        $('#addPayment').css("display","none");
  });
 
  $("#add-payment-form").submit(function(e){
  e.preventDefault(); //empêcher une action par défaut
  let url = $(this).attr("action"); //récupérer l'URL du formulaire

  let method = $(this).attr("method"); //récupérer la méthode GET/POST du formulaire
    // let data = $(this).serialize(); //Encoder les éléments du formulaire pour la soumission
  let _token   = $('meta[name="csrf-token"]').attr('content');
  let reference = $('#input-reference').val();
  let amount = $('#input-amount').val();
  let payment_date = $('#input-payment-date').val();
  console.log(_token);

  $.ajax({
    url : url,
    type: method,
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    data :{
        "reference":reference,
        "payment_date":payment_date,
        "amount":amount,
    },
    dataType: "json",
    contentType: 'application/json; charset=utf-8',
    success:function(response){
          console.log(response);
          if(response) {
            $('.success').text(response.success);
            $("#add-payment-form")[0].reset();
          }
        },
        error: function(error) {
        //  console.log(error);
        //   $('#nameError').text(response.responseJSON.errors.name);
        //   $('#emailError').text(response.responseJSON.errors.email);
        //   $('#mobileError').text(response.responseJSON.errors.mobile);
        //   $('#messageError').text(response.responseJSON.errors.message);
        }
  });
});

</script> 