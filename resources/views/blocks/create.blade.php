@extends('layouts.app', ['activePage' => 'block', 'titlePage' => __('Add block')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('blocks.store') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Add block') }}</h4>
                <p class="card-category">{{ __('Block information') }}</p>
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
                  <label class="col-sm-2 col-form-label">{{ __('Code') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('code') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" name="code" id="input-code" type="text" placeholder="{{ __('Code') }}" required="true" aria-required="true"/>
                      @if ($errors->has('code'))
                        <span id="code-error" class="error text-danger" for="input-code">{{ $errors->first('code') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
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
                  <label class="col-sm-2 col-form-label">{{ __('Rooms number') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('number_rooms') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('number_rooms') ? ' is-invalid' : '' }}" name="number_rooms" id="input-number_rooms" type="integer" placeholder="{{ __('Number rooms') }}" required />
                      @if ($errors->has('number_rooms'))
                        <span id="number_rooms-error" class="error text-danger" for="input-number_rooms">{{ $errors->first('number_rooms') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Warehouses') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('warehouse_id') ? ' has-danger' : '' }}">
                      <select class="form-control{{ $errors->has('warehouse_id') ? ' is-invalid' : '' }}" name="warehouse_id" id="input-block" type="select" placeholder="{{ __('block') }}" required >
                      <option value="">{{ __('Select warehouse') }}</option>
                        @foreach($warehouses as $warehouse)
                        <option value="{{ $warehouse->id }}" >{{ $warehouse->name }}</option>
                        @endforeach
                    </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a class="btn btn-default btn-close" href="{{ route('blocks.index') }}">{{ __('Cancel') }}</a>
             
              </div>
            </div>
          </form>
        </div>
      </div>
      
    </div>
  </div>
@endsection