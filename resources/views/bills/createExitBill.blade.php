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
                       required="true" aria-required="true"/>
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
                      {!! Form::input('date','bill_date',date('Y-m-d'),['class' => 'form-control']) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Products') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('product_id') ? ' has-danger' : '' }}">
                      <select class="form-control{{ $errors->has('product_id') ? ' is-invalid' : '' }}" name="product_id" id="input-product" type="select" placeholder="{{ __('Product') }}" required >
                      <option value="">{{ __('Select product') }}</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}" >{{ $product->name }}</option>
                        @endforeach
                    </select>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Blocks') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('block_id') ? ' has-danger' : '' }}">
                      <select class="form-control{{ $errors->has('block_id') ? ' is-invalid' : '' }}" name="block_id" id="input-block" type="select" placeholder="{{ __('block') }}" required >
                      <option value="">{{ __('Select block') }}</option>
                        @foreach($blocks as $block)
                        <option value="{{ $block->id }}" >{{ $block->name }}</option>
                        @endforeach
                    </select>
                    </div>
                  </div>
                </div>
                <div id="div-room">
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Rooms') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                   
                    {!! Form::select('room_id', $rooms,null,
                      [
                        'class' => 'form-control',
                        'placeholder'=> __('Select room') ,
      
                        ]) !!}
                    </div>
                  </div>
                </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Customers') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('third_party_id') ? ' has-danger' : '' }}">
                      <select class="form-control{{ $errors->has('third_party_id') ? ' is-invalid' : '' }}" name="third_party_id" id="input-third-party" type="select"  required >
                        <option value="">{{ __('Select customer') }}</option>
                        @foreach($thirdParties as $thirdParty)
                        <option value="{{ $thirdParty->id }}" >{{ $thirdParty->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <button type="button" data-toggle="modal" data-target="#addThirdParty" class="btn btn-sm btn-primary" id="addThirdPartyButton"><i class="material-icons">edit</i></button>
                 
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Registration') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('truck_id') ? ' has-danger' : '' }}">
                      <select class="form-control{{ $errors->has('truck_id') ? ' is-invalid' : '' }}" name="truck_id" id="input-truck" type="select" placeholder="{{ __('Registration') }}" required >
                      <option value="">{{ __('Select registration') }}</option>
                        @foreach($trucks as $truck)
                        <option value="{{ $truck->id }}" >{{ $truck->registration }}</option>
                        @endforeach
                    </select>
                    </div>
                  </div>
                  <button type="button" data-toggle="modal" data-target="#addTruck" class="btn btn-sm btn-primary" id="addTruckButton"><i class="material-icons">edit</i></button>
                 
                </div>
               
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Number boxes taken') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('number_boxes', null, [
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
                    {!! Form::number('raw', null, [
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
                    {!! Form::number('tare', null, [
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
                    {!! Form::number('net', null, [
                                                'class' => 'form-control',
                                                'step' => '1',
                                                'id' =>'input-net',
                                                //'onchange'=>'calculateNetPayableValue(this.value)',
                                                'required' => true
                                                ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('weight discount percentage') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('weight_discount_percentage', 0, [
                                                'class' => 'form-control',
                                                'step' => '0.01',
                                                'id' =>'input-weight-discount-percentage',
                                                
                                                ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Net with weight discount') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('net_weight_discount', null, [
                                                'class' => 'form-control',
                                                'step' => '0.01',
                                                'id' =>'input-net-weight-discount',
                                                //'onchange'=>'calculateNetPayableValue(this.value)',
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
                                                //'onchange'=>'calculateNetPayableValue(this.value)',
                                                'required' => true
                                                ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Discount') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('discount_value', 0, [
                                                'class' => 'form-control',
                                                'step' => '0.01',
                                                'id' =>'input-discount-value',
                                                //'onchange'=>'calculateNetPayableValueWithDiscountValue(this.value)',
                                                
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
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Number boxes returned') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('number_boxes_returned', 0, [
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
          $('#input-name').attr('required',true);
          
            // $('#addThirdParty').addClass('show'); 
            // $('#addThirdParty').css("display","block");
      });
jQuery(document).on('click', '#addTruckButton', function() {
          $('#addTruck').appendTo("body").modal('show');
          $('#input-registration').attr('required',true);

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
            $('#input-name').removeAttr('required');
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
            $('#input-registration').removeAttr('required');
        }
      },
      error: function(error) {
        console.log(error);
      }
});
});
      });
  </script>