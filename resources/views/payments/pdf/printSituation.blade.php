<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{__('Payments situation')}}</title>

<style type="text/css">
     @page{
        margin-top: 290px;
        margin-bottom:130px;
      }
      header{
        position: fixed;
        left: 0px;
        right: 0px;
        height: 290px;
        margin-top: -290px; 
      }
      footer{
        position: fixed;
        left: 0px;
        right: 0px;
        height: 60px;
        margin-bottom: -60px;
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

<header>
 <div style='width:100%; height:180px; border-bottom: 1px solid; padding-top:40px; padding-bottom:30px' >
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
 <div style='width:100%; height:40px; border-top: 1px solid;' ></div>
</header>  

<body>
  <h1 style=' width: 500px; margin-left : 200px; margin-bottom :40px; display:inline-block' >{{__('Payments Situation')}}</h1>
    
  <div style ="width:700px" >
      <table >
          <tr>
              <td></td>
              <td ></td>
              @if(!empty($thirdParty->name))
              <td style=" width:350px;text-align:right;
              display: block; position: relative; top:0px; font-weight:bold; font-size:20px">{{__('Customer')}} :  </span>
              </td>
              <td style=" width:200px ; font-size:18px; 
               position: relative;"> {{$thirdParty->name}} 
              </td>
              @endif
          </tr>
          
      </table>
  
  </div>
  <div style="width: 600px; margin-left : 380px; margin-bottom :20px">
       </div>

<br/>

<?php 
$countReceipts =0;
$countDisbursements =0;
 ?>
<table width="100%" class='main-table'>
  <thead style="background-color: lightgray;">
                  <tr>
                   
                    <th>  
                      {{ __('Reference')}}
                  </th>
                  <th>
                      {{__('Date')}} 
                  </th>
                
                  @if(empty($thirdParty->id))
                      <th >
                      {{__('Customer')}} 
                      </th>
                    @endif 
                    <th>
                      {{__('Type')}} 
                  </th> 
                  <th>
                      {{__('Amount')}} 
                  </th>

                    </th>
                  </tr>
  </thead>
  <tbody>
                @foreach($payments as $payment)
                <?php 
                if($payment->payment_type==0){
                    $countReceipts = $countReceipts+ $payment->amount;
                }else {
                    $countDisbursements = $countDisbursements + $payment->amount;
                }
               
                 ?>
                <tr>
                      <td>
                      {{  $payment->reference }}
                      </td>
                      <td>
                      {{  Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y')}}
                      </td>
                      @if(empty($thirdParty->id))
                        <td>
                        {{ $payment->thirdPartyName }}
                        </td>
                      @endif
                      <td>
                        @if($payment->payment_type == 0)
                      {{ __('Receipt')}}
                      @else
                      {{ __('Disbursement')}}
                      @endif 
                      </td>
                      <td>
                      {{ number_format($payment->amount, 2, ',', ' ') }}
                      </td>
                    </tr>
                @endforeach
              </tbody>

</table>
<p style="font-size:16px"><strong >{{__('Total ').__('Receipt')}} :</strong> {{number_format($countReceipts, 2, ',', ' ');}}</p>
<p style="font-size:16px"><strong >{{__('Total ').__('Disbursement')}} :</strong> {{number_format($countDisbursements, 2, ',', ' ');}}</p>

  </body>
  <footer>
    </footer>

</html>