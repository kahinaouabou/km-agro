<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{$paymentName}}</title>

<style type="text/css">
     @page{
        margin-top: 220px;
        margin-bottom:130px;
      }
      header{
        position: fixed;
        left: 0px;
        right: 0px;
        height: 220px;
        margin-top: -220px; 
      }
      footer{
        position: fixed;
        left: 0px;
        right: 0px;
        height: 70px;
        margin-bottom: -70px;
      }
    * {
        font-family: Verdana, Arial, sans-serif;
    }
    tfoot tr td{
        font-weight: bold;
    }
    .gray {
        background-color: lightgray
    }
    .main-table {
            border: 1px solid black;
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .main-table > thead > tr > th, 
        .main-table > tbody > tr > th, 
        .main-table > tfoot > tr > th, 
        .main-table > thead > tr > td, 
        .main-table > tbody > tr > td, 
        .main-table > tfoot > tr > td {
            border: 1px solid #000;
        }

        .main-table th {
            border: 1px solid black;
            padding: 10px 5px 15px 5px;
            text-align: center;
            font-size: 14px
        }

        .main-table td {
            text-align: center;
            padding: 3px 5px;
            font-size: 12px;
            padding: 10px 5px ;
        }
</style>

</head>
<body>
<header>
 <div style='width:100%; height:190px; border-bottom: 1px solid;' >
  <table width="100%" height="100px">
    <tr>
        <td valign="top" width="300px"></td>
        
       <td align="left">
            <h1>{{$company->name}} </h1>
            <p>{{$company->address}}</p>
            <p>Email: {{$company->email}}</p> 
            @if(!empty($company->fax))  
            <p>Tel: {{$company->phone}} / Fax: {{$company->fax}}</p>
            @else 
            <p>Tel: {{$company->phone}} </p>
            @endif
            
        </td>
    </tr>

  </table>
 </div>
 <div style='width:100%; height:30px; border-top: 1px solid;' ></div>
</header>  
<body>
    
    <div style="width: 500px; margin-left : 180px; margin-bottom :50px">
    <h1 >{{__('Payment receipt')}} :  {{$payment->reference}}</h1>
    </div>
    <div style ="width:700px" >
        <table >
            <tr>
                <td style=" font-weight:bold; font-size:18px">{{__('Date')}}: </td>
                <td style=" font-size:16px">
                    {{$payment->payment_date->format('d/m/Y')}}</td>
                <td style=" width:350px;text-align:right;
                display: block; position: relative; top:0px; font-weight:bold; font-size:20px">{{__('Customer')}} :  </span>
                </td>
                <td style=" width:200px ; font-size:18px; 
                 position: relative;"> {{$payment->thirdParty->name}} 
                </td>
            </tr>
            
        </table>
    
    </div>
    <div style="width: 600px; margin-left : 380px; margin-bottom :20px">
         </div>
  <table width="100%">
    <tr>
        <td><p style="font-size:16px"><strong >{{__('Total amount paid')}} :</strong> {{number_format($payment->amount, 2, ',', ' ');}}</p></td>
        
    </tr>
  </table>
  <br/>
  <table width="100%" class='main-table'>
    <thead style="background-color: lightgray;">
    <tr>
                      <th>
                       {{ __('Reference')}}
                      </th>
                      <th>
                        {{__('Date')}} 
                      </th>
                      <th>
                        {{__('Net')}} 
                      </th>
                      <th>
                        {{__('Unit price')}} 
                      </th>
                      <th>
                        {{__('Net payable')}} 
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
    @foreach($paymentBills as $paymentBill)
    <?php $netRemaining = $paymentBill->bill->net_payable- $paymentBill->amount_paid ?>
                          <tr>
                              <td>
                                  {{ $paymentBill->bill->reference }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->bill_date->format('d/m/Y') }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->net }}
                              </td>
                              <td>
                                  {{number_format( $paymentBill->bill->unit_price, 2, ',', ' ') }}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->bill->net_payable, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->amount_paid, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($netRemaining, 2, ',', ' ')}}
                              </td>
                          </tr>
                      @endforeach
                      @foreach($paymentBills as $paymentBill)
    <?php $netRemaining = $paymentBill->bill->net_payable- $paymentBill->amount_paid ?>
                          <tr>
                              <td>
                                  {{ $paymentBill->bill->reference }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->bill_date->format('d/m/Y') }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->net }}
                              </td>
                              <td>
                                  {{number_format( $paymentBill->bill->unit_price, 2, ',', ' ') }}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->bill->net_payable, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->amount_paid, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($netRemaining, 2, ',', ' ')}}
                              </td>
                          </tr>
                      @endforeach
                      @foreach($paymentBills as $paymentBill)
    <?php $netRemaining = $paymentBill->bill->net_payable- $paymentBill->amount_paid ?>
                          <tr>
                              <td>
                                  {{ $paymentBill->bill->reference }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->bill_date->format('d/m/Y') }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->net }}
                              </td>
                              <td>
                                  {{number_format( $paymentBill->bill->unit_price, 2, ',', ' ') }}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->bill->net_payable, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->amount_paid, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($netRemaining, 2, ',', ' ')}}
                              </td>
                          </tr>
                      @endforeach
                      @foreach($paymentBills as $paymentBill)
    <?php $netRemaining = $paymentBill->bill->net_payable- $paymentBill->amount_paid ?>
                          <tr>
                              <td>
                                  {{ $paymentBill->bill->reference }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->bill_date->format('d/m/Y') }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->net }}
                              </td>
                              <td>
                                  {{number_format( $paymentBill->bill->unit_price, 2, ',', ' ') }}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->bill->net_payable, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->amount_paid, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($netRemaining, 2, ',', ' ')}}
                              </td>
                          </tr>
                      @endforeach
                      @foreach($paymentBills as $paymentBill)
    <?php $netRemaining = $paymentBill->bill->net_payable- $paymentBill->amount_paid ?>
                          <tr>
                              <td>
                                  {{ $paymentBill->bill->reference }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->bill_date->format('d/m/Y') }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->net }}
                              </td>
                              <td>
                                  {{number_format( $paymentBill->bill->unit_price, 2, ',', ' ') }}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->bill->net_payable, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->amount_paid, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($netRemaining, 2, ',', ' ')}}
                              </td>
                          </tr>
                      @endforeach
                      @foreach($paymentBills as $paymentBill)
    <?php $netRemaining = $paymentBill->bill->net_payable- $paymentBill->amount_paid ?>
                          <tr>
                              <td>
                                  {{ $paymentBill->bill->reference }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->bill_date->format('d/m/Y') }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->net }}
                              </td>
                              <td>
                                  {{number_format( $paymentBill->bill->unit_price, 2, ',', ' ') }}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->bill->net_payable, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->amount_paid, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($netRemaining, 2, ',', ' ')}}
                              </td>
                          </tr>
                      @endforeach
                      @foreach($paymentBills as $paymentBill)
    <?php $netRemaining = $paymentBill->bill->net_payable- $paymentBill->amount_paid ?>
                          <tr>
                              <td>
                                  {{ $paymentBill->bill->reference }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->bill_date->format('d/m/Y') }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->net }}
                              </td>
                              <td>
                                  {{number_format( $paymentBill->bill->unit_price, 2, ',', ' ') }}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->bill->net_payable, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->amount_paid, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($netRemaining, 2, ',', ' ')}}
                              </td>
                          </tr>
                      @endforeach
                      @foreach($paymentBills as $paymentBill)
                        <?php $netRemaining = $paymentBill->bill->net_payable- $paymentBill->amount_paid ?>
                          <tr>
                              <td>
                                  {{ $paymentBill->bill->reference }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->bill_date->format('d/m/Y') }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->net }}
                              </td>
                              <td>
                                  {{number_format( $paymentBill->bill->unit_price, 2, ',', ' ') }}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->bill->net_payable, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->amount_paid, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($netRemaining, 2, ',', ' ')}}
                              </td>
                          </tr>
                      @endforeach
                      @foreach($paymentBills as $paymentBill)
                        <?php $netRemaining = $paymentBill->bill->net_payable- $paymentBill->amount_paid ?>
                          <tr>
                              <td>
                                  {{ $paymentBill->bill->reference }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->bill_date->format('d/m/Y') }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->net }}
                              </td>
                              <td>
                                  {{number_format( $paymentBill->bill->unit_price, 2, ',', ' ') }}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->bill->net_payable, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->amount_paid, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($netRemaining, 2, ',', ' ')}}
                              </td>
                          </tr>
                      @endforeach
                      @foreach($paymentBills as $paymentBill)
                        <?php $netRemaining = $paymentBill->bill->net_payable- $paymentBill->amount_paid ?>
                          <tr>
                              <td>
                                  {{ $paymentBill->bill->reference }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->bill_date->format('d/m/Y') }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->net }}
                              </td>
                              <td>
                                  {{number_format( $paymentBill->bill->unit_price, 2, ',', ' ') }}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->bill->net_payable, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->amount_paid, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($netRemaining, 2, ',', ' ')}}
                              </td>
                          </tr>
                      @endforeach
                      @foreach($paymentBills as $paymentBill)
                        <?php $netRemaining = $paymentBill->bill->net_payable- $paymentBill->amount_paid ?>
                          <tr>
                              <td>
                                  {{ $paymentBill->bill->reference }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->bill_date->format('d/m/Y') }}
                              </td>
                              <td>
                                  {{ $paymentBill->bill->net }}
                              </td>
                              <td>
                                  {{number_format( $paymentBill->bill->unit_price, 2, ',', ' ') }}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->bill->net_payable, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($paymentBill->amount_paid, 2, ',', ' ')}}
                              </td>
                              <td>
                                  {{ number_format($netRemaining, 2, ',', ' ')}}
                              </td>
                          </tr>
                      @endforeach
     
    </tbody>

 
  </table>
  </body>
  <footer>
    </footer>
</body>
</html>