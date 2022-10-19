@extends('layouts.app', ['activePage' => 'transactionBox', 'titlePage' => __('TransactionBoxes')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          @if (session()->has('message'))
          <div class="alert alert-success" role="alert">
              {{ session('message') }}
          </div>
          @endif
		  		
          <div class="panel-group">
            <div class="panel panel-default">
            
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#search"><i class="material-icons">search</i>{{ __('Search') }}</a>
                </h4>
              </div>
              <div class="collapse " id="search">
                <form action="{{ route('transactionBoxes.index') }}" method="GET" style="margin-top: 20px;">
                
                <div class="card ">
                  
                    <div class="card-body ">
                      
                        <div class="col-sm-12">
                            <label class="col-sm-2 col-form-label col-form-label-filter">{{ __('Customers') }}</label>
                        
                            <div class="col-sm-3" style="display: inline-block;">
                              <div class="form-group">
                                <select name="third_party_id" id="input-third-party" class="form-control">
                                  <option value="0">{{ __('Select customer') }}</option>
                                  @foreach (\App\Models\ThirdParty::select('id','name')->where('is_supplier','=',App\Enums\ThirdPartyEnum::Customer)->get() as $thirdParty)
                                    <option value="{{ $thirdParty->id }}" {{ $thirdParty->id == $selected_id['third_party_id'] ? 'selected' : '' }}>
                                    {{ $thirdParty['name'] }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>	
                            
                          </div>	
                          
                          <div class="col-sm-12">
                            <label class="col-sm-2 col-form-label col-form-label-filter">{{ __('Date from') }}</label>
                        
                            <div class="col-sm-3" style="display: inline-block;">
                              <div class="form-group">
                              {!! Form::input('date','date_from', $selected_id['date_from']  ,
                                              [
                                                'class' => 'form-control',
                                                'id'=> 'input-date-form'
                                                ]) !!}
                              </div>
                            </div>	
                            <label class="col-sm-2 col-form-label col-form-label-filter">{{ __('Date to') }}</label>
                        
                            <div class="col-sm-3" style="display: inline-block;">
                              <div class="form-group">
                              {!! Form::input('date','date_to',$selected_id['date_to'],
                                          [
                                            'class' => 'form-control',
                                            'id'=>'input-date-to'
                                            ]) !!}
                              </div>
                            </div>
                          </div>			   
                          
                    </div>
                    <div class="card-footer ml-auto mr-auto">
                      <input type="submit" class="btn btn-danger btn-sm" value="{{ __('Filter') }}"> 
                    </div>
                    
                  
                </div>
                </form>
              </div>
            </div>
          </div>
			
			
				<div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{__('Transaction boxes')}}</h4>
              <p class="card-category"> {{__('Here you can manage transaction boxes')}}</p>
            </div>
				    <div class="card-body">
              <div class="row">
                <div class="col-12 text-right">
                <a href="{{ route('transactionBoxes.print', $selected_id) }}"  class="btn btn-sm btn-primary">{{__('Print PDF')}}</a>
                
                  <a href="{{ route('transactionBoxes.create') }}" class="btn btn-sm btn-primary">{{__('Add returned boxes')}}</a>
                </div>
              </div>
				      <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr>
                      <th>
                        {{ __('Reference').' '.__('Bill')}}
                      </th>
                      <th>
                        {{ __('Date')}}
                      </th>
                      <th>
                      {{__('Customer')}} 
                      </th>
                      <th>
                      {{__('Nb boxes taken')}} 
                      </th>
                      <th>
                      {{__('Nb boxes returned')}} 
                      </th>
                      <th class="text-right">
                      {{ __('Actions')}}
                      </th>
                    </tr>
                </thead>
                  <tbody>
                  @forelse($transactionBoxes as $transactionBox)
               
                    <tr>
                        <td>
                        @if(!empty($transactionBox->bill->reference))
                        {{  $transactionBox->bill->reference }}
                        @endif
                        </td>
                        <td>
                        {{  $transactionBox->transaction_date->format('d/m/Y') }}
                        </td>
                        <td>
                        {{ $transactionBox->thirdParty->name }}
                        </td>
                        <td>
                        {{ $transactionBox->number_boxes_taken }}
                        </td>
                        <td>
                        {{ $transactionBox->number_boxes_returned }}
                        </td>
                        <td class="td-actions text-right">
                             <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('transactionBoxes.edit', $transactionBox->id) }}" data-original-title="" title="">
                              <i class="material-icons">edit</i>
                              <div class="ripple-container"></div>
                            </a>
                            
                            <a rel="tooltip" class="btn btn-danger btn-link"
                                onclick="event.preventDefault(); document.getElementById('destroy{{ $transactionBox->id }}').submit();" data-original-title="" title="">
                                <i class="material-icons">delete</i>
                              <div class="ripple-container"></div>  
                              </a>

            
                            <form id="destroy{{ $transactionBox->id }}" action="{{ route('transactionBoxes.destroy', $transactionBox->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                      </tr>
					        @empty
	    				    <p> {{__('No data Found')}} </p>
	    				    @endforelse
					      </tbody>
                </table>
              </div>
			      </div>
			      <div class="card-header card-header-primary card-footer-primary">
              <h4 class="card-title ">{{__('Number boxes taken')}} : <strong >{{$countTakenBoxes}}</strong></h4>
              <h4 class="card-title ">{{__('Number boxes returned')}} : <strong>{{$countReturnedBoxes}}</strong></h4>
            </div> 
	    	</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/functions.js') }}"></script>
<script type="text/javascript">



</script>