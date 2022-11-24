@extends('layouts.app', ['activePage' => 'transactionBox', 'titlePage' => __('Edit returned boxes')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('transactionBoxes.update', $transactionBox->id) }}" class="form-horizontal">
            @csrf
            @method('PUT')
            
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Edit returned boxes') }}</h4>
                <p class="card-category">{{ __('Box information') }}</p>
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
                  <label class="col-sm-2 col-form-label">{{ __('Date') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      {!! Form::input('date','transaction_date',$transactionBox->transaction_date->format('Y-m-d'),['class' => 'form-control']) !!}
                    </div>
                  </div>
                </div>
              
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Customers') }}</label>
                 
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('third_party_id') ? ' has-danger' : '' }}">
                      <select class="third-party-select2 form-control{{ $errors->has('third_party_id') ? ' is-invalid' : '' }}" name="third_party_id" id="input-third-party" type="select"  required >
                        <option value="">{{ __('Select customer') }}</option>
                        @foreach($thirdParties  as $key => $value)
                        
                        @if($key == $transactionBox->thirdParty->id)
                          <option selected value="{{ $key }}" >{{ $value }}</option>
                        @else
                        <option value="{{ $key }}" >{{ $value }}</option>
                        @endif
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Nb boxes returned') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('number_boxes_returned', $transactionBox->number_boxes_returned, [
                                  'class' => 'form-control',
                                  'required' => true
                                  ]) !!}
                    </div>
                  </div>
                </div>
                {!! Form::number('number_boxes_taken', $transactionBox->number_boxes_taken, [
                                  'class' => 'form-control',
                                  'required' => true,
                                  'hidden'=>true
                                  ]) !!}
                
                                  {!! Form::number('bill_id',$transactionBox->bill_id, [
                                  'class' => 'form-control',
                                  'hidden'=>true
                                  ]) !!}                                    
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a class="btn btn-default btn-close" href="{{ route('transactionBoxes.index') }}">{{ __('Cancel') }}</a>
             
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