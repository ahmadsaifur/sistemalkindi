<?php echo form_open('jasa/tambah_jasa', array('id' => 'FormTambahJasa')); ?>

<div class='form-group'>
	<label>KODE</label>
	<input type='text' name='kode' class='form-control' placeholder="TULIS KODE JASA">
</div>
<div class='form-group'>
	<label>Nama Jasa</label>
	<input type='text' name='nama' class='form-control' placeholder="TULIS NAMA JASA" oninput='this.value = this.value.toUpperCase()'>
</div>
<div class='form-group'>
	<label>Harga</label>
	<input type='number' name='harga' class='form-control' placeholder="TULIS HARGA">
</div>

<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function TambahJasa()
{
	$.ajax({
		url: $('#FormTambahJasa').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormTambahJasa').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1)
			{ 
				$('#FormTambahJasa').each(function(){
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
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanDataJasa'>Simpan Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormTambahJasa").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanDataJasa').click(function(e){
		e.preventDefault();
		TambahJasa();
	});

	$('#FormTambahJasa').submit(function(e){
		e.preventDefault();
		TambahJasa();
	});
});
</script>