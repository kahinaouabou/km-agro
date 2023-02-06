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
        <input class="form-control{{ $errors->has('reference') ? ' is-invalid' : '' }}" name="reference" id="input-reference" type="text" placeholder="{{ __('Reference') }}" required="true" aria-required="true" />
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
        <select class="form-control{{ $errors->has('product_id') ? ' is-invalid' : '' }}" name="product_id" id="input-product" type="select" placeholder="{{ __('Product') }}" required>
          <option value="">{{ __('Select product') }}</option>
          @foreach($products as $product)
          <option value="{{ $product->id }}">{{ $product->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <label class="col-sm-2 col-form-label">{{ __('Blocks') }}</label>
    <div class="col-sm-7">
      <div class="form-group{{ $errors->has('block_id') ? ' has-danger' : '' }}">
        <select class="form-control{{ $errors->has('block_id') ? ' is-invalid' : '' }}" name="block_id" id="input-block" type="select" placeholder="{{ __('block') }}" required>
          <option value="">{{ __('Select block') }}</option>
          @foreach($blocks as $block)
          <option value="{{ $block->id }}">{{ $block->name }}</option>
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
        <select class="form-control{{ $errors->has('third_party_id') ? ' is-invalid' : '' }}" name="third_party_id" id="input-third-party" type="select" required>
          <option value="">{{ __('Select customer') }}</option>
          @foreach($thirdParties as $thirdParty)
          <option value="{{ $thirdParty->id }}">{{ $thirdParty->name }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>
  <div class="row">
    <label class="col-sm-2 col-form-label">{{ __('Trucks') }}</label>
    <div class="col-sm-7">
      <div class="form-group{{ $errors->has('truck_id') ? ' has-danger' : '' }}">
        <select class="form-control{{ $errors->has('truck_id') ? ' is-invalid' : '' }}" name="truck_id" id="input-truck" type="select" placeholder="{{ __('truck') }}" required>
          <option value="">{{ __('Select truck') }}</option>
          @foreach($trucks as $truck)
          <option value="{{ $truck->id }}">{{ $truck->model }}</option>
          @endforeach
        </select>
      </div>
    </div>
  </div>

  <div class="row">
    <label class="col-sm-2 col-form-label">{{ __('Number boxes') }}</label>
    <div class="col-sm-7">
      <div class="form-group">
        {!! Form::number('number_boxes', null, [
        'class' => 'form-control',
        'step' => '0.1',
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
        'step' => '0.1',
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
        'step' => '0.1',
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
        'step' => '0.1',
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
        {!! Form::number('weight_discount_percentage', 0, [
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
        {!! Form::number('unit_price', null, [
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
        {!! Form::number('discount_value', 0, [
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
        {!! Form::number('net_payable', null, [
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
        {!! Form::number('number_boxes_returned', 0, [
        'class' => 'form-control',
        'step' => '0.1',
        'id' =>'input-number-boxes-returned',
        ]) !!}
      </div>
    </div>
  </div>

  {!! Form::number('bill_type', $type, [
  'hidden' => true
  ]) !!}
</div>