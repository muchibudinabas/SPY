<!DOCTYPE html>
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Sistem Pendaftaran Yudisium | Fakultas Sains Teknologi Universitas Airlangga</title>
	<meta name="description" content="Worthy a Bootstrap-based, Responsive HTML5 Template">
	<meta name="author" content="htmlcoder.me">
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- Mobile Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Favicon -->
	<link rel="shortcut icon" href="{{$url = asset('private/resources/assets/Mahasiswa/images/favicon.ico')}}">

	<!-- Web Fonts -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700,300&amp;subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Raleway:700,400,300' rel='stylesheet' type='text/css'>

	<!-- Bootstrap core CSS -->
	<link href="{{$url = asset('private/resources/assets/Mahasiswa/bootstrap/css/bootstrap.css')}}" rel="stylesheet">

	<!-- Font Awesome CSS -->
	<link href="{{$url = asset('private/resources/assets/Mahasiswa/fonts/font-awesome/css/font-awesome.css')}}" rel="stylesheet">

	<!-- Plugins -->
	<link href="{{$url = asset('private/resources/assets/Mahasiswa/css/animations.css')}}" rel="stylesheet">

	<!-- Worthy core CSS file -->
	<link href="{{$url = asset('private/resources/assets/Mahasiswa/css/style3.css')}}" rel="stylesheet">

	<!-- Custom css --> 
	<link href="{{$url = asset('private/resources/assets/Mahasiswa/css/custom.css')}}" rel="stylesheet">
	<link href="{{$url = asset('private/resources/assets/Mahasiswa/js/sweetalert.css')}}" rel="stylesheet">

	<!-- css preloader -->
	<style type="text/css">
		.preload-wrapper {
			z-index:9999999999;
			position: fixed;
			top:0;
			left: 0;
			right: 0;
			bottom:0;
			background:#fff;
			overflow: hidden;
		}
		#preloader_4{
			position:relative;
			width:70px;
			margin:23% auto;
		}
		#preloader_4 span{
			position:absolute;
			width:20px;
			height:20px;
			background:#3498db;
			opacity:0.5;
			border-radius:20px;
			-animation: preloader_4 1s infinite ease-in-out;
			-webkit-animation: preloader_4 1s infinite ease-in-out; 
		}
		#preloader_4 span:nth-child(2){
			left:20px;
			animation-delay: .2s;
			-webkit-animation-delay: .2s;
		}
		#preloader_4 span:nth-child(3){
			left:40px;
			-webkit-animation-delay: .4s;
			animation-delay: .4s;
		}
		#preloader_4 span:nth-child(4){
			left:60px;
			animation-delay: .6s;
			-webkit-animation-delay: .6s;
		}
		#preloader_4 span:nth-child(5){
			left:80px;
			animation-delay: .8s;
			-webkit-animation-delay: .8s;
		}
		@keyframes preloader_4 {
			0% {opacity: 0.3; transform:translateY(0px);    box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.1);}
			50% {opacity: 1; transform: translateY(-10px); background:#f1c40f;  box-shadow: 0px 20px 3px rgba(0, 0, 0, 0.05);}
			100%  {opacity: 0.3; transform:translateY(0px); box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.1);}
		}
		@-webkit-keyframes preloader_4 {
			0% {opacity: 0.3; transform:translateY(0px);    box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.1);}
			50% {opacity: 1; transform: translateY(-10px); background:#f1c40f;  box-shadow: 0px 20px 3px rgba(0, 0, 0, 0.05);}
			100%  {opacity: 0.3; transform:translateY(0px); box-shadow: 0px 0px 3px rgba(0, 0, 0, 0.1);}
		}
	</style>
	<!-- end preloader -->

</head>

<body class="no-trans">


	<!-- scrollToTop -->
	<!-- ================ -->
	<div class="scrollToTop"><i class="icon-up-open-big"></i></div>

	<!-- header start -->
	<!-- ================ --> 
	<header class="header fixed clearfix navbar navbar-fixed-top">
		<div class="container">
			<div class="row">
				<div class="col-md-4">

					<!-- header-left start -->
					<!-- ================ -->
					<div class="header-left clearfix">

						<!-- logo -->
							<!-- <div class="logo smooth-scroll">
								<a href="#banner"><img id="logo" src="images/logo.png" alt="Worthy"></a>
							</div> -->

							<!-- name-and-slogan -->
							<div class="site-name-and-slogan smooth-scroll">
								<div class="site-name" style="font-size: 26px;"><a href="#home">Sistem Pendaftaran Yudisium</a></div>
								<div class="site-slogan">Fakultas Sains Teknologi <a target="_blank" href="http://unair.ac.id">Universitas Airlangga</a></div>
							</div>

						</div>
						<!-- header-left end -->

					</div>
					<div class="col-md-8">

						<!-- header-right start -->
						<!-- ================ -->
						<div class="header-right clearfix">

							<!-- main-navigation start -->
							<!-- ================ -->
							<div class="main-navigation animated">

								<!-- navbar start -->
								<!-- ================ -->
								<nav class="navbar navbar-default" role="navigation">
									<div class="container-fluid">

										<!-- Toggle get grouped for better mobile display -->
										<div class="navbar-header">
											<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
												<span class="sr-only">Toggle navigation</span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
												<span class="icon-bar"></span>
											</button>
										</div>

										<!-- Collect the nav links, forms, and other content for toggling -->
										<div class="collapse navbar-collapse scrollspy smooth-scroll" id="navbar-collapse-1">
											<ul class="nav navbar-nav navbar-right">
												<li><a href="{{ url('dashboard') }}">Dashboard</a></li>
												<li><a href="{{ url('biodata') }}">Biodata</a></li>
												<li class="active"><a href="{{ url('fileyudisium') }}">File Yudisium</a></li>
												<li><a href="{{ url('logout') }}">Logout</a></li>
											</ul>
										</div>

									</div>
								</nav>
								<!-- navbar end -->

							</div>
							<!-- main-navigation end -->

						</div>
						<!-- header-right end -->

					</div>
				</div>
			</div>
		</header>
		<!-- header end -->

		<!-- banner start -->
		<!-- ================ -->
		<div id="home" class="banner">
			<div class="banner-image"></div>
			<div class="banner-caption">
				
			</div>
		</div>
		<!-- banner end -->

		<!-- section start -->
		<!-- ================ -->
		<div class="section clearfix object-non-visible" data-animation-effect="fadeIn">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-sm-2">
							</div>
							<div class="col-sm-8">
							<h1 id="" class="title text-left"><span>File Yudisium</span></h1>
								<div class="space"></div>
									<h2 class="lead "><span><b>Upload file</b></span></h2>

									<!-- //hehe -->

									<form name="myForm" role="form" id="body-form" method="POST" action="{{ url('daftar_yudisium') }}" accept-charset="UTF-8" enctype="multipart/form-data">
									{!! csrf_field() !!}
									<div class="form-group">
									
									@foreach($data as $dataa)
									<input type="hidden" class="form-control" placeholder="NIM" id="nim" name="nim" value="{{$dataa->NIM}}" >
									@endforeach

									<div class="form-group">
										<label for="fy">File Yudisium</label>
										<select class="form-control " name="fy" id="fy" onfocusin="exitnim()" onchange="myFunction()" value="<?php echo Form::old('fy') ?>" >
											@foreach($fy as $fyy)
											<option id="fill-<?php echo $fyy->ID_FILE; ?>" value="{{$fyy->ID_FILE}}">{{$fyy->NAMA_FILE}}</option>
											@endforeach
										</select>

				                        <p style="margin-bottom: 5px;"></p>
				                        <p style="font-size: 11px; margin-bottom: 5px; color:black;"><em>Ket : </em> <b id="ketfile2" ></b><b id="ketfile3" ></b></p></p>
									</div>
									<div class="form-group">
									<input type="file" class="filestyle" data-buttonName="btn-primary" id="fileyudisium" name="fileyudisium" accept="application/pdf" value="">
									</div>
									</form>

									<div class="space"></div>
									<h2 class="lead "><span><b>Belum punya file persyaratan yudisium? </b></span></h2>
									<p>Surat keterangan bebas pinjam alat dan buku <a target="_blank" href="{{ url('suratbebaspinjamalat') }}"><strong>download</strong></a></p>

									
							</div>
							<div class="col-sm-2">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>
		
		<!-- section end -->



<footer id="footer">
	<!-- .subfooter start -->
	<!-- ================ -->
	<div class="subfooter">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p class="text-center">Copyright © 2016 Universitas Airlangga.</p>
					<p class="text-center">Developed by <a target="_blank" href="https://www.facebook.com/muchibudinabas14"><strong>Muchi</strong></a>.</p>

				</div>
			</div>
		</div>
	</div>
	<!-- .subfooter end -->

</footer>
<!-- footer end -->


		<!-- JavaScript files placed at the end of the document so the pages load faster
		================================================== -->

		<!-- 		<link rel="stylesheet" href="{{$url = asset('private/resources/assets/AdminLTE/bootstrap/css/bootstrap.min.css')}}"> -->

		<!-- Jquery and Bootstap core js files -->
		<script type="text/javascript" src="{{$url = asset('private/resources/assets/Mahasiswa/plugins/jquery.min.js')}}"></script>
		<script type="text/javascript" src="{{$url = asset('private/resources/assets/Mahasiswa/bootstrap/js/bootstrap.min.js')}}"></script>

		<!-- Modernizr javascript -->
		<script type="text/javascript" src="{{$url = asset('private/resources/assets/Mahasiswa/plugins/modernizr.js')}}"></script>

		<!-- Isotope javascript -->
		<script type="text/javascript" src="{{$url = asset('private/resources/assets/Mahasiswa/plugins/isotope/isotope.pkgd.min.js')}}"></script>
		
		<!-- Backstretch javascript -->
		<script type="text/javascript" src="{{$url = asset('private/resources/assets/Mahasiswa/plugins/jquery.backstretch.min.js')}}"></script>

		<!-- Appear javascript -->
		<script type="text/javascript" src="{{$url = asset('private/resources/assets/Mahasiswa/plugins/jquery.appear.js')}}"></script>

		<!-- Initialization of Plugins -->
		<script type="text/javascript" src="{{$url = asset('private/resources/assets/Mahasiswa/js/template.js')}}"></script>

		<!-- Custom Scripts -->
		<script type="text/javascript" src="{{$url = asset('private/resources/assets/Mahasiswa/js/custom.js')}}"></script>

		<!-- disquet -->
		<script id="dsq-count-scr" src="//localhostyudisiumfst.disqus.com/count.js" async></script>


		<!-- Uploading File -->
		<script type="text/javascript">

			function exitnim() {
				var nim = $('#nim').val();

	            // $("#fy").each(function()
				// {
	                // $('#fill-1').css('color','#000');
	                // $('#fill-2').css('color','#000');
	                // $('#fill-3').css('color','#000');
	                // $('#fill-4').css('color','#000');

	                $("#fy > option").each(function() {
		                $(this).css('color','#555');


					    // alert(this.text + ' ' + this.value);
					});

                    
				// });

				$.get('getfy' + '/' + nim, function(data) {

					data = JSON.parse(data);
					console.log(data);
		            // alert( data[0]['ID_FILE'] );



					$.each(data, function (index, subcatObj) {
	                    $('#fill-'+subcatObj.ID_FILE).css('background-color','#55acee').css('color','white');
	                });            
	            });


	            // if (data[0]['ID_FILE'] != "") {
	            // 	alert('ada isi file 1');
	            // }
				// alert('nim input = '+ nim);

			}

			function myFunction() {
				$x = document.getElementById("fy").value;
				// document.getElementById("demo").innerHTML = "you : " + $x;
				$nim = $('#nim').val();


	            //ajax
	        	$.get('getfy' + '/' + $nim + '/' + $x, function($nim, $x) {
				
				// document.getElementById("demo").innerHTML = "you : " + $nim;

                // $('#fy').empty();
                // $.each($nim, function (index, subcatObj) {

                //     $('#fy').append('<option value="' + subcatObj.ID_FILE + '">' + subcatObj.NAMA_FILE + '</option>').css('color','#55acee');

                // });


                $('#ketfile2').empty();
                $.each($nim, function (index, subcatObj) {
                    $('#ketfile2').text('' + subcatObj.NAMA_FILE + '').css('color','#55acee');

                });

                $('#ketfile3').empty();
                $.each($nim, function (index, subcatObj) {
                    $('#ketfile3').text('' + subcatObj.NAMA_FILE2 + '').css('color','black');

                });




				// document.getElementById("demo2").innerHTML = "you : " + $x;

	                
	            });


			}
		</script>



		<script type="text/javascript">
	//binds to onchange event of your input field
	$('#fileyudisium').bind('change', function() {
		
	  	//check whether browser fully supports all File API
	  	if (window.File && window.FileReader && window.FileList && window.Blob) 
	  	{
	        //get the file size and file type from file input field
	        var fsize = $('#fileyudisium')[0].files[0].size;
	        
	        if(fsize>1048576) //do something if file size more than 1 mb (1048576)
	        {
	            // alert('Silahkan upload file max 1 MB');
	            sweetAlert("Oops...", "Maximum Size 1 MB!", "error");

	            if($.browser.msie){
	            	$("input[type='file']").replaceWith($("input[type='file']").clone(true));
	            } else {
	            	$("input[type='file']").val('');
	            }

	        } else {
	            // alert(fsize +" bites\nYou are good to go!");
	            //check whether browser fully supports all File API
	            if (window.File && window.FileReader && window.FileList && window.Blob)
	            {
			        //get the file size and file type from file input field
			        var fsize = $('#fileyudisium')[0].files[0].size;
			        var ftype = $('#fileyudisium')[0].files[0].type;
			        var fname = $('#fileyudisium')[0].files[0].name;
			        
			        switch(ftype)
			        {
			        	case 'application/pdf':
			                // alert("Oke!");
			                //get nim before submit
						    // var nim = document.getElementById('nim').value;
						    // var nimm = "(a)"+nim;
							// alert(nimm);

							swal({   
								title: "Uploading File",   
								text: "Submit to upload file",   
								type: "info",   
								showCancelButton: true,   
								closeOnConfirm: false,   
								showLoaderOnConfirm: true, 
							}, 
							function(){   
								setTimeout(function(){

									$.ajax({

										url:'fileyudisium',
										data:new FormData($("#body-form")[0]),
										dataType:'json',
										async:false,
										type:'post',
										processData: false,
										contentType: false,
							      	// success:function(response){
							      	// 	console.log(response);
							      	// },
							      	success: function (data) {
							      		
							      		if(data.success == false)
							      		{
							      			sweetAlert("Oops...", data.data, "error");
							      		}
							      		else
							      		{
							      			var id = $('#fy').val();
							      			// alert ( $('#fy').val() );
							      			var myElement = document.querySelector('#fill-'+id);
											myElement.style.backgroundColor = "#55acee";
											// myElement.style.backgroundColor = "#55acee";

											// .css('color','white')
							      			// $('fill-'+id).
							      			swal("File has uploaded!", "", "success");
							      			// alert('tes');
							      		}
							      		
							      	},

							      });

								}, 3000); });
			                	// 	swal("File has uploaded!", "", "success");
			                	// }, 60000); });

							        // alert('Berhasi hore2');
							        // window.location.href = "{{ url('/#myModal') }}";
							        break;
							        default:
			                // alert('Silahkan upload file pdf');
			                sweetAlert("Oops...", "File Type allowed: pdf.", "error");

			                if($.browser.msie){
			                	$("input[type='file']").replaceWith($("input[type='file']").clone(true));
			                } else {
			                	$("input[type='file']").val('');
			                }
			            }

			        } else {
			        	sweetAlert("Oops...", "Please upgrade your browser, because your current browser lacks some new features we need!", "error");
			        }
			    }
			    //
			} else {
				sweetAlert("Oops...", "Please upgrade your browser, because your current browser lacks some new features we need!", "error");
			}

		});
	</script>


		




	<!-- popohover -->
	<script type="text/javascript">
		var originalLeave = $.fn.popover.Constructor.prototype.leave;
		$.fn.popover.Constructor.prototype.leave = function(obj){
			var self = obj instanceof this.constructor ?
			obj : $(obj.currentTarget)[this.type](this.getDelegateOptions()).data('bs.' + this.type)
			var container, timeout;

			originalLeave.call(this, obj);

			if(obj.currentTarget) {
				container = $(obj.currentTarget).siblings('.popover')
				timeout = self.timeout;
				container.one('mouseenter', function(){
			      //We entered the actual popover – call off the dogs
			      clearTimeout(timeout);
			      //Let's monitor popover content instead
			      container.one('mouseleave', function(){
			      	$.fn.popover.Constructor.prototype.leave.call(self, self);
			      });
			  })
			}
		};

		$('body').popover({ selector: '[data-popover]', trigger: 'click hover', placement: 'auto', delay: {show: 50, hide: 400}});

	</script>


	<script type="text/javascript">
		$("#yes").on("click", function(){
			$('#file_input').val('yes');
		});
	</script>

	<script type="text/javascript">
		$("#no").on("click", function(){
			$('#file_input').val('no');
		});
	</script>

	<script type="text/javascript" src="{{$url = asset('private/resources/assets/Mahasiswa/js/bootstrap-filestyle.min.js')}}"> </script>

	<script type="text/javascript" src="{{$url = asset('private/resources/assets/Mahasiswa/js/bootstrap-filestyle.js')}}"> </script>
	<script type="text/javascript" src="{{$url = asset('private/resources/assets/Mahasiswa/js/sweetalert.min.js')}}"> </script>


	<script type="text/javascript">
		/*Add new catagory Event*/
		$(".addbtn").click(function(){
			$.ajax({
				url:'add-catagory',
				data:new FormData($("#upload_form")[0]),
				dataType:'json',
				async:false,
				type:'post',
				processData: false,
				contentType: false,
				success:function(response){
					console.log(response);
				},
			});
		});
	</script>
	<script type="text/javascript">
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
	</script>
</body>
</html>
