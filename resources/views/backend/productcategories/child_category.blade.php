<option {{ old('parent_id')==$child_category->id?"selected":""}} value="{{$child_category->id}}"><?php echo $flag.=$flag;?>{{ $child_category->title }}</option>
 @foreach ($child_category->children as $childCategory)
            @include('backend.productcategories.child_category', ['child_category' => $childCategory])
@endforeach