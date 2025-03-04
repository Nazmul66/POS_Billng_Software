
<!doctype html>
<html lang="en" class="semi-dark">

<head>
    {{-- Include CSS  --}}
    @include('admin.include.css')
</head>


<body>
	<!--wrapper-->
	<div class="wrapper">

		<!--sidebar wrapper -->
           @include('admin.include.sidebar')
		<!--end sidebar wrapper -->


		<!--start header -->
            @include('admin.include.header')
		<!--end header -->


		<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content">

                <!--start main body content -->
                @yield('body-content')
                <!--end main body content -->

			</div>
		</div>
		<!--end page wrapper -->


		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> 
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->


		<!--start footer -->
            @include('admin.include.footer')
		<!--end footer -->
	</div>
	<!--end wrapper-->



  {{-- Include JS --}}
  @include("admin.include.script")

</body>

</html>