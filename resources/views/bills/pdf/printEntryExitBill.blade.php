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