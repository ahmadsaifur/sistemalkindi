<?php echo form_open('barang/tambah_klinik', array('id' => 'FormTambahBarang')); ?>

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

<table class='table table-bordered' id='TabelTambahBarang'>
	<thead>
		<tr>
			<th>#</th><!-- 
			<th>Kode Barang</th> -->
			<th>Nama Barang</th>
			<th>Kategori</th>
			<th>Satuan</th>
			<th>Stok</th>
			<th>Harga</th>
			<th>Keterangan</th>
			<th>User</th><!-- 
			<th>Batal</th> -->
		</tr>
	</thead>
	<tbody></tbody>
</table>
<?php echo form_close(); ?>
<!-- 
<button id='BarisBaru' class='btn btn-default'>Baris Baru</button> -->
<div id='ResponseInput'></div>

<script>
$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanTambahBarang'>Simpan Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	BarisBaru();

	$('#BarisBaru').click(function(){
		BarisBaru();
	});
	
    $('#kode_barang').select2({
        dropdownParent: $('#ModalGue')
    });
    
	$('#kode_barang').change(function(){
		if($(this).val() !== '')
		{
			$.ajax({
				url: "<?php echo site_url('barang/ajax_barang1'); ?>",
				type: "POST",
				cache: false,
				data: "kode_barang="+$(this).val(),
				dataType:'json',
				success: function(json){
					$('#nama_barang').val(json.nama_barang);
					$('#kategori').val(json.kategori);
					$('#id_kategori_barang').val(json.id_kategori_barang);
					$('#total_stok').val(json.total_stok);
					$('#harga').val(json.harga);
					$('#satuan').val(json.satuan);
				}
			});
		}
		else
		{
			$('#nama_barang').html('<small><i>Tidak ada</i></small>');
			$('#kategori').html('<small><i>Tidak ada</i></small>');
			$('#total_stok').html('<small><i>Tidak ada</i></small>');
			$('#harga').html('<small><i>Tidak ada</i></small>');
		}
	});

	

	$('#SimpanTambahBarang').click(function(e){
		e.preventDefault();

		if($(this).hasClass('disabled'))
		{
			return false;
		}
		else
		{
			if($('#FormTambahBarang').serialize() !== '')
			{
				$.ajax({
					url: $('#FormTambahBarang').attr('action'),
					type: "POST",
					cache: false,
					data: $('#FormTambahBarang').serialize(),
					dataType:'json',
					beforeSend:function(){
						$('#SimpanTambahBarang').html("Menyimpan Data, harap tunggu ...");
					},
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

						$('#SimpanTambahBarang').html('Simpan Data');
					}
				});
			}
			else
			{
				$('#ResponseInput').html('');
			}
		}
	});

	$("#FormTambahBarang").find('input[type=text],textarea,select').filter(':visible:first').focus();
});

$(document).on('click', '#HapusBaris', function(e){
	e.preventDefault();
	$(this).parent().parent().remove();

	var Nomor = 1;
	$('#TabelTambahBarang tbody tr').each(function(){
		$(this).find('td:nth-child(1)').html(Nomor);
		Nomor++;
	});

	$('#SimpanTambahBarang').removeClass('disabled');
});

$(document).on('keyup', '#total_stok', function(){
	var Indexnya = $(this).parent().parent().index();
	var JumlahBeli = $(this).val();
	var KodeBarang = $('#kode_barang').val();

	$.ajax({
		url: "<?php echo site_url('barang/cek-stok3'); ?>",
		type: "POST",
		cache: false,
		data: "kode_barang="+encodeURI(KodeBarang)+"&stok="+JumlahBeli,
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

function BarisBaru()
{
	var Nomor = $('#TabelTambahBarang tbody tr').length + 1;
	var Baris = "<tr>";
	Baris += "<td>"+Nomor+"</td>";/*
	Baris += "<td><input type='text' name='kode[]' class='form-control input-sm kode_barang'><span id='SamaKode'></span></td>";
*/
	Baris += "<td>";
	Baris += "<select name='kode[]' class='form-control input-sm' id='kode_barang' style='width:100px;'>";
	Baris += "<option value=''></option>";

	<?php 
	if($obat->num_rows() > 0)
	{   
		foreach($obat->result() as $bb) { ?>
		
			Baris += "<option value='<?php echo $bb->kd_barang; ?>'><?php echo $bb->nama_barang; ?></option>";
		<?php }
	}
	?>

	Baris += "</select>";
	Baris += "</td>";
	Baris += "<input type='hidden' name='nama[]' id='nama_barang' class='form-control input-sm' readonly='readonly'>";
	Baris += "<input type='hidden' name='id_kategori_barang[]' id='id_kategori_barang' class='form-control input-sm' readonly='readonly'>";
	Baris += "<td><input type='text' name='kategori[]' id='kategori' class='form-control input-sm' readonly='readonly'></td>";
	
	/*Baris += "<td>";
	Baris += "<select name='id_kategori_barang[]'  id='' class='form-control input-sm' style='width:100px;'>";
	Baris += "<option value=''></option>";

	<?php 
	if($kategori->num_rows() > 0)
	{   
	    
		foreach($kategori->result() as $k) { ?>
	<?php	$selected = '';
			if($barang->id_kategori_barang == $k->id_kategori_barang){
						$selected = 'selected';
			}
	?>
			Baris += "<option value='<?php echo $k->id_kategori_barang; echo ".$selected." ?>'><?php echo $k->kategori; ?></option>";
		<?php }
	}
	?>

	Baris += "</select>";
	Baris += "</td>"; */
	/*onkeypress='return check_int(event)'*/ /*onkeypress='return check_int(event)'*/

	Baris += "<td><input type='text' name='satuan_obat[]' id='satuan' class='form-control input-sm' readonly='readonly'></td>";
	Baris += "<td><input type='text' name='stok[]' id='total_stok' class='form-control input-sm' ></td>";
	Baris += "<td><input type='text' name='harga[]' id='harga' class='form-control input-sm' readonly='readonly'></td>";
	Baris += "<td><textarea name='keterangan[]' class='form-control input-sm' readonly='readonly'>klinik</textarea></td>";
	Baris += "<td><input type='text' name='id_kasir[]' class='form-control input-sm' value='<?php echo $level_id; ?>' readonly></td>";/*
	Baris += "<td align='center'><a href='#' id='HapusBaris'><i class='fa fa-times' style='color:red;'></i></a></td>";*/
	Baris += "</tr>";

	$('#TabelTambahBarang tbody').append(Baris);
}

function check_int(evt) {
	var charCode = ( evt.which ) ? evt.which : event.keyCode;
	return ( charCode >= 48 && charCode <= 57 || charCode == 8 );
}
</script>