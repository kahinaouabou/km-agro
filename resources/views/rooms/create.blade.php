@extends('layouts.app', ['activePage' => 'room', 'titlePage' => __('Add room')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" action="{{ route('rooms.store') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Add room') }}</h4>
                <p class="card-category">{{ __('Room information') }}</p>
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
                  <label class="col-sm-2 col-form-label">{{ __('Length') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('length', null, [
                                  'class' => 'form-control',
                                  'step' => '0.01',
                                  'id'=>'length-id',
                                  'onchange'=>'calculateVolumeValue(this.value)',
                                  'required' => true
                                  ]) !!}
                    </div>
                  </div>
                </div>
              
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Width') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('width', null, [
                                            'class' => 'form-control',
                                            'step' => '0.01',
                                            'id'=>'width-id',
                                            'onchange'=>'calculateVolumeValue(this.value)',
                                            'required' => true
                                            ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Height') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('height', null, [
                                            'class' => 'form-control',
                                            'step' => '0.01',
                                            'id'=>'height-id',
                                            'onchange'=>'calculateVolumeValue(this.value)',
                                            'required' => true
                                            ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Volume') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('volume', null, [
                                                'class' => 'form-control',
                                                'step' => '0.01',
                                                'id'=>'volume-id',
                                                'required' => true
                                                ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Stored quantity') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('stored_quantity', 0, [
                                                    'class' => 'form-control',
                                                    'required'=> true,
                                                    'step' => '0.1',
                                                    ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Unstocked quantity') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('unstocked_quantity', 0, [
                                                    'class' => 'form-control',
                                                    'required'=> true,
                                                    'step' => '0.1',
                                                    ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Damaged quantity') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('damaged_quantity', 0, [
                                                    'class' => 'form-control',
                                                    'required'=> true,
                                                    'step' => '0.1',
                                                    ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Weightloss') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('weightloss_value', 0, [
                                                    'class' => 'form-control',
                                                    'required'=> true,
                                                    'step' => '0.1',
                                                    ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Loss') .' %' }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('loss_percentage', 0, [
                                                    'class' => 'form-control',
                                                    'required'=> true,
                                                    'step' => '0.1',
                                                    ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Blocks') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('block_id') ? ' has-danger' : '' }}">
                      <select class="form-control{{ $errors->has('block_id') ? ' is-invalid' : '' }}" name="block_id" id="input-block" type="select" placeholder="{{ __('block') }}" required >
                      <option value="">{{ __('Select block') }}</option>
                        @foreach($blocks as $block)
                        <option value="{{ $block->id }}" >{{ $block->name }}</option>
                        @endforeach
                    </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                <a class="btn btn-default btn-close" href="{{ route('rooms.index') }}">{{ __('Cancel') }}</a>
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
