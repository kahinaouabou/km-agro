@extends('layouts.app', ['activePage' => 'discharge', 'titlePage' => __('Discharges')])

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
              <h4 class="card-title ">{{__('Discharges')}}</h4>
              <p class="card-category"> {{__('Here you can manage discharges')}}</p>
            </div>
            <div class="card-body">
                              <div class="row">
                <div class="col-12 text-right">
                  <a href="{{ route('discharges.create') }}" class="btn btn-sm btn-primary">{{__('Add discharge')}}</a>
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
                    {{__('Date')}} 
                    </th>
                    <th>
                        {{ __('Amount') }}

                        </th>
                        <th>
                        {{ __('Quantity') }}

                        </th>    
                    <th class="text-right">
                    {{ __('Actions')}}
                    </th>
                  </tr></thead>
                  <tbody>
                  @foreach($discharges as $discharge)
                    <tr>
                       
                        <td>
                        {{ $discharge->name }}

                        </td>
                        <td>
                        {{ Carbon\Carbon::parse($discharge->discharge_date)->format('d/m/Y') }}

                        </td>
                        <td>
                        {{ $discharge->amount }}

                        </td>
                        <td>
                        {{ $discharge->quantity }}

                        </td>
                        <td class="td-actions text-right">
                             <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('discharges.edit', $discharge->id) }}" data-original-title="" title="">
                              <i class="material-icons">edit</i>
                              <div class="ripple-container"></div>
                            </a>
                            <a rel="tooltip" class="btn btn-warning btn-link" href="{{ route('discharges.print', $discharge->id) }}" data-original-title="" title="" target="_blank">
                            <i class="material-icons">print</i>
                            <div class="ripple-container"></div>
                        </a> 
                            <a rel="tooltip" class="btn btn-danger btn-link"
                                onclick="event.preventDefault(); document.getElementById('destroy{{ $discharge->id }}').submit();" data-original-title="" title="">
                                <i class="material-icons">delete</i>
                              <div class="ripple-container"></div>  
                              </a>

                            
                            <form id="destroy{{ $discharge->id }}" action="{{ route('discharges.destroy', $discharge->id) }}" method="POST" style="display: none;">
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