<option {{ $product->product_categories_id==$child_category->id?"selected":""}} value="{{$child_category->id}}"><?php echo $flag.=$flag;?>{{ $child_category->title }}</option>
 @foreach ($child_category->children as $childCategory)
    @include('backend.product.edit_child_category', ['child_category' => $childCategory])
@endforeach