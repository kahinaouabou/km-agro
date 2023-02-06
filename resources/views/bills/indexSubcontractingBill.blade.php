@include('bills.modals.addPayment')
@include('bills.modals.associatePayment')
@include('bills.modals.alertMessage')
@include('bills.modals.ajax-modal')
<table class="table table-bordered data-table">
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
        {{__('Net payable')}}
      </th>
      <th>
        {{__('Net remaining')}}
      </th>
      <th>
        {{__('Net paid')}}
      </th>
      <th class="text-right">
        {{ __('Actions')}}
      </th>
    </tr>
  </thead>
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




<script src="{{ asset('/js/jquery-3.4.1.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('js/functions.js') }}"></script>


<script type="text/javascript">
  //   $(document).ready(function() {
  //             // Select2 Multiple
  //             $('.third-party-select2').select2();

  //         });
  $(function() {

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
      ajax: {
        url: url,
        data: function(d) {
          d.third_party_id = jQuery('#input-third-party-search').val(),
            d.truck_id = jQuery('#input-truck-search').val(),
            d.driver_id = jQuery('#input-driver-search').val(),
            d.date_from = jQuery('#input-date-from').val(),
            d.date_to = jQuery('#input-date-to').val()
        }
      },
      columns: [{
          data: 'reference',
          name: 'reference'
        },
        {
          data: 'bill_date',
          name: 'bill_date',
          stype: 'eu_date'
        },
        {
          data: 'productName',
          name: 'Product.name',
          searchable: true
        },
        {
          data: 'thirdPartyName',
          name: 'ThirdParty.name'
        },
        {
          data: 'driverName',
          name: 'Driver.name'
        },
        {
          data: 'truckName',
          name: 'Truck.registration'
        },
        {
          data: 'number_boxes',
          name: 'number_boxes'
        },
        {
          data: 'net_payable',
          name: 'net_payable'
        },

        {
          data: 'net_remaining',
          name: 'net_remaining'
        },
        {
          data: 'net_paid',
          name: 'net_payable'
        },
        {
          data: 'action',
          name: 'action',
          orderable: false,
          searchable: true
        },
      ],
      "columnDefs": [{
        targets: 1,
        render: function(data, type, row) {
          var datetime = moment(data, 'YYYY-MM-DD');
          var displayString = moment(datetime).format('DD/MM/YY');
          if (type === 'display' || type === 'filter') {
            return displayString;
          } else {
            return datetime;
          }
        }
      }],
      "createdRow": function(row, data, index) {

        $('#total-net').html(data.sumNet);
        $('#total-boxes').html(data.sumNbBoxes);
        $('#input-total-net').val(data.inputSumNet);
      },


    });



    $("#btn-search").click(function(e) {
      e.preventDefault();
      let selected_id = '';
      selected_id = selected_id + 'third_party_id=' + jQuery('#input-third-party-search').val();
      selected_id = selected_id + '&block_id=' + jQuery('#input-block-search').val();
      selected_id = selected_id + '&room_id=' + jQuery('#input-room-search').val();
      selected_id = selected_id + '&net_remaining=' + jQuery('#input-net-remaining-search').val();
      selected_id = selected_id + '&date_from=' + jQuery('#input-date-from').val();
      selected_id = selected_id + '&date_to=' + jQuery('#input-date-to').val();
      console.log(selected_id);
      let url = "{{ route('bills.printDeliveryBill' , ':selected_id') }}";
      url = url.replace(':selected_id', selected_id);
      $('#print-situation').attr('href', url);

      table.draw(false);
    });


    $("#add-payment-button").click(function(e) {

      e.preventDefault(); //empêcher une action par défaut

      let url = $('#add-payment-form').attr("action"); //récupérer l'URL du formulaire

      let method = $('#add-payment-form').attr("method"); //récupérer la méthode GET/POST du formulaire
      // let data = $(this).serialize(); //Encoder les éléments du formulaire pour la soumission
      let _token = $('meta[name="csrf-token"]').attr('content');
      let reference = $('#input-reference').val();
      let amount = $('#input-amount').val();
      let payment_date = $('#input-payment-date').val();
      let third_party_id = $('#input-third-party').val();
      console.log(third_party_id);
      let payment_type = $('#input-payment-type').val();
      $.ajax({
        url: "{{ route('payments.store') }}",
        type: 'post',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: {
          reference: reference,
          payment_date: payment_date,
          amount: amount,
          third_party_id: third_party_id,
          payment_type: payment_type,
          billIds: JSON.stringify(billIds)
        },
        success: function(response) {
          console.log(response);
          if (response) {
            console.log(response);
            $('#addPayment').modal('hide');
            $('#addPayment').css("display", "none");
            table.draw(false);
            // window.location.reload();
          }
        },
        error: function(error) {
          console.log(error);
        }
      });
    });


    $("#associate-payment-button").click(function(e) {

      e.preventDefault(); //empêcher une action par défaut

      let _token = $('meta[name="csrf-token"]').attr('content');
      console.log(paymentIds);
      console.log(billIds);
      $.ajax({
        url: "{{ route('payments.associatePaymentsBills') }}",
        type: 'post',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: {
          billIds: JSON.stringify(billIds),
          paymentIds: JSON.stringify(paymentIds),
          paymentTypeId: $('#input-payment-type').val(),
        },
        success: function(response) {
          console.log(response);
          if (response) {
            console.log(response);
            $('#associatePayment').modal('hide');
            $('#associatePayment').css("display", "none");
            $('#input-amount-associate').val('');
            $('#input-remaining-associate').val('');


            table.draw(false);
            // window.location.reload();
          }
        },
        error: function(error) {
          console.log(error);
        }
      });
    });

    let ids = [];
    $('.data-table tbody').on('click', 'tr', function() {
      $(this).toggleClass('selected');

      // $(table.rows({selected:true}).map(function()
      //     {
      //         console.log(table.rows('.selected').data().length);
      //     }
      //     ));
      for (i = 0; i <= table.rows('.selected').data().length - 1; i++) {
        //console.log(table.rows('.selected').data()[i].id);
      }
    });
    jQuery(document).on('click', '.edit-bill-button', function(e) {

      e.preventDefault();
      let href = $(this).attr('href');
      $('#input-href').val(href);
      console.log(href);
      $('#alertMessage').addClass('show');
      $('#alertMessage').css("display", "block");
      $('#alertMessage .modal-body').html("<p><?php echo __('Do you accepte that the association with the payment will be deleted ?') ?></p>");
      $('#modal-footer').html('<button type="button" class="btn btn-default " id="accept-button" data-dismiss="modal">{{ __("Yes") }}</button><button type="button" class="btn btn-default btn-close quick-close" data-dismiss="modal">{{ __("No") }}</button>')
    })



    jQuery(document).on('click', '#addPaymentButton', function() {
      let thirdPartyIds = [];
      if (table.rows('.selected').data().length == 0) {
        $('#alertMessage').addClass('show');
        $('#alertMessage').css("display", "block");
        $('#alertMessage .modal-body').html("<p><?php echo __('Select one row of table at least') ?></p>");

      } else {
        thirdPartyIds = [table.rows('.selected').data()[0].third_party_id];
        for (i = 0; i <= table.rows('.selected').data().length - 1; i++) {
          let thirdPartyId = table.rows('.selected').data()[i].third_party_id;
          console.log(thirdPartyId);
          if ($.inArray(thirdPartyId, thirdPartyIds) == -1) {
            thirdPartyIds.push(table.rows('.selected').data()[i].third_party_id);
          }
        }
        if (thirdPartyIds.length > 1) {
          $('#alertMessage').addClass('show');
          $('#alertMessage').css("display", "block");
          $('#alertMessage .modal-body').html("<p><?php echo __('Select one customer') ?></p>");

        } else {
          getPaymentReference();
          $('#add-payment-form').trigger("reset");
          $('#addPayment').addClass('show');
          $('#addPayment').css("display", "block");
          let sumNetPayable = 0;
          let sumNetRemaining = 0;
          let sumNetPaid = 0;
          billIds = [];
          for (i = 0; i <= table.rows('.selected').data().length - 1; i++) {
            billIds.push(table.rows('.selected').data()[i].id);
            console.log(billIds);
            let netPayable = table.rows('.selected').data()[i].net_payable.replace(/ /g, '');
            console.log(parseFloat(netPayable));
            sumNetPayable = parseFloat(sumNetPayable) + parseFloat(netPayable);
            let netRemaining = table.rows('.selected').data()[i].net_remaining.replace(/ /g, '');
            sumNetRemaining = parseFloat(sumNetRemaining) + parseFloat(netRemaining);
            console.log(sumNetRemaining);
            let netPaid = table.rows('.selected').data()[i].net_paid.replace(/ /g, '');
            sumNetPaid = parseFloat(sumNetPaid) + parseFloat(netPaid);
            console.log(sumNetPaid);
          }
          $('#input-amount').val(sumNetRemaining);
          $('#input-amount-payable').val(sumNetRemaining);
          console.log(thirdPartyIds);
          $('#input-third-party').val(parseInt(thirdPartyIds[0]));
        }
      }
    });


    jQuery(document).on('click', '#associatePaymentButton', function() {
      let thirdPartyIds = [];
      if (table.rows('.selected').data().length == 0) {
        $('#alertMessage').addClass('show');
        $('#alertMessage').css("display", "block");
        $('#alertMessage .modal-body').html("<p><?php echo __('Select one row of table at least') ?></p>");

      } else {
        thirdPartyIds = [table.rows('.selected').data()[0].third_party_id];
        for (i = 0; i <= table.rows('.selected').data().length - 1; i++) {
          let thirdPartyId = table.rows('.selected').data()[i].third_party_id;
          console.log(thirdPartyId);
          if ($.inArray(thirdPartyId, thirdPartyIds) == -1) {
            thirdPartyIds.push(table.rows('.selected').data()[i].third_party_id);
          }
        }
        if (thirdPartyIds.length > 1) {
          $('#alertMessage').addClass('show');
          $('#alertMessage').css("display", "block");
          $('#alertMessage .modal-body').html("<p><?php echo __('Select one customer') ?></p>");

        } else {
          $('#add-payment-form').trigger("reset");
          $('#associatePayment').addClass('show');
          $('#associatePayment').css("display", "block");
          billIds = [];
          let sumNetRemaining = 0;
          $paymentTypeId = $('#input-payment-type').val();
          let url = "{{ route('payments.getReceiptsByThirdPartyId' , [':thirdPartyId',':paymentTypeId']) }}";
          url = url.replace(':thirdPartyId', thirdPartyIds[0]);
          url = url.replace(':paymentTypeId', $paymentTypeId);
          jQuery('#receipt-tab').load(url, function() {

          });

          for (i = 0; i <= table.rows('.selected').data().length - 1; i++) {
            billIds.push(table.rows('.selected').data()[i].id);
            let netRemaining = table.rows('.selected').data()[i].net_remaining.replace(/ /g, '');
            sumNetRemaining = parseFloat(sumNetRemaining) + parseFloat(netRemaining);
            console.log(sumNetRemaining);
          }
          //$('#input-amount-associate').val('');
          $('#input-amount-payable-associate').val(sumNetRemaining);
          $('#input-third-party').val(parseInt(thirdPartyIds[0]));
        }
      }
    });



    function getPaymentReference() {
      $.ajax({
        url: "{{ route('payments.getReference') }}",
        type: 'get',
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },

        success: function(response) {
          console.log(response);
          if ((response.reference.length !== "")) {
            $('#input-reference').val(response.reference);

          }

        },
        error: function(error) {
          console.log(error);
        }
      });
    }




  });
</script>