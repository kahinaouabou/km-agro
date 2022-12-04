<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Décharge</title>

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
    <h1 style=' width: 500px; margin-left : 250px; margin-bottom :50px; display:inline-block' >{{__('Décharge')}} </h1>
    
    
    <div style ="width:700px" >
      <p style="margin-left: 50px; margin-right: 50px; line-height:2.5">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Je soussigné <strong>Mr {{$discharge->name}} </strong>
        le représentant de FRIGOMEDIT  d'avoir pris 
        le 
        <strong>{{Carbon\Carbon::parse($discharge->discharge_date)->format('d/m/Y')}} 

        </strong> 
        la somme de 
        <strong>{{number_format($discharge->amount, 2, ',', ' ')}} DA </strong> 
        
        de la part de <strong>Mr Haouchine Malek </strong>pour le paiement d'une quantité 
        de <strong>{{number_format($discharge->quantity, 0, ',', ' ')}} Kg </strong>de pomme de terre de consommation stockées au niveau de <strong>l'entrepot HAOUCHINE </strong> </p>
    
    </div>
  

  </body>
  <footer>
    </footer>

</html>