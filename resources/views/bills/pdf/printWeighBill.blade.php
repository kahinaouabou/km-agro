<table width="100%" class='main-table'>
    <thead style="background-color: lightgray;">
      <tr>
      <th>
                    {{__('Number boxes')}} 
                    </th>
                    <th>
                    {{__('Raw')}} 
                    </th>
                    <th>
                    {{__('Tare')}} 
                    </th>
                    <th>
                    {{__('Net')}} 
      </tr>
    </thead>
    <tbody>
       
            <tr>
                <td align="right">{{$bill->number_boxes}}</td>
                <td align="right">{{$bill->raw}}</td>
                <td align="right">{{$bill->tare}}</td>
                <td align="right">{{$bill->net}}</td>
            </tr>
        
     
    </tbody>

 
  </table>