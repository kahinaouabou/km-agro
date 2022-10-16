@extends('layouts.app', ['activePage' => 'parcel', 'titlePage' => __('Parcels')])

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
              <h4 class="card-title ">{{__('Parcels')}}</h4>
              <p class="card-category"> {{__('Here you can manage parcel')}}</p>
            </div>
            <div class="card-body">
                              <div class="row">
                <div class="col-12 text-right">
                  <a href="{{ route('parcels.create') }}" class="btn btn-sm btn-primary">{{__('Add parcel')}}</a>
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
                    {{__('Address')}} 
                    </th>
                    <th>
                    {{__('Parcel category')}} 
                    </th>
                    <th>
                    {{__('Third party')}} 
                    </th>
                    
                    <th class="text-right">
                    {{ __('Actions')}}
                    </th>
                  </tr>
                </thead>
                  <tbody>
                  @foreach($parcels as $parcel)
                    <tr>
                        <td>
                        {{ $parcel->code }}
                        </td>
                        <td>
                        {{ $parcel->name }}

                        </td>
                        <td>
                        {{ $parcel->address }}

                        </td>
                        <td>
                        {{ $parcel->parcelCategory->name }}

                        </td>
                        <td>
                          @if(!empty($parcel->thirdParty->name))
                            {{ $parcel->thirdParty->name }}
                          @endif  

                        </td>
                        <td class="td-actions text-right">
                             <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('parcels.edit', $parcel->id) }}" data-original-title="" title="">
                              <i class="material-icons">edit</i>
                              <div class="ripple-container"></div>
                            </a>
                            <a rel="tooltip" class="btn btn-danger btn-link"
                                onclick="event.preventDefault(); document.getElementById('destroy{{ $parcel->id }}').submit();" data-original-title="" title="">
                                <i class="material-icons">delete</i>
                              <div class="ripple-container"></div>  
                              </a>
                            
                            <form id="destroy{{ $parcel->id }}" action="{{ route('parcels.destroy', $parcel->id) }}" method="POST" style="display: none;">
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