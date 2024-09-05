@if(count($sliderItemData)>0)
<div class="tp-banner-container">
  <div class="tp-banner">
    <ul>
       @foreach($sliderItemData as $slider)
        <li data-slotamount="7" data-transition="3dcurtain-horizontal" data-masterspeed="1000" data-saveperformance="on"> 
          <img alt="" src="public/{{ $slider->image}}" data-lazyload="public/{{ $slider->image}}">
            <div class="caption lft large-title tp-resizeme slidertext2" data-x="center" data-y="360" data-speed="600" data-start="1600"><span> {{$slider->title}} </span></div>
            <div class="caption lfb large-title tp-resizeme slidertext3" data-x="center" data-y="440" data-speed="600" data-start="2200"><?php print_r($slider->description);?></div>
      </li>
        @endforeach
    </ul>
  </div>
</div>
@endif