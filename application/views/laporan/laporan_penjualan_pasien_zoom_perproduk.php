<?php if($penjualan->num_rows() > 0) { ?>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>#</th>
							<th>Tanggal</th>
							<th>Nomor Nota</th>
							<th>Grand Total</th>
							<th>Pelanggan</th>
							<th>Keterangan</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			$total_penjualan = 0;
			foreach($penjualan->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".$p->tanggal."</td>
						<td><a href='".site_url('penjualan/detail-transaksi2_zoom/'.$p->id_penjualan_m)."' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> ".$p->nomor_nota."</a></td>
						<td>".$p->grand_total."</td>
						<td>".$p->nama_pelanggan."</td>
						<td>".$p->keterangan."</td>
					</tr>
				";

				/*$total_penjualan = $total_penjualan + $p->total;*/
				$no++;
			}

			/*echo "
				<tr>
					<td colspan='4'><b>Total Seluruh Penjualan</b></td>
					<td><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b></td>
				</tr>
			";*/
			?>
		</tbody>
	</table>

	<p>
		<?php
		$from 	= date('Y-m-d', strtotime($from));
		$to		= date('Y-m-d', strtotime($to));
		$saless 	= $sales;
		?>
		<!-- <a href="<?php echo site_url('laporan/pdf_perproduk/'.$from.'/'.$to.'/'.$saless); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>pdf.png"> Export ke PDF</a>
		<a href="<?php echo site_url('laporan/excel/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>xls.png"> Export ke Excel</a> -->
	</p>
	<br />
<?php } ?>

<?php if($penjualan->num_rows() == 0) { ?>
<div class='alert alert-info'>
Data dari tanggal <b><?php echo $from; ?></b> sampai tanggal <b><?php echo $to; ?></b> tidak ditemukan
</div>
<br />
<?php } ?>

<script type="text/javascript">
	$(document).on('click', '#LihatDetailTransaksi', function(e){
		e.preventDefault();
		var CaptionHeader = 'Transaksi Nomor Nota ' + $(this).text();
		$('.modal-dialog').removeClass('modal-sm');
		$('.modal-dialog').addClass('modal-lg');
		$('#ModalHeader').html(CaptionHeader);
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal'>Tutup</button>");
		$('#ModalGue').modal('show');
	});
</script>
