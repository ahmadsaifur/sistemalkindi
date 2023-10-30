<?php echo form_open('barang/update_stok_online_kimia', array('id' => 'FormTambahPelanggan')); ?>

<?php
$level 		= $this->session->userdata('ap_level');
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
	<select name='id_kasir' id='id_kasir' class='form-control input-sm' <?php echo $readonly; ?>>
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
	<input type='hidden' id='nama_barang' name='nama_barang' class='form-control'>
	<input type='hidden' id='satuan' name='satuan' class='form-control'>
</div>

<div class='form-group'>
	<label>Stok per DUS</label>
	<input type='number' id='stok' name='stok' class='form-control' placeholder="Update Stok">
</div>

<div class='form-group'>
	<label>TGL Kadaluarsa</label>
	<input type='text' name='date' class='form-control' id='date' value="<?php echo date('Y-m-d'); ?>">
</div>

<div class='form-group'>
	<label>Standar STRIP</label>
	<input type='number' id='standar_strip' name='standar_strip' class='form-control' readonly >
</div>

<div class='form-group'>
	<label>Standar PCS</label>
	<input type='number' id='standar_pcs' name='standar_pcs' class='form-control' readonly>
</div>

<div class='form-group col-md-6'>
	<label>Total Satuan STRIP</label><br>
    <input type='number' id='total_stok_strip' name='total_stok_strip' class='form-control' readonly>
</div>
<div class='form-group col-md-6'>
	<label>Total Satuan PCS</label><br>
    <input type='number' id='total_stok_pcs' name='total_stok_pcs' class='form-control' readonly>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>
<link rel="stylesheet" type="text/css" href="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.css"/>
<script src="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.js"></script>
<script>
 /*
 $('#nama').select2({
      placeholder: 'Pilih Pasien',
      allowClear: true
    });
    */
$('#date').datetimepicker({
	lang:'en',
	timepicker:false,
	format:'Y-m-d',
	closeOnDateSelect:true
});
$('#id_barang').select2({
        dropdownParent: $('#ModalGue')
    });
$('#id_barang').change(function(){
		if($(this).val() !== '')
		{
			$.ajax({
				url: "<?php echo site_url('barang/ajax_barang_online_kimia_standar'); ?>",
				type: "POST",
				cache: false,
				data: "id_barang="+$(this).val(),
				dataType:'json',
				success: function(json){
					$('#nama_barang').val(json.nama_barang);
					$('#standar_strip').val(json.standar_strip);
					$('#standar_pcs').val(json.standar_pcs);
					$('#satuan').val(json.satuan);/*
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

$(document).on('keyup', '#stok', function(){
	var JumlahBeli = $(this).val();
	var pcs = $('#standar_pcs').val();
	var strip = $('#standar_strip').val();
	
		var SubTotal_pcs = parseInt(JumlahBeli) *  parseInt(pcs);
		var SubTotal_strip = parseInt(JumlahBeli) * parseInt(strip);
		
        $('#total_stok_strip').val(SubTotal_strip);
        $('#total_stok_pcs').val(SubTotal_pcs);
});
</script>