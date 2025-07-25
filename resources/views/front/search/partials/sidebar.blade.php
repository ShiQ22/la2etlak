@php
	$showOnLargeScreensOnly = ' d-none d-md-block';
	$showOnMobileOnly = ' d-block d-sm-block d-md-none'; // overflow-y-auto
	
	$isPriceFilterCanBeDisplayed = (!empty($cat) && data_get($cat, 'type') != 'not-salable');
@endphp
{{-- Sidebar (for Large Screens) | d-none d-md-block --}}
<div class="col-md-3 pb-4{{ $showOnLargeScreensOnly }}" id="leftSidebar">
	<aside>
		<div class="card">
			<div class="card-body vstack gap-4 text-wrap">
				
				@php
					$prefixId = '';
				@endphp
				@include('front.search.partials.sidebar.fields', ['prefixId' => $prefixId])
				@include('front.search.partials.sidebar.type', ['prefixId' => $prefixId])
				@include('front.search.partials.sidebar.categories', ['prefixId' => $prefixId])
	            @include('front.search.partials.sidebar.cities', ['prefixId' => $prefixId])
				@if (!config('settings.listings_list.hide_date'))
					@include('front.search.partials.sidebar.date', ['prefixId' => $prefixId])
				@endif
				 {{--@include('front.search.partials.sidebar.price', ['prefixId' => $prefixId])--}}
				
			</div>
		</div>
	</aside>
</div>

{{-- Offcanvas (for Mobile Screen) | d-block d-sm-block d-md-none --}}
<div class="offcanvas offcanvas-start px-0" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">
	<div class="offcanvas-header bg-body-secondary">
		<h5 class="offcanvas-title fw-bold" id="mobileSidebarLabel">
			{{ t('Filters') }}
		</h5>
		<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	</div>
	<div class="offcanvas-body vh-200 overflow-y-auto">
		<div class="card{{ $showOnMobileOnly }}">
			<div class="card-body vstack gap-4 text-wrap">
				
				@php
					$prefixId = 'm-';
				@endphp
				@include('front.search.partials.sidebar.fields', ['prefixId' => $prefixId])
				@include('front.search.partials.sidebar.categories', ['prefixId' => $prefixId])
				@include('front.search.partials.sidebar.cities', ['prefixId' => $prefixId])
				@if (!config('settings.listings_list.hide_date'))
					@include('front.search.partials.sidebar.date', ['prefixId' => $prefixId])
				@endif
				{{--@include('front.search.partials.sidebar.price', ['prefixId' => $prefixId])--}}
			
			</div>
		</div>
	</div>
</div>

@section('after_scripts')
    @parent
    <script>
        var baseUrl = '{{ request()->url() }}';
    </script>
    
    {{-- sidebar/date.blade.php --}}
    <script>
	    onDocumentReady((event) => {
		    const postedDateEls = document.querySelectorAll('input[type=radio][name=postedDate]');
		    if (postedDateEls.length > 0) {
			    postedDateEls.forEach((element) => {
				    element.addEventListener('click', (e) => {
					    const queryStringEl = document.querySelector('input[type=hidden][name=postedQueryString]');
					    
					    if (queryStringEl) {
						    let queryString = queryStringEl.value;
						    queryString += (queryString !== '') ? '&' : '';
						    queryString = queryString + 'postedDate=' + e.target.value;
						    
						    let searchUrl = baseUrl + '?' + queryString;
						    redirect(searchUrl);
					    }
				    });
			    });
		    }
	    });
    </script>
@endsection
