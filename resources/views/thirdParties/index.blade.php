


@extends('layouts.app', ['activePage' => $activePage, 'titlePage' => __($titlePage)])

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
              
            @if($isSupplier==1) 
              @if($isSubcontractor==1) 
                <h4 class="card-title ">{{__('Subcontractors')}}</h4>
                <p class="card-category"> {{__('Here you can manage subcontractor')}}</p> 
              @else
                <h4 class="card-title ">{{__('Suppliers')}}</h4>
                <p class="card-category"> {{__('Here you can manage supplier')}}</p> 
              @endif             
            @else
              <h4 class="card-title ">{{__('Customers')}}</h4>
              <p class="card-category"> {{__('Here you can manage customer')}}</p>         
            @endif
              
            </div>
            <div class="card-body">
                              <div class="row">
                <div class="col-12 text-right">
                @if($isSupplier==1 )   
                    @if($isSubcontractor==1)
                        <a href="{{ route('thirdParties.create',[(int)$isSupplier ,(int)$isSubcontractor]) }}" 
                        class="btn btn-sm btn-primary">{{__('Add subcontractor')}}</a>              
                    @else 
                        <a href="{{ route('thirdParties.create',[(int)$isSupplier ,(int)$isSubcontractor]) }}" 
                        class="btn btn-sm btn-primary">{{__('Add supplier')}}</a>              
                    @endif            
                @else 
                    <a href="{{ route('thirdParties.create',[(int)$isSupplier ,(int)$isSubcontractor]) }}" 
                    class="btn btn-sm btn-primary">{{__('Add customer')}}</a>       
                @endif
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
                    {{__('Address')}} 
                    </th>
                    <th>
                    {{__('Phone')}} 
                    </th>
                    
                    <th class="text-right">
                    {{ __('Actions')}}
                    </th>
                  </tr></thead>
                  <tbody>
                  @foreach($thirdParties as $thirdParty)
                    <tr>
                        <td>
                        {{ $thirdParty->code }}
                        </td>
                        <td>
                        {{ $thirdParty->name }}

                        </td>
                        <td>
                        {{ $thirdParty->address }}
                        
                        </td>
                        <td>
                        {{ $thirdParty->phone }}
                        
                        </td>
                        <td class="td-actions text-right">
                             <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('thirdParties.edit', [$thirdParty->id , (int)$isSupplier ,(int)$isSubcontractor] ) }}" data-original-title="" title="">
                              <i class="material-icons">edit</i>
                              <div class="ripple-container"></div>
                            </a>
                            <a rel="tooltip" class="btn btn-danger btn-link"
                                onclick="event.preventDefault(); document.getElementById('destroy{{ $thirdParty->id }}').submit();" data-original-title="" title="">
                                <i class="material-icons">delete</i>
                              <div class="ripple-container"></div>  
                              </a>

                            
                            <form id="destroy{{ $thirdParty->id }}" action="{{ route('thirdParties.destroy', $thirdParty->id) }}" method="POST" style="display: none;">
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