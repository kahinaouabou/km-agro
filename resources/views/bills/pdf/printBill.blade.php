<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{$billName}}</title>

<style type="text/css">
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

        .main-table > thead > tr > th, .main-table > tbody > tr > th, .main-table > tfoot > tr > th, .main-table > thead > tr > td, .main-table > tbody > tr > td, .main-table > tfoot > tr > td {
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
            font-size: 14px;
            padding: 15px 5px 50px 5px;
        }
</style>

</head>
<body>

  <table width="100%">
    <tr>
       <td valign="top" width="300px"></td>
        
        <td align="left">
            <h1>{{$company->name}} </h1>
            <p>{{$company->address}}</p>
              
            <p>Email: {{$company->email}}</p> 
            @if(!empty($company->fax))  
            <p >Tel: {{$company->phone}} / Fax: {{$company->fax}}</p>
            @else 
            <p >Tel: {{$company->phone}} </p>
            @endif
            
        </td>
    </tr>

  </table>
<hr>
    <div style="width: 500px; margin-left : 180px; margin-bottom :100px; margin-top:50px">
    <h1 >{{__($page['name'])}} N°: {{$bill->reference}}</h1>
    </div>
    <div style ="width:700px" >
        <table >
            <tr>
                <td style=" font-weight:bold; font-size:18px">{{__('Date')}}: </td>
                <td style=" font-size:16px">
                    {{$bill->bill_date->format('d/m/Y')}}</td>
                <td style=" width:350px;text-align:right;
                display: block; position: relative; top:0px; font-weight:bold; font-size:20px"></span>
                </td>
                <td style=" width:200px ; font-size:18px; ">
                </td>
            </tr>
            
        </table>
    
    </div>
    <div style="width: 600px; margin-left : 380px; margin-bottom :50px">
         </div>
  <table width="100%">
    <tr>
        <td><p style="font-size:16px"><strong >{{__('Product')}} :</strong> {{$bill->product->name}}</p></td>
        <td><p style="font-size:16px"><strong >{{__('Registration')}} :</strong>{{$bill->truck->registration}}</p> </</td>
   
    </tr>
  </table>
  <br/>
            @switch($type)
                @case (\App\Enums\BillTypeEnum::EntryBill):
                @case (\App\Enums\BillTypeEnum::ExitBill)
                  @include('bills.pdf.printEntryExitBill')
                @break
                @case (\App\Enums\BillTypeEnum::WeighBill)
                  @include('bills.pdf.printWeighBill')
                @break 
            @endswitch


</body>
</html>