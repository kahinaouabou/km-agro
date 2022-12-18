<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{__('Bills situation')}}</title>

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
    


<h1 style=' width: 500px; margin-left : 200px; margin-bottom :50px; display:inline-block' >{{__('Information delivery bill')}}</h1>

<div style="width: 600px; margin-left : 380px; margin-bottom :20px">
         </div>
 
  <br/>
  <?php 
  $countNbBoxes =0;
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
                    <th>
                        {{__('Subcontractor')}} 
                        </th>
                        <th>
                        {{__('Driver')}} 
                        </th>
                        <th>
                        {{__('Phone')}} 
                        </th>
                      <th>
                        {{__('Registration')}} 
                    </th> 
                    <th>
                        {{__('Nb boxes')}} 
                    </th> 
                    
                    </tr>
    </thead>
    <tbody>
                  @foreach($bills as $bill)
                  <?php 
                  $countNbBoxes =  $countNbBoxes + $bill->number_boxes;
                   ?>
                  <tr>
                        <td>
                        {{  $bill->reference }}
                        </td>
                        <td>
                        {{  Carbon\Carbon::parse($bill->bill_date)->format('d/m/Y')}}
                        </td>
                          <td>
                          {{ $bill->thirdPartyName }}
                          </td>
                          <td>
                          {{ $bill->driverName }}
                          </td>
                          <td>
                          {{ $bill->driverPhone }}
                          </td>
                          <td>
                          {{ $bill->truckName }}
                          </td>
                    
                        <td>
                        {{ number_format($bill->number_boxes, 0, ',', ' ') }}
                        </td>
                      </tr>
					        @endforeach
					      </tbody>
 
  </table>
  <table width="100%" >
    
    <tr style ="height:10px; ">
        <td style='  width:300px; height:10px!important; padding:0; margin:0;'><p style="font-size:16px ;"><strong >{{__('Total ').__('Nb boxes')}} :</strong></p></td><td><p> {{number_format($countNbBoxes, 0, ',', ' ');}}</p></td>
        
    </tr>
  
  </table>

</body>

<footer>
</footer>

</html>