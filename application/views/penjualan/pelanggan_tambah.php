<?php echo form_open('penjualan/tambah-pelanggan', array('id' => 'FormTambahPelanggan')); ?>

<div class='form-group'>
	<label>NRMP</label>
	<input type='number' name='nrmp' class='form-control' placeholder="TULIS NOMOR NRMP">
</div>
<div class='form-group'>
	<label>Nama</label>
    <p class="alert-danger" style="padding-left: 5px"><strong>Perhatian!</strong> Tulis Nama Pasien Dengan Huruf Kapital dan Kata BAPAK/IBU, Terimakasih...</p>
	<input type='text' name='nama' class='form-control' placeholder="NAMA DITULIS HURUF KAPITAL" oninput='this.value = this.value.toUpperCase()'>
</div>
<div class='form-group'>
	<label>Herbalis</label>
    <p class="alert-danger" style="padding-left: 5px"><strong>Perhatian!</strong> Tulis Kode Herbarlis Tidak Menggunakan Simbol &, Terimakasih...</p>
	<input type='text' name='herbalis' class='form-control' placeholder="TULIS KODE HERBALIS">
</div>
<div class='form-group'>
	<label>Tanggal Datang Kembali</label>
	<input type='date' name='tgl_kembali' class='form-control'>
</div>
<!-- <div class='form-group'>
	<label>Alamat</label>
	<textarea name='alamat' class='form-control' style='resize:vertical;'></textarea>
</div>
<div class='form-group'>
	<label>Nomor Telepon / Handphone</label>
	<input type='text' name='telepon' class='form-control'>
</div> -->
<div class='form-group'>
	<label>Info Tambahan Lainnya</label>
	<textarea name='info' class='form-control' style='resize:vertical;'></textarea>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
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