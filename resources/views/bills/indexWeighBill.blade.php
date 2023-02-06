@include('bills.modals.alertMessage')
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
                {{__('Customer')}}
            </th>

            <th>
                {{__('Block')}}
            </th>
            <th>
                {{__('Ch')}}
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
                        d.block_id = jQuery('#input-block-search').val(),
                        d.room_id = jQuery('#input-room-search').val(),
                        d.truck_id = jQuery('#input-truck-search').val(),
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
                    data: 'blockName',
                    name: 'Block.name'
                },
                {
                    data: 'roomName',
                    name: 'Room.name'
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
                    data: 'raw',
                    name: 'raw'
                },
                {
                    data: 'tare',
                    name: 'tare'
                },
                {
                    data: 'net',
                    name: 'net'
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
                $('#input-total-net').val(data.inputSumNet);
            },


        });

        jQuery(document).on('click', '.edit-bill-button', function(e) {

            e.preventDefault();
            let href = $(this).attr('href');
            $('#input-href').val(href);
            $('#alertMessage').addClass('show');
            $('#alertMessage').css("display", "block");
            $('#alertMessage .modal-body').html("<p><?php echo __('Do you accepte that the association with the payment will be deleted ?') ?></p>");
            $('#modal-footer').html('<button type="button" class="btn btn-default " id="accept-button" data-dismiss="modal">{{ __("Yes") }}</button><button type="button" class="btn btn-default btn-close quick-close" data-dismiss="modal">{{ __("No") }}</button>')

        })

        $("#btn-search").click(function(e) {
            e.preventDefault();

            table.draw(false);
        });

    });

    function calculateNetPayable() {
        let netTotal = jQuery('#input-total-net').val();
        let unitPrice = jQuery('#input-unit-price').val();
        if (jQuery('#input-unit-price').val() == '') {
            unitPrice = 0;
        }
        if (jQuery('#input-net-total').val() != '') {
            let totalNetPayable = parseFloat(netTotal) * parseFloat(unitPrice);
            jQuery("#input-total-net-payable").val(totalNetPayable.toFixed(2));
            $('#total-net-payable').html(new Intl.NumberFormat().format(totalNetPayable));

        }
    }
</script>