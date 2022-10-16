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
      <li class="nav-item {{ ($activePage == 'profile' || $activePage == 'user-management') ? ' active' : '' }}">
        <a class="nav-link" data-toggle="collapse" href="#laravelExample" aria-expanded="true">
          <i><img style="width:25px" src="{{ asset('material') }}/img/laravel.svg"></i>
          <p>{{ __('Blocks / Rooms') }}
            <b class="caret"></b>
          </p>
        </a>
        <div class="collapse show" id="laravelExample">
          <ul class="nav">
          <li class="nav-item{{ $activePage == 'warehouse' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('warehouses.index') }}">
                <span class="sidebar-mini"> Et </span>
                <span class="sidebar-normal">{{ __('Warehouses') }} </span>
              </a>
            </li>
          <li class="nav-item{{ $activePage == 'block' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('blocks.index') }}">
                <span class="sidebar-mini"> Bk </span>
                <span class="sidebar-normal">{{ __('Blocks') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'room' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('rooms.index') }}">
                <span class="sidebar-mini"> Rm </span>
                <span class="sidebar-normal">{{ __('Rooms') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'product' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('products.index') }}">
                <span class="sidebar-mini"> Pt </span>
                <span class="sidebar-normal">{{ __('Products') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'thirdParty/0' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('thirdParties', ['isSupplier'=>0]) }}">
                <span class="sidebar-mini"> Cr </span>
                <span class="sidebar-normal">{{ __('Customers') }} </span>
              </a>
            </li>
   
            <li class="nav-item{{ $activePage == 'thirdParty/1' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('thirdParties' , $isSupplier = 1) }}">
                <span class="sidebar-mini"> Sr </span>
                <span class="sidebar-normal">{{ __('Suppliers') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'parcel' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('parcels.index') }}">
                <span class="sidebar-mini"> Pl </span>
                <span class="sidebar-normal">{{ __('Parcels') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'parcelCategory' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('parcelCategories.index') }}">
                <span class="sidebar-mini"> Pc </span>
                <span class="sidebar-normal">{{ __('Parcel categories') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'mark' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('marks.index') }}">
                <span class="sidebar-mini"> Mk </span>
                <span class="sidebar-normal">{{ __('Marks') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'truck' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('trucks.index') }}">
                <span class="sidebar-mini"> Tk </span>
                <span class="sidebar-normal">{{ __('Trucks') }} </span>
              </a>
            </li>
    
            <li class="nav-item{{ $activePage == 'bill/1' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('bills' , $type = \App\Enums\BillTypeEnum::EntryBill) }}">
                <span class="sidebar-mini"> Be </span>
                <span class="sidebar-normal">{{ __('Entry bill') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'bill/2' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('bills' , $type = \App\Enums\BillTypeEnum::ExitBill) }}">
                <span class="sidebar-mini"> Bs </span>
                <span class="sidebar-normal">{{ __('Weigh bill for payment') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'bill/3' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('bills' , $type = \App\Enums\BillTypeEnum::WeighBill ) }}">
                <span class="sidebar-mini"> Bp </span>
                <span class="sidebar-normal">{{ __('Weigh bill') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'transactionBox' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('transactionBoxes.index') }}">
                <span class="sidebar-mini"> Tb </span>
                <span class="sidebar-normal">{{ __('Transaction boxes') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'payment' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('payments.index') }}">
                <span class="sidebar-mini"> Pt </span>
                <span class="sidebar-normal">{{ __('Payments') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'company' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('companies.edit', \App\Models\Company::first()) }}">
                <span class="sidebar-mini"> Cy </span>
                <span class="sidebar-normal">{{ __('Company') }} </span>
              </a>
            </li>
              <li class="nav-item{{ $activePage == 'profile' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('profile.edit') }}">
                <span class="sidebar-mini"> UP </span>
                <span class="sidebar-normal">{{ __('User profile') }} </span>
              </a>
            </li>
            <li class="nav-item{{ $activePage == 'user-management' ? ' active' : '' }}">
              <a class="nav-link" href="{{ route('user.index') }}">
                <span class="sidebar-mini"> UM </span>
                <span class="sidebar-normal"> {{ __('User Management') }} </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
      <li class="nav-item{{ $activePage == 'table' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('table') }}">
          <i class="material-icons">content_paste</i>
            <p>{{ __('Table List') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'typography' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('typography') }}">
          <i class="material-icons">library_books</i>
            <p>{{ __('Typography') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'icons' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('icons') }}">
          <i class="material-icons">bubble_chart</i>
          <p>{{ __('Icons') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'map' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('map') }}">
          <i class="material-icons">location_ons</i>
            <p>{{ __('Maps') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'notifications' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('notifications') }}">
          <i class="material-icons">notifications</i>
          <p>{{ __('Notifications') }}</p>
        </a>
      </li>
      <li class="nav-item{{ $activePage == 'language' ? ' active' : '' }}">
        <a class="nav-link" href="{{ route('language') }}">
          <i class="material-icons">language</i>
          <p>{{ __('RTL Support') }}</p>
        </a>
      </li>  
    </ul>
  </div>
</div>
