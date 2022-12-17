@extends('layouts.app', ['activePage' => 'driver', 'titlePage' => __('Drivers')])

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
          @if (session()->has('error'))
          <div class="alert alert-danger" role="alert">
              {{ session('error') }}
          </div>
          @endif
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{__('Drivers')}}</h4>
              <p class="card-category"> {{__('Here you can manage drivers')}}</p>
            </div>
            <div class="card-body">
                              <div class="row">
                <div class="col-12 text-right">
                  <a href="{{ route('drivers.create') }}" class="btn btn-sm btn-primary">{{__('Add driver')}}</a>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr>
                    <th>
                    {{__('Name')}} 
                    </th>
                    <th>
                    {{__('Phone')}} 
                    </th>
                    <th>
                        {{ __('Subcontractors') }}

                    </th>
                    <th class="text-right">
                    {{ __('Actions')}}
                    </th>
                  </tr></thead>
                  <tbody>
                  @foreach($drivers as $driver)
                    <tr>
                        
                        <td>
                        {{ $driver->name }}

                        </td>
                        <td>
                        {{ $driver->phone }}

                        </td>
                        <td>
                        {{ $driver->thirdParty->name }}

                        </td>
                        <td class="td-actions text-right">
                             <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('drivers.edit', $driver->id) }}" data-original-title="" title="">
                              <i class="material-icons">edit</i>
                              <div class="ripple-container"></div>
                            </a>
                            <a rel="tooltip" class="btn btn-danger btn-link"
                                onclick="event.preventDefault(); document.getElementById('destroy{{ $driver->id }}').submit();" data-original-title="" title="">
                                <i class="material-icons">delete</i>
                              <div class="ripple-container"></div>  
                              </a>

                            
                            <form id="destroy{{ $driver->id }}" action="{{ route('drivers.destroy', $driver->id) }}" method="POST" style="display: none;">
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