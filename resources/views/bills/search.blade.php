<div class="panel-group">
            <div class="panel panel-default">
            
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#search"><i class="material-icons">search</i>{{ __('Search') }}</a>
                </h4>
              </div>
              <div class="collapse " id="search">
                <form action="{{ route('bills',$type) }}" method="GET" style="margin-top: 20px;">
                
                <div class="card ">
                  
                    <div class="card-body ">
                      
                        <div class="col-sm-12">
                            <label class="col-sm-2 col-form-label col-form-label-filter">{{ __('Customers') }}</label>
                        
                            <div class="col-sm-3" style="display: inline-block;">
                              <div class="form-group">
                                <select name="third_party_id" id="input-third-party" class="form-control">
                                  <option value="0">{{ __('Select customer') }}</option>
                                  @foreach (\App\Models\ThirdParty::select('id','name')->where('is_supplier','=',App\Enums\ThirdPartyEnum::Customer)->get() as $thirdParty)
                                    <option value="{{ $thirdParty->id }}" {{ $thirdParty->id == $selected_id['third_party_id'] ? 'selected' : '' }}>
                                    {{ $thirdParty['name'] }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>	
                            
                          </div>	
                          
                          <div class="col-sm-12">
                            <label class="col-sm-2 col-form-label col-form-label-filter">{{ __('Date from') }}</label>
                        
                            <div class="col-sm-3" style="display: inline-block;">
                              <div class="form-group">
                              {!! Form::input('date','date_from', $selected_id['date_from']  ,
                                ['class' => 'form-control','id'=>'input-date-from']) !!}
                              </div>
                            </div>	
                            <label class="col-sm-2 col-form-label col-form-label-filter">{{ __('Date to') }}</label>
                        
                            <div class="col-sm-3" style="display: inline-block;">
                              <div class="form-group">
                              {!! Form::input('date','date_to',$selected_id['date_to'],
                                ['class' => 'form-control','id'=>'input-date-to']) !!}
                              </div>
                            </div>
                          </div>			   
                          
                    </div>
                    <div class="card-footer ml-auto mr-auto">
                            <input type="submit" id="btn-search" class="btn btn-danger btn-sm" value="{{ __('Filter') }}"> 
                    </div>
                    
                  
                </div>
                </form>
              </div>
            </div>
          </div>