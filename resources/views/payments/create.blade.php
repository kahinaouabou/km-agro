@extends('layouts.app', ['activePage' => $page['active'], 'titlePage' => __($page['title'])])

@section('content')
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">

      <form id="add-payment-form" method="post" action="{{ route('payments.store') }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('post')
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">{{__($page['titleCard'])}}</h4>
              <p class="card-category"> {{__($page['name']).' '.__('information')}}</p>
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
                      {!! Form::input('text','reference',$nextReference,[
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
                  <label class="col-sm-2 col-form-label">{{ __('Third party') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('third_party_id') ? ' has-danger' : '' }}">
                      <select class="third-party-select2 form-control{{ $errors->has('third_party_id') ? ' is-invalid' : '' }}" name="third_party_id" id="input-third-party" type="select"  required >
                        <option value="">{{ __('Select third') }}</option>
                        @foreach($thirdParties as $thirdParty)
                        <option value="{{ $thirdParty->id }}" >{{ $thirdParty->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div> 
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Amount') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('amount', null, [
                                                'class' => 'form-control',
                                                'step' => '0.01',
                                                'id' =>'input-amount',
                                                'required' => true,
                                                ]) !!}
                                                                            
                    </div>
                  </div>
                </div> 
               
                {!! Form::number('payment_type', $type, [
                                                'class' => 'form-control',
                                                'step' => '0.1',
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