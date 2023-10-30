<?php echo form_open('barang/tambah_standar', array('id' => 'FormTambahPelanggan')); ?>

<div class='form-group'>
	<label>Nama Obat</label>
	<select name='id_barang' id='id_barang' class='form-control input-sm' style='cursor: pointer;'>
		<option value=''>-- Umum --</option>
			<?php
				if($obat->num_rows() > 0)
				{
					foreach($obat->result() as $p)
					{
					echo "<option value='".$p->id_barang."'>".$p->nama_barang."</option>";
					}
				}
		    ?>
	</select>
	<input type='hidden' id='kd_barang' name='kd_barang' class='form-control'>
	<input type='hidden' id='kode_barang' name='kode_barang' class='form-control'>
	<input type='hidden' id='nama_barang' name='nama_barang' class='form-control'>
	<input type='hidden' id='satuan' name='satuan' class='form-control'>
	<input type='hidden' id='harga' name='harga' class='form-control'>
</div>

<div class='form-group'>
	<label>Standar STRIP</label>
	<input type='number' id='standar_strip' name='standar_strip' class='form-control' placeholder="Isi Standar STRIP" >
</div>

<div class='form-group'>
	<label>Standar PCS</label>
	<input type='number' id='standar_pcs' name='standar_pcs' class='form-control'placeholder="Isi Standar PCS">
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>
<script>
 /*
 $('#nama').select2({
      placeholder: 'Pilih Pasien',
      allowClear: true
    });
    */
$('#id_barang').select2({
        dropdownParent: $('#ModalGue')
    });
$('#id_barang').change(function(){
		if($(this).val() !== '')
		{
			$.ajax({
				url: "<?php echo site_url('barang/ajax_barang_online_kimia'); ?>",
				type: "POST",
				cache: false,
				data: "id_barang="+$(this).val(),
				dataType:'json',
				success: function(json){
					$('#nama_barang').val(json.nama_barang);
					$('#kode_barang').val(json.kode_barang);
					$('#kd_barang').val(json.kd_barang);
					$('#satuan').val(json.satuan);
					$('#harga').val(json.harga);/*
					$(".id_herbalis2" ).replaceWith( "<input id='id_herbalis' readonly='readonly' class='form-control' type='text' name='nama_herbalis'> value='"+val(json.herbalis)+"'");*/
				}
			});
		}
		else
		{
			$('#nrmp').html('<small><i>Tidak ada</i></small>');
		}
	});
function TambahPelanggan()
{
	$.ajax({
		url: $('#FormTambahPelanggan').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormTambahPelanggan').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1)
			{ 
				$('#FormTambahPelanggan').each(function(){
					this.reset();
				});

				if(document.getElementById('PelangganArea') != null)
				{
					$('#ResponseInput').html('');

					$('.modal-dialog').removeClass('modal-lg');
					$('.modal-dialog').addClass('modal-sm');
					$('#ModalHeader').html('Berhasil');
					$('#ModalContent').html(json.pesan);
					$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Okay</button>");
					$('#ModalGue').modal('show');

					$('#id_pelanggan').append("<option value='"+json.id_pelanggan+"' selected>"+json.nrmp+' - '+json.nama+"</option>");
					$('#telp_pelanggan').html(json.telepon);
					$('#alamat_pelanggan').html(json.alamat);
					$('#info_tambahan_pelanggan').html(json.info);
				}
				else
				{
					$('#ResponseInput').html(json.pesan);
					setTimeout(function(){ 
				   		$('#ResponseInput').html('');
				    }, 3000);
					$('#my-grid').DataTable().ajax.reload( null, false );
				}
			}
			else
			{
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}

$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanTambahPelanggan'>Simpan Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormTambahPelanggan").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanTambahPelanggan').click(function(e){
		e.preventDefault();
		TambahPelanggan();
	});

	$('#FormTambahPelanggan').submit(function(e){
		e.preventDefault();
		TambahPelanggan();
	});
});

</script>