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
                            <label class="col-sm-2 col-form-label col-form-label-filter">{{ __($page['third']) }}</label>
                        
                            <div class="col-sm-3" style="display: inline-block;">
                              <div class="form-group">
                                <select name="third_party_id" id="input-third-party-search" class="third-party-select2 form-control">
                                  
                                    
                                <option value="0">{{ __($page['selectThird']) }}</option>
                                  @foreach ($thirdParties as $thirdParty)
                                    <option value="{{ $thirdParty->id }}" {{ $thirdParty->id == $selected_id['third_party_id'] ? 'selected' : '' }}>
                                    {{ $thirdParty['name'] }}
                                  </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            @if($type == \App\Enums\BillTypeEnum::DeliveryBill)
                            <label class="col-sm-2 col-form-label col-form-label-filter" >{{ __('Drivers') }}</label>
                        
                            <div class="col-sm-3" style="display: inline-block;">
                              <div class="form-group">
                                <select name="driver_id" id="input-driver-search" class="driver-select2 form-control" >
                                  <option value="0">{{ __('Select driver') }}</option>
                                  @foreach (\App\Models\Driver::select('id','name')->get() as $driver)
                                  
                                    <option value="{{ $driver->id }}" {{ $driver->id == $selected_id['driver_id'] ? 'selected' : '' }}>
                                    {{ $driver['name'] }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                            @endif
                     </div>	
                      @if($type != \App\Enums\BillTypeEnum::DeliveryBill)	
                        <div class="col-sm-12">
                            <label class="col-sm-2 col-form-label col-form-label-filter">{{ __('Blocks') }}</label>
                        
                            <div class="col-sm-3" style="display: inline-block;">
                              <div class="form-group">
                                <select name="block_id" id="input-block-search" class="room-select2 form-control" multiple onchange="getRoomsByBlock()">
                                  <option value="0">{{ __('Select block') }}</option>
                                  @foreach (\App\Models\Block::select('id','name')->get() as $block)
                                    <option value="{{ $block->id }}" {{ $block->id == $selected_id['block_id'] ? 'selected' : '' }}>
                                    {{ $block['name'] }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>

                            <label class="col-sm-2 col-form-label col-form-label-filter">{{ __('Rooms') }}</label>
                        
                            <div class="col-sm-3" style="display: inline-block;">
                              <div class="form-group">
                                <select name="room_id" id="input-room-search" class="room-select2 form-control" multiple>
                                  <option value="0">{{ __('Select room') }}</option>
                                  <!-- @foreach (\App\Models\Room::select('id','name')->get() as $room)
                                    <option value="{{ $room->id }}" {{ $room->id == $selected_id['room_id'] ? 'selected' : '' }}>
                                    {{ $room['name'] }}
                                    </option>
                                  @endforeach -->
                                </select>
                              </div>
                            </div>
                            
                        </div>
                      @endif  
                        
                        @if($type == \App\Enums\BillTypeEnum::ExitBill)	
                        <div class="col-sm-12">
                            <label class="col-sm-2 col-form-label col-form-label-filter">{{ __('Net remaining') }}</label>
                            <?php $netRemainingConditions = ['='=>' = 0 ', '>'=>' > 0 ']; ?>
                           
                            <div class="col-sm-3" style="display: inline-block;">
                              <div class="form-group">
                                <select name="net_remaining" id="input-net-remaining-search" class=" form-control">
                                  <option value="0">{{ __('Select Net') }}</option>
                                  @foreach ($netRemainingConditions as $key=>$value)
                                    <option value="{{ $key }}" {{ $key == $selected_id['net_remaining'] ? 'selected' : '' }}>
                                    {{ $value }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                          </div>
                          @endif
                          
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