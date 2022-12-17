@extends('layouts.app', ['activePage' => 'driver', 'titlePage' => __('Add driver')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('drivers.store') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Add driver') }}</h4>
                <p class="card-category">{{ __('Driver information') }}</p>
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
                  <label class="col-sm-2 col-form-label">{{ __('Phone') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('phone') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" id="input-name" type="text" placeholder="{{ __('Phone') }}"   aria-required="true"/>
                      @if ($errors->has('phone'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('phone') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
               
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Subcontractors') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('third_party_id') ? ' has-danger' : '' }}">
                      <select class="form-control{{ $errors->has('third_party_id') ? ' is-invalid' : '' }}" name="third_party_id" 
                      id="input-subcontractor" type="select" placeholder="{{ __('subcontractor') }}" required >
                      <option value="">{{ __('Select subcontractor') }}</option>
                        @foreach($subcontractors as $subcontractor)
                        <option value="{{ $subcontractor->id }}" >{{ $subcontractor->name }}</option>
                        @endforeach
                    </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a class="btn btn-default btn-close" href="{{ route('drivers.index') }}">{{ __('Cancel') }}</a>
             
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
@endsection