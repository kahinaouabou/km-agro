<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>{{__('Rooms')}}</title>

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
    
    <h1 style=' width: 500px; margin-left : 180px; margin-bottom :50px; display:inline-block' >{{__('Rooms')}}</h1>
    

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
                    <tr>
                    <th>
                    {{__('Blocks')}} 
                    </th>
                    <th>
                    {{__('Name')}} 
                    </th>
                    <th>
                    {{__('Stored quantity')}} 
                    </th>
                    <th>
                    {{__('Unstocked quantity')}} 
                    </th>
                    <th>
                    {{__('Damaged quantity')}} 
                    </th>
                    <th>
                    {{__('Weightloss')}} 
                    </th>
                    <th>
                    {{__('Loss')}} 
                    </th>
                    <th>
                    {{__('Loss'). ' %'}} 
                    </th>
                    
                  </tr>
                    </tr>
    </thead>
    <tbody>
    @foreach($rooms as $room)
               
               <tr>
                    <td>
                   {{ $room->block->name }}

                   </td>
                   <td>
                   {{ $room->name }}
                   </td>
                  
                   <td>
                   {{ $room->stored_quantity }}
                   </td>
                   <td>
                   {{ $room->unstocked_quantity }}
                   </td>
                   <td>
                   {{ $room->damaged_quantity }}
                   </td>
                   <td>
                   {{ $room->weightloss_value }}
                   </td>
                   <td>
                   {{ $room->loss_value }}
                   </td>
                   <td>
                   {{ $room->loss_percentage }}
                   </td>
                  
                
                 </tr>
                  @endforeach
					      </tbody>
 
  </table>
 


  </body>
  <footer>
    </footer>

</html>