<h2 style=' width: 500px; margin-left : 170px; 
margin-bottom :50px; display:inline-block' >{{__('Exit bill with payment')}} <br> <span style='margin-left:75px'> N°: {{$bill->reference}}</span></h2>
    
    <div style ="width:700px" >
        <table >
            <tr>
                <td style=" font-weight:bold; font-size:18px">{{__('Date')}}: </td>
                <td style=" font-size:16px">
                    {{$bill->bill_date->format('d/m/Y')}}</td>
                <td style=" width:350px;text-align:right;
                display: block; position: relative; top:0px; font-weight:bold; font-size:20px">{{__('Customer')}} :  </span>
                </td>
                <td style=" width:200px ; font-size:18px; 
                 position: relative;"> {{$bill->thirdParty->name}} 
                </td>
            </tr>
            
        </table>
    
    </div>
    <br><br><br><br>
    <table width="100%" class='bill-table'>
    <thead style="background-color: lightgray;">
        <tr>
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
                <td align="right" width="100px">{{$bill->product->name}}</td>
                <td align="right" width="120px">{{number_format($bill->net, 0, ',', ' ')}}</td>
                <td align="right" width="120px">{{number_format($bill->unit_price, 2, ',', ' ')}}</td>
                <td align="right" width="160px">{{number_format($bill->net_payable, 2, ',', ' ')}}</td>
            </tr>
        
     
    </tbody>
    
 
  </table>
  <br><br><br><br><br><br>
@if(!empty($billPayments[0]))
    <table width="100%" class='payment-table'>
    <thead style="background-color: lightgray;">
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