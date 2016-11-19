
<div class="box-body">
<br>
<div class="table-responsive">
    <table id="example" class="table table-bordered table-striped">
        <thead>
          <tr class="bg-blue">
            <th width="20%">TGL YUDISIUM</th>
            <th width="40%">NAMA FILE</th>
            <th width="0%">INISIAL</th>
            <th width="0%">STATUS</th>
            <th width="0%">Actions</th>
            <!-- <th colspan="2">Actions</th> -->
          </tr>
        </thead>
        <tbody id="person3-list" name="person3-list">
        @foreach ($person3 as $persons)
          <tr id="person3{{ $persons->ID_FILE }}">
            <td>{{indonesiaDate($persons->TGL_YUDISIUM)}}</td>
            <td>{{ $persons->NAMA_FILE }}</td>
            <td>{{$persons->INISIAL}}</td>
            <td>@if ($persons->STATUS == 1)
            <span class="label label-success">Tampilkan</span>
            @endif
            @if ($persons->STATUS == 2)
            <span class="label label-danger">Sembunyikan</span>
            @endif
            </td>

            <td style="text-align:center;width:15%;">
            <button class="btn btn-xs bg-blue open-modal3" value="{{$persons->ID_FILE}}"><i class="glyphicon glyphicon-edit"></i> </button>
<!--                                 <button class="btn btn-xs btn-danger delete3" value="{{$persons->ID_FILE}}"><i class="glyphicon glyphicon-trash"></i> </button> -->
            </td>
            
          </tr>
          @endforeach
        </tbody>
      </table>
<br>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>