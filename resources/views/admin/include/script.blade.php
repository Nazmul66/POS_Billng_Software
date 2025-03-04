	<!-- Bootstrap JS -->
	<script src="{{ asset('admin/assets/js/bootstrap.bundle.min.js') }}"></script>

	<!--plugins-->
	<script src="{{ asset('admin/assets/js/jquery.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/chartjs/chart.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/sparkline-charts/jquery.sparkline.min.js') }}"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script src="{{ asset('admin/assets/plugins/jquery-knob/excanvas.js') }}"></script>
	<script src="{{ asset('admin/assets/plugins/jquery-knob/jquery.knob.js') }}"></script>

	 <!-- toaster Js plugins  -->
	 <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

	  <script src="{{ asset('admin/assets/js/index.js') }}"></script>
	<!--app JS-->
	<script src="{{ asset('admin/assets/js/app.js') }}"></script>

	<script>
		$(function() {
			$(".knob").knob();
		});
	</script>

	{{-- Add New JS --}}
	@stack('add-js')


	{!! Toastr::message() !!}

	<script type="text/javascript">
	
		@if ($errors->any())
			@foreach ($errors->all() as $error)
				toastr.error("{!! $error !!}");
			@endforeach
		@endif

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>