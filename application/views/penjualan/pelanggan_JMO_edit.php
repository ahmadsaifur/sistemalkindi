<?php echo form_open('penjualan/pelanggan_jmo_edit/'.$pelanggan->id_jmo, array('id' => 'FormEditPelanggan')); ?>

<div class='form-group'>
	<label>NRMP</label>
	<?php
	echo form_input(array(
		'name' => 'nrmp', 
		'class' => 'form-control',
		'readonly' => 'readonly',
		'value' => $pelanggan->nrmp
	));
	?>
</div>

<div class='form-group'>
	<label>Nama</label>
	<?php
	echo form_input(array(
		'name' => 'nama', 
		'class' => 'form-control',
		'readonly' => 'readonly',
		'value' => $pelanggan->nama
	));
	?>
</div>

<div class='form-group'>
	<label>Herbalis</label>
	<?php
	echo form_input(array(
		'name' => 'herbalis', 
		'class' => 'form-control',
		'value' => $pelanggan->herbalis,
		'autocomplete' =>"off",
		'id' =>"id_herbalis",
		'readonly' => 'readonly',
		'rows' => 3
	));
	?>
	<button type="button" id="klik" class="btn btn-primary btn-sm" data-toggle="modal" style="margin-top: 5px" ><b> EDIT </b></button>
</div>

<div class='form-group'>
	<label>Keterangan</label>
	<?php
	echo form_input(array(
		'name' => 'keterangan', 
		'class' => 'form-control',
		'value' => $pelanggan->keterangan,
		'autocomplete' =>"off",
		'readonly' => 'readonly',
		'id' =>"keterangan",
		'rows' => 3
	));
	?>
	<button type="button" id="ubah_keterangan" class="btn btn-primary btn-sm" data-toggle="modal" style="margin-top: 5px" ><b> EDIT </b></button>
</div>

<div class='form-group'>
	<label>Info Tambahan</label>
	<?php
	echo form_textarea(array(
		'name' => 'info_tambahan', 
		'class' => 'form-control',
		'value' => $pelanggan->info_tambahan,
		'style' => "resize:vertical",
		'rows' => 3
	));
	?>
</div>

<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
function EditPelanggan()
{
	$.ajax({
		url: $('#FormEditPelanggan').attr('action'),
		type: "POST",
		cache: false,
		data: $('#FormEditPelanggan').serialize(),
		dataType:'json',
		success: function(json){
			if(json.status == 1){ 
				$('#ResponseInput').html(json.pesan);
				setTimeout(function(){ 
			   		$('#ResponseInput').html('');
			    }, 3000);
				$('#my-grid').DataTable().ajax.reload( null, false );
			}
			else {
				$('#ResponseInput').html(json.pesan);
			}
		}
	});
}


$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanEditPelanggan'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$("#FormEditPelanggan").find('input[type=text],textarea,select').filter(':visible:first').focus();

	$('#SimpanEditPelanggan').click(function(e){
		e.preventDefault();
		EditPelanggan();
	});

	$('#FormEditPelanggan').submit(function(e){
		e.preventDefault();
		EditPelanggan();
	});
	
	$("#klik").click(function () {

       		$("#id_herbalis" ).replaceWith( "<select name='herbalis' class='form-control input-sm' style='cursor: pointer;' autocomplete='off'><option value=''>-- Pilih Herbalis --</option><option value='Akhi Faruq'>Akhi Faruq</option><option value='Ayu Indah Lestari'>Ayu Indah Lestari</option><option value='Meutia Anita Bakti'>Meutia Anita Bakti</option><option value='Mira Natawiriya'>Mira Natawiriya</option><option value='Nien Kurniasih'>Nien Kurniasih</option><option value='Nintin Apriyanti'>Nintin Apriyanti</option><option value='Sri Winarti'>Sri Winarti</option><option value='Tien Suryatini'>Tien Suryatini</option><option value=''>-------------------------------</option><option value='OL Yeski'>OL Yeski</option><option value='OL Ricko'>OL Ricko</option><option value='OL Fendi'>OL Fendi</option></select>");
       		$(this).hide();/*
       		$(".save").show();*/
       		// $(".foto").show();
   		});
   	
   	$("#ubah_keterangan").click(function () {

       		$("#keterangan" ).replaceWith( "<select name='keterangan' class='form-control input-sm' style='cursor: pointer;' autocomplete='off'><option value=''>-- Pilih Keterangan --</option><option value='pasien klinik'>Pasien Klinik</option><option value='pasien online'>Pasien Online</option><option value='pasien zoom'>Pasien Zoom</option></select>");
       		$(this).hide();/*
       		$(".save").show();*/
       		// $(".foto").show();
   		});
});
</script>