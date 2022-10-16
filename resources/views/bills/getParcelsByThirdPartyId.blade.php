
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Parcels') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group">
                   
                    {!! Form::select('parcel_id', $parcels,null,
                      [
                        'class' => 'form-control',
                        'placeholder'=> __('Select parcel') ,
                        
                        ]) !!}
                    </div>
                  </div>
                </div>