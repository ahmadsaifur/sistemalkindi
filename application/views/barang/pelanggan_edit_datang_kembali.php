<?php echo form_open('penjualan/pelanggan_edit_datang_kembali/'.$pelanggan->id_pelanggan.'/'.$id_penjualan_m, array('id' => 'FormEditPelanggan')); ?>

<div class='form-group'>
	<label>NRMP</label>
	<?php
	echo form_input(array(
		'name' => 'nrmp', 
		'class' => 'form-control',
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
		'readonly' => 'true',
		'value' => $pelanggan->nama
	));
	?>
</div>
<div class='form-group'>
	<label>Tanggal Kembali</label>
	<?php
	echo form_input(array(
	    'type' => 'date',
		'name' => 'tgl_kembali',  
		'class' => 'form-control',
		'value' => $pelanggan->tgl_kembali
	));
	?>
</div>
<div class='form-group'>
	<label>Keterangan Pasien</label>
	<select name='keterangan_pasien' class='form-control input-sm' style='cursor: pointer;'>
		<option value=''>-- Pilih Keterangan --</option>
		<option value='Zoom'>Zoom</option>
		<option value='Datang'>Datang</option>
		<option value='Pending'>Pending</option>
	</select>
</div>
<div class='form-group'>
	<label>Info Tambahan Lainnya</label>
	<?php
	echo form_textarea(array(
		'name' => 'info', 
		'class' => 'form-control',
		'value' => $pelanggan->info_tambahan,
		'style' => "resize:vertical",
		'rows' => 3
	));
	?>
</div>

<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script src="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.js"></script>
<link href="https://cdn.jsdelivr.net/timepicker.js/latest/timepicker.min.css" rel="stylesheet"/>

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
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Sukses !');
				$('#ModalContent').html(json.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal'>Ok</button>");
				$('#ModalGue').modal('show');
				setTimeout(function(){// wait for 5 secs(2)
                       location.reload(); // then reload the page.(3)
                  }, 2000); 
				/*$('#my-grid').DataTable().ajax.reload( null, false );
				setInterval(function() 
				    {location.reload();
				}, 2000);*/
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
	
	$('#time').click(function(){
    var timepicker = new TimePicker('time', {
      lang: 'en',
      theme: 'dark'
    });
    timepicker.on('change', function(evt) {
      
      var value = (evt.hour || '00') + ':' + (evt.minute || '00');
      evt.element.value = value;
    
    });
});
	
});

</script>