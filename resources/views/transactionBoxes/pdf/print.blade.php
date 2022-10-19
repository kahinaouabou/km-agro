<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{__('Transaction boxes')}}</title>

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
    
    <h1 style=' width: 500px; margin-left : 180px; margin-bottom :50px; display:inline-block' >{{__('Transaction boxes')}}</h1>
    
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
  $countTakenBoxes =0;
  $countReturnedBoxes =0;
   ?>
  <table width="100%" class='main-table'>
    <thead style="background-color: lightgray;">
                    <tr>
                      <th>
                        {{ __('Reference').' '.__('Bill')}}
                      </th>
                      <th>
                        {{ __('Date')}}
                      </th>
                      @if(empty($thirdParty->id))
                        <th>
                        {{__('Customer')}} 
                        </th>
                      @endif
                      <th>
                      {{__('Nb boxes taken')}} 
                      </th>
                      <th>
                      {{__('Nb boxes returned')}} 
                      </th>
                    </tr>
    </thead>
    <tbody>
                  @foreach($transactionBoxes as $transactionBox)
                  <?php 
                  $countTakenBoxes =  $countTakenBoxes + $transactionBox->number_boxes_taken;
                  $countReturnedBoxes = $countReturnedBoxes + $transactionBox->number_boxes_returned;
                   ?>
                  <tr>
                        <td>
                        @if(!empty($transactionBox->bill->reference))
                        {{  $transactionBox->bill->reference }}
                        @endif
                        </td>
                        <td>
                        {{  $transactionBox->transaction_date->format('d/m/Y') }}
                        </td>
                        @if(empty($thirdParty->id))
                          <td>
                          {{ $transactionBox->thirdParty->name }}
                          </td>
                        @endif
                        <td>
                        {{ $transactionBox->number_boxes_taken }}
                        </td>
                        <td>
                        {{ $transactionBox->number_boxes_returned }}
                        </td>
                      </tr>
					        @endforeach
					      </tbody>
 
  </table>
  <div style="height: 50px; "></div>
  <table width="100%" >
    
    <tr style ="height:20px; ">
        <td style='  width:260px; height:10px!important; padding:0; margin:0;'><p style="font-size:16px ;"><strong >{{__('Number boxes taken')}} :</strong></p></td><td><p> {{number_format($countTakenBoxes, 0, ',', ' ');}}</p></td>
        
    </tr>
    <tr style ="height:20px;">
        <td ><p style="font-size:16px"><strong >{{__('Number boxes returned')}} :</strong> </p></td><td><p>{{number_format($countReturnedBoxes, 0, ',', ' ');}}</p></td>
        
    </tr>
  </table>
  </body>
  <footer>
    </footer>

</html>