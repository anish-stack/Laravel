@extends('layout.main')

@section('main-container')
    <!--begin::Content-->
					<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
						
					<h2>!Weclome {{Auth()->user()->name}}</h2>
					</div>
					<!--end::Content-->
@endsection