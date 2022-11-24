@extends('layouts.app', ['activePage' => 'warehouse', 'titlePage' => __('Warehouses')])

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
              <h4 class="card-title ">{{__('Warehouses')}}</h4>
              <p class="card-category"> {{__('Here you can manage warehouse')}}</p>
            </div>
            <div class="card-body">
                              <div class="row">
                <div class="col-12 text-right">
                  <a href="{{ route('warehouses.create') }}" class="btn btn-sm btn-primary">{{__('Add warehouse')}}</a>
                </div>
              </div>
              <div class="table-responsive">
                <table class="table table-bordered data-table">
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
                    
                    <th class="text-right">
                    {{ __('Actions')}}
                    </th>
                  </tr></thead>
                  <tbody>
                 
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
<script src="{{ asset('/js/jquery-3.4.1.min.js')}}" ></script>
<script type="text/javascript">

  $(function () {

    

    var table = $('.data-table').DataTable({

        processing: true,

        serverSide: true,

        ajax: "{{ route('warehouses.index') }}",

        columns: [
            {data: 'code', name: 'code'},
            {data: 'name', name: 'name'},
            {data: 'address', name: 'address'},

            {data: 'action', name: 'action', orderable: false, searchable: false},

        ]

    });

    

  });

</script>