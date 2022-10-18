@extends('layouts.app', ['activePage' => 'payment', 'titlePage' => __('Add parcel')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          

            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Payment') }}</h4>
                <p class="card-category">{{ __('Payment information') }}</p>
              </div>
              <div class="card-body">
               <p><strong>{{__('Reference')}}  : </strong>{{$payment->reference}}</p>
               <p><strong>{{__('Date')}} : </strong>{{$payment->payment_date->format('d/m/Y')}}</p>
               <p><strong>{{__('Third party')}} : </strong>{{$payment->thirdParty->name}}</p>
               <p><strong>{{__('Type')}} : </strong>{{$payment->payment_type}}</p>
               <p><strong>{{__('Amount')}} : </strong>{{number_format($payment->amount, 2, ',', ' ');}}</p>
               <p><strong>{{__('Amount remaining')}} : </strong>{{number_format($payment->amount_remaining, 2, ',', ' ');}}</p>
              </div>

              <div class="table-responsive">
                <table class="table">
                  <thead class=" text-primary">
                    <tr>
                      <th>
                       {{ __('Reference')}}
                      </th>
                      <th>
                        {{__('Date')}} 
                      </th>
                      <th>
                        {{__('Net payable')}} 
                      </th>
                      <th>
                        {{__('Amount paid')}} 
                      </th>
                      <th>
                        {{__('Amount remaining')}} 
                      </th>
                    </tr>
                    </thead>
                    <tbody>
                      @foreach($paymentBills as $paymentBill)
                          <tr>
                              <td>
                                  {{ $paymentBill->bill->reference }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->bill_date->format('d/m/Y') }}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->bill->net_payable, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->amount_paid, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->bill->net_remaining, 2, ',', ' ')}}
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
@endsection