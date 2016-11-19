
<div class="box-body">
<br>
<div class="table-responsive">
  <table id="example" class="table table-bordered table-striped" >
    <thead>
      <tr class="bg-blue">
        <th width="0%">NIM</th>
        <th width="25%">NAMA</th>
        <th width="15%">PRODI</th>
        <th width="0%">JENIS KELAMIN</th>
        <th width="20%">TGL LULUS</th>
        <th width="25%">NO IJAZAH</th>
        <th width="0%">IPK</th>
        <th width="0%">SKS</th>
        <th width="0%">ELPT</th>
        <th width="0%">SKP</th>
    </tr>
</thead>
<tbody id="person-list" name="person-list">
    @foreach ($person as $persons)
    <tr id="person{{ $persons->NIM }}">
        <td>{{ $persons->NIM }}</td>
        <td><a id="nama-{{ $persons->NIM }}" href="{{ url('mhs_wisudawan') }}/{{ $persons->NIM }}">{{ $persons->NAMA}}</td>
        <td>{{ $persons->UNIT }}</td>
        @if ($persons->JENIS_KELAMIN == 1)
        <td >Laki-laki</td>
        @endif
        @if ($persons->JENIS_KELAMIN == 2)
        <td >Perempuan</td>
        @endif
        <td>{{ indonesiaDate($persons->TGL_LULUS) }}</td>
        <td>{{ $persons->NO_IJAZAH }}</td>
        <td>{{ $persons->IPK }}</td>
        <td>{{ $persons->SKS }}</td>
        <td>{{ $persons->ELPT }}</td>
        <td>{{ $persons->SKP }}</td>
    </tr>
    @endforeach
</tbody>
</table>
<!-- <br> -->
</div>
<br>
<form method="GET" action ="{{ url('exportexceldataalumniprodi') }}">  
    <button type="submit" class="btn btn-success pull-left">Export to excel</button>
</form>

<script type="text/javascript">
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>