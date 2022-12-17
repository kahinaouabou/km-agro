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
                      <input class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" 
                      value="{{ $nextReference }}"
                      name="reference" id="input-reference" type="text" placeholder="{{ __('Reference') }}" 
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
                  <label class="col-sm-2 col-form-label">{{ __('Number boxes') }}</label>
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
<script src="{{ asset('/js/jquery-3.4.1.min.js')}}" ></script>
<script type="text/javascript" src="{{ URL::asset('js/functions.js') }}"></script>
<script type="text/javascript">

  $(function () {
    $.ajaxSetup({
    headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
        });



jQuery("#add-third-party-button").click(function(e){

e.preventDefault(); //empêcher une action par défaut


let name = $('#input-name').val();
if(name.length!==0){
  let name = $('#input-name').val();
    let exist = false ;
    let url =  "{{ route('thirdParties.searchName') }}";
    $.ajax({
  url : url,
  type: 'get',
  headers: {
      'X-CSRF-TOKEN': '{{ csrf_token() }}'
    },
  data :{
      name:name,
  },
  success:function(response){
        if((response.thirdParty.length!==0)){
         $('#input-name').val('');
         $('#p-msg').html("<?php __('Name already exist, change it.')?>");
         exist = true ;
         console.log(exist);
        }else {
          $('#p-msg').html("");
          exist = false ;
          
          let is_supplier = $('#input-is-supplier').val();
          let is_subcontractor = $('#input-is-subcontractor').val();
          let address = $('#input-address').val();
          let phone = $('#input-phone').val();
          $.ajax({
            url : "{{ route('thirdParties.store') }}",
            type: 'post',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
            data :{
                name:name,
                address:address,
                phone:phone,
                is_supplier:is_supplier,
                is_subcontractor :is_subcontractor
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
        }
        console.log(exist);
      },
      error: function(error) {
        console.log(error);
      }
});

 

}

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