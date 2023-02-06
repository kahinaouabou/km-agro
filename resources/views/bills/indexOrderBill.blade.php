
<table class="table table-bordered data-table">
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
                {{__('Variety')}}
            </th>
            <th>
                {{__('Customer')}}
            </th>
            <th>
                {{__('Net')}}
            </th>
            <th>
                {{__('Unit price')}}
            </th>
            <th>
                {{__('Net payable')}}
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
    let paymentIds = [];
    $(function () {
        let billIds = [];
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

            ajax: {
                url: url,
                data: function (d) {
                    d.third_party_id = jQuery('#input-third-party-search').val(),
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
                name: 'Product.name'
            },
            {
                data: 'varietyName',
                name: 'Variety.name'
            },
            {
                data: 'thirdPartyName',
                name: 'ThirdParty.name'
            },
            {
                data: 'net',
                name: 'net'
            },
             {
                 data: 'unit_price',
                 name: 'unit_price'
             },
             {
                 data: 'net_payable',
                 name: 'net_payable'
             },

            {
                data: 'action',
                name: 'action',
                orderable: true,
                searchable: true
            },
            ],
            "columnDefs": [{
                targets: 1,
                render: function (data, type, row) {
                    var datetime = moment(data, 'YYYY-MM-DD');
                    var displayString = moment(datetime).format('DD/MM/YYYY');
                    if (type === 'display' || type === 'filter') {
                        return displayString;
                    } else {
                        return datetime;
                    }
                }
            }],
            "createdRow": function (row, data, index) {

                $('#total-net-payable').html(data.sumNetPayable);
            },

        });

        $("#btn-search").click(function (e) {
            e.preventDefault();
            let selected_id = '';
            selected_id = selected_id + 'third_party_id=' + jQuery('#input-third-party-search').val();
            selected_id = selected_id + '&date_from=' + jQuery('#input-date-from').val();
            selected_id = selected_id + '&date_to=' + jQuery('#input-date-to').val();
            let url = "{{ route('bills.printSituation' , ':selected_id') }}";
            url = url.replace(':selected_id', selected_id);
            $('#print-situation').attr('href', url);

            console.log(url);

            table.draw(false);
        });



        let ids = [];
        $('.data-table tbody').on('click', 'tr', function () {
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



    });




</script>