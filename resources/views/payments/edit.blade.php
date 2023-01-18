@extends('layouts.app', ['activePage' => 'payment', 'titlePage' => __('Edit Payment')])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

      <form id="add-payment-form" method="post" action="{{ route('payments.update', $payment->id) }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{__('Payment')}}</h4>
              <p class="card-category"> {{__('Payment').' '.__('information')}}</p>
              </div>
              <div class="card-body ">
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Reference') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      {!! Form::input('text','reference',$payment->reference,[
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
                      {!! Form::input('date','payment_date',Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d'),[
                        'class' => 'form-control',
                        'id'=>'input-payment-date'
                        ]) !!}
                    </div>
                  </div>
                </div>
                @if(!empty( $payment->paymentCategory->id))
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Categories') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::select('payment_category_id', $paymentCategries, $payment->paymentCategory->id,
                      [
                        'class' => 'form-control',
                        'placeholder'=> __('Select category') ,
      
                        ]) !!}
                    </div>
                  </div>
                </div>
                @else 
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Categories') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::select('payment_category_id', $paymentCategries, null,
                      [
                        'class' => 'form-control',
                        'placeholder'=> __('Select category') ,
      
                        ]) !!}
                    </div>
                  </div>
                </div>
                @endif
               
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Third party') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('third_party_id') ? ' has-danger' : '' }}">
                      <select class="third-party-select2 form-control{{ $errors->has('third_party_id') ? ' is-invalid' : '' }}" name="third_party_id" id="input-third-party" type="select"  required >
                        <option value="">{{ __('Select third') }}</option>
                        @foreach($thirdParties as $thirdParty)
                        @if($thirdParty->id == $payment->third_party_id)
                          <option selected="selected" value="{{ $thirdParty->id }}" >{{ $thirdParty->name }}</option>
                        @else 
                          <option value="{{ $thirdParty->id }}" >{{ $thirdParty->name }}</option>
                        @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div> 
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Amount') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('amount', $payment->amount, [
                                                'class' => 'form-control',
                                                'step' => '0.01',
                                                'id' =>'input-amount',
                                                'required' => true,
                                                ]) !!}
                                                                            
                    </div>
                  </div>
                </div> 
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Observation') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::textarea('observation', $payment->observation, [
                                                'class' => 'form-control',
                                                'id' =>'input-observation',
                                                ]) !!}
                                                                            
                    </div>
                  </div>
                </div>
               
                {!! Form::number('payment_type', $payment->payment_type, [
                                                'class' => 'form-control',
                                                'required' => true,
                                                'hidden'=>true
                                                ]) !!} 
                                            
             </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a class="btn btn-default btn-close" href="{{ route('payments.index') }}">{{ __('Cancel') }}</a>
             
              </div>
            </div>
      </form>
 
</div>
      </div>
      
    </div>
  </div>
@endsection

<script src="{{ asset('/js/jquery-3.4.1.min.js')}}" ></script>

<script type="text/javascript" src="{{ URL::asset('js/functions.js') }}"></script>
<script type="text/javascript">
</script> 