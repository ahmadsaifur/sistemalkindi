<?php echo form_open('barang/update_stok_online', array('id' => 'FormTambahPelanggan')); ?>

<?php
$level 		= $this->session->userdata('ap_level');
$readonly	= '';
$disabled	= '';
if ($level !== 'admin') {
	$readonly	= 'readonly';
	$disabled	= 'disabled';
}
?>

<div class='form-group'>
	<label>Nama Obat</label>
	<select name='id_barang' id='id_barang' class='form-control input-sm' style='cursor: pointer;'>
		<option value=''>-- Umum --</option>
		<?php
		if ($obat->num_rows() > 0) {
			foreach ($obat->result() as $p) {
				echo "<option value='" . $p->id_barang . "'>" . $p->nama_barang . "- " . $p->id_barang . "</option>";
			}
		}
		?>
	</select>
	<input type='hidden' id='nama_barang' name='nama_barang' class='form-control'>
	<input type='hidden' id='satuan' name='satuan' class='form-control'>
</div>

<div class='form-group'>
	<label>Stok</label>
	<input type='number' id='stok' name='stok' class='form-control' placeholder="0">
</div>

<div class='form-group'>
	<label>User</label>
	<select name='id_kasir' id='id_kasir' class='form-control input-sm' <?php echo $readonly; ?>>
		<?php
		if ($kasirnya->num_rows() > 0) {
			foreach ($kasirnya->result() as $k) {
				$selected = '';
				if ($k->id_user == $this->session->userdata('ap_id_user')) {
					$selected = 'selected';
				}

				echo "<option value='" . $k->id_user . "' " . $selected . ">" . $k->nama . "</option>";
			}
		}
		?>
	</select>
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
	$('#id_barang').change(function() {
		if ($(this).val() !== '') {
			$.ajax({
				url: "<?php echo site_url('barang/ajax_barang_online'); ?>",
				type: "POST",
				cache: false,
				data: "id_barang=" + $(this).val(),
				dataType: 'json',
				success: function(json) {
					$('#nama_barang').val(json.nama_barang);
					// $('#stok').val(json.stok);
					$('#satuan').val(json.satuan);
					/*
										$(".id_herbalis2" ).replaceWith( "<input id='id_herbalis' readonly='readonly' class='form-control' type='text' name='nama_herbalis'> value='"+val(json.herbalis)+"'");*/
				}
			});
		} else {
			$('#nrmp').html('<small><i>Tidak ada</i></small>');
		}
	});

	function TambahPelanggan() {
		$.ajax({
			url: $('#FormTambahPelanggan').attr('action'),
			type: "POST",
			cache: false,
			data: $('#FormTambahPelanggan').serialize(),
			dataType: 'json',
			success: function(json) {
				if (json.status == 1) {
					$('#FormTambahPelanggan').each(function() {
						this.reset();
					});

					if (document.getElementById('PelangganArea') != null) {
						$('#ResponseInput').html('');

						$('.modal-dialog').removeClass('modal-lg');
						$('.modal-dialog').addClass('modal-sm');
						$('#ModalHeader').html('Berhasil');
						$('#ModalContent').html(json.pesan);
						$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Okay</button>");
						$('#ModalGue').modal('show');

						$('#id_pelanggan').append("<option value='" + json.id_pelanggan + "' selected>" + json.nrmp + ' - ' + json.nama + "</option>");
						$('#telp_pelanggan').html(json.telepon);
						$('#alamat_pelanggan').html(json.alamat);
						$('#info_tambahan_pelanggan').html(json.info);
					} else {
						$('#ResponseInput').html(json.pesan);
						setTimeout(function() {
							$('#ResponseInput').html('');
						}, 3000);
						$('#my-grid').DataTable().ajax.reload(null, false);
					}
				} else {
					$('#ResponseInput').html(json.pesan);
				}
			}
		});
	}

	$(document).ready(function() {
		var Tombol = "<button type='button' class='btn btn-primary' id='SimpanTambahPelanggan'>Simpan Data</button>";
		Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
		$('#ModalFooter').html(Tombol);

		$("#FormTambahPelanggan").find('input[type=text],textarea,select').filter(':visible:first').focus();

		$('#SimpanTambahPelanggan').click(function(e) {
			e.preventDefault();
			TambahPelanggan();
		});

		$('#FormTambahPelanggan').submit(function(e) {
			e.preventDefault();
			TambahPelanggan();
		});
	});
</script>