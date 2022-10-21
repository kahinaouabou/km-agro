<div class="modal" id="addTruck">
  <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="modal-title">{{__("Add registration")}}</h4>
                <button type="button" class="close quick-close" data-dismiss="modal">
                <span>&times;</span>
                </button>            
            </div>
            <form id="add-truck-form"   autocomplete="off" class="form-horizontal">
          
                <div class="modal-body">
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Registration') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('registration') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('registration') ? ' is-invalid' : '' }}" name="registration" id="input-registration" type="text" placeholder="{{ __('Registration') }}" required="true" aria-required="true"/>
                      @if ($errors->has('registration'))
                        <span id="registration-error" class="error text-danger" for="input-registration">{{ $errors->first('registration') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Model') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('model') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('model') ? ' is-invalid' : '' }}" name="model" id="input-model" type="text" placeholder="{{ __('Model') }}"   aria-required="true"/>
                      @if ($errors->has('model'))
                        <span id="model-error" class="error text-danger" for="input-model">{{ $errors->first('model') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Tare') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                    {!! Form::number('tare', null, [
                                                    'class' => 'form-control',
                                                    'id'=>'input-tare-truck',
                                                    'step' => '0.1',
                                                    ]) !!}
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Marks') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('mark_id') ? ' has-danger' : '' }}">
                      <select class="form-control{{ $errors->has('mark_id') ? ' is-invalid' : '' }}" name="mark_id" id="input-mark" type="select" placeholder="{{ __('Mark') }}" required >
                      <option value="">{{ __('Select mark') }}</option>
                        @foreach(\App\Models\Mark::select('id','name')->get() as $mark)
                        <option value="{{ $mark->id }}" >{{ $mark->name }}</option>
                        @endforeach
                    </select>
                    </div>
                  </div>
                </div>
                
            
                </div>
                <div class="modal-footer">
                    <button type="button" id="add-truck-button" class="btn btn-primary">{{ __('Save') }}</button>
                    <button type="button" class="btn btn-default btn-close quick-close" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </form>
        </div>
  </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
  
  jQuery(document).on('click', '.quick-close', function() {
        $('#addTruck').removeClass('show'); 
        $('#addTruck').css("display","none");
  });
 

});
</script> 