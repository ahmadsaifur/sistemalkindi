<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<?php
$level = $this->session->userdata('ap_level');
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-file-text-o fa-fw'></i> Laporan Penjualan Pasien Online ATY SEMUA KOTA</h5>
			<a href="<?php echo site_url('laporan/laporan_pasien_ATY'); ?>" class='btn btn-info'>PER KOTA</a>
			<!-- <h2><center>ATY</center></h2> -->
			<hr />

			<?php echo form_open('laporan', array('id' => 'FormLaporan')); ?>
			<div class="row">
				<div class="col-sm-4">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-4 control-label">Dari Tanggal</label>
							<div class="col-sm-8">
								<input type='text' name='from' class='form-control' id='tanggal_dari' value="<?php echo date('Y-m-d'); ?>">
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-4">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-4 control-label">Sampai Tanggal</label>
							<div class="col-sm-8">
								<input type='text' name='to' class='form-control' id='tanggal_sampai' value="<?php echo date('Y-m-d'); ?>">
							</div>
						</div>
					</div>
				</div>

				<!--<div class="col-sm-4">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-5 control-label">Pilih Kota ATY</label>
							<div class="col-sm-7">
								<select name='aty' id='aty_kota' class='form-control' style='cursor: pointer;'>
									<option value='a'>-- PILIH KOTA --</option>
									<option value='aty_mksr'>-- ATY MAKASSAR --</option>
									<option value='aty_mdn'>-- ATY MEDAN --</option>
									<option value='aty_sby'>-- ATY SURABAYA --</option>
									<option value='aty_bali'>-- ATY BALI --</option>
									
								</select>
							</div>
						</div>
					</div>
				</div>-->
			</div>	

			<div class='row'>
				<div class="col-sm-4">
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
			<p style="color: red">Catatan : Laporan Pasien Online ATY Saja </p>
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
		var TanggalSampai = $('#tanggal_sampai').val();

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
			var URL = "<?php echo site_url('laporan/penjualan_pasien_ATY_semua_kota'); ?>/" + TanggalDari + "/" + TanggalSampai;
			$('#result').load(URL);
		}
	});
});
</script>

<?php $this->load->view('include/footer'); ?>