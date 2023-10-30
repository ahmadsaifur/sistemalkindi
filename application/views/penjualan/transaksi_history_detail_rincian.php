<?php
if( ! empty($master->id_pelanggan))
{
	echo "
		<table class='info_pelanggan'>
		    <tr>
				<td>NRMP</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />', $master->nrmp)."</td>
			</tr>
			<tr>
				<td>Nama Pasien</td>
				<td>:</td>
				<td>".$master->nama_pelanggan."</td>
			</tr>
			<tr>
				<td>Herbalis</td>
				<td>:</td>
				<td>".$master->nama_herbalis."</td>
			</tr>
			<tr>
				<td>Tanggal Kembali</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />',$master->tanggal_kembali )."</td>
			</tr>	
				
		</table>
		<hr />
	";
}
else
{
	echo "Pelanggan : Umum";
}
?>

<!-- <tr>
				<td>Telp. / HP</td>
				<td>:</td>
				<td>".$master->telp_pelanggan."</td>
			</tr>
			<tr>
				<td>Informasi Tambahan</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />', $master->info_pelanggan)."</td>
			</tr> -->

<input type="hidden" id="nomor_nota" value="<?php echo html_escape($master->nomor_nota); ?>">
<input type="hidden" id="tanggal" value="<?php echo $master->tanggal; ?>">
<input type="hidden" id="id_kasir" value="<?php echo $master->id_kasir; ?>">
<input type="hidden" id="id_pelanggan" value="<?php echo $master->id_pelanggan; ?>">
<input type="hidden" id="UangCash" value="<?php echo $master->bayar; ?>">
<input type="hidden" id="catatan" value="<?php echo html_escape($master->catatan); ?>">
<input type="hidden" id="TotalBayarHidden" value="<?php echo $master->grand_total; ?>">
<input type="hidden" id="Totalitemdiscount" value="<?php echo $master->total_awal; ?>">
<input type="hidden" id="discount_total" value="<?php echo $master->discount_total; ?>">
<input type="hidden" id="id_herbalis" value="<?php echo $master->nama_herbalis; ?>">
<input type="hidden" id="nrmp" value="<?php echo $master->nrmp; ?>">
<input type="hidden" id="nama_sales" value="<?php echo $master->nama_sales; ?>">
<input type="hidden" id="tanggal_kembali" value="<?php echo $master->tanggal_kembali; ?>">

<table id="my-grid" class="table tabel-transaksi" style='margin-bottom: 0px; margin-top: 10px;'>
	<thead>
		<tr>
			<th>#</th>
			<th>Nama Barang</th>
			<th colspan="3" style='width:20px;'>Dosis</th>
			<th>Harga Satuan</th>
			<th>Qty</th>
			<th>Sub Total</th>
			<th>Disc</th>
			<th>Discount</th>
			<th>Grand Total</th>
		</tr>
	</thead>
	<tbody>
	<?php
	$no 			= 1;
	foreach($detail->result() as $d)
	{
		echo "
			<tr>
				<td>".$no."</td>
				<td>".$d->nama_barang." <input type='hidden' name='kode_barang[]' value='".html_escape($d->kode_barang)."'></td>
				<td>".$d->dosis1." <input type='hidden' name='jumlah_beli[]' value='".html_escape($d->dosis1)."'></td>
				<td>X</td>
				<td>".$d->dosis2." <input type='hidden' name='jumlah_beli_2[]' value='".html_escape($d->dosis2)."'></td>
				<td>".$d->harga_satuan." <input type='hidden' name='harga_satuan[]' value='".$d->harga_satuan_asli."'></td>
				<td>".$d->jumlah_beli." <input type='hidden' name='kebutuhan[]' value='".$d->jumlah_beli."'></td>
				<td>".$d->sub_total_awal." <input type='hidden' name='sub_total_awal[]' value='".$d->sub_total_asli_awal."'></td>
				<td>".$d->discnya ." % <input type='hidden' name='discount[]' value='".$d->discnya."'></td>
				<td>".$d->discount." <input type='hidden' name='discountnya[]' value='".$d->discountnya."'></td>
				<td>".$d->sub_total." <input type='hidden' name='sub_total[]' value='".$d->sub_total_asli."'></td>
			</tr>
		";

		$no++;
	}

	echo "
	    <tr style='background:#deeffc;'>
			<td colspan='10' style='text-align:right;'><b>Total Awal</b></td>
			<td><b>Rp. ".str_replace(',', '.', number_format($master->total_awal))."</b></td>
		</tr>
		<tr style='background:#deeffc;'>
			<td colspan='10' style='text-align:right;'><b>Discount Total</b></td>
			<td><b>Rp. ".$master->discount_total2."</b></td>
		</tr>
		<tr style='background:#deeffc;'>
			<td colspan='10' style='text-align:right;'><b>Grand Total</b></td>
			<td><b>Rp. ".str_replace(',', '.', number_format($master->grand_total))."</b></td>
		</tr>
		<tr>
			<td colspan='10' style='text-align:right; border:0px;'>Bayar</td>
			<td style='border:0px;'>Rp. ".str_replace(',', '.', number_format($master->bayar))."</td>
		</tr>
		<tr>
			<td colspan='10' style='text-align:right; border:0px;'>Kembali</td>
			<td style='border:0px;'>Rp. ".str_replace(',', '.', number_format(($master->bayar - $master->grand_total)))."</td>
		</tr>
	";
	?>
	</tbody>
</table>

<script>
$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='Cetaks'><i class='fa fa-print'></i> Cetak</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$('button#Cetaks').click(function(){
		var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
		FormData += "&tanggal="+encodeURI($('#tanggal').val());
		FormData += "&id_kasir="+$('#id_kasir').val();
		FormData += "&id_pelanggan="+$('#id_pelanggan').val();
		FormData += "&" + $('.tabel-transaksi tbody input').serialize();
		FormData += "&cash="+$('#UangCash').val();
		FormData += "&catatan="+encodeURI($('#catatan').val());
		FormData += "&grand_total="+$('#TotalBayarHidden').val();
		FormData += "&nama_herbalis="+$('#id_herbalis').val();
		FormData += "&sales_pam="+$('#nama_sales').val();
		FormData += "&nrmp="+$('#nrmp').val();
		FormData += "&tanggal_kembali="+$('#tanggal_kembali').val();
		FormData += "&total_discount="+$('#discount_total').val();
		FormData += "&total_awal="+$('#Totalitemdiscount').val();

		window.open("<?php echo site_url('penjualan/tr_cetak_rincian/?'); ?>" + FormData,'_blank');
	});
});
</script>