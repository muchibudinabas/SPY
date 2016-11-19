<!DOCTYPE html>
<html>
<head>
<title>Ajax CRUD in laravel - justlaravel.com</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet"
	href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script
	src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<style>
.table-borderless tbody tr td, .table-borderless tbody tr th,
	.table-borderless thead tr th {
	border: none;
}
</style>
<body>
	<div class="container ">
		<div class="form-group row add">
			<div class="col-md-8">
				<input type="text" class="form-control" id="ID_AGAMA" name="ID_AGAMA"
					placeholder="Enter some name" required>
				<p class="error text-center alert alert-danger hidden"></p>

				<input type="text" class="form-control" id="AGAMA" name="AGAMA"
					placeholder="Enter some name" required>
				<p class="error text-center alert alert-danger hidden"></p>
				

			</div>
			<div class="col-md-4">
				<button class="btn btn-primary" type="submit" id="add">
					<span class="glyphicon glyphicon-plus"></span> ADD
				</button>
			</div>
		</div>

		<div class="alert alert-success" style="display:none;" id="addsuccess">
            <p><strong>Success! </strong> Data berhasil disimpan.</p>
        </div>
        <div class="alert alert-success" style="display:none;" id="deletesuccess">
            <p><strong>Success! </strong> Data berhasil dihapus.</p>
        </div>
        <div class="alert alert-success" style="display:none;" id="updatesuccess">
            <p><strong>Success! </strong> Data berhasil diedit.</p>
        </div>

		{{ csrf_field() }}
		<div class="table-responsive text-center">
			<table class="table table-borderless" id="table">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th class="text-center">Name</th>
						<th class="text-center">Actions</th>
					</tr>
				</thead>
				@foreach($data as $item)
				<tr class="item{{$item->ID_AGAMA}}">
					<td>{{$item->ID_AGAMA}}</td>
					<td>{{$item->AGAMA}}</td>
					<td><button class="edit-modal btn btn-info" data-id="{{$item->ID_AGAMA}}"
							data-name="{{$item->AGAMA}}">
							<span class="glyphicon glyphicon-edit"></span> Edit
						</button>
						<button class="delete-modal btn btn-danger"
							data-id="{{$item->ID_AGAMA}}" data-name="{{$item->AGAMA}}">
							<span class="glyphicon glyphicon-trash"></span> Delete
						</button></td>
				</tr>
				@endforeach
			</table>
		</div>
	</div>
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" role="form">
						<div class="form-group">
							<label class="control-label col-sm-2" for="id">ID:</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="fid" disabled>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2" for="name">Name:</label>
							<div class="col-sm-10">
								<input type="name" class="form-control" id="n" required="">
				<p class="error text-center alert alert-danger hidden"></p>

							</div>
						</div>
					</form>
					<div class="deleteContent">
						Are you Sure you want to delete <span class="dname"></span> ? <span
							class="hidden did"></span>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn actionBtn" data-dismiss="modal">
							<span id="footer_action_button" class='glyphicon'> </span>
						</button>
						<!-- <button type="button" class="btn btn-warning" data-dismiss="modal"> -->
						<button type="button" class="btn btn-warning" data-dismiss="modal">
							<span class='glyphicon glyphicon-remove'></span> Close
						</button>
					</div>
				</div>
			</div>
		</div>
		<script>
    $(document).on('click', '.edit-modal', function() {
        $('#footer_action_button').text(" Update");
        $('#footer_action_button').addClass('glyphicon-check');
        $('#footer_action_button').removeClass('glyphicon-trash');
        $('.actionBtn').addClass('btn-success');
        $('.actionBtn').removeClass('btn-danger');
        $('.actionBtn').addClass('edit');
        $('.modal-title').text('Edit');
        $('.deleteContent').hide();
        $('.form-horizontal').show();
        $('#fid').val($(this).data('id'));
        $('#n').val($(this).data('name'));
        $('#myModal').modal('show');
    });
    $(document).on('click', '.delete-modal', function() {
        $('#footer_action_button').text(" Delete");
        $('#footer_action_button').removeClass('glyphicon-check');
        $('#footer_action_button').addClass('glyphicon-trash');
        $('.actionBtn').removeClass('btn-success');
        $('.actionBtn').addClass('btn-danger');
        $('.actionBtn').addClass('delete');
        $('.modal-title').text('Delete');
        $('.did').text($(this).data('id'));
        $('.deleteContent').show();
        $('.form-horizontal').hide();
        $('.dname').html($(this).data('name'));
        $('#myModal').modal('show');
    });

    $('.modal-footer').on('click', '.edit', function() {

        $.ajax({
            type: 'post',
            url: 'editItem',
            data: {
                '_token': $('input[name=_token]').val(),
                'ID_AGAMA': $("#fid").val(),
                'AGAMA': $('#n').val()
            },
            success: function(data) {
                $('.item' + data.ID_AGAMA).replaceWith("<tr class='item" + data.ID_AGAMA + "'><td>" + data.ID_AGAMA + "</td><td>" + data.AGAMA + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.ID_AGAMA + "' data-name='" + data.AGAMA + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.ID_AGAMA + "' data-name='" + data.AGAMA + "' ><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");
                
                $('#updatesuccess').append();
                    $('#updatesuccess').slideDown();
                    $('#updatesuccess').fadeTo(2000, 500).slideUp(500, function(){
                       // $('#p').hide().$('#p').empty();
                       $('#updatesuccess').hide();

                    });

            }
        });
    });
    $("#add").click(function() {

        $.ajax({
            type: 'post',
            url: 'addItem',
            data: {
                // '_token': $('input[AGAMA=_token]').val(),
                '_token': $('input[name=_token]').val(),
                'ID_AGAMA': $('input[name=ID_AGAMA]').val(),

                'AGAMA': $('input[name=AGAMA]').val()
            },
            success: function(data) {
                if ((data.errors)){
                	$('.error').removeClass('hidden');
                    $('.error').text(data.errors.ID_AGAMA);
                    $('.error').text(data.errors.AGAMA);
                }
                else {
                    $('.error').remove();
                    $('#table').append("<tr class='item" + data.ID_AGAMA + "'><td>" + data.ID_AGAMA + "</td><td>" + data.AGAMA + "</td><td><button class='edit-modal btn btn-info' data-id='" + data.ID_AGAMA + "' data-name='" + data.AGAMA + "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.ID_AGAMA + "' data-name='" + data.AGAMA + "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");



                    $('#addsuccess').append();
                    $('#addsuccess').slideDown();
                    $('#addsuccess').fadeTo(2000, 500).slideUp(500, function(){
                       // $('#p').hide().$('#p').empty();
                       $('#addsuccess').hide();

                    });

                }
            },

        });
        $('#AGAMA').val('');
    });
    $('.modal-footer').on('click', '.delete', function() {
        $.ajax({
            type: 'post',
            url: 'deleteItem',
            data: {
                '_token': $('input[name=_token]').val(),
                'ID_AGAMA': $('.did').text()
            },
            success: function(data) {
                $('.item' + $('.did').text()).remove();

                $('#deletesuccess').append();
                    $('#deletesuccess').slideDown();
                    $('#deletesuccess').fadeTo(2000, 500).slideUp(500, function(){
                       // $('#p').hide().$('#p').empty();
                       $('#deletesuccess').hide();

                    });
            }
        });
    });
</script>

</body>
</html>
