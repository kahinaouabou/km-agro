<div class="row">
  <label class="col-sm-2 col-form-label">{{ __('Varieties') }}</label>
  <div class="col-sm-7">
    <div class="form-group">

      {!! Form::select('variety_id', $varieties,null,
      [
      'class' => 'form-control',
      'placeholder'=> __('Select variety') ,
      'id'=>'input-variety'

      ]) !!}
    </div>
  </div>
</div>