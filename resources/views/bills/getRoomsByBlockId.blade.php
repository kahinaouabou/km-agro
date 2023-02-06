<div class="row">
  <label class="col-sm-2 col-form-label">{{ __('Rooms') }}</label>
  <div class="col-sm-7">
    <div class="form-group">

      {!! Form::select('room_id', $rooms,null,
      [
      'class' => 'form-control',
      'placeholder'=> __('Select room') ,
      'id'=>'input-room'

      ]) !!}
    </div>
  </div>
</div>