@extends('layouts.admin-theme')
@section('content')

<script type="text/javascript" src="{{ asset('admin/js/jquery.nestable.js') }}"></script>
<div class="container-fluid">
  <h2><span>Menus</span></h2>

  <div class="content info-box">	
    @if(count($menus) > 0)		
	Select a menu to edit: 		
	<form action="{{url('manage-menus')}}" class="form-inline">
      <select name="id" class='form-control'>
		@foreach($menus as $menu)
	        @if($desiredMenu != '')
			<option value="{{$menu->id}}" @if($menu->id == $desiredMenu->id) selected @endif>{{$menu->title}}</option>
		  @else
			<option value="{{$menu->id}}">{{$menu->title}}</option>
		  @endif
		@endforeach
	  </select>
	  <button class="btn btn-sm btn-default btn-menu-select">Select</button>
	</form> 
	or <a href="{{url('manage-menus?id=new')}}">Create a new menu</a>.	
  @endif 	
    
  </div>

  <div class="row" id="main-row">				
	<div class="col-sm-3 cat-form @if(count($menus) == 0) disabled @endif">
      <h3><span>Add Menu Items</span></h3>			

	  <div class="panel-group" id="menu-items">
		<div class="panel panel-default">
	      <div class="panel-heading">
			<a href="#pages-list" data-toggle="collapse" data-parent="#menu-items">Pages <span class="caret pull-right"></span></a>
		  </div>
		  <div class="panel-collapse collapse in" id="pages-list">
		    <div class="panel-body">						
			  <div class="item-list-body">
				@foreach($pages as $page)
				  <p><input type="checkbox" name="select-pages[]" value="{{$page->id}}"> {{$page->page_title}}</p>
				@endforeach
			  </div>	
			  <div class="item-list-footer">
			    <label class="btn btn-sm btn-default"><input type="checkbox" id="select-all-pages"> Select All</label>
				  <button type="button" class="pull-right btn btn-default btn-sm" id="add-pages">Add to Menu</button>
			</div>
		  </div>						
		</div>
		<script>
		  $('#select-all-pages').click(function(event) {   
			if(this.checked) {
			  $('#pages-list :checkbox').each(function() {
			    this.checked = true;                        
			  });
			}else{
			  $('#pages-list :checkbox').each(function() {
			    this.checked = false;                        
			  });
			}
		  });
		</script>
	  </div>
	    <div class="panel panel-default">
    	    <div class="panel-heading">
    		  <a href="#events-list" data-toggle="collapse" data-parent="#menu-items">Events <span class="caret pull-right"></span></a>
    		</div>
    		<div class="panel-collapse collapse" id="events-list">
    		  <div class="panel-body">						
    			<div class="item-list-body">
    			  @foreach($events as $event)
    				<p><input type="checkbox" name="select-event[]" value="{{$event->id}}"> {{$event->note}}</p>
    			  @endforeach
    			</div>	
    			<div class="item-list-footer">
    			  <label class="btn btn-sm btn-default"><input type="checkbox" id="select-all-event"> Select All</label>
    			  <button type="button" id="add-event" class="pull-right btn btn-default btn-sm">Add to Menu</button>
    			</div>
    		  </div>						
    		</div>
    		<script>
    		  $('#select-all-event').click(function(event) {   
    		    if(this.checked) {
    			  $('#events-list :checkbox').each(function() {
    				this.checked = true;                        
    			  });
    			}else{
    			  $('#events-list :checkbox').each(function() {
    				this.checked = false;                        
    			  });
    			}
    		  });
    		</script>
	  </div>
	    <div class="panel panel-default">
	        <div class="panel-heading">
    		  <a href="#notice-list" data-toggle="collapse" data-parent="#menu-items">Notices <span class="caret pull-right"></span></a>
    		</div>
		    <div class="panel-collapse collapse" id="notice-list">
		  <div class="panel-body">						
			<div class="item-list-body">
			  @foreach($notices  as $notice)
				<p><input type="checkbox" name="select-notice[]" value="{{$notice->id}}"> {{$notice->title}}</p>
			  @endforeach
			</div>	
			<div class="item-list-footer">
			  <label class="btn btn-sm btn-default"><input type="checkbox" id="select-all-notice"> Select All</label>
			  <button type="button" id="add-notice" class="pull-right btn btn-default btn-sm">Add to Menu</button>
			</div>
		  </div>						
		</div>
		    <script>
        		  $('#select-all-notice').click(function(event) {   
        		    if(this.checked) {
        			  $('#notice-list :checkbox').each(function() {
        				this.checked = true;                        
        			  });
        			}else{
        			  $('#notice-list :checkbox').each(function() {
        				this.checked = false;                        
        			  });
        			}
        		  });
		    </script>
	    </div>
	  <div class="panel panel-default">
		<div class="panel-heading">
	      <a href="#custom-links" data-toggle="collapse" data-parent="#menu-items">Custom Links <span class="caret pull-right"></span></a>
		</div>
		<div class="panel-collapse collapse" id="custom-links">
		  <div class="panel-body">						
			<div class="item-list-body">
			  <div class="form-group">
				<label>URL</label>
				<input type="url" id="url" class="form-control" placeholder="https://">
			  </div>
			  <div class="form-group">
				<label>Link Text</label>
			      <input type="text" id="linktext" class="form-control" placeholder="">
				</div>
			  </div>	
			  <div class="item-list-footer">
				<button type="button" class="pull-right btn btn-default btn-sm" id="add-custom-link">Add to Menu</button>
			  </div>
			</div>
		</div>
	 </div>
	  </div>		
	</div>		

	<div class="col-sm-9 cat-view">
        <h3><span>Menu Structure</span></h3>
        @if($desiredMenu == '')
          <h4>Create New Menu</h4>
          <form method="post" action="{{url('create-menu')}}">
            {{csrf_field()}}
            <div class="row">
              <div class="col-sm-12">
                <label>Name</label>
              </div>
              <div class="col-sm-6">
                <div class="form-group">							
                  <input type="text" name="title" class="form-control">
                </div>
              </div>
              <div class="col-sm-6 text-right">
                <button class="btn btn-sm btn-primary">Create Menu</button>
              </div>
            </div>
          </form>
        @else
        
          <div id="menu-content">
            <div style="min-height: 240px;" >
                <p>Select Pages, Enebts, Notice or add custom links to menus.</p>
                @if($desiredMenu != '')
                    <div class="dd" id="nestable">
                        <ol class="dd-list" id="menuitems">
                            @if(!empty($menuitems))
                               
                                @foreach($menuitems as $key=>$item)
                                   @php
                                      $menuitem = App\Models\Menuitems::where('id',$item->id)->first(); 
                                     
                                   @endphp
                                   @if(!empty($menuitem))
                                    <li data-id="{{$item->id}}" class='dd-item '>
                                        <a href="#collapse{{$item->id}}" class="pull-right" data-toggle="collapse"><i class="caret"></i></a>
                                        <div class="dd-handle">
                                            <span class="menu-item-bar"><i class="fa fa-arrows"></i>
                                                @if(empty($menuitem->name)) {{$menuitem->title}} @else {{$menuitem->name}} @endif 
                                            </span>
                                        </div> 
                                        <div class="collapse" id="collapse{{$item->id}}">
                                                <div class="input-box">
                                                    <form method="post" action="{{url('update-menuitem')}}/{{$item->id}}">
                                                        {{csrf_field()}}
                                                        <div class="form-group">
                                                        <label>Link Name</label>
                                                        <input type="text" name="name" value="@if(empty($menuitem->name)) {{$menuitem->title}} @else {{$menuitem->name}} @endif" class="form-control">
                                                        </div>
                                                        @if($menuitem->type == 'custom')
                                                        <div class="form-group">
                                                            <label>URL</label>
                                                            <input type="text" name="slug" value="{{$menuitem->slug}}" class="form-control">
                                                        </div>					
                                                        <div class="form-group">
                                                            <input type="checkbox" name="target" value="_blank" @if($menuitem->target == '_blank') checked @endif> Open in a new tab
                                                        </div>
                                                        @endif
                                                        <div class="form-group">
                                                        <button class="btn btn-sm btn-primary">Save</button>
                                                        <a href="{{url('delete-menuitem')}}/{{$item->id}}/{{$key}}" class="btn btn-sm btn-danger">Delete</a>
                                                        </div>
                                                    </form>
                                                </div>
                                        </div>
                                        @if(isset($item->children))
                                        <ol class="dd-list">
                                            @foreach($item->children as $key=>$child)
                                                @include('menumanagge.child', ['child' => $child, 'key'=>$key])
                                            @endforeach
                                        </ol>
                                        @endif
                                    </li>
                                   @endif
                                @endforeach
                            @endif
                  </ol>	
                    </div>
                @endif	
              </div>
            @if($desiredMenu != '')
            <div class="col-sm-9 cat-view">
              <div class="form-group menulocation">
                <label><h3>Menu Location</h3></label>
                <label><input type="radio" name="location" value="1" @if($desiredMenu->location == 1) checked @endif> Main Navigation</label>
               
              </div>									
              <div class="text-right">
                <button class="btn btn-sm btn-primary" id="saveMenu">Save Menu</button>
              </div>
              <p><a href="{{url('delete-menu')}}/{{$desiredMenu->id}}">Delete Menu</a></p>
            </div>
            @endif										
          </div>
        @endif	
      </div>
  </div>
</div>
<textarea id="nestable-output">@if($desiredMenu){{$desiredMenu->content}}@endif</textarea>

<style type="text/css">
    #nestable-output{display: none;}
  

.dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
.dd-list .dd-list { padding-left:30px; }

.dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }

.dd-handle { display: block; height:30px; margin: 5px 0; padding: 5px 10px; color: #333; 
    text-decoration: none; font-weight: bold; border: 1px solid #ccc;
    background: #fafafa;
    background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
    background:         linear-gradient(top, #fafafa 0%, #eee 100%);
    -webkit-border-radius: 3px;
            border-radius: 3px;
    box-sizing: border-box; -moz-box-sizing: border-box;
}
.dd-handle:hover { color: #2ea8e5; background: #fff; }

.dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
.dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
.dd-item > button[data-action="collapse"]:before { content: '-'; }

.dd-placeholder,
.dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
.dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
    background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                      -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                         -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
                              linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
    background-size: 60px 60px;
    background-position: 0 0, 30px 30px;
}

.dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
.dd-dragel > .dd-item .dd-handle { margin-top: 0; }
.dd-dragel .dd-handle {
    -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
            box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
}

@media only screen and (min-width: 700px) {

    .dd { float: left; width: 48%; }
    .dd + .dd { margin-left: 2%; }

}

.dd-hover > .dd-handle { background: #2ea8e5 !important; }
    
    
    item-list,.info-box{background: #fff;padding: 10px;}
  .item-list-body{max-height: 300px;overflow-y: scroll;}
  .panel-body p{margin-bottom: 5px;}
  .info-box{margin-bottom: 15px;}
  .form-inline{display: inline;}
  
  
  .menulocation label{font-weight: normal;display: block;}
  
  .input-box{width:75%;background:#fff;padding: 10px;box-sizing: border-box;margin-bottom: 5px;}
  .input-box .form-control{width: 50%}
    
        </style>
@if($desiredMenu)
<script>
$('#add-pages').click(function(){
  var menuid = <?=$desiredMenu->id?>;
  var n = $('input[name="select-pages[]"]:checked').length;
  var array = $('input[name="select-pages[]"]:checked');
  var ids = [];
  for(i=0;i<n;i++){
    ids[i] =  array.eq(i).val();
  }
  if(ids.length == 0){
	return false;
  }
  $.ajax({
	type:"get",
	data: {menuid:menuid,ids:ids},
	url: "{{url('add-pages-to-menu')}}",				
	success:function(res){				
      location.reload();
	}
  })
})

    $('#add-event').click(function(){
      var menuid = <?=$desiredMenu->id?>;
      var n = $('input[name="select-event[]"]:checked').length;
      var array = $('input[name="select-event[]"]:checked');
      var ids = [];
      for(i=0;i<n;i++){
        ids[i] =  array.eq(i).val();
      }
      if(ids.length == 0){
    	return false;
      }
      $.ajax({
    	type:"get",
    	data: {menuid:menuid,ids:ids},
    	url: "{{url('add-event-to-menu')}}",				
    	success:function(res){	
          location.reload();
    	}
      })
    })

    $('#add-notice').click(function(){
      var menuid = <?=$desiredMenu->id?>;
      var n = $('input[name="select-notice[]"]:checked').length;
      var array = $('input[name="select-notice[]"]:checked');
      var ids = [];
      for(i=0;i<n;i++){
    	ids[i] =  array.eq(i).val();
      }
      if(ids.length == 0){
    	return false;
      }
      $.ajax({
    	type:"get",
    	data: {menuid:menuid,ids:ids},
    	url: "{{url('add-notice-to-menu')}}",				
    	success:function(res){
      	  location.reload();
    	}
      })
    })

$("#add-custom-link").click(function(){
  var menuid = <?=$desiredMenu->id?>;
  var url = $('#url').val();
  var link = $('#linktext').val();
  if(url.length > 0 && link.length > 0){
	$.ajax({
	  type:"get",
	  data: {menuid:menuid,url:url,link:link},
	  url: "{{url('add-custom-link')}}",				
	  success:function(res){
	    location.reload();
	  }
	})
  }
})


    $(document).ready(function(){
        var updateOutput = function(e) {
            var list   = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
            } else {
                output.val('JSON browser support required for this demo.');
            }
        };
        

    // activate Nestable for list 1
    $('#nestable').nestable({
        group: 1
    }).on('change', updateOutput);
        // output initial serialised data
        updateOutput($('#nestable').data('output', $('#nestable-output')));
    });

</script>
@endif
@if($desiredMenu)	
<script>
$('#saveMenu').click(function(){
  var menuid = <?=$desiredMenu->id?>;
  var location = $('input[name="location"]:checked').val();
  var newText = $("#nestable-output").val();
  var data = JSON.parse(newText);	
  //alert(data); //return;
  $.ajax({
    type:"get",
	data: {menuid:menuid,data:data,location:location},
	url: "{{url('update-menu')}}",				
	success:function(res){
	  window.location.reload();
	}
  })	
})
</script>	
@endif
@endsection