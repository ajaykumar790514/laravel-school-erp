@if(session('success'))
<div class="alert bg-success alert-styled-left">
      <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
      <span class="text-semibold"> Well done!</span> {{session('success')}}
  </div>
@elseif(session('error'))
<div class="alert bg-danger alert-styled-left">
    <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
    <span class="text-semibold">Oh snap! </span> {{session('error')}}
</div>
@endif    
      
      