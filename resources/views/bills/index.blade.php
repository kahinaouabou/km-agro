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
                  @if($type==\App\Enums\BillTypeEnum::ExitBill)
                  <button type="button" data-toggle="modal" data-target="#addPayments" class="btn btn-sm btn-primary" id="addPaymentButton">{{__('Payment')}}</button>
                  @endif
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
              @endswitch
               
              </div>
            </div>
          
          </div>
          @if ( $type == \App\Enums\BillTypeEnum::ExitBill)
              <div class="card-header card-header-primary card-footer-primary">
                <h4 class="card-title ">{{__('Total net payable')}} : <strong id="total-net-payable"></strong></h4>
                <h4 class="card-title ">{{__('Total net remaining')}} : <strong id="total-net-remaining"></strong></h4>
              </div> 
            @endif
         
      </div>
    </div>
  </div>
</div>
@endsection
