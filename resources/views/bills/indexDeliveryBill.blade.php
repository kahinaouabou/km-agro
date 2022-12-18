@include('bills.modals.alertMessage')
<table  class="table table-bordered data-table">
                  <thead class=" text-primary">
                    <tr>
                    <th>  
                        {{ __('Ref.')}}
                    </th>
                    <th>
                        {{__('Date')}} 
                    </th>
                      <th>
                        {{__('Product')}} 
                    </th> 
                   
                     <th>
                        {{__('Subcontractor')}} 
                    </th>
                    <th>
                        {{__('Driver')}} 
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

                 {!! Form::text('href', null, [
                                  'id'=>'input-href',
                                  'hidden' => true
                                  ]) !!}                  
                                  
           
          
        
<script src="{{ asset('/js/jquery-3.4.1.min.js')}}" ></script>
<script type="text/javascript" src="{{ URL::asset('js/functions.js') }}"></script>

    
<script type="text/javascript">
//   $(document).ready(function() {
//             // Select2 Multiple
//             $('.third-party-select2').select2();

//         });
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
            d.third_party_id  = jQuery('#input-third-party-search').val(),
            d.date_from = jQuery('#input-date-from').val(),
            d.date_to = jQuery('#input-date-to').val()
        }
        },
        columns: [
            {data: 'reference', name: 'reference'},
            {data: 'bill_date', name: 'bill_date' ,stype:'eu_date'},
            {data: 'productName', name: 'Product.name', searchable: true},
            {data: 'thirdPartyName', name: 'ThirdParty.name'},
            {data: 'driverName', name: 'Driver.name'},
            {data: 'truckName', name: 'Truck.registration'},
            {data: 'number_boxes', name: 'number_boxes'},
            {data: 'raw', name: 'raw'},
            {data: 'tare', name: 'tare'},
            {data: 'net', name: 'net'},
            {data: 'action', name: 'action', orderable: false, searchable: true},
        ],
        "columnDefs":[
            { targets: 1,
                render: function ( data, type, row ) {
                var datetime = moment(data, 'YYYY-MM-DD');
                var displayString = moment(datetime).format('DD/MM/YY');
                if ( type === 'display' || type === 'filter' ) {
                    return displayString;
                } else {
                    return datetime;
                }
                }
            }],
            "createdRow": function ( row, data, index ) {
          
            $('#total-net').html(data.sumNet);
            $('#total-boxes').html(data.sumNbBoxes);
            $('#input-total-net').val(data.inputSumNet);
        },    
         
      
    });

 

    $("#btn-search").click(function(e){
        e.preventDefault();
        let selected_id ='';
            selected_id = selected_id +'third_party_id='+ jQuery('#input-third-party-search').val();
            selected_id = selected_id +'&block_id='+ jQuery('#input-block-search').val();
            selected_id= selected_id +'&room_id='+ jQuery('#input-room-search').val();
            selected_id = selected_id +'&net_remaining='+ jQuery('#input-net-remaining-search').val();
            selected_id= selected_id +'&date_from='+ jQuery('#input-date-from').val();
            selected_id= selected_id +'&date_to='+ jQuery('#input-date-to').val();
            console.log(selected_id);
            let url = "{{ route('bills.printDeliveryBill' , ':selected_id') }}";
            url = url.replace(':selected_id', selected_id);
            $('#print-situation').attr('href',url);
           
        table.draw(false);
    });

  });

</script>