<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<?php
$level = $this->session->userdata('ap_level');
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-file-text-o fa-fw'></i> Laporan Penjualan Obat Pasien Zoom Online</h5>
			<hr />

			<?php echo form_open('laporan', array('id' => 'FormLaporan')); ?>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-5 control-label">Dari Tanggal</label>
							<div class="col-sm-7">
								<input type='text' name='from' class='form-control' id='tanggal_dari' value="<?php echo date('Y-m-d'); ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-5 control-label">Sampai Tanggal</label>
							<div class="col-sm-7">
								<input type='text' name='to' class='form-control' id='tanggal_sampai' value="<?php echo date('Y-m-d'); ?>">
							</div>
						</div>
					</div>
				</div>

				<!-- <div class="col-sm-4">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-5 control-label">Pilih Herbalis</label>
							<div class="col-sm-7">
								<select name='herbalis' id='herbalis' class='form-control' style='cursor: pointer;'>
									<option value=''>-- Umum --</option>
									<option value='BM-NS'>BM-NS</option>
											<option value='AY-DN'>AY-DN</option>
											<option value='DT-BW'>DT-BW</option>
											<option value='BM-MT'>BM-MT</option>
											<option value='AY-DT-MT'>AY-DT-MT</option>
											<option value='AY-NS'>AY-NS</option>
											<option value='BW-DN'>BW-DN</option>
											<option value='Dr.Faruq'>Dr.Faruq</option>
								</select>
							</div>
						</div>
					</div>
				</div> -->
			</div>	

			<div class='row'>
				<div class="col-sm-5">
					<div class="form-horizontal">
						<div class="form-group">
							<div class="col-sm-4"></div>
							<div class="col-sm-8">
								<button type="submit" class="btn btn-primary" style='margin-left: 0px;'>Tampilkan</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php echo form_close(); ?>

			<br />
			<p style="color: red">Catatan : Laporan Obat Online Zoom Aja</p>
			<br />
			<div id='result'></div>
		</div>
	</div>
</div>
<p class='footer'><?php echo config_item('web_footer'); ?></p>

<link rel="stylesheet" type="text/css" href="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.css"/>
<script src="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.js"></script>
<script>
$('#tanggal_dari').datetimepicker({
	lang:'en',
	timepicker:false,
	format:'Y-m-d',
	closeOnDateSelect:true
});
$('#tanggal_sampai').datetimepicker({
	lang:'en',
	timepicker:false,
	format:'Y-m-d',
	closeOnDateSelect:true
});

$(document).ready(function(){
	$('#FormLaporan').submit(function(e){
		e.preventDefault();

		var TanggalDari = $('#tanggal_dari').val();
		var TanggalSampai = $('#tanggal_sampai').val();/*
		var herbalis = $('#herbalis').val();*/

		if(TanggalDari == '' || TanggalSampai == '')
		{
			$('.modal-dialog').removeClass('modal-lg');
			$('.modal-dialog').addClass('modal-sm');
			$('#ModalHeader').html('Oops !');
			$('#ModalContent').html("Tanggal harus diisi !");
			$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
			$('#ModalGue').modal('show');
		}
		else
		{
			var URL = "<?php echo site_url('laporan/penjualan_obat_pasien_zoom'); ?>/" + TanggalDari + "/" + TanggalSampai /*+ "/" + herbalis*/;
			$('#result').load(URL);
		}
	});
});
</script>

<?php $this->load->view('include/footer'); ?>