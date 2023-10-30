<?php echo form_open('barang/tambah_klinik_Kimia', array('id' => 'FormTambahPelanggan')); ?>

<?php
$level 		= $this->session->userdata('ap_level');
$level_id 	= $this->session->userdata('ap_id_user');
$readonly	= '';
$disabled	= '';
if($level !== 'admin')
{
	$readonly	= 'readonly';
	$disabled	= 'disabled';
}
?>

<div class='form-group'>
	<label>User</label>
	<select name='id_kasir' id='id_kasir' class='form-control input-sm' <?php echo $disabled; ?>>
				<?php
					if($kasirnya->num_rows() > 0)
					{
					    foreach($kasirnya->result() as $k)
						{
							$selected = '';
							if($k->id_user == $this->session->userdata('ap_id_user')){
							$selected = 'selected';
						    }

						    echo "<option value='".$k->id_user."' ".$selected.">".$k->nama."</option>";
						}
					}
				?>
	</select>
</div>

<div class='form-group'>
	<label>Nama Obat</label>
	<select name='kd_barang' id='kd_barang' class='form-control input-sm' style='cursor: pointer;'>
		<option value=''>-- Umum --</option>
			<?php
				if($obat->num_rows() > 0)
				{
					foreach($obat->result() as $p)
					{
					echo "<option value='".$p->kd_barang."'>".$p->nama_barang."</option>";
					}
				}
		    ?>
	</select>
	<input type='hidden' id='nama_barang' name='nama_barang' class='form-control'>
	<input type='hidden' id='id_kategori_barang' name='id_kategori_barang' class='form-control' readonly>
</div>

<div class="form-group">
	<label>Kategori</label>
	<input type='text' id='kategori' name='kategori' class='form-control' readonly>
</div>

<div class='form-group'>
	<label>Satuan</label>
	<input type='text' id='satuan' name='satuan' class='form-control' readonly>
</div>

<div class='form-group'>
	<label>Stok</label>
	<input type='number' id='stok' name='stok' class='form-control' >
</div>

<div class='form-group'>
	<label>Harga</label>
	<input type='number' id='harga' name='harga' class='form-control' readonly>
</div>

<div class='form-group'>
	<label>Keterangan</label>
	<input type='text' name='keterangan' class='form-control' value='klinik' readonly>
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
$('#kd_barang').select2({
        dropdownParent: $('#ModalGue')
    });
    
$('#kd_barang').change(function(){
		if($(this).val() !== '')
		{
			$.ajax({
				url: "<?php echo site_url('barang/ajax_tambah_barang_online_kimia'); ?>",
				type: "POST",
				cache: false,
				data: "kd_barang="+$(this).val(),
				dataType:'json',
				success: function(json){
					$('#nama_barang').val(json.nama_barang);
					$('#satuan').val(json.satuan);
					$('#kategori').val(json.kategori);
					$('#id_kategori_barang').val(json.id_kategori_barang);
					$('#stok').val(json.stok);
					$('#harga').val(json.harga);
					$('#keterangan').val(json.keterangan);/*
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

$(document).on('keyup', '#stok', function(){
	var Indexnya = $(this).parent().parent().index();
	var JumlahBeli = $(this).val();
	var kd_barang = $('#kd_barang').val();

	$.ajax({
		url: "<?php echo site_url('barang/cek-stok2'); ?>",
		type: "POST",
		cache: false,
		data: "kd_barang="+encodeURI(kd_barang)+"&stok="+JumlahBeli,
		dataType:'json',
		success: function(data){
			if(data.status == 0)
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
				$('#ModalGue').modal('show');
/*
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(5) input').val('1');*/
			}
		}
	});
});

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