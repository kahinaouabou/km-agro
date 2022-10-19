@extends('layouts.app', ['activePage' => 'truck', 'titlePage' => __('Edit truck')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('trucks.update', $truck->id) }}" class="form-horizontal">
            @csrf
            @method('PUT')
            
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Edit truck') }}</h4>
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
                      <input class="form-control{{ $errors->has('registration') ? ' is-invalid' : '' }}" name="registration" id="input-registration" type="text" placeholder="{{ __('Registration') }}"  value="{{ $truck->registration }}" required="true" aria-required="true"/>
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
                      <input class="form-control{{ $errors->has('model') ? ' is-invalid' : '' }}" name="model" id="input-model" type="text" placeholder="{{ __('Model') }}" value="{{ $truck->model }}"   aria-required="true"/>
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
                    {!! Form::number('tare', $truck->tare, [
                                                            'class' => 'form-control',
                                                            'step' => '0.1',
                                                            ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Marks') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                   
                    {!! Form::select('mark_id', $marks, $truck->mark->id,
                      [
                        'class' => 'form-control',
                        'placeholder'=> __('Select mark') ,
                        'label'=>__('Marks'),
      
                        ]) !!}
                    </div>
                  </div>
                </div>

               
              
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a class="btn btn-default btn-close" href="{{ route('trucks.index') }}">{{ __('Cancel') }}</a>
             
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
@endsection