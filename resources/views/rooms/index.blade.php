@extends('layouts.app', ['activePage' => 'room', 'titlePage' => __('Rooms')])

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
                <form action="{{ route('rooms.index') }}" method="GET" style="margin-top: 20px;">
                
                <div class="card ">
                  
                    <div class="card-body ">
                      
                        <div class="col-sm-12">
                            <label class="col-sm-2 col-form-label col-form-label-filter">{{ __('Blocks') }}</label>
                        
                            <div class="col-sm-3" style="display: inline-block;">
                              <div class="form-group">
                                <select name="block_id" id="input-block" class="form-control">
                                  <option value="0">{{ __('Select block') }}</option>
                                  @foreach (\App\Models\Block::select('id','name')->get() as $block)
                                    <option value="{{ $block->id }}" {{ $block->id == $selected_id['block_id'] ? 'selected' : '' }}>
                                    {{ $block['name'] }}
                                    </option>
                                  @endforeach
                                </select>
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
              <h4 class="card-title ">{{__('Rooms')}}</h4>
              <p class="card-category"> {{__('Here you can manage rooms')}}</p>
            </div>
            <div class="card-body">
                              <div class="row">
                <div class="col-12 text-right">
                <a target="_blanck" href="{{ route('rooms.print', $selected_id) }}"  class="btn btn-sm btn-primary">{{__('Print PDF')}}</a>
                
                  <a href="{{ route('rooms.create') }}" class="btn btn-sm btn-primary">{{__('Add room')}}</a>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr>
                      <th>
                       {{ __('Code')}}
                    </th>
                    <th>
                    {{__('Name')}} 
                    </th>
                    <th>
                    {{__('Volume')}} 
                    </th>
                    <th>
                    {{__('Stored quantity')}} 
                    </th>
                    <th>
                    {{__('Unstocked quantity')}} 
                    </th>
                    <th>
                    {{__('Damaged quantity')}} 
                    </th>
                    <th>
                    {{__('Weightloss')}} 
                    </th>
                    <th>
                    {{__('Loss')}} 
                    </th>
                    <th>
                    {{__('Loss'). ' %'}} 
                    </th>
                    <th>
                    {{__('Blocks')}} 
                    </th>
                    <th class="text-right">
                    {{ __('Actions')}}
                    </th>
                  </tr>
                </thead>
                  <tbody>
                  @foreach($rooms as $room)
               
                    <tr>
                        <td>
                        {{  $room->code }}
                        </td>
                        <td>
                        {{ $room->name }}
                        </td>
                       
                        <td>
                        {{ $room->volume }}
                        </td>
                        <td>
                        {{ $room->stored_quantity }}
                        </td>
                        <td>
                        {{ $room->unstocked_quantity }}
                        </td>
                        <td>
                        {{ $room->damaged_quantity }}
                        </td>
                        <td>
                        {{ $room->weightloss_value }}
                        </td>
                        <td>
                        {{ $room->loss_value }}
                        </td>
                        <td>
                        {{ $room->loss_percentage }}
                        </td>
                        <td>
                        {{ $room->block->name }}

                        </td>
                        <td class="td-actions text-right">
                             <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('rooms.edit', $room->id) }}" data-original-title="" title="">
                              <i class="material-icons">edit</i>
                              <div class="ripple-container"></div>
                            </a>
                            
                            <a rel="tooltip" class="btn btn-danger btn-link"
                                onclick="event.preventDefault(); document.getElementById('destroy{{ $room->id }}').submit();" data-original-title="" title="">
                                <i class="material-icons">delete</i>
                              <div class="ripple-container"></div>  
                              </a>

                            
                            <form id="destroy{{ $room->id }}" action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                      </tr>
					   @endforeach
					</tbody>
                </table>
              </div>
            </div>
          </div>
         
      </div>
    </div>
  </div>
</div>
@endsection