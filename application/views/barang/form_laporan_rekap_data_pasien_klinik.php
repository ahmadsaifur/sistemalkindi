<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<?php
$level = $this->session->userdata('ap_level');

$tanggal = date('d-M-Y');
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-file-text-o fa-fw'></i> Form Laporan Rekap Pasien Klinik</h5>
			<hr />

			<?php echo form_open('laporan', array('id' => 'FormLaporan')); ?>
			<div class="row">
				<div class="col-sm-5">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-4 control-label">Tanggal</label>
							<div class="col-sm-8">
								<!--<select autocomplete="off" name='from' id='aty' class='form-control input-sm' style='cursor: pointer;'>
									<option value=''>-- Pilih Tanggal --</option>
									<option value='aty_sby'>2019</option>
									<option value='aty_mdn'>ATY MEDAN</option>
									<option value='aty_mksr'>ATY MAKASSAR</option>
									<option value='aty_bali'>ATY BALI</option>
								</select>-->
								<?php
                                $now=date('Y');
                                echo "<select autocomplete='off' id='tanggal_dari' class='form-control input-sm' style='cursor: pointer;' name='tahun'>";
                                for ($a=2019;$a<=$now;$a++)
                                {
                                     echo "<option value='$a'>$a</option>";
                                }
                                echo "</select>";
                                ?>
							</div>
						</div>
					</div>
				</div>
			</div>	

			<div class='row'>
				<div class="col-sm-5">
					<div class="form-horizontal">
						<div class="form-group">
							<div class="col-sm-4"></div>
							<div class="col-sm-8">
								<button type="submit" class="btn btn-success" style='margin-left: 0px;'>Tampilkan</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php echo form_close(); ?>
			<br />
			<div id='result'></div>
			
		</div>
	</div>
</div>
<p class='footer'><?php echo config_item('web_footer'); ?></p>

<link rel="stylesheet" type="text/css" href="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.css"/>
<script src="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.js"></script>
<script>

$(document).on('click', '#TambahPelanggan, #EditPelanggan', function(e){
		e.preventDefault();

		$('.modal-dialog').removeClass('modal-sm');
		$('.modal-dialog').removeClass('modal-lg');
		if($(this).attr('id') == 'TambahPelanggan')
		{
			$('#ModalHeader').html('Tambah Pelanggan');
		}
		if($(this).attr('id') == 'EditPelanggan')
		{
			$('#ModalHeader').html('Edit Pesan');
		}
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});
	
$(document).ready(function(){
	    $('#FormLaporan').submit(function(e){
		e.preventDefault();

		var TanggalDari = $('#tanggal_dari').val();

	    var URL = "<?php echo site_url('penjualan/rekap_laporan_tahun_data_pasien_klinik'); ?>/" + TanggalDari;
			$('#result').load(URL);
	});
});


</script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/dataTables.bootstrap.js"></script>

<?php $this->load->view('include/footer'); ?>