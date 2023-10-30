<?php echo form_open('penjualan/tambah_pelanggan_jmo', array('id' => 'FormTambahPelanggan')); ?>

<div class='form-group'>
	<label>Nama Pasien</label>
	<select name='nama' id='nama' class='form-control input-sm' style='cursor: pointer;'>
		<option value=''>-- Umum --</option>
			<?php
				if($pelanggan->num_rows() > 0)
				{
					foreach($pelanggan->result() as $p)
					{
					echo "<option value='".$p->id_pelanggan."'>".$p->nama."</option>";
					}
				}
		    ?>
	</select>
	<input type='hidden' id='nama_pasien' name='nama_pasien' class='form-control' placeholder="TULIS NAMA">
</div>

<div class='form-group'>
	<label>NRMP</label>
	<input type='number' readonly id='nrmp' name='nrmp' class='form-control' placeholder="TULIS NOMOR NRMP">
</div>

<div class='form-group'>
	<label>Konsultan Utama</label>
	<!--<input type='text' name='herbalis' class='form-control' placeholder="TULIS HERBALIS UTAMA" autocomplete="off">-->
	<select name='herbalis' class='form-control input-sm' style='cursor: pointer;' autocomplete="off">
		<option value=''>-- Pilih Herbalis --</option>
		<option value='Akhi Faruq'>Akhi Faruq</option>
		<option value='Ayu Indah Lestari'>Ayu Indah Lestari</option>
		<option value='Meutia Anita Bakti'>Meutia Anita Bakti</option>
		<option value='Mira Natawiriya'>Mira Natawiriya</option>
		<option value='Nien Kurniasih'>Nien Kurniasih</option>
		<option value='Nintin Apriyanti'>Nintin Apriyanti</option>
		<option value='Sri Winarti'>Sri Winarti</option>
		<option value='Tien Suryatini'>Tien Suryatini</option>
		<option value=''>-------------------------------</option>
		<option value='OL Yeski'>OL Yeski</option>
		<option value='OL Ricko'>OL Ricko</option>
		<option value='OL Fendi'>OL Fendi</option>
	</select>
</div>
<div class='form-group'>
	<label>Keterangan</label>
	<select name='keterangan' class='form-control input-sm' style='cursor: pointer;' autocomplete="off">
		<option value=''>-- Pilih Keterangan --</option>
		<option value='pasien klinik'>Pasien Klinik</option>
		<option value='pasien online'>Pasien Online</option>
		<option value='pasien zoom'>Pasien Zoom</option>
	</select>
</div>
<div class='form-group'>
	<label>Info Tambahan</label>
	<textarea name='info_tambahan' class='form-control' style='resize:vertical;'></textarea>
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
$('#nama').select2({
        dropdownParent: $('#ModalGue')
    });
$('#nama').change(function(){
		if($(this).val() !== '')
		{
			$.ajax({
				url: "<?php echo site_url('penjualan/ajax_pelanggan_jmo'); ?>",
				type: "POST",
				cache: false,
				data: "id_pelanggan="+$(this).val(),
				dataType:'json',
				success: function(json){
					$('#nrmp').val(json.nrmp);
					$('#nama_pasien').val(json.nama);/*
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
			else if (json.status == 2) 
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