@extends('layouts.app', ['activePage' => $page['active'], 'titlePage' => __($page['title'])])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">

        <form method="post" action="{{ route('bills.store') }}" autocomplete="off" class="form-horizontal">
          @csrf
          @method('post')
          <div class="card ">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{__($page['titleCard'])}}</h4>
              <p class="card-category"> {{__($page['name']).' '.__('information')}}</p>
            </div>
            @switch($type)
            @case (\App\Enums\BillTypeEnum::EntryBill)
            @include('bills.createEntryBill')
            @break
            @case (\App\Enums\BillTypeEnum::ExitBill)
            @case (\App\Enums\BillTypeEnum::WeighBill)
            @include('bills.createExitBill')
            @break
            @case (\App\Enums\BillTypeEnum::DamageBill)
            @include('bills.createDamageBill')
            @break
            @case (\App\Enums\BillTypeEnum::DeliveryBill)
            @include('bills.createDeliveryBill')
            @break
            @case (\App\Enums\BillTypeEnum::SubcontractingBill)
            @include('bills.createSubcontractingBill')
            @break
            @case (\App\Enums\BillTypeEnum::OrderBill)
            @include('bills.createOrderBill')
            @break
            @endswitch
            <div class="card-footer ml-auto mr-auto">
              <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
              <a class="btn btn-default btn-close" href="{{ route('bills' ,  $type) }}">{{ __('Cancel') }}</a>

            </div>
          </div>
        </form>
      </div>
    </div>

  </div>
</div>
@endsection
<script src="{{ asset('/js/jquery-3.4.1.min.js')}}"></script>

<script type="text/javascript" src="{{ URL::asset('js/functions.js') }}"></script>