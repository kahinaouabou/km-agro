@extends('layouts.app', ['activePage' => 'truck', 'titlePage' => __('Add truck')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('trucks.store') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Add truck') }}</h4>
                <p class="card-category">{{ __('Truck information') }}</p>
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
                  <label class="col-sm-2 col-form-label">{{ __('Registration') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('registration') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('registration') ? ' is-invalid' : '' }}" name="registration" id="input-registration" type="text" placeholder="{{ __('Registration') }}" required="true" aria-required="true"/>
                      @if ($errors->has('registration'))
                        <span id="registration-error" class="error text-danger" for="input-registration">{{ $errors->first('registration') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Model') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('model') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('model') ? ' is-invalid' : '' }}" name="model" id="input-model" type="text" placeholder="{{ __('Model') }}"   aria-required="true"/>
                      @if ($errors->has('model'))
                        <span id="model-error" class="error text-danger" for="input-model">{{ $errors->first('model') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Tare') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('tare', null, [
                                                    'class' => 'form-control',
                                                    'step' => '0.1',
                                                    ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Marks') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('mark_id') ? ' has-danger' : '' }}">
                      <select class="form-control{{ $errors->has('mark_id') ? ' is-invalid' : '' }}" name="mark_id" id="input-mark" type="select" placeholder="{{ __('Mark') }}"  >
                      <option value="">{{ __('Select mark') }}</option>
                        @foreach($marks as $mark)
                        <option value="{{ $mark->id }}" >{{ $mark->name }}</option>
                        @endforeach
                    </select>
                    </div>
                  </div>
                </div>
                
                
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a class="btn btn-default btn-close" href="{{ route('warehouses.index') }}">{{ __('Cancel') }}</a>
             
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
@endsection