@extends('layouts.app', ['activePage' => 'program', 'titlePage' => __('Programs')])

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
              <h4 class="card-title ">{{__('Programs')}}</h4>
              <p class="card-category"> {{__('Here you can manage programs')}}</p>
            </div>
            <div class="card-body">
                              <div class="row">
                <div class="col-12 text-right">
                  <a href="{{ route('programs.create') }}" class="btn btn-sm btn-primary">{{__('Add program')}}</a>
                  <a href="{{ route('profile.editProgram') }}" class="btn btn-sm btn-primary">{{__('select current program')}}</a>
                
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
                    
                    <th class="text-right">
                    {{ __('Actions')}}
                    </th>
                  </tr></thead>
                  <tbody>
                  @foreach($programs as $program)
                    <tr>
                        <td>
                        {{ $program->code }}
                        </td>
                        <td>
                        {{ $program->name }}

                        </td>
                        <td class="td-actions text-right">
                           
                             <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('programs.edit', $program->id) }}" data-original-title="" title="">
                              <i class="material-icons">edit</i>
                              <div class="ripple-container"></div>
                            </a>
                            <a rel="tooltip" class="btn btn-danger btn-link"
                                onclick="event.preventDefault(); document.getElementById('destroy{{ $program->id }}').submit();" data-original-title="" title="">
                                <i class="material-icons">delete</i>
                              <div class="ripple-container"></div>  
                              </a>

                            
                            <form id="destroy{{ $program->id }}" action="{{ route('programs.destroy', $program->id) }}" method="POST" style="display: none;">
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

<script type="text/javascript">


</script>
