 @include('bills.modals.addThirdParty')
@include('bills.modals.addTruck') 
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
                      <input class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" name="reference" id="input-reference" type="text" placeholder="{{ __('Reference') }}" 
                      value="{{ $bill->reference }}" required="true" aria-required="true"/>
                      @if ($errors->has('reference'))
                        <span id="reference-error" class="error text-danger" for="input-reference">{{ $errors->first('reference') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Date') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                      {!! Form::input('date','bill_date',$bill->bill_date->format('Y-m-d'),['class' => 'form-control']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Products') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                      {!! Form::select('product_id', $products, $bill->product->id,
                      [
                        'class' => 'form-control',
                        'placeholder'=> __('Select product') ,
                        'label'=>__('Products'),
      
                        ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Blocks') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('block_id') ? ' has-danger' : '' }}">
                      {!! Form::select('block_id', $blocks, $bill->block->id,
                      [
                        'class' => 'form-control',
                        'placeholder'=> __('Select block') ,
                        'label'=>__('Blocks'),
      
                        ]) !!}
                    </div>
                  </div>
                </div>
                <div id="div-room">
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Rooms') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                   
                    {!! Form::select('room_id', $rooms, $bill->room->id,
                      [
                        'class' => 'form-control',
                        'placeholder'=> __('Select room') ,
                        'label'=>__('Rooms'),
      
                        ]) !!}
                    </div>
                  </div>
                </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Customers') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('third_party_id') ? ' has-danger' : '' }}">
                      {!! Form::select('third_party_id', $thirdParties, $bill->thirdParty->id,
                      [
                        'class' => 'form-control',
                        'id'=>'input-third-party',
                        'placeholder'=> __('Select customer') ,
                        'label'=>__('Customers'),
      
                        ]) !!}
                    </div>
                  </div>
                  <button type="button" data-toggle="modal" data-target="#addThirdParty" class="btn btn-sm btn-primary" id="addThirdPartyButton"><i class="material-icons">edit</i></button>
                 
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Registration') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('truck_id') ? ' has-danger' : '' }}">
                      {!! Form::select('truck_id', $trucks, $bill->truck->id,
                      [
                        'class' => 'form-control',
                        'id' => 'input-truck',
                        'placeholder'=> __('Select registration') ,
      
                        ]) !!}
                    </div>
                  </div>
                  <button type="button" data-toggle="modal" data-target="#addTruck" class="btn btn-sm btn-primary" id="addTruckButton"><i class="material-icons">edit</i></button>
                 
                </div>
               
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Number boxes taken') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('number_boxes', $bill->number_boxes, [
                                                'class' => 'form-control',
                                                'step' => '1',
                                                'id' =>'input-number-boxes',
                                                'required' => true,
                                                'onchange'=>'calculateNetValue(this.value)'
                                                ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Raw') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('raw', $bill->raw, [
                                                'class' => 'form-control',
                                                'step' => '1',
                                                'id' =>'input-raw',
                                                'required' => true,
                                                'onchange'=>'calculateNetValue(this.value)'
                                                ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Tare') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('tare', $bill->tare, [
                                                'class' => 'form-control',
                                                'step' => '1',
                                                'id' =>'input-tare',
                                                'required' => true,
                                                'onchange'=>'calculateNetValue(this.value)'
                                                ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Net') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('net', $bill->net, [
                                                'class' => 'form-control',
                                                'step' => '1',
                                                'id' =>'input-net',
                                                'onchange'=>'calculateNetPayableValue(this.value)',
                                                'required' => true
                                                ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('weight discount percentage') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('weight_discount_percentage', $bill->weight_discount_percentage, [
                                                'class' => 'form-control',
                                                'step' => '0.1',
                                                'id' =>'input-weight-discount-percentage',
                                                'onchange'=>'calculateNetValueWithWeightDiscountPercentage(this.value)',
                                                
                                                ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Unit price') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('unit_price', $bill->unit_price, [
                                                'class' => 'form-control',
                                                'step' => '0.1',
                                                'id' =>'input-unit-price',
                                                'onchange'=>'calculateNetPayableValue(this.value)',
                                                'required' => true
                                                ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Discount') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('discount_value', $bill->discount_value, [
                                                'class' => 'form-control',
                                                'step' => '0.1',
                                                'id' =>'input-discount-value',
                                                'onchange'=>'calculateNetPayableValueWithDiscountValue(this.value)',
                                                
                                                ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Net payable') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('net_payable', $bill->net_payable, [
                                                'class' => 'form-control',
                                                'step' => '0.1',
                                                'id' =>'input-net-payable',
                                                'required' => true
                                                ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Number boxes returned') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('number_boxes_returned', $bill->number_boxes_returned, [
                                                'class' => 'form-control',
                                                'step' => '1',
                                                'id' =>'input-number-boxes-returned',
                                                ]) !!}
                    </div>
                  </div>
                </div>
               
                {!! Form::number('bill_type', $type, [
                                  'hidden' => true
                                  ]) !!}
</div>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.0.4/popper.js"></script>
<script type="text/javascript" src="{{ URL::asset('js/functions.js') }}"></script>
<script type="text/javascript">

  $(function () {
    $.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });
jQuery(document).on('click', '#addThirdPartyButton', function() {
          $('#addThirdParty').appendTo("body").modal('show');

            // $('#addThirdParty').addClass('show'); 
            // $('#addThirdParty').css("display","block");
      });
jQuery(document).on('click', '#addTruckButton', function() {
          $('#addTruck').appendTo("body").modal('show');

      }); 

jQuery("#add-third-party-button").click(function(e){

e.preventDefault(); //empêcher une action par défaut

let code = $('#input-code').val();
let name = $('#input-name').val();
let address = $('#input-address').val();
let is_supplier = $('#input-is-supplier').val();
$.ajax({
  url : "{{ route('thirdParties.store') }}",
  type: 'post',
  headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
  data :{
      code:code,
      name:name,
      address:address,
      is_supplier:is_supplier
  },
  success:function(response){
        console.log(response);
        if(response) {
          $('#input-third-party').empty();
                $("#input-third-party").append('<option>{{ __("Select customer") }}</option>');
               
                    $.each(response.thirdParties,function(key,value){
                      // $('#input-third-party').append($("<option/>", {
                      //      value: key,
                      //      text: value,
                      //   }));
                      if(key ==response.selectedId){
                        $("#input-third-party").append( '<option selected="selected" value="'+key+'">'+value+'</option>' )
                      }else {
                        $("#input-third-party").append( '<option value="'+key+'">'+value+'</option>' )
                      }
                       
                    });
                
            $('#addThirdParty').appendTo("body").modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }
      },
      error: function(error) {
        console.log(error);
      }
});
}); 

jQuery("#add-truck-button").click(function(e){

e.preventDefault(); //empêcher une action par défaut

let registration = $('#input-registration').val();
let model = $('#input-model').val();
let tare = $('#input-tare-truck').val();
let mark_id = $('#input-mark').val();
console.log(tare);
$.ajax({
  url : "{{ route('trucks.store') }}",
  type: 'post',
  headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
  data :{
      registration:registration,
      model:model,
      tare:tare,
      mark_id:mark_id
  },
  success:function(response){
        console.log(response);
        if(response) {
          $('#input-truck').empty();
                $("#input-truck").append('<option>{{ __("Select registration") }}</option>');
               
                    $.each(response.trucks,function(key,value){
                      // $('#input-third-party').append($("<option/>", {
                      //      value: key,
                      //      text: value,
                      //   }));
                      if(key ==response.selectedId){
                        $("#input-truck").append( '<option selected="selected" value="'+key+'">'+value+'</option>' )
                      }else {
                        $("#input-truck").append( '<option value="'+key+'">'+value+'</option>' )
                      }
                       
                    });
                
            $('#addTruck').appendTo("body").modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        }
      },
      error: function(error) {
        console.log(error);
      }
});
});
      });
  </script>