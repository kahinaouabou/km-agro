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
       
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{__('Rooms')}}</h4>
              <p class="card-category"> {{__('Here you can manage rooms')}}</p>
            </div>
            <div class="card-body">
                              <div class="row">
                <div class="col-12 text-right">
                  <a href="{{ route('rooms.create') }}" class="btn btn-sm btn-primary">{{__('Add room')}}</a>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr><th>
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
                  </tr></thead>
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