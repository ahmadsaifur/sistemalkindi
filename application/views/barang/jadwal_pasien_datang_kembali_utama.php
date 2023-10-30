<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<?php
$level = $this->session->userdata('ap_level');

$tanggal = date('d-M-Y');
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body hidden-xs">
			<h5><i class='fa fa-file-text-o fa-fw'></i> Laporan Pasien Datang Kembali</h5>
			<hr />
			    <?php if($level == 'admin' OR $level == 'kasir') { ?>
                    <a href="<?php echo site_url('penjualan/form_jadwal_pasien_datang_kembali');?>" type="button" id="ilang" class="btn btn-success"> Jadwal Datang Kembali Klinik</a>
                    
                    <a href="<?php echo site_url('penjualan/form_jadwal_pasien_datang_kembali_online');?>" type="button" id="ilang2" class="btn btn-success" id='TambahPelanggan' style="margin-left:10px">Jadwal Datang Kembali Online</a>
                    
                    <a href="<?php echo site_url('penjualan/pelanggan');?>" type="button" id="ilang2" class="btn btn-success" style="margin-left:10px">Data Semua Pasien</a>
                    
                    <a href="<?php echo site_url('penjualan/jadwal_pasien_pending');?>" type="button"  class="btn btn-danger" style="margin-left:10px">Semua Pasien Pending</a>
                    
                    <!--<a href="whatsapp://send?phone=6283156537859&text=halo fal tes lagi" type="button" id="ilang2" class="btn btn-success" style="margin-left:10px">tes</a>-->
                    
                <?php } ?>
		</div>
		<div class="panel-body visible-xs">
			<h5><i class='fa fa-file-text-o fa-fw'></i> Laporan Pasien Datang Kembali</h5>
			<hr />
			    <?php if($level == 'admin') { ?>
                    <a href="<?php echo site_url('penjualan/form_jadwal_pasien_datang_kembali');?>" type="button" id="ilang" class="btn btn-success"> Jadwal Datang Kembali Klinik</a>
                    <br>
                    
                    <a href="<?php echo site_url('penjualan/form_jadwal_pasien_datang_kembali_online');?>" type="button" id="ilang2" class="btn btn-success" id='TambahPelanggan' style="margin-left:10px">Jadwal Datang Kembali Online</a>
                    <br>
                    
                    <a href="<?php echo site_url('penjualan/pelanggan');?>" type="button" id="ilang2" class="btn btn-success" style="margin-left:10px">Data Semua Pasien</a>
                    <br>
                    
                    <a href="<?php echo site_url('penjualan/pelanggan_pending');?>" type="button"  class="btn btn-danger" style="margin-left:10px">Semua Pasien Pending</a>
                    
                    <!--<a href="whatsapp://send?phone=6283156537859&text=halo fal tes lagi" type="button" id="ilang2" class="btn btn-success" style="margin-left:10px">tes</a>-->
                <?php } ?>
		</div>
	</div>
</div>
<p class='footer'><?php echo config_item('web_footer'); ?></p>


<?php $this->load->view('include/footer'); ?>