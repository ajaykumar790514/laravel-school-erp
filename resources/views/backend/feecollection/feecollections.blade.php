@extends('layouts.admin-theme')
@section('content')
<style>
    input[type="checkbox"][readonly] {
  pointer-events: none;
}
</style>
    <!-- Page header -->
    <div class="page-header page-header-default">
          <div class="page-header-content">
            <div class="page-title">
              <h4><i class="icon-arrow-left52 position-left"></i> <span class="text-semibold">Fees Module </span> ->Menu->Fee Collection</h4>
            </div>
          </div>
    </div>
    <!-- /page header -->
    <!-- Content area -->
    <div class="content">
        <!-- 2 columns form -->
        <div class="panel panel-flat">
                @include('layouts.massage') 
                 @include('layouts.validation-error') 
                <div class="panel-heading">
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                            <li><a data-action="close"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <fieldset>
                                <div class="form-group{{ $errors->has('session_id') ? ' has-error' : '' }}">
                                    <label class"text-semibold">Student Name/Roll No.</label>
                                    <h6 class"text-semibold">{{$data->student_name}}/{{$data->roll_no}}</h6>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-md-3">
                            <fieldset>
                               <div class="form-group{{ $errors->has('class_maping_id') ? ' has-error' : '' }}">
                                <label>Session</label>
                                 <h6>{{$data->session_name}}</h6>
                              </div>
                            </fieldset>
                        </div>
                        <div class="col-md-3">
                            <fieldset>
                               <div class="form-group{{ $errors->has('section_id') ? ' has-error' : '' }}">
                                <label>Class</label>
                                <h6>{{$data->class_name}}</h6>
                              </div>
                            </fieldset>
                        </div>
                        <div class="col-md-3">
                            <fieldset>
                               <div class="form-group{{ $errors->has('section_id') ? ' has-error' : '' }}">
                                <label>Section</label>
                                <h6>{{$data->section_name}}</h6>
                              </div>
                            </fieldset>
                        </div>
                        <div class="col-md-12">
                             <?php $feecollection= getFeeCollectionWithoutPayment($data->id , $data->SessionID, $data->classId, $data->sectionId);?>
                            
                              @if(count($feecollection)>0)
                                <?php $feeAmt=0; ?>
                                 @foreach($feecollection as $feeCollectionDetails)
                                   <?php $feeAmt=$feeAmt+$feeCollectionDetails->amount; ?>
                                 @endforeach
                                <h2>Total Amount Due: Rs. {{$feeAmt}} <br>
                                @can('fee-invoice') 
                                    <a class="btn btn-primary" href='{{ url("fee-invoice/{$studentClassAllotment}")}}'>Generate Invoice</a></h2>
                                @endcan
                              @endif
                        </div>
                        
                    </div>
                </div>
            </div>
            
        <div class="panel panel-flat">
                <div class="panel-heading">
                    <div class="heading-elements">
                        <ul class="icons-list">
                            <li><a data-action="collapse"></a></li>
                            <li><a data-action="close"></a></li>
                        </ul>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form class="" method="POST" action="{{ url('addCollectionInInvoice')}}" >
                                {{ csrf_field() }}
                                <div class="col-md-3 ">
                                    <div class="panel 
                                    <?php
                                        if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '4')>0){
                                            echo "panel-success ";
                                        } else{
                                            echo "panel-warning ";
                                        }
                                    ?>
                                     panel-bordered">
                                        
    								<div class="panel-heading">
    									<h6 class="panel-title">April-{{$data->session_name}}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
    									<input type="hidden" name="monthName" id="monthName" value="4"> 
    									<input type="hidden" name="stdClassAltId" id="stdClassAltId" value="{{$studentClassAllotment}}"> 
    									<div class="heading-elements">
    										<ul class="icons-list">
    					                		<li><a data-action="collapse"></a></li>
    					                	</ul>
    				                	</div>
    								</div>
    								<div class="panel-body">
    									<ul class="list-unstyled">
                                      @foreach($feeHead as $feehead)
                                            <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                @if($feehead->is_compulsory==0)
                                                <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                    <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                    {{ $feehead->is_compulsory==0?"checked  readonly ":""}} >
                                                    {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                </li>
                                                @else
                                                    <li class="">
                                                        <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                        <?php if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '4')>0) { ?>
                                                                {{getFeeCollectionFeeHeadAmtId($data->id , $data->SessionID, $data->classId, $data->sectionId, '4', $feehead->id)>0?"checked":""}}
                                                        <?php  } ?>
                                                        >
                                                        {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                    </li>
                                                @endif
                                            </li>
                                      @endforeach
                                    </ul>
                                             @if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '4')>0)
                                                <?php $checkPayment=checkMonthlyPayment($data->id , $data->SessionID, $data->classId, $data->sectionId, '4');?>
                                                 @if($checkPayment->payment_status==1)
                                                     <p>Paid</p>
                                                    @else
                                                        <h6>Added in Invoice</h6>
                                                        <a href='{{url("removeFeeSession/{$data->id}/4/{$data->SessionID}")}}' class="btn btn-danger btn-xs">Remove</a>
                                                    @endif
                                                    
                                                
                                            @else
                                            <button type="submit" class="btn btn-primary">Add to Invoice</button>
                                            @endif
                                    
    								</div>
    							</div>
                            </div>
                            </form> 
                            <form class="" method="POST" action="{{ url('addCollectionInInvoice')}}" >
                                {{ csrf_field() }}
                                <div class="col-md-3 ">
                                    <div class="panel 
                                    <?php
                                        if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '5')>0){
                                            echo "panel-success ";
                                        } else{
                                            echo "panel-warning ";
                                        }
                                    ?>
                                     panel-bordered">
                                        
    								<div class="panel-heading">
    									<h6 class="panel-title">May-{{$data->session_name}}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
    									<input type="hidden" name="monthName" id="monthName" value="5"> 
    									<input type="hidden" name="stdClassAltId" id="stdClassAltId" value="{{$studentClassAllotment}}"> 
    									<div class="heading-elements">
    										<ul class="icons-list">
    					                		<li><a data-action="collapse"></a></li>
    					                	</ul>
    				                	</div>
    								</div>
    								<div class="panel-body">
    									<ul class="list-unstyled">
                                      @foreach($feeHead as $feehead)
                                            <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                @if($feehead->is_compulsory==0)
                                                <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                    <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                    {{ $feehead->is_compulsory==0?"checked  readonly ":""}} >
                                                    {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                </li>
                                                @else
                                                    <li class="">
                                                        <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                        <?php if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '5')>0) { ?>
                                                                {{getFeeCollectionFeeHeadAmtId($data->id , $data->SessionID, $data->classId, $data->sectionId, '5', $feehead->id)>0?"checked":""}}
                                                        <?php  } ?>
                                                        >
                                                        {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                    </li>
                                                @endif
                                            </li>
                                      @endforeach
                                    </ul>
                                    
                                            @if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '5')>0)
                                                <?php $checkPayment=checkMonthlyPayment($data->id , $data->SessionID, $data->classId, $data->sectionId, '5');?>
                                                 @if($checkPayment->payment_status==1)
                                                     <p>Paid</p>
                                                    @else
                                                        <h6>Added in Invoice</h6>
                                                        <a href='{{url("removeFeeSession/{$data->id}/5/{$data->SessionID}")}}' class="btn btn-danger btn-xs">Remove</a>
                                                    @endif
                                            @else
                                            <button type="submit" class="btn btn-primary">Add to Invoice</button>
                                            @endif
    								</div>
    							</div>
                            </div>
                            </form>  
                            <form class="" method="POST" action="{{ url('addCollectionInInvoice')}}" >
                                {{ csrf_field() }}
                                <div class="col-md-3 ">
                                    <div class="panel 
                                    <?php
                                        if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '6')>0){
                                            echo "panel-success ";
                                        } else{
                                            echo "panel-warning ";
                                        }
                                    ?>
                                     panel-bordered">
                                        
    								<div class="panel-heading">
    									<h6 class="panel-title">June-{{$data->session_name}}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
    									<input type="hidden" name="monthName" id="monthName" value="6"> 
    									<input type="hidden" name="stdClassAltId" id="stdClassAltId" value="{{$studentClassAllotment}}"> 
    									<div class="heading-elements">
    										<ul class="icons-list">
    					                		<li><a data-action="collapse"></a></li>
    					                	</ul>
    				                	</div>
    								</div>
    								<div class="panel-body">
    									<ul class="list-unstyled">
                                      @foreach($feeHead as $feehead)
                                            <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                @if($feehead->is_compulsory==0)
                                                <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                    <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                    {{ $feehead->is_compulsory==0?"checked  readonly ":""}} >
                                                    {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                </li>
                                                @else
                                                    <li class="">
                                                        <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                        <?php if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '6')>0) { ?>
                                                                {{getFeeCollectionFeeHeadAmtId($data->id , $data->SessionID, $data->classId, $data->sectionId, '6', $feehead->id)>0?"checked":""}}
                                                        <?php  } ?>
                                                        >
                                                        {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                    </li>
                                                @endif
                                            </li>
                                      @endforeach
                                    </ul>
                                    @if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '6')>0)
                                                <?php $checkPayment=checkMonthlyPayment($data->id , $data->SessionID, $data->classId, $data->sectionId, '6');?>
                                                 @if($checkPayment->payment_status==1)
                                                     <p>Paid</p>
                                                    @else
                                                        <h6>Added in Invoice</h6>
                                                        <a href='{{url("removeFeeSession/{$data->id}/6/{$data->SessionID}")}}' class="btn btn-danger btn-xs">Remove</a>
                                                    @endif
                                                    
                                                
                                            @else
                                            <button type="submit" class="btn btn-primary">Add to Invoice</button>
                                            @endif
    								</div>
    							</div>
                            </div>
                            </form>  
                            <form class="" method="POST" action="{{ url('addCollectionInInvoice')}}" >
                                {{ csrf_field() }}
                                <div class="col-md-3 ">
                                    <div class="panel 
                                    <?php
                                        if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '7')>0){
                                            echo "panel-success ";
                                        } else{
                                            echo "panel-warning ";
                                        }
                                    ?>
                                     panel-bordered">
                                        
    								<div class="panel-heading">
    									<h6 class="panel-title">July-{{$data->session_name}}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
    									<input type="hidden" name="monthName" id="monthName" value="7"> 
    									<input type="hidden" name="stdClassAltId" id="stdClassAltId" value="{{$studentClassAllotment}}"> 
    									<div class="heading-elements">
    										<ul class="icons-list">
    					                		<li><a data-action="collapse"></a></li>
    					                	</ul>
    				                	</div>
    								</div>
    								<div class="panel-body">
    									<ul class="list-unstyled">
                                      @foreach($feeHead as $feehead)
                                            <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                @if($feehead->is_compulsory==0)
                                                <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                    <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                    {{ $feehead->is_compulsory==0?"checked  readonly ":""}} >
                                                    {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                </li>
                                                @else
                                                    <li class="">
                                                        <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                        <?php if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '7')>0) { ?>
                                                                {{getFeeCollectionFeeHeadAmtId($data->id , $data->SessionID, $data->classId, $data->sectionId, '7', $feehead->id)>0?"checked":""}}
                                                        <?php  } ?>
                                                        >
                                                        {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                    </li>
                                                @endif
                                            </li>
                                      @endforeach
                                    </ul>
                                     @if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '7')>0)
                                                <?php $checkPayment=checkMonthlyPayment($data->id , $data->SessionID, $data->classId, $data->sectionId, '7');?>
                                                 @if($checkPayment->payment_status==1)
                                                     <p>Paid</p>
                                                    @else
                                                        <h6>Added in Invoice</h6>
                                                        <a href='{{url("removeFeeSession/{$data->id}/7/{$data->SessionID}")}}' class="btn btn-danger btn-xs">Remove</a>
                                                    @endif
                                                    
                                                
                                            @else
                                            <button type="submit" class="btn btn-primary">Add to Invoice</button>
                                            @endif
    								</div>
    							</div>
                            </div>
                            </form>  
                        </div>
                        <div class="col-md-12">
                            <form class="" method="POST" action="{{ url('addCollectionInInvoice')}}" >
                                {{ csrf_field() }}
                                <div class="col-md-3 " style="margin-bottom:50px">
                                    <div class="panel 
                                    <?php
                                        if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '8')>0){
                                            echo "panel-success ";
                                        } else{
                                            echo "panel-warning ";
                                        }
                                    ?>
                                     panel-bordered">
                                        
    								<div class="panel-heading">
    									<h6 class="panel-title">Aug-{{$data->session_name}}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
    									<input type="hidden" name="monthName" id="monthName" value="8"> 
    									<input type="hidden" name="stdClassAltId" id="stdClassAltId" value="{{$studentClassAllotment}}"> 
    									<div class="heading-elements">
    										<ul class="icons-list">
    					                		<li><a data-action="collapse"></a></li>
    					                	</ul>
    				                	</div>
    								</div>
    								<div class="panel-body">
    									<ul class="list-unstyled">
                                      @foreach($feeHead as $feehead)
                                            <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                @if($feehead->is_compulsory==0)
                                                <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                    <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                    {{ $feehead->is_compulsory==0?"checked  readonly ":""}} >
                                                    {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                </li>
                                                @else
                                                    <li class="">
                                                        <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                        <?php if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '8')>0) { ?>
                                                                {{getFeeCollectionFeeHeadAmtId($data->id , $data->SessionID, $data->classId, $data->sectionId, '8', $feehead->id)>0?"checked":""}}
                                                        <?php  } ?>
                                                        >
                                                        {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                    </li>
                                                @endif
                                            </li>
                                      @endforeach
                                    </ul>
                                   @if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '8')>0)
                                                <?php $checkPayment=checkMonthlyPayment($data->id , $data->SessionID, $data->classId, $data->sectionId, '8');?>
                                                 @if($checkPayment->payment_status==1)
                                                     <p>Paid</p>
                                                    @else
                                                        <h6>Added in Invoice</h6>
                                                        <a href='{{url("removeFeeSession/{$data->id}/8/{$data->SessionID}")}}' class="btn btn-danger btn-xs">Remove</a>
                                                    @endif
                                                    
                                                
                                            @else
                                            <button type="submit" class="btn btn-primary">Add to Invoice</button>
                                            @endif
    								</div>
    							</div>
                            </div>
                            </form> 
                            <form class="" method="POST" action="{{ url('addCollectionInInvoice')}}" >
                                {{ csrf_field() }}
                                <div class="col-md-3 " style="margin-bottom:50px">
                                    <div class="panel 
                                    <?php
                                        if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '9')>0){
                                            echo "panel-success ";
                                        } else{
                                            echo "panel-warning ";
                                        }
                                    ?>
                                     panel-bordered">
                                        
    								<div class="panel-heading">
    									<h6 class="panel-title">Sep-{{$data->session_name}}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
    									<input type="hidden" name="monthName" id="monthName" value="9"> 
    									<input type="hidden" name="stdClassAltId" id="stdClassAltId" value="{{$studentClassAllotment}}"> 
    									<div class="heading-elements">
    										<ul class="icons-list">
    					                		<li><a data-action="collapse"></a></li>
    					                	</ul>
    				                	</div>
    								</div>
    								<div class="panel-body">
    									<ul class="list-unstyled">
                                      @foreach($feeHead as $feehead)
                                            <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                @if($feehead->is_compulsory==0)
                                                <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                    <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                    {{ $feehead->is_compulsory==0?"checked  readonly ":""}} >
                                                    {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                </li>
                                                @else
                                                    <li class="">
                                                        <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                        <?php if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '9')>0) { ?>
                                                                {{getFeeCollectionFeeHeadAmtId($data->id , $data->SessionID, $data->classId, $data->sectionId, '9', $feehead->id)>0?"checked":""}}
                                                        <?php  } ?>
                                                        >
                                                        {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                    </li>
                                                @endif
                                            </li>
                                      @endforeach
                                    </ul>
                                    @if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '9')>0)
                                                <?php $checkPayment=checkMonthlyPayment($data->id , $data->SessionID, $data->classId, $data->sectionId, '9');?>
                                                 @if($checkPayment->payment_status==1)
                                                     <p>Paid</p>
                                                    @else
                                                        <h6>Added in Invoice</h6>
                                                        <a href='{{url("removeFeeSession/{$data->id}/9/{$data->SessionID}")}}' class="btn btn-danger btn-xs">Remove</a>
                                                    @endif
                                                    
                                                
                                            @else
                                            <button type="submit" class="btn btn-primary">Add to Invoice</button>
                                            @endif
    								</div>
    							</div>
                            </div>
                            </form> 
                            <form class="" method="POST" action="{{ url('addCollectionInInvoice')}}" >
                                {{ csrf_field() }}
                                <div class="col-md-3 " style="margin-bottom:50px">
                                    <div class="panel 
                                    <?php
                                        if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '10')>0){
                                            echo "panel-success ";
                                        } else{
                                            echo "panel-warning ";
                                        }
                                    ?>
                                     panel-bordered">
                                        
    								<div class="panel-heading">
    									<h6 class="panel-title">Oct-{{$data->session_name}}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
    									<input type="hidden" name="monthName" id="monthName" value="10"> 
    									<input type="hidden" name="stdClassAltId" id="stdClassAltId" value="{{$studentClassAllotment}}"> 
    									<div class="heading-elements">
    										<ul class="icons-list">
    					                		<li><a data-action="collapse"></a></li>
    					                	</ul>
    				                	</div>
    								</div>
    								<div class="panel-body">
    									<ul class="list-unstyled">
                                      @foreach($feeHead as $feehead)
                                            <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                @if($feehead->is_compulsory==0)
                                                <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                    <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                    {{ $feehead->is_compulsory==0?"checked  readonly ":""}} >
                                                    {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                </li>
                                                @else
                                                    <li class="">
                                                        <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                        <?php if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '10')>0) { ?>
                                                                {{getFeeCollectionFeeHeadAmtId($data->id , $data->SessionID, $data->classId, $data->sectionId, '10', $feehead->id)>0?"checked":""}}
                                                        <?php  } ?>
                                                        >
                                                        {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                    </li>
                                                @endif
                                            </li>
                                      @endforeach
                                    </ul>
                                   @if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '10')>0)
                                                <?php $checkPayment=checkMonthlyPayment($data->id , $data->SessionID, $data->classId, $data->sectionId, '10');?>
                                                 @if($checkPayment->payment_status==1)
                                                     <p>Paid</p>
                                                    @else
                                                        <h6>Added in Invoice</h6>
                                                        <a href='{{url("removeFeeSession/{$data->id}/10/{$data->SessionID}")}}' class="btn btn-danger btn-xs">Remove</a>
                                                    @endif
                                                    
                                                
                                            @else
                                            <button type="submit" class="btn btn-primary">Add to Invoice</button>
                                            @endif
    								</div>
    							</div>
                            </div>
                            </form> 
                            <form class="" method="POST" action="{{ url('addCollectionInInvoice')}}" >
                                {{ csrf_field() }}
                                <div class="col-md-3 " style="margin-bottom:50px">
                                    <div class="panel 
                                    <?php
                                        if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '11')>0){
                                            echo "panel-success ";
                                        } else{
                                            echo "panel-warning ";
                                        }
                                    ?>
                                     panel-bordered">
                                        
    								<div class="panel-heading">
    									<h6 class="panel-title">Nov-{{$data->session_name}}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
    									<input type="hidden" name="monthName" id="monthName" value="11"> 
    									<input type="hidden" name="stdClassAltId" id="stdClassAltId" value="{{$studentClassAllotment}}"> 
    									<div class="heading-elements">
    										<ul class="icons-list">
    					                		<li><a data-action="collapse"></a></li>
    					                	</ul>
    				                	</div>
    								</div>
    								<div class="panel-body">
    									<ul class="list-unstyled">
                                      @foreach($feeHead as $feehead)
                                            <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                @if($feehead->is_compulsory==0)
                                                <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                    <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                    {{ $feehead->is_compulsory==0?"checked  readonly ":""}} >
                                                    {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                </li>
                                                @else
                                                    <li class="">
                                                        <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                        <?php if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '11')>0) { ?>
                                                                {{getFeeCollectionFeeHeadAmtId($data->id , $data->SessionID, $data->classId, $data->sectionId, '11', $feehead->id)>0?"checked":""}}
                                                        <?php  } ?>
                                                        >
                                                        {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                    </li>
                                                @endif
                                            </li>
                                      @endforeach
                                    </ul>
                                    @if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '11')>0)
                                                <?php $checkPayment=checkMonthlyPayment($data->id , $data->SessionID, $data->classId, $data->sectionId, '11');?>
                                                 @if($checkPayment->payment_status==1)
                                                     <p>Paid</p>
                                                    @else
                                                        <h6>Added in Invoice</h6>
                                                        <a href='{{url("removeFeeSession/{$data->id}/11/{$data->SessionID}")}}' class="btn btn-danger btn-xs">Remove</a>
                                                    @endif
                                                    
                                                
                                            @else
                                            <button type="submit" class="btn btn-primary">Add to Invoice</button>
                                            @endif
    								</div>
    							</div>
                            </div>
                            </form> 
                        </div>
                        <form class="" method="POST" action="{{ url('addCollectionInInvoice')}}" >
                            {{ csrf_field() }}
                            <div class="col-md-3 ">
                                <div class="panel 
                                <?php
                                    if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '12')>0){
                                        echo "panel-success ";
                                    } else{
                                        echo "panel-warning ";
                                    }
                                ?>
                                 panel-bordered">
                                    
								<div class="panel-heading">
									<h6 class="panel-title">Dec-{{$data->session_name}}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
									<input type="hidden" name="monthName" id="monthName" value="12"> 
									<input type="hidden" name="stdClassAltId" id="stdClassAltId" value="{{$studentClassAllotment}}"> 
									<div class="heading-elements">
										<ul class="icons-list">
					                		<li><a data-action="collapse"></a></li>
					                	</ul>
				                	</div>
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
                                  @foreach($feeHead as $feehead)
                                        <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                            @if($feehead->is_compulsory==0)
                                            <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                {{ $feehead->is_compulsory==0?"checked  readonly ":""}} >
                                                {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                            </li>
                                            @else
                                                <li class="">
                                                    <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                    <?php if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '12')>0) { ?>
                                                            {{getFeeCollectionFeeHeadAmtId($data->id , $data->SessionID, $data->classId, $data->sectionId, '12', $feehead->id)>0?"checked":""}}
                                                    <?php  } ?>
                                                    >
                                                    {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                </li>
                                            @endif
                                        </li>
                                  @endforeach
                                </ul>
                                @if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '12')>0)
                                                <?php $checkPayment=checkMonthlyPayment($data->id , $data->SessionID, $data->classId, $data->sectionId, '12');?>
                                                 @if($checkPayment->payment_status==1)
                                                     <p>Paid</p>
                                                    @else
                                                        <h6>Added in Invoice</h6>
                                                        <a href='{{url("removeFeeSession/{$data->id}/12/{$data->SessionID}")}}' class="btn btn-danger btn-xs">Remove</a>
                                                    @endif
                                                    
                                                
                                            @else
                                            <button type="submit" class="btn btn-primary">Add to Invoice</button>
                                            @endif
								</div>
							</div>
                        </div>
                        </form>
                        <form class="" method="POST" action="{{ url('addCollectionInInvoice')}}" >
                            {{ csrf_field() }}
                            <div class="col-md-3 ">
                                <div class="panel 
                                <?php
                                    if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '1')>0){
                                        echo "panel-success ";
                                    } else{
                                        echo "panel-warning ";
                                    }
                                ?>
                                 panel-bordered">
                                    
								<div class="panel-heading">
									<h6 class="panel-title">Jan-{{$data->session_name}}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
									<input type="hidden" name="monthName" id="monthName" value="1"> 
									<input type="hidden" name="stdClassAltId" id="stdClassAltId" value="{{$studentClassAllotment}}"> 
									<div class="heading-elements">
										<ul class="icons-list">
					                		<li><a data-action="collapse"></a></li>
					                	</ul>
				                	</div>
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
                                  @foreach($feeHead as $feehead)
                                        <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                            @if($feehead->is_compulsory==0)
                                            <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                {{ $feehead->is_compulsory==0?"checked  readonly ":""}} >
                                                {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                            </li>
                                            @else
                                                <li class="">
                                                    <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                    <?php if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '1')>0) { ?>
                                                            {{getFeeCollectionFeeHeadAmtId($data->id , $data->SessionID, $data->classId, $data->sectionId, '1', $feehead->id)>0?"checked":""}}
                                                    <?php  } ?>
                                                    >
                                                    {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                </li>
                                            @endif
                                        </li>
                                  @endforeach
                                </ul>
                                @if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '1')>0)
                                                <?php $checkPayment=checkMonthlyPayment($data->id , $data->SessionID, $data->classId, $data->sectionId, '1');?>
                                                 @if($checkPayment->payment_status==1)
                                                     <p>Paid</p>
                                                    @else
                                                        <h6>Added in Invoice</h6>
                                                        <a href='{{url("removeFeeSession/{$data->id}/1/{$data->SessionID}")}}' class="btn btn-danger btn-xs">Remove</a>
                                                    @endif
                                                    
                                                
                                            @else
                                            <button type="submit" class="btn btn-primary">Add to Invoice</button>
                                            @endif
								</div>
							</div>
                        </div>
                        </form>
                        <form class="" method="POST" action="{{ url('addCollectionInInvoice')}}" >
                            {{ csrf_field() }}
                            <div class="col-md-3 ">
                                <div class="panel 
                                <?php
                                    if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '2')>0){
                                        echo "panel-success ";
                                    } else{
                                        echo "panel-warning ";
                                    }
                                ?>
                                 panel-bordered">
                                    
								<div class="panel-heading">
									<h6 class="panel-title">Feb-{{$data->session_name}}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
									<input type="hidden" name="monthName" id="monthName" value="2"> 
									<input type="hidden" name="stdClassAltId" id="stdClassAltId" value="{{$studentClassAllotment}}"> 
									<div class="heading-elements">
										<ul class="icons-list">
					                		<li><a data-action="collapse"></a></li>
					                	</ul>
				                	</div>
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
                                  @foreach($feeHead as $feehead)
                                        <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                            @if($feehead->is_compulsory==0)
                                            <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                {{ $feehead->is_compulsory==0?"checked  readonly ":""}} >
                                                {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                            </li>
                                            @else
                                                <li class="">
                                                    <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                    <?php if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '2')>0) { ?>
                                                            {{getFeeCollectionFeeHeadAmtId($data->id , $data->SessionID, $data->classId, $data->sectionId, '2', $feehead->id)>0?"checked":""}}
                                                    <?php  } ?>
                                                    >
                                                    {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                </li>
                                            @endif
                                        </li>
                                  @endforeach
                                </ul>
                               @if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '2')>0)
                                                <?php $checkPayment=checkMonthlyPayment($data->id , $data->SessionID, $data->classId, $data->sectionId, '2');?>
                                                 @if($checkPayment->payment_status==1)
                                                     <p>Paid</p>
                                                    @else
                                                        <h6>Added in Invoice</h6>
                                                        <a href='{{url("removeFeeSession/{$data->id}/2/{$data->SessionID}")}}' class="btn btn-danger btn-xs">Remove</a>
                                                    @endif
                                                    
                                                
                                            @else
                                            <button type="submit" class="btn btn-primary">Add to Invoice</button>
                                            @endif
								</div>
							</div>
                        </div>
                        </form>
                        <form class="" method="POST" action="{{ url('addCollectionInInvoice')}}" >
                            {{ csrf_field() }}
                            <div class="col-md-3 ">
                                <div class="panel 
                                <?php
                                    if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '3')>0){
                                        echo "panel-success ";
                                    } else{
                                        echo "panel-warning ";
                                    }
                                ?>
                                 panel-bordered">
                                    
								<div class="panel-heading">
									<h6 class="panel-title">March-{{$data->session_name}}<a class="heading-elements-toggle"><i class="icon-more"></i></a></h6>
									<input type="hidden" name="monthName" id="monthName" value="3"> 
									<input type="hidden" name="stdClassAltId" id="stdClassAltId" value="{{$studentClassAllotment}}"> 
									<div class="heading-elements">
										<ul class="icons-list">
					                		<li><a data-action="collapse"></a></li>
					                	</ul>
				                	</div>
								</div>
								<div class="panel-body">
									<ul class="list-unstyled">
                                  @foreach($feeHead as $feehead)
                                        <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                            @if($feehead->is_compulsory==0)
                                            <li class="{{$feehead->is_compulsory==0?'text-semibold':''}}">
                                                <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                {{ $feehead->is_compulsory==0?"checked  readonly ":""}} >
                                                {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                            </li>
                                            @else
                                                <li class="">
                                                    <input class="" type="checkbox" value="{{$feehead->id}}" name="headId[]" id="headId" 
                                                    <?php if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '3')>0) { ?>
                                                            {{getFeeCollectionFeeHeadAmtId($data->id , $data->SessionID, $data->classId, $data->sectionId, '3', $feehead->id)>0?"checked":""}}
                                                    <?php  } ?>
                                                    >
                                                    {{$feehead->fee_head_name}} (Rs. {{$feehead->fee_amount}})
                                                </li>
                                            @endif
                                        </li>
                                  @endforeach
                                </ul>
                               @if(getFeeCollectionMonth($data->id , $data->SessionID, $data->classId, $data->sectionId, '3')>0)
                                                <?php $checkPayment=checkMonthlyPayment($data->id , $data->SessionID, $data->classId, $data->sectionId, '3');?>
                                                 @if($checkPayment->payment_status==1)
                                                     <p>Paid</p>
                                                    @else
                                                        <h6>Added in Invoice</h6>
                                                        <a href='{{url("removeFeeSession/{$data->id}/3/{$data->SessionID}")}}' class="btn btn-danger btn-xs">Remove</a>
                                                    @endif
                                                    
                                                
                                            @else
                                            <button type="submit" class="btn btn-primary">Add to Invoice</button>
                                            @endif
								</div>
							</div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
@endsection
@section('script')
    <!-- /page container -->
    <script type="text/javascript">
        
       
    </script>
@endsection
