<?php
$controller = $this->router->fetch_class();
$level = $this->session->userdata('ap_level');
?>

<nav class="navbar navbar-default">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo site_url(); ?>">
				<img alt="<?php echo config_item('web_title'); ?>" src="<?php echo config_item('img'); ?>Alkindiherbal1.png">
			</a>
		</div>

		<p class="navbar-text">Anda login sebagai <?php echo $this->session->userdata('ap_level_caption'); ?></p>

		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<!-- OR $level == 'kasir_2'-->
				<li class="dropdown <?php if ($controller == 'pembelian') {
										echo 'active';
									} ?>">
					<!-- <a href="javascript:void()" data-toggle="dropdown" aria-expanded="false" role="button"><i class="fa fa-odnoklassniki fa-fw"></i> Pembelian <span class="caret"></span></a> -->
					<!-- <ul class="dropdown-menu">
						<li>
							<a href="<?= base_url('pembelian/') ?>"> Data Supplier</a>
						</li>
						<li>
							<a href="<?php echo site_url('pembelian/orderbarangpo/') ?>"> Order Barang PO</a>
						</li>
						<li>
							<a href="<?= base_url('pembelian/datapo/') ?>"> Data PO</a>
						</li>
						<li>
							<a href="<?= base_url('pembelian/returpo/') ?>"> Retur PO</a>
						</li>
						<li>
							<a href="<?= base_url('pembelian/datareturpo/') ?>"> Data Retur PO</a>
						</li>
					</ul> -->
				</li>
				<?php if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory' or $level == 'resepsionis') { ?>
					<li class="dropdown <?php if ($controller == 'penjualan') {
											echo 'active';
										} ?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-shopping-cart fa-fw'></i> Penjualan <span class="caret"></span></a>
						<ul class="dropdown-menu">

							<?php if ((!isset($level)) || ($level != "inventory" && $level != "resepsionis")) { ?>
								<li><a href="<?php echo site_url('penjualan/transaksi'); ?>">Transaksi Klinik</a></li>
								<li><a href="<?php echo site_url('penjualan/transaksi2'); ?>">Transaksi Online</a></li>
								<li><a href="<?php echo site_url('penjualan/transaksi_pending'); ?>">Transaksi Pending</a></li>
							<?php } ?>

							<?php if ($level !== 'resepsionis') { ?>
								<li><a href="<?php echo site_url('penjualan/transaksi_asuransi'); ?>">Transaksi Asuransi</a></li>
								<li><a href="<?php echo site_url('penjualan/transaksi_medan'); ?>">Transaksi Medan</a></li>

								<li role="separator" class="divider"></li>
							<?php } ?>

							<li><a href="<?php echo site_url('penjualan/history'); ?>">History Penjualan klinik</a></li>

							<li><a href="<?php echo site_url('penjualan/history_online'); ?>">History Penjualan online</a></li>

							<?php if ($level !== 'resepsionis') { ?>
								<li><a href="<?php echo site_url('penjualan/history_asuransi'); ?>">History asuransi</a></li>
								<li><a href="<?php echo site_url('penjualan/history_medan'); ?>">History Medan</a></li>
							<?php } ?>

							<!-- <li><a href="<?php echo site_url('penjualan/history_stok_klinik'); ?>">History Stok Klinik</a></li> -->
							<?php if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') { ?>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo site_url('penjualan/rincian_pasien'); ?>">Data Rincian Pasien </a></li>
							<?php } ?>

							<?php if ((!isset($level)) || ($level != "inventory" && $level != "resepsionis")) { ?>
								<li><a href="<?php echo site_url('penjualan/pelanggan'); ?>">Data Pasien</a></li>
								<li><a href="<?php echo site_url('penjualan/laporan_rekap_data_pasien_utama'); ?>">Laporan Data Pasien</a></li>
								<!--<li><a href="<?php echo site_url('penjualan/jadwal_pasien_datang_kembali'); ?>">Jadwal Pasien Datang Kembali</a></li>-->
								<li><a href="<?php echo site_url('penjualan/jadwal_pasien_datang_kembali_utama'); ?>">Jadwal Pasien Datang Kembali</a></li>
							<?php } ?>

							<?php if ($level !== 'resepsionis') { ?>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo site_url('penjualan/pelanggan_JMO'); ?>">Data Pasien JMO</a></li>
							<?php } ?>

							<!--<?php if ($level !== 'kasir') { ?>-->
							<li role="separator" class="divider"></li>
							<li><a href="https://alkindikasir.com/pengiriman/index.html" target="_blank">Format Pengiriman Landscape</a></li>
							<li><a href="https://alkindikasir.com/pengiriman/potrait/index.html" target="_blank">Format Pengiriman Potrait</a></li>
						<?php } ?>

						</ul>
					</li>
				<?php } ?>

				<?php if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') { ?>
					<li class="dropdown <?php if ($controller == 'barang') {
											echo 'active';
										} ?>">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-cube fa-fw'></i> Obat <span class="caret"></span></a>
						<ul class="dropdown-menu">
							<!-- <li><a href="<?php echo site_url('barang'); ?>">Semua Obat</a></li> -->
							<li><a href="<?php echo site_url('barang/barang_online'); ?>">Obat Gudang Pusat</a></li>
							<li><a href="<?php echo site_url('barang/barang_online'); ?>">Obat Gudang MDN</a></li>
							<li><a href="<?php echo site_url('barang/barang_online'); ?>">Obat Gudang SBY</a></li>

							<li role="separator" class="divider"></li>

							<!-- 
						<li><a href="<?php echo site_url('barang/list-merek'); ?>">List Merek</a></li> -->
							<li><a href="<?php echo site_url('barang/barang_klinik'); ?>">Obat Klinik Depok</a></li>

							<!-- <li><a href="<?php echo site_url('barang/barang_online'); ?>">Obat Gudang Pusat</a></li> -->


							<?php if ((!isset($level)) || ($level != "kasir" && $level != "keuangan")) { ?>

								<!-- <li role="separator" class="divider"></li>

								<li><a href="<?php echo site_url('barang/barang_online_herbal'); ?>">Gudang Herbal</a></li>
								<li><a href="<?php echo site_url('barang/barang_online_kimia'); ?>">Gudang Kimia</a></li> -->
							<?php } ?>

							<li role="separator" class="divider"></li>
							<!-- <li><a href="<?php echo site_url('barang/history_brg_klinik'); ?>">History Klinik</a></li> -->
							<li><a href="<?php echo site_url('barang/history_brg_online'); ?>">HIstory Gudang Pusat</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="<?php echo site_url('barang/barang_kimia_standar'); ?>">Standar Obat kimia</a></li>
							<li><a href="<?php echo site_url('barang/barang_kadaluarsa'); ?>">Obat Kadaluarsa</a></li>
							<!-- 
						<li><a href="<?php echo site_url('barang/list-kategori'); ?>">Kategori Obat</a></li> -->
						</ul>
					</li>
				<?php } ?>

				<?php if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') { ?>
					<li class="dropdown <?php if ($controller == 'jasa') {
											echo 'active';
										} ?>">
						<a href="<?php echo site_url('jasa'); ?>" aria-haspopup="true"><i class='fa fa-eyedropper fa-fw'></i> Jasa </a>
					</li>
				<?php } ?>

				<?php if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory' or $level == 'resepsionis') { ?>
					<li <?php if ($controller == 'laporan') {
							echo "class='active'";
						} ?>>
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-file-text-o fa-fw'></i> laporan <span class="caret"></span></a>
						<ul class="dropdown-menu">

							<?php if ((!isset($level)) || ($level != "inventory" && $level != "resepsionis")) { ?>
								<li><a href="<?php echo site_url('laporan'); ?>">Laporan Per Item Klinik</a></li>
								<li><a href="<?php echo site_url('laporan/laporan_peritem'); ?>">Laporan Per Item Online</a></li>
								<li role="separator" class="divider"></li>
								<!--<li><a href="<?php echo site_url('laporan/laporan_pasienklinik_khusus'); ?>">Laporan Pasien Klinik <b style='color:red'>(khusus)</b></a></li>-->

								<li><a href="<?php echo site_url('laporan/laporan_pasienklinik'); ?>">Laporan Pasien Klinik</a></li>
								<li><a href="<?php echo site_url('laporan/laporan_pasien'); ?>">Laporan Pasien Online</a></li>
							<?php } ?>

							<li><a href="<?php echo site_url('laporan/laporan_pasien_ATY'); ?>">Laporan Pasien Online ATY</a></li>

							<?php if ((!isset($level)) || ($level != "inventory" && $level != "resepsionis")) { ?>
								<li><a href="<?php echo site_url('laporan/laporan_pasien_asuransi'); ?>">Laporan Pasien Asuransi</a></li>

								<li role="separator" class="divider"></li>
							<?php } ?>


							<?php if ($level !== 'resepsionis') { ?>
								<li><a href="<?php echo site_url('laporan/laporan_obatklinik'); ?>">Laporan Obat Klinik </a></li>
								<li><a href="<?php echo site_url('laporan/laporan_obat'); ?>">Laporan Obat Online</a></li>
								<li><a href="<?php echo site_url('laporan/laporan_obat_ATY'); ?>">Laporan Obat Online ATY</a></li>
								<li><a href="<?php echo site_url('laporan/laporan_obat_kimia'); ?>">Laporan Obat Kimia</a></li>
								<li><a href="<?php echo site_url('laporan/laporan_obat_asuransi'); ?>">Laporan Obat Asuransi</a></li>
							<?php } ?>


							<?php if ((!isset($level)) || ($level != "inventory" && $level != "resepsionis")) { ?>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo site_url('laporan/laporan_sales_perproduk'); ?>">Laporan Sales Per Produk</a></li>

							<?php } ?>

							<?php if ($level !== 'inventory') { ?>
								<li><a href="<?php echo site_url('laporan/laporan_sales_perproduk_ATY'); ?>">Laporan Sales Per Produk ATY</a></li>
							<?php } ?>


							<?php if ((!isset($level)) || ($level != "inventory" && $level != "resepsionis")) { ?>
								<li><a href="<?php echo site_url('laporan/laporan_sales_baru'); ?>">Laporan Sales</a></li>
							<?php } ?>

							<?php if ($level !== 'inventory') { ?>
								<li><a href="<?php echo site_url('laporan/laporan_sales_ATY'); ?>">Laporan Sales ATY</a></li>
							<?php } ?>

							<?php if ((!isset($level)) || ($level != "inventory" && $level != "resepsionis")) { ?>
								<li role="separator" class="divider"></li>

								<li><a href="<?php echo site_url('laporan/laporan_sales_pam'); ?>">Laporan Sales PAM</a></li>
								<li><a href="<?php echo site_url('laporan/laporan_obat_sales_pam'); ?>">Laporan Obat Sales PAM</a></li>

								<li role="separator" class="divider"></li>

								<li><a href="<?php echo site_url('laporan/laporan_herbalis'); ?>">Laporan Herbalis</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo site_url('laporan/laporan_zoom'); ?>">Laporan Zoom Online</a></li>
								<li><a href="<?php echo site_url('laporan/laporan_zoom_klinik'); ?>">Laporan Zoom Klinik</a></li>
								<li><a href="<?php echo site_url('laporan/laporan_obat_zoom'); ?>">Laporan Obat Zoom Online</a></li>
								<li><a href="<?php echo site_url('laporan/laporan_obat_zoom_klinik'); ?>">Laporan Obat Zoom Klinik</a></li>

							<?php } ?>
						</ul>

					</li>
				<?php } ?>

				<?php if ($level == 'admin') { ?>
					<li <?php if ($controller == 'user') {
							echo "class='active'";
						} ?>><a href="<?php echo site_url('user'); ?>"><i class='fa fa-users fa-fw'></i> List User</a></li>
				<?php } ?>
			</ul>

			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class='fa fa-user fa-fw'></i> <?php echo $this->session->userdata('ap_nama'); ?> <span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="<?php echo site_url('user/ubah-password'); ?>" id='GantiPass'>Ubah Password</a></li>
						<li role="separator" class="divider"></li>
						<li><a href="<?php echo site_url('secure/logout'); ?>"><i class='fa fa-sign-out fa-fw'></i> Log Out</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</nav>

<script>
	$(document).on('click', '#GantiPass', function(e) {
		e.preventDefault();

		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Ubah Password');
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});
</script>