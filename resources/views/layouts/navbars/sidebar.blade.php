<div class="sidebar" data-color="orange" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
  <!--
      Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

      Tip 2: you can also add an image using data-image tag
  -->
  <div class="logo">
    <a href="#" class="simple-text logo-normal">
      {{ __('KM AGRO') }}
    </a>
  </div>
  <div class="sidebar-wrapper">
    <ul class="nav">
      <li class="nav-item{{ $activePage == 'dashboard' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
          <i class="material-icons">dashboard</i>
            <p>{{ __('Dashboard') }}</p>
        </a>
      </li>
            @if(auth()->user()->hasRole('Admin'))
            <li class="nav-item{{ $activePage == 'warehouse' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('warehouses.index') }}">
              <i class="material-icons icon-sidebar">Et</i>
                <span class="sidebar-normal">{{ __('Warehouses') }} </span>
              </a>
            </li>
            
            
            <li class="nav-item{{ $activePage == 'block' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('blocks.index') }}">
              <i class="material-icons icon-sidebar"> Bk </i>
                <span class="sidebar-normal">{{ __('Blocks') }} </span>
              </a>
            </li>
            

            <li class="nav-item{{ $activePage == 'room' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('rooms.index') }}">
                <i class="material-icons icon-sidebar"> Rm </i>
                <span class="sidebar-normal">{{ __('Rooms') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'product' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('products.index') }}">
                <i class="material-icons icon-sidebar"> Pt </i>
                <span class="sidebar-normal">{{ __('Products') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'thirdParty/0/0' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('thirdParties', 
                ['isSupplier'=>0 , 'isSubcontractor'=>0]) }}">
              <i class="material-icons icon-sidebar"> Cr </i>
                <span class="sidebar-normal">{{ __('Customers') }} </span>
              </a>
            </li>
   
            <li class="nav-item{{ $activePage == 'thirdParty/1/0' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('thirdParties' , 
                [$isSupplier = 1, 'isSubcontractor'=>0]) }}">
              <i class="material-icons icon-sidebar"> Sr </i>
                <span class="sidebar-normal">{{ __('Suppliers') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'thirdParty/1/1' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('thirdParties' , 
                [$isSupplier = 1, 'isSubcontractor'=>1]) }}">
              <i class="material-icons icon-sidebar"> Sr </i>
                <span class="sidebar-normal">{{ __('Subcontractors') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'driver' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('drivers.index') }}">
              <i class="material-icons icon-sidebar"> Dr </i>
                <span class="sidebar-normal">{{ __('Drivers') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'parcel' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('parcels.index') }}">
              <i class="material-icons icon-sidebar"> Pl </i>
                <span class="sidebar-normal">{{ __('Parcels') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'parcelCategory' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('parcelCategories.index') }}">
              <i class="material-icons icon-sidebar"> Pc </i>
                <span class="sidebar-normal">{{ __('Parcel categories') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'mark' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('marks.index') }}">
              <i class="material-icons icon-sidebar"> Mk </i>
                <span class="sidebar-normal">{{ __('Marks') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'truck' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('trucks.index') }}">
              <i class="material-icons icon-sidebar"> Tk </i>
                <span class="sidebar-normal">{{ __('Trucks') }} </span>
              </a>
            </li>
    
            <li class="nav-item{{ $activePage == 'bill/1' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('bills' , $type = \App\Enums\BillTypeEnum::EntryBill) }}">
              <i class="material-icons icon-sidebar"> Be </i>
                <span class="sidebar-normal">{{ __('Entry bill') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'bill/2' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('bills' , $type = \App\Enums\BillTypeEnum::ExitBill) }}">
              <i class="material-icons icon-sidebar"> Bs </i>
                <span class="sidebar-normal">{{ __('Weigh bill for payment') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'bill/' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('bills' , $type = \App\Enums\BillTypeEnum::WeighBill ) }}">
              <i class="material-icons icon-sidebar"> Bp </i>
                <span class="sidebar-normal">{{ __('Weigh bill') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'bill/4' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('bills' , $type = \App\Enums\BillTypeEnum::DamageBill ) }}">
              <i class="material-icons icon-sidebar"> Bd </i>
                <span class="sidebar-normal">{{ __('Damage bill') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'bill/5' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('bills' , $type = \App\Enums\BillTypeEnum::DeliveryBill ) }}">
              <i class="material-icons icon-sidebar"> Dd </i>
                <span class="sidebar-normal">{{ __('Delivery bill') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'bill/6' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('bills' , $type = \App\Enums\BillTypeEnum::SubcontractingBill ) }}">
              <i class="material-icons icon-sidebar"> Sb </i>
                <span class="sidebar-normal">{{ __('Subcontracting bill') }} </span>
              </a>
            </li>
            @endif
            @if (auth()->user()->can('transaction-box-list'))
            <li class="nav-item{{ $activePage == 'transactionBox' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('transactionBoxes.index') }}">
              <i class="material-icons icon-sidebar"> Tb </i>
                <span class="sidebar-normal">{{ __('Transaction boxes') }} </span>
              </a>
            </li>
            @endif
            @if(auth()->user()->hasRole('Admin'))
            <li class="nav-item{{ $activePage == 'payment' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('payments.index') }}">
              <i class="material-icons icon-sidebar"> Pt </i>
                <span class="sidebar-normal">{{ __('Payments') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'company' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('companies.edit', \App\Models\Company::first()) }}">
              <i class="material-icons icon-sidebar"> Cy </i>
                <span class="sidebar-normal">{{ __('Company') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'program' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('programs.index') }}">
              <i class="material-icons icon-sidebar"> Pt </i>
                <span class="sidebar-normal">{{ __('Programs') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'discharge' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('discharges.index') }}">
              <i class="material-icons icon-sidebar"> Ds </i>
                <span class="sidebar-normal">{{ __('Discharges') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
              <i class="material-icons icon-sidebar"> UM </i>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li>
            @endif
           
    </ul>
  </div>
</div>
