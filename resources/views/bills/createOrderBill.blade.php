@include('bills.modals.addThirdParty')
<div class="card-body ">
  @if (session('status'))
  <div class="row">
    <div class="col-sm-12">
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <i class="material-icons">close</i>
        </button>
        <span>{{ session('status') }}</span>
      </div>
    </div>
  </div>
  @endif
  <div class="row">
    <label class="col-sm-2 col-form-label">{{ __('Reference') }}</label>
    <div class="col-sm-7">
      <div class="form-group{{ $errors->has('reference') ? ' has-danger' : '' }}">
        <input class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" value="{{ $nextReference }}"
          name="reference" id="input-reference" type="text" placeholder="{{ __('Reference') }}" required="true"
          aria-required="true" />
        @if ($errors->has('reference'))
        <span id="reference-error" class="error text-danger" for="input-reference">{{ $errors->first('reference')
          }}</span>
        @endif
      </div>
    </div>
  </div>
  <div class="row">
    <label class="col-sm-2 col-form-label">{{ __('Date') }}</label>
    <div class="col-sm-7">
      <div class="form-group">
        {!! Form::input('date','bill_date',date('Y-m-d'),['class' => 'form-control']) !!}
      </div>
    </div>
  </div>
  <div class="row">
    <label class="col-sm-2 col-form-label">{{ __('Products') }}</label>
    <div class="col-sm-7">
      <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
        <select class="form-control{{ $errors->has('product_id') ? ' is-invalid' : '' }}" name="product_id"
          id="input-product" type="select" placeholder="{{ __('Product') }}" required>
          <option value="">{{ __('Select product') }}</option>
          @foreach($products as $product)
          <option value="{{ $product->id }}">{{ $product->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  <?php $varieties = []; ?>
  <div id="div-variety">
    <div class="row">
      <label class="col-sm-2 col-form-label">{{ __('Varieties') }}</label>
      <div class="col-sm-7">
        <div class="form-group{{ $errors->has('variety_id') ? ' has-danger' : '' }}">
          <select class="form-control{{ $errors->has('product_id') ? ' is-invalid' : '' }}" name="variety_id"
            id="input-variety" type="select" placeholder="{{ __('Variety') }}">
            <option value="">{{ __('Select variety') }}</option>
            @foreach($varieties as $variety)
            <option value="{{ $variety->id }}">{{ $variety->name }}</option>
            @endforeach
          </select>
        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 col-form-label">{{ __('Customers') }}</label>
    <div class="col-sm-7">
      <div class="form-group{{ $errors->has('third_party_id') ? ' has-danger' : '' }}">
        <select class="third-party-select2 form-control{{ $errors->has('third_party_id') ? ' is-invalid' : '' }}"
          name="third_party_id" id="input-third-party" type="select" onchange="getTrucksByThirdPartyId()" required>
          <option value="">{{ __('Select customer') }}</option>
          @foreach($thirdParties as $thirdParty)
          <option value="{{ $thirdParty->id }}">{{ $thirdParty->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
    <button type="button" data-toggle="modal" data-target="#addThirdParty" class="btn btn-sm btn-primary"
      id="addThirdPartyButton"><i class="material-icons">edit</i></button>

  </div>

  <div class="row">
    <label class="col-sm-2 col-form-label">{{ __('Net') }}</label>
    <div class="col-sm-7">
      <div class="form-group">
        {!! Form::number('net', null, [
        'class' => 'form-control',
        'step' => '1',
        'id' =>'input-net',
        'onchange'=>'calculateOrderNetPayableValue(this.value)',
        'required' => true
        ]) !!}
      </div>
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 col-form-label">{{ __('Unit price') }}</label>
    <div class="col-sm-7">
      <div class="form-group">
        {!! Form::number('unit_price', null, [
        'class' => 'form-control',
        'step' => '0.01',
        'id' =>'input-unit-price',
        'onchange'=>'calculateOrderNetPayableValue(this.value)',
        'required' => true
        ]) !!}
      </div>
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 col-form-label">{{ __('Net payable') }}</label>
    <div class="col-sm-7">
      <div class="form-group">
        {!! Form::number('net_payable', null, [
        'class' => 'form-control',
        'step' => '0.01',
        'id' =>'input-net-payable',
        'required' => true
        ]) !!}
      </div>
    </div>
  </div>


  {!! Form::number('bill_type', $dbBillType, [
  'hidden' => true
  ]) !!}
  {!! Form::number('display_type', $type, [
  'hidden' => true
  ]) !!}
</div>
<script src="{{ asset('/js/jquery-3.4.1.min.js')}}"></script>
<script type="text/javascript" src="{{ URL::asset('js/functions.js') }}"></script>
<script type="text/javascript">
  $(function () {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });

    jQuery('#input-product').change(function () {
      let productId = jQuery(this).val();
      console.log(productId);
      let url = base_path + "bills/" + productId + "/getVarietiesByProductId/";

      jQuery('#div-variety').load(url, function () {

      });
    });

   
    
    jQuery(document).on('click', '#addThirdPartyButton', function () {
      $('#addThirdParty').appendTo("body").modal('show');
      $('#input-name').attr('required', true);

      // $('#addThirdParty').addClass('show'); 
      // $('#addThirdParty').css("display","block");
    });


    jQuery("#add-third-party-button").click(function (e) {

      e.preventDefault(); //empêcher une action par défaut


      let name = $('#input-name').val();
      if (name.length !== 0) {
        let name = $('#input-name').val();
        let exist = false;
        let url = "{{ route('thirdParties.searchName') }}";
        $.ajax({
          url: url,
          type: 'get',
          headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          data: {
            name: name,
          },
          success: function (response) {
            if ((response.thirdParty.length !== 0)) {
              $('#input-name').val('');
              $('#p-msg').html("<?php __('Name already exist, change it.') ?>");
              exist = true;
              console.log(exist);
            } else {
              $('#p-msg').html("");
              exist = false;
              let is_supplier = $('#input-is-supplier').val();
              let is_subcontractor = $('#input-is-subcontractor').val();

              let address = $('#input-address').val();
              let phone = $('#input-phone').val();
              $.ajax({
                url: "{{ route('thirdParties.store') }}",
                type: 'post',
                headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                data: {
                  name: name,
                  address: address,
                  phone: phone,
                  is_supplier: is_supplier,
                  is_subcontractor: is_subcontractor
                },
                success: function (response) {
                  console.log(response);
                  if (response) {
                    $('#input-third-party').empty();
                    $("#input-third-party").append('<option>{{ __("Select customer") }}</option>');

                    $.each(response.thirdParties, function (key, value) {
                      // $('#input-third-party').append($("<option/>", {
                      //      value: key,
                      //      text: value,
                      //   }));
                      if (key == response.selectedId) {
                        $("#input-third-party").append('<option selected="selected" value="' + key + '">' + value + '</option>')
                      } else {
                        $("#input-third-party").append('<option value="' + key + '">' + value + '</option>')
                      }

                    });

                    $('#addThirdParty').appendTo("body").modal('hide');
                    $('body').removeClass('modal-open');
                    $('.modal-backdrop').remove();
                    $('#input-name').removeAttr('required');
                  }
                },
                error: function (error) {
                  console.log(error);
                }
              });
            }
            console.log(exist);
          },
          error: function (error) {
            console.log(error);
          }
        });



      }

    });

  });

  function calculateOrderNetPayableValue() {
      let net = jQuery('#input-net').val();

      let unitPrice = jQuery('#input-unit-price').val();

      if (jQuery('#input-net').val() != '' && jQuery('#input-unit-price').val() != '') {
        let netPayable = parseFloat(net) * parseFloat(unitPrice);
        jQuery("#input-net-payable").val(netPayable.toFixed(2));
      }

    }
    
    
</script>