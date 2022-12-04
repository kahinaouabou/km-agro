@extends('layouts.app', ['activePage' => 'discharge', 'titlePage' => __('Add discharge')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('discharges.store') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Add discharge') }}</h4>
                <p class="card-category">{{ __('Discharge information') }}</p>
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
                  <label class="col-sm-2 col-form-label">{{ __('Name') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Name') }}"  required="true" aria-required="true"/>
                      @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Date') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      {!! Form::input('date','discharge_date',date('Y-m-d'),[
                        'class' => 'form-control',
                        'id'=>'input-discharge-date'
                        ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Amount') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('amount') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('amount') ? ' is-invalid' : '' }}" name="amount" id="input-amount" type="number" placeholder="{{ __('Amount') }}" required />
                      @if ($errors->has('amount'))
                        <span id="amount-error" class="error text-danger" for="input-amount">{{ $errors->first('amount') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Quantity') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('quantity') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('quantity') ? ' is-invalid' : '' }}" name="quantity" id="input-quantity" type="number" placeholder="{{ __('Quantity') }}" required />
                      @if ($errors->has('quantity'))
                        <span id="quantity-error" class="error text-danger" for="input-quantity">{{ $errors->first('quantity') }}</span>
                      @endif
                    </div>
                  </div>
                      </div>

              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a class="btn btn-default btn-close" href="{{ route('discharges.index') }}">{{ __('Cancel') }}</a>
             
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
@endsection