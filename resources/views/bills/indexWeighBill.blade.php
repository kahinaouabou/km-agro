
<table  class="table table-bordered data-table">
                  <thead class=" text-primary">
                    <tr>
                    <th>  
                        {{ __('Reference')}}
                    </th>
                    <th>
                        {{__('Date')}} 
                    </th>
                      <th>
                        {{__('Product')}} 
                    </th>
                    <th>
                        {{__('Customer')}} 
                    </th> 
                   
                     <th>
                        {{__('Block')}} 
                    </th>
                    <th>
                        {{__('Room')}} 
                    </th>
                    
                    <th>
                        {{__('Truck')}} 
                    </th>
                    <th>
                        {{__('Nb boxes')}} 
                    </th>
                    <th>
                        {{__('Raw')}} 
                    </th>
                    <th>
                        {{__('Tare')}} 
                    </th>
                    <th>
                        {{__('Net')}} 
                    </th>
                   
                    <th class="text-right">
                    {{ __('Actions')}}
                    </th>
                  </tr></thead>
                    <tbody>
                
				    </tbody>
</table>
                {!! Form::number('bill_type', $type, [
                                'id'=>'type',
                                'hidden' => true
                                  ]) !!} 
                                  
                                  

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/functions.js') }}"></script>
<script type="text/javascript">

  $(function () {
    let billIds = [];
    $.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
    //console.log(data);
    let url = "{{ route('bills' , ':type') }}";
    url = url.replace(':type', jQuery('#type').val());
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax:{ 
        url :url,
        data: function (d) {
            d.third_party_id  = jQuery('#input-third-party').val(),
            d.date_from = jQuery('#input-date-from').val(),
            d.date_to = jQuery('#input-date-to').val()
        }
        },
        columns: [
            {data: 'reference', name: 'reference'},
            {data: 'bill_date', name: 'bill_date' ,type:'date'},
            {data: 'productName', name: 'productName'},
            {data: 'thirdPartyName', name: 'thirdPartyName'},
            {data: 'blockName', name: 'blockName'},
            {data: 'roomName', name: 'roomName'},
            {data: 'truckName', name: 'truckName'},
            {data: 'number_boxes', name: 'number_boxes'},
            {data: 'raw', name: 'raw'},
            {data: 'tare', name: 'tare'},
            {data: 'net', name: 'net'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $("#btn-search").click(function(e){
        e.preventDefault();
           
        table.draw(false);
    });

  });
</script>