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
    .main-table, .bill-table, .payment-table {
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
        .main-table > tfoot > tr > td,
        
        .bill-table > thead > tr > th, 
        .bill-table > tbody > tr > th, 
        .bill-table > tfoot > tr > th, 
        .bill-table > thead > tr > td, 
        .bill-table > tbody > tr > td, 
        .bill-table > tfoot > tr > td,

        .payment-table > thead > tr > th, 
        .payment-table > tbody > tr > th, 
        .payment-table > tfoot > tr > th, 
        .payment-table > thead > tr > td, 
        .payment-table > tbody > tr > td, 
        .payment-table > tfoot > tr > td

         {
            border: 1px solid #000;
        }

        .main-table th {
            border: 1px solid black;
            padding: 10px 5px 15px 5px;
            text-align: center;
            font-size: 18px
        }

        .main-table td {
            text-align: center;
            padding: 3px 5px;
            font-size: 16px;
            padding: 15px 5px 50px 5px;
        }

        .bill-table th, .payment-table th  {
            border: 1px solid black;
            padding:  5px ;
            text-align: center;
            font-size: 14px
        }

        .bill-table td, .payment-table td {
            text-align: center;
            padding:  5px;
            font-size: 12px;
            padding:  5px ;
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

            @switch($type)
                @case (\App\Enums\BillTypeEnum::EntryBill)
                  @include('bills.pdf.printEntryBill')
                @break
                @case (\App\Enums\BillTypeEnum::WeighBill)
                  @include('bills.pdf.printWeighBill')
                @break 
                @case (\App\Enums\BillTypeEnum::ExitBill)
                  @include('bills.pdf.printExitBill')
                @break 
            @endswitch


</body>
</html>