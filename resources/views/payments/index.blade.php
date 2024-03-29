@extends('layouts.app', ['activePage' => 'payment', 'titlePage' =>  __('Payments')])

@section('content')

<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
          @if (session()->has('message'))
          <div class="alert alert-success" role="alert">
              {{ session('message') }}
          </div>
          @endif
          @if (session()->has('error'))
          <div class="alert alert-danger" role="alert">
              {{ session('error') }}
          </div>
          @endif
          @include('payments.search')
          <div class="card">
            <div class="card-header card-header-primary">
              <h4 class="card-title ">{{__('Payments')}}</h4>
              <p class="card-category"> {{__('Here you can manage payment')}}</p>
            </div>
            <div class="card-body">
                              <div class="row">
                <div class="col-12 text-right">
                  <a target="_blanck" href="{{ route('payments.printSituation', $selected_id) }}" id='print-situation' class="btn btn-sm btn-primary">{{__('Print PDF')}}</a>
                  <a href="{{ route('payments.create', \App\Enums\PaymentTypeEnum::Receipt) }}" class="btn btn-sm btn-primary">{{ __('Add receipt')}}</a>
                  <a href="{{ route('payments.create',\App\Enums\PaymentTypeEnum::Disbursement) }}" class="btn btn-sm btn-primary">{{ __('Add disbursement')}}</a>
                </div>
              </div>
              <div class="table-responsive">
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
                        {{__('Categories')}} 
                    </th>
                    <th>
                        {{__('Customer')}} 
                    </th> 
                    <th>
                        {{__('Type')}} 
                    </th> 
                    <th>
                        {{__('Amount')}} 
                    </th>
                    
                    <th class="text-right">
                    {{ __('Actions')}}
                    </th>
                  </tr></thead>
                    <tbody>
                
				      </tbody>
                </table>
                {!! Form::text('href', null, [
                'id'=>'input-href',
                'hidden' => true
                ]) !!} 
               
              </div>
            </div>
          </div>
          <div class="card-header card-header-primary card-footer-primary">
                <h4 class="card-title ">{{__('Total receipts')}} : <strong id="total-receipt"></strong><strong> DA</strong></h4>
                <h4 class="card-title ">{{__('Total disbursements')}} : <strong id="total-disbursement"></strong><strong> DA</strong></h4>
                
              </div> 
         
      </div>
    </div>
  </div>
</div>
@include('payments.modals.alertMessage')
@endsection
<script src="{{ asset('/js/jquery-3.4.1.min.js')}}" ></script>
<script type="text/javascript" src="{{ URL::asset('js/functions.js') }}"></script>
<script type="text/javascript">
    $(function () {
        $.ajaxSetup({
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
        let url = "{{ route('payments.index')}}"
        var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax:{ 
        url :url,
        data: function (d) {
            d.third_party_id  = jQuery('#input-third-party').val(),
            d.payment_category_id  = jQuery('#input-payment-category').val(),
            d.payment_type  = jQuery('#input-payment-type').val(),
            d.date_from = jQuery('#input-date-from').val(),
            d.date_to = jQuery('#input-date-to').val()
        }
        },
        columns: [
            {data: 'reference', name: 'reference'},
            {data: 'payment_date', name: 'payment_date' ,type:'date'},
            {data: 'categoryName', name: 'PaymentCategory.name'},
            {data: 'thirdPartyName', name: 'ThirdParty.name'},
            {data: 'payment_type', name: 'payment_type'},
            {data: 'amount', name: 'amount'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ],
        "columnDefs":[
            { targets: 1,
                render: function ( data, type, row ) {
                var datetime = moment(data, 'YYYY-MM-DD');
                var displayString = moment(datetime).format('DD/MM/YYYY');
                if ( type === 'display' || type === 'filter' ) {
                    return displayString;
                } else {
                    return datetime;
                }
                }
            }],
        "createdRow": function ( row, data, index ) {
            $('#total-receipt').html(data.sumReceipts);
            $('#total-disbursement').html(data.sumDisbursements);
        },
        });

        $("#btn-search").click(function(e){
        e.preventDefault();  
        let selected_id ='';
            selected_id = selected_id +'third_party_id='+ jQuery('#input-third-party').val();
            selected_id = selected_id +'&payment_category_id='+ jQuery('#input-payment-category').val();
            selected_id = selected_id +'&payment_type='+ jQuery('#input-payment-type').val();
            selected_id= selected_id +'&date_from='+ jQuery('#input-date-from').val();
            selected_id= selected_id +'&date_to='+ jQuery('#input-date-to').val();
            console.log(selected_id);
            let url = "{{ route('payments.printSituation' , ':selected_id') }}";
            url = url.replace(':selected_id', selected_id);
            $('#print-situation').attr('href',url);
        table.draw(false);
    });


    jQuery(document).on('click', '.edit-payment-button', function(e) {
     
     e.preventDefault();
     let href = $(this).attr('href');
     $('#input-href').val(href);
     console.log(href);
     $('#alertMessage').addClass('show'); 
     $('#alertMessage').css("display","block");
     $('#alertMessage .modal-body').html("<p><?php echo __('Do you accepte that the association with the payment will be deleted ?') ?></p>");
     $('#modal-footer').html('<button type="button" class="btn btn-default " id="accept-button" data-dismiss="modal">{{ __("Yes") }}</button><button type="button" class="btn btn-default btn-close quick-close" data-dismiss="modal">{{ __("No") }}</button>')
  })

    }); 
</script>
   
