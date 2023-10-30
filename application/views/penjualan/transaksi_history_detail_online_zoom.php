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
				<td>Nama Pelanggan</td>
				<td>:</td>
				<td>".$master->nama_pelanggan."</td>
			</tr>
			<tr>
				<td>Alamat</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />', $master->alamat_pelanggan)."</td>
			</tr>
			<tr>
				<td>Tanggal Kembali</td>
				<td>:</td>
				<td>".preg_replace("/\r\n|\r|\n/",'<br />',$master->tanggal_kembali )."</td>
			</tr>
			<tr>
				<td>Sales</td>
				<td>:</td>
				<td>".$master->nama_sales."</td>
			</tr>
			<tr>
				<td>Herbalis</td>
				<td>:</td>
				<td>".$master->nama_herbalis."</td>
			</tr>
			<tr>
				<td>Kota</td>
				<td>:</td>
				<td>".$master->ATY_kota."</td>
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
<input type="hidden" id="total_awal" value="<?php echo $master->total_awal; ?>">
<input type="hidden" id="discount_total" value="<?php echo $master->discount_total2; ?>">
<input type="hidden" id="id_herbalis" value="<?php echo $master->nama_sales; ?>">
<input type="hidden" id="id_herbalis_ori" value="<?php echo $master->nama_herbalis; ?>">
<input type="hidden" id="kota_aty" value="<?php echo $master->ATY_kota; ?>">
<input type="hidden" id="nrmp" value="<?php echo $master->nrmp; ?>">
<input type="hidden" id="tanggal_kembali" value="<?php echo $master->tanggal_kembali; ?>">

<table id="my-grid" class="table tabel-transaksi" style='margin-bottom: 0px; margin-top: 10px;'>
	<thead>
		<tr>
			<th>#</th>
			<th>Kode Obat</th>
			<th>Nama Barang</th>
			<th>Harga Satuan</th>
			<th>Qty</th>
			<th>Satuan</th>
			<th>Sub Total</th>
			<th>Disc</th>
			<th>Discount</th>
			<th>Sub Total</th>
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
				<td>".$d->kode_barang." <input type='hidden' name='kode_barang[]' value='".html_escape($d->kode_barang)."'></td>
				<td>".$d->nama_barang."</td>
				<td>".$d->harga_satuan." <input type='hidden' name='harga_satuan[]' value='".$d->harga_satuan_asli."'></td>
				<td>".$d->jumlah_beli." <input type='hidden' name='jumlah_beli[]' value='".$d->jumlah_beli."'></td>
				<td>".$d->satuan." <input type='hidden' name='satuan[]' value='".$d->satuan."'></td>
				<td>".$d->sub_total_awal." <input type='hidden' name='sub_total_awal[]' value='".$d->sub_total_asli_awal."'></td>
				<td>".$d->disc."<input type='hidden' name='discount[]' value='".$d->disc."'></td>
				<td>".$d->discount." <input type='hidden' name='discountnya[]' value='".$d->discount."'></td>
				<td>".$d->sub_total." <input type='hidden' name='sub_total[]' value='".$d->sub_total_asli."'></td>
			</tr>
		";

		$no++;
	}

	echo "
	    <tr style='background:#deeffc;'>
			<td colspan='9' style='text-align:right;'><b>Total Awal</b></td>
			<td><b>Rp. ".str_replace(',', '.', number_format($master->total_awal))."</b></td>
		</tr>
		<tr style='background:#deeffc;'>
			<td colspan='9' style='text-align:right;'><b>Discount Total</b></td>
			<td><b>Rp. ".$master->discount_total2."</b></td>
		</tr>
		<tr style='background:#deeffc;'>
			<td colspan='9' style='text-align:right;'><b>Grand Total</b></td>
			<td><b>Rp. ".str_replace(',', '.', number_format($master->grand_total))."</b></td>
		</tr>
		<tr>
			<td colspan='9' style='text-align:right; border:0px;'>Bayar</td>
			<td style='border:0px;'>Rp. ".str_replace(',', '.', number_format($master->bayar))."</td>
		</tr>
		<tr>
			<td colspan='9' style='text-align:right; border:0px;'>Kembali</td>
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
		FormData += "&total_awal="+$('#total_awal').val();
		FormData += "&total_discount="+$('#discount_total').val();
		FormData += "&nama_herbalis="+$('#id_herbalis').val();
		FormData += "&nama_herbalis_ori="+$('#id_herbalis_ori').val();
		FormData += "&aty_kota="+$('#kota_aty').val();
		FormData += "&nrmp="+$('#nrmp').val();
		FormData += "&tanggal_kembali="+$('#tanggal_kembali').val();

		window.open("<?php echo site_url('penjualan/transaksi-cetak2/?'); ?>" + FormData,'_blank');
	});
});
</script>