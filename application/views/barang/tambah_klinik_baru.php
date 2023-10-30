<?php echo form_open('barang/tambah_klinik_baru', array('id' => 'FormTambahKlinikBaru')); ?>
<label>Tanggal Input</label>
	<input type='text' readonly="true" name='tanggal' class='form-control' value='<?php echo date('Y-m-d H:i:s'); ?>'>


<div class='form-group col-md-3'>
	<label>KD Barang</label>
	<input type='text' name='kd_barang' class='form-control' placeholder="Kd Barang" value="">
</div>
<div class='form-group col-md-3'>
	<label>Kode Barang</label>
	<input type='text' name='kode_barang' class='form-control' placeholder="Isi Kode Barang">
</div>
<div class='form-group col-md-6'>
	<label>Nama Barang</label>
	<input type='text' name='nama_barang' class='form-control' placeholder="Isi Nama Barang">
</div>
<div class='form-group col-md-3'>
	<label>Kategori</label>
	<select type="number" name='id_kategori_barang' class='form-control'>
		<option value=''> ---- Pilih Kategori ----</option>
	<?php
		if($kategori->num_rows() > 0)
		{
			foreach($kategori->result() as $k)
			{
				echo "<option value='".$k->id_kategori_barang."'>".$k->kategori."</option>";
			}
		}
	?>
	</select>
</div><!-- 
<div class='form-group col-md-3'>
	<label>Stok</label>
	<input type="number" name='stok' class='form-control' placeholder="Isi Stok Barang"></input>
</div> -->
<div class='form-group col-md-4'>
	<label>Total Stok</label>
	<input type='number' name='total_stok' class='form-control' placeholder="Stok">
</div>
<div class='form-group col-md-3'>
	<label>Satuan</label>
	<select type="number" name='satuan' class='form-control'>
		<option value=''> ---- Pilih satuan ----</option>
	<?php
		if($satuan->num_rows() > 0)
		{
			foreach($satuan->result() as $k)
			{
				echo "<option value='".$k->id_satuan."'>".$k->satuan."</option>";
			}
		}
	?>
	</select>
</div>

<div class='form-group col-md-4'>
	<label>harga</label>
	<input type='number' name='harga' class='form-control' placeholder="Isi Harga">
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function TambahKlinikBaru()
{
	$.ajax({
		url: $('#FormTambahKlinikBaru').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormTambahKlinikBaru').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){ 
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Sukses !');
				$('#ModalContent').html(json.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal'>Ok</button>");
				$('#ModalGue').modal('show');
				$('#my-grid').DataTable().ajax.reload( null, false );
			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button style='margin-bottom:8px;' type='button' class='btn btn-success' id='SimpanKlinikBaru'>Simpan Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#SimpanKlinikBaru").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanKlinikBaru').click(function(e){
		e.preventDefault();
		TambahKlinikBaru();
	});

	$('#SimpanTambahKlinikBaru').submit(function(e){
		e.preventDefault();
		TambahKlinikBaru();
	});
});
</script>
</script>