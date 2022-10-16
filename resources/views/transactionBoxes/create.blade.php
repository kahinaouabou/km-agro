@extends('layouts.app', ['activePage' => 'transactionBox', 'titlePage' => __('Add returned boxes')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('transactionBoxes.store') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Add returned boxes') }}</h4>
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
                        {!! Form::input('date','transaction_date',date('Y-m-d'),['class' => 'form-control']) !!}
                    </div>
                  </div>
                </div>
               
                
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Customers') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('third_party_id') ? ' has-danger' : '' }}">
                      <select class="form-control{{ $errors->has('third_party_id') ? ' is-invalid' : '' }}" name="third_party_id" id="input-third-party" type="select" placeholder="{{ __('Customer') }}" required >
                      <option value="">{{ __('Select customer') }}</option>
                        @foreach($thirdParties as $thirdParty)
                        <option value="{{ $thirdParty->id }}" >{{ $thirdParty->name }}</option>
                        @endforeach
                    </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Nb boxes returned') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('number_boxes_returned', null, [
                                  'class' => 'form-control',
                                  'required' => true
                                  ]) !!}
                    </div>
                  </div>
                </div>
                {!! Form::number('number_boxes_taken', 0, [
                                  'class' => 'form-control',
                                  'required' => true,
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