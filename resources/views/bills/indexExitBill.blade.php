@include('bills.modals.addPayment')
@include('bills.modals.alertMessage')
@include('bills.modals.ajax-modal')
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
                        {{__('Net payable')}} 
                    </th> 
                    <th>
                        {{__('Net remaining')}} 
                    </th>
                    <!-- <th>
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
                    <th>
                        {{__('Unit price')}} 
                    </th>
                   
                    <th>
                        {{__('Nb boxes returned')}} 
                    </th> -->
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
                {!! Form::number('sum_net_payable', 0, [
                                'id'=>'input-sum-net-payable',
                                'hidden' => true
                                  ]) !!}  
                {!! Form::number('sum_net_remaining', 0, [
                                'id'=>'input-sum-net-remaining',
                                'hidden' => true
                                  ]) !!}                                     
                                  
                                  

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/functions.js') }}"></script>
<script type="text/javascript">

  $(function () {
    let billIds = [];
    let sumNetPayable = jQuery('#input-sum-net-payable').val();
    let sumNetRemaining =jQuery('#input-sum-net-remaining').val();
    $.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
    

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
            {data: 'net_payable', name: 'net_payable'},
            {data: 'net_remaining', name: 'net_remaining'},
            //  {data: 'block_id', name: 'block_id'},
            // {data: 'room_id', name: 'room_id'},
            // 
            // {data: 'truck_id', name: 'truck_id'},
            // {data: 'number_boxes', name: 'number_boxes'},
            // {data: 'raw', name: 'raw'},
            // {data: 'tare', name: 'tare'},
            // {data: 'net', name: 'net'},
            // {data: 'unit_price', name: 'unit_price'},
             
            // {data: 'number_boxes_returned', name: 'number_boxes_returned'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "createdRow": function ( row, data, index ) {
            if(index==0){
                sumNetPayable=  parseFloat(data.net_payable);
                sumNetRemaining =  parseFloat(data.net_remaining);
            }else {
                sumNetPayable= parseFloat(sumNetPayable) + parseFloat(data.net_payable);
                sumNetRemaining =  parseFloat(sumNetRemaining)+parseFloat(data.net_remaining);
            }
            
            console.log(data.net_remaining);
            console.log(data.net_payable);
            $('#total-net-payable').html(sumNetPayable.toFixed(2));
            $('#total-net-remaining').html(sumNetRemaining.toFixed(2));
        },
       
    });

    $("#btn-search").click(function(e){
        e.preventDefault();
           
        table.draw(false);
    });


$("#add-payment-button").click(function(e){

e.preventDefault(); //empêcher une action par défaut

let url = $('#add-payment-form').attr("action"); //récupérer l'URL du formulaire

let method = $('#add-payment-form').attr("method"); //récupérer la méthode GET/POST du formulaire
  // let data = $(this).serialize(); //Encoder les éléments du formulaire pour la soumission
let _token   = $('meta[name="csrf-token"]').attr('content');
let reference = $('#input-reference').val();
let amount = $('#input-amount').val();
let payment_date = $('#input-payment-date').val();
let third_party_id = $('#input-third-party').val();
let payment_type = $('#input-payment-type').val();
$.ajax({
  url : "{{ route('payments.store') }}",
  type: 'post',
  headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
  data :{
      reference:reference,
      payment_date:payment_date,
      amount:amount,
      third_party_id:third_party_id,
      payment_type:payment_type,
      billIds:JSON.stringify(billIds)
  },
  success:function(response){
        console.log(response);
        if(response) {
            console.log(response);
          $('#addPayment').modal('hide');
          $('#addPayment').css("display","none");
          window.location.reload();
        }
      },
      error: function(error) {
        console.log(error);
      }
});
});

    let ids =[];
    $('.data-table tbody').on('click', 'tr', function () {
        $(this).toggleClass('selected');
        
        // $(table.rows({selected:true}).map(function()
        //     {
        //         console.log(table.rows('.selected').data().length);
        //     }
        //     ));
            for(i=0;i<= table.rows('.selected').data().length-1;i++){
                //console.log(table.rows('.selected').data()[i].id);
            }
    });
    jQuery(document).on('click', '#addPaymentButton', function() {
     
      if(table.rows('.selected').data().length==0){
        $('#alertMessage').addClass('show'); 
        $('#alertMessage').css("display","block");
        $('#alertMessage .modal-body').html("<p><?php echo __('Select one row of table at least') ?></p>");
        
      }else {
        let thirdPartyIds = [table.rows('.selected').data()[0].third_party_id];
        for(i=0;i<= table.rows('.selected').data().length-1;i++){
            let thirdPartyId = table.rows('.selected').data()[i].third_party_id;
            if ($.inArray(thirdPartyId, thirdPartyIds) == -1)
            {
                thirdPartyIds.push(table.rows('.selected').data()[i].third_party_id);
            }
        }
        if(thirdPartyIds.length > 1){
            $('#alertMessage').addClass('show'); 
            $('#alertMessage').css("display","block");
            $('#alertMessage .modal-body').html("<p><?php echo __('Select one customer') ?></p>");
        
        }else {
            $('#add-payment-form').trigger("reset");
            $('#addPayment').addClass('show'); 
            $('#addPayment').css("display","block");
            let sumNetPayable = 0;
            let sumNetRemaining = 0;
            for(i=0;i<= table.rows('.selected').data().length-1;i++){
                billIds.push(table.rows('.selected').data()[i].id);
                let netPayable = table.rows('.selected').data()[i].net_payable;
                sumNetPayable =  parseFloat(sumNetPayable)+parseFloat(netPayable);
                let netRemaining = table.rows('.selected').data()[i].net_remaining;
                sumNetRemaining =  parseFloat(sumNetRemaining)+parseFloat(netRemaining);
            }
                $('#input-amount').val(sumNetRemaining);
                $('#input-amount-payable').val(sumNetRemaining);     
                $('#input-third-party').val(parseInt(thirdPartyIds[0])); 
        } 
      }
  });
  });
</script>