<div style="width: 500px; margin-left : 180px; margin-bottom :100px; margin-top:50px">
    <h1 >{{__($page['name'])}} N°: {{$bill->reference}}</h1>
    </div>
    <div style ="width:700px" >
        <table >
            <tr>
                <td style=" font-weight:bold; font-size:22px">{{__('Date')}}: </td>
                <td style=" font-size:20px">
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
        <td><p style="font-size:18px"><strong >{{__('Product')}} :</strong> {{$bill->product->name}}</p></td>
        <td><p style="font-size:18px"><strong >{{__('Registration')}} :</strong>{{$bill->truck->registration}}</p> </td>
    </tr>
  </table>
  <br/>


<br/> <br/> <br/>
<table width="100%" class='main-table'>
    <thead style="background-color: lightgray;">
      <tr>
      <th>
                    {{__('Nb boxes')}} 
                    </th>
                    <th>
                    {{__('Weight').'  '.__('Raw').'  '.__('(Kg)')}} 
                    </th>
                    <th>
                    {{__('Weight').'  '.__('Tare').'  '.__('(Kg)')}} 
                    </th>
                    <th>
                    {{__('Weight').'  '.__('Net').'  '.__('(Kg)')}} 
      </tr>
    </thead>
    <tbody>
       
            <tr>
                <td align="right" width="100px">{{number_format($bill->number_boxes, 0, ',', ' ')}}</td>
                <td align="right" width="120px">{{number_format($bill->raw, 0, ',', ' ')}}</td>
                <td align="right" width="120px">{{number_format($bill->tare, 0, ',', ' ')}}</td>
                <td align="right" width="160px">{{number_format($bill->net, 0, ',', ' ')}}</td>
            </tr>
        
     
    </tbody>

 
  </table>