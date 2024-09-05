@extends('layouts.frontend')
@section('content')
    <section class="page-header page-header-modern bg-color-light-scale-1 page-header-md m-0">
					<div class="container">
						<div class="row">
							<div class="col-md-8 order-2 order-md-1 align-self-center p-static">
								<h1 class="text-dark font-weight-bold text-9 appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="100">Testimonals</h1>
							</div>
							<div class="col-md-4 order-1 order-md-2 align-self-center">
								<ul class="breadcrumb d-block text-md-end appear-animation" data-appear-animation="fadeIn" data-appear-animation-delay="300">
									<li><a href="{{url('index')}}">Home</a></li>
									<li class="active">Testimonals All</li>
								</ul>
							</div>
						</div>
					</div>
				</section>
    <div class="container py-5">
	<div class="row">
	    @if(count($testimonalAll)>0)
	       @foreach($testimonalAll as $testimonal) 
	         <div class='row'>
	             <div class="col-md-2">
        		     @if($testimonal->images!='')
        				<img src="{{asset($testimonal->images)}}" class="img-fluid mb-2" alt="{{$testimonal->name}}" width='100'>
        				@endif
        		</div>
        		<div class="col-md-10">
        			<p class="pb-3 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="800">{{$testimonal->descraption}}</p>
        		</div>
	         </div>
        		<hr class="solid my-4 appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="900">	
        		
        	@endforeach
		@endif
	</div>
	
</div>
@endsection  