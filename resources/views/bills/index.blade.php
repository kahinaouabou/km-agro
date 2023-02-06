@extends('layouts.app', ['activePage' => $page['active'], 'titlePage' => __($page['title'])])

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
        @include('bills.search')
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">{{__($page['titleCard'])}}</h4>
            <p class="card-category"> {{__('Here you can manage').' '.__($page['name'])}}</p>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-12 text-right">
                @switch($type)
                @case (\App\Enums\BillTypeEnum::ExitBill)

                <button type="button" data-toggle="modal" data-target="#associatePayments" class="btn btn-sm btn-primary" id="associatePaymentButton">{{__('Associate payment')}}</button>

                <button type="button" data-toggle="modal" data-target="#addPayments" class="btn btn-sm btn-primary" id="addPaymentButton">{{__('Payment')}}</button>

                <div class="dropdown" style="display: inline-block;">
                  <button style="padding: 6px 20px !important" class="btn  btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{__('Print')}}
                  </button>
                  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <div style="text-align: center;display: block;">
                      <a target="_blanck" id='print-situation' href="{{ route('bills.printSituation', $selected_id) }}">{{__('Print global')}}</a>
                    </div>
                    <div style="text-align: center;display: block;">
                      <a target="_blanck" id='print-detail-situation' href="{{ route('bills.printDetailedSituation', $selected_id) }}">{{__('Print detail')}}</a>
                    </div>
                  </div>
                </div>
                @break
                @case (\App\Enums\BillTypeEnum::DeliveryBill)
                <a target="_blanck" id='print-situation' href="{{ route('bills.printDeliveryBill', $selected_id) }}" class="btn btn-sm btn-primary">{{__('Print PDF')}}</a>

                @break
                @case (\App\Enums\BillTypeEnum::SubcontractingBill)
                <button type="button" data-toggle="modal" data-target="#associatePayments" class="btn btn-sm btn-primary" id="associatePaymentButton">{{__('Associate payment')}}</button>

                <button type="button" data-toggle="modal" data-target="#addPayments" class="btn btn-sm btn-primary" id="addPaymentButton">{{__('Payment')}}</button>

                @break
                @endswitch
                <a href="{{ route('bills.create',$type) }}" class="btn btn-sm btn-primary">{{ __($page['title'])}}</a>

              </div>
            </div>
            <div class="table-responsive">
              @switch($type)
              @case (\App\Enums\BillTypeEnum::EntryBill)
              @include('bills.indexEntryBill')
              @break
              @case (\App\Enums\BillTypeEnum::ExitBill)
              @include('bills.indexExitBill')
              @break
              @case (\App\Enums\BillTypeEnum::WeighBill)
              @include('bills.indexWeighBill')
              @break
              @case (\App\Enums\BillTypeEnum::DamageBill)
              @include('bills.indexDamageBill')
              @break
              @case (\App\Enums\BillTypeEnum::DeliveryBill)
              @include('bills.indexDeliveryBill')
              @break
              @case (\App\Enums\BillTypeEnum::SubcontractingBill)
              @include('bills.indexSubcontractingBill')
              @break
              @case (\App\Enums\BillTypeEnum::OrderBill)
              @include('bills.indexOrderBill')
              @break
              @endswitch

            </div>
          </div>

        </div>
        @switch($type)
        @case ( \App\Enums\BillTypeEnum::ExitBill)
        @case ( \App\Enums\BillTypeEnum::SubcontractingBill)
        <div class="card-header card-header-primary card-footer-primary">
          <h4 class="card-title ">{{__('Total net payable')}} : <strong id="total-net-payable"></strong><strong> DA</strong></h4>
          <h4 class="card-title ">{{__('Total net paid')}} : <strong id="total-net-paid"></strong><strong> DA</strong></h4>
          <h4 class="card-title ">{{__('Total net remaining')}} : <strong id="total-net-remaining"></strong><strong> DA</strong></h4>
        </div>
        @break
        @case ( \App\Enums\BillTypeEnum::WeighBill)
        <div class="card-header card-header-primary card-footer-primary">
          <h4 class="card-title">{{__('Total quantity removed')}} : <strong id="total-net"></strong><strong> Kg</strong></h4>
          {!! Form::number('total_net', 0, [
          'id'=>'input-total-net'
          ]) !!}

          <label class="col-sm-2 col-form-label">{{ __('Unit price') }}</label>
          {!! Form::number('unit_price', null, [
          'step' => '0.01',
          'id' =>'input-unit-price',
          'onchange'=>'calculateNetPayable(this.value)'
          ]) !!}


          {!! Form::number('total_net_payable', 0, [
          'id'=>'input-total-net-payable'
          ]) !!}
          <h4 class="card-title">{{__('Total net payable')}} : <strong id="total-net-payable"></strong><strong> DA</strong></h4>
        </div>
        @break
        @case ( \App\Enums\BillTypeEnum::DamageBill)
        <div class="card-header card-header-primary card-footer-primary">
          <h4 class="card-title">{{__('Total quantity removed')}} : <strong id="total-net"></strong><strong> Kg</strong></h4>



        </div>
        @break
        @case ( \App\Enums\BillTypeEnum::DeliveryBill)
        <div class="card-header card-header-primary card-footer-primary">
          <h4 class="card-title">{{__('Total quantity')}} : <strong id="total-net"></strong><strong> Kg</strong></h4>
          <h4 class="card-title">{{__('Total boxes')}} : <strong id="total-boxes"></strong><strong></strong></h4>



        </div>
        @break
        @endswitch

      </div>
    </div>
  </div>
</div>
@endsection