@extends('layouts.app', ['activePage' => 'truck', 'titlePage' => __('Trucks')])

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
              <h4 class="card-title ">{{__('Trucks')}}</h4>
              <p class="card-category"> {{__('Here you can manage truck')}}</p>
            </div>
            <div class="card-body">
                              <div class="row">
                <div class="col-12 text-right">
                  <a href="{{ route('trucks.create') }}" class="btn btn-sm btn-primary">{{__('Add truck')}}</a>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr><th>
                       {{ __('Registration')}}
                    </th>
                    <th>
                    {{__('Model')}} 
                    </th>
                    <th>
                    {{__('Mark')}} 
                    </th>
                    <th>
                    {{__('Tare')}} 
                    </th>
                    <th class="text-right">
                    {{ __('Actions')}}
                    </th>
                  </tr></thead>
                  <tbody>
                  @foreach($trucks as $truck)
                    <tr>
                        <td>
                        {{ $truck->registration }}
                        </td>
                        <td>
                        {{ $truck->model }}

                        </td>
                        <td>
                        {{ $truck->mark->name }}

                        </td>
                        <td>
                        {{ $truck->tare }}

                        </td>
                        <td class="td-actions text-right">
                             <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('trucks.edit', $truck->id) }}" data-original-title="" title="">
                              <i class="material-icons">edit</i>
                              <div class="ripple-container"></div>
                            </a>
                            <a rel="tooltip" class="btn btn-danger btn-link"
                                onclick="event.preventDefault(); document.getElementById('destroy{{ $truck->id }}').submit();" data-original-title="" title="">
                                <i class="material-icons">delete</i>
                              <div class="ripple-container"></div>  
                              </a>

                            
                            <form id="destroy{{ $truck->id }}" action="{{ route('trucks.destroy', $truck->id) }}" method="POST" style="display: none;">
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