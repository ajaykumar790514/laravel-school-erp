<li data-id="{{$child->id}}" class='dd-item'>
    @php
        $menuitem = App\Models\Menuitems::where('id',$child->id)->first(); 
    @endphp
    <a href="#collapse{{$child->id}}" class="pull-right" data-toggle="collapse"><i class="caret"></i></a></span>
    <div class="dd-handle">
        <span class="menu-item-bar"><i class="fa fa-arrows"></i>
       
            @if(empty($menuitem->name)) {{$menuitem->title}} @else {{$menuitem->name}} @endif 
       
     
    </div> 
    <div class="collapse" id="collapse{{$child->id}}">
                                    <div class="input-box">
                                    <form method="post" action="{{url('update-menuitem')}}/{{$child->id}}">
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
                                        <!--<a href="{{url('delete-menuitem')}}/{{$child->id}}/{{$key}}" class="btn btn-sm btn-danger">Delete</a>-->
                                        </div>
                                    </form>
                                    </div>
                            </div>
    @if(isset($child->children))
    <ol class="dd-list">
        @foreach($child->children as $key=>$childs)
            @include('menumanagge.child', ['child' => $childs, 'key'=>$key])
        @endforeach
    </ol>
    @endif                        
</li>