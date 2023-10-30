<?php if($penjualan->num_rows() > 0) { ?>

	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>#</th>
				<th>Nama Sales</th>
				<th>Total Obat</th>
				<th>Nama Produk</th>
				<th>Total Penjualan</th>
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
						<td>".$p->nama_sales."</td>
						<td>".$p->jumlah_beli."</td>
						<td>".$p->nama_barang."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->total))."</td>
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->total;
				$no++;
			}

			echo "
				<tr>
					<td colspan='4'><b>Total Seluruh Penjualan</b></td>
					<td><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b></td>
				</tr>
			";
			?>
		</tbody>
	</table>

	<p>
		<?php
		$from 	= date('Y-m-d', strtotime($from));
		$to		= date('Y-m-d', strtotime($to));
		$saless 	= $sales;
		$aty_kota 	= $aty;
		?>
		<a href="<?php echo site_url('laporan/pdf_perproduk_aty/'.$from.'/'.$to.'/'.$saless.'/'.$aty_kota); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>pdf.png"> Export ke PDF</a>
		<a href="<?php echo site_url('laporan/excel/'.$from.'/'.$to); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>xls.png"> Export ke Excel</a>
	</p>
	<br />
<?php } ?>

<?php if($penjualan->num_rows() == 0) { ?>
<div class='alert alert-info'>
Data dari tanggal <b><?php echo $from; ?></b> sampai tanggal <b><?php echo $to; ?></b> tidak ditemukan
</div>
<br />
<?php } ?>