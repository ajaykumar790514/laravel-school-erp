<option {{ old('parent_id')==$child_category->id?"selected":""}} value="{{$child_category->id}}"><?php echo $flag.=$flag;?>{{ $child_category->name }}</option>
 @foreach ($child_category->children as $childCategory)
            @include('menu.child_menu', ['child_category' => $childCategory])
@endforeach