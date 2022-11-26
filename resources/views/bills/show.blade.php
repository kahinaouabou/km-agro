@extends('layouts.app', ['activePage' => $page['active'], 'titlePage' => __($page['title'])])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          

            <div class="card">
              <div class="card-header card-header-primary">
              <h4 class="card-title ">{{__($page['titleCard'])}}</h4>
              <p class="card-category"> {{__('Here you can manage').' '.__($page['name'])}}</p>
              </div>
              <div class="card-body">
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
                    {{__('Product')}} 
                    </th>
                    <th>
                    {{__('Net')}} 
                    </th>
                    <th>
                    {{__('Unit price')}} 
                    </th>
                    <th>
                    {{__('Net payable')}} 
        </tr>
    </thead>
    <tbody>
       
            <tr>
            <td align="center" width="100px">{{ $bill->reference }}</td>
            <td align="center" width="100px">{{ $bill->bill_date->format('d/m/Y') }}</td>
                <td align="center" width="100px">{{$bill->product->name}}</td>
                <td align="center" width="120px">{{number_format($bill->net, 0, ',', ' ')}}</td>
                <td align="center" width="120px">{{number_format($bill->unit_price, 2, ',', ' ')}}</td>
                <td align="center" width="160px">{{number_format($bill->net_payable, 2, ',', ' ')}}</td>
            </tr>
        
     
    </tbody>
    
 
  </table>
              </div>

              <div class="table-responsive">
              @if(!empty($billPayments[0]))
                <table class="table">
                  <thead class=" text-primary">
    <tr>
        <th colspan="4">
        {{ __('Payment list')}}
        </th>
    </tr>
    <tr>
                      <th>
                       {{ __('Reference')}}
                      </th>
                      <th>
                        {{__('Date')}} 
                      </th>
                      <th>
                        {{__('Amount paid')}} 
                      </th>
                      <th>
                        {{__('Net remaining')}} 
                      </th>
                    </tr>
    </thead>
    <tbody>
    <?php 
    $totalNetRemaining = 0;
    $totalAmountPaid = 0;
    ?>   
    @foreach($billPayments as $billPayment)
    <?php 
    $totalAmountPaid = $totalAmountPaid + $billPayment->amount_paid;
    $netRemaining = $billPayment->bill->net_payable- $totalAmountPaid ;
    ?>
                          <tr>
                              <td>
                                  {{ $billPayment->payment->reference }}
                              </td>
                              <td>
                                  {{ $billPayment->payment->payment_date->format('d/m/Y') }}
                              </td>
                             
                              <td>
                                  {{ number_format($billPayment->amount_paid, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($netRemaining, 2, ',', ' ')}}
                              </td>
                          </tr>
                      @endforeach
                        <?php 
                        $totalNetRemaining = $billPayment->bill->net_payable  - $totalAmountPaid;
                        ?>
                            <tr style ='border-bottom:none'>
                                <td colspan="3" style ='border-bottom:none'>{{__('Total net paid')}}</td>
                                <td style ='border-bottom:none'>{{number_format($totalAmountPaid, 2, ',', ' ');}}  DA</td>
                            </tr>
                            <tr>
                                <td colspan="3">{{__('Total net remaining')}}</td>
                                <td>{{number_format($totalNetRemaining, 2, ',', ' ');}}  DA</td>
                            </tr>
     
    </tbody>
 
  </table>
@endif
              </div>


              
            </div>
          
        </div>
      </div>
      
    </div>
  </div>
@endsection