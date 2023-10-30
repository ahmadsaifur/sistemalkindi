<?php
	echo "
		<table class='info_pelanggan'>
			<tr>
				<td>Tanggal Transaksi</td>
				<td>:</td>
				<td>".$master->tanggal."</td>
			</tr>
			<tr>
				<td>Nomor Nota</td>
				<td>:</td>
				<td>".$master->nomor_nota."</td>
			</tr>	
				
		</table>
		<hr />
	";
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
<input type="hidden" id="catatan" value="<?php echo html_escape($master->catatan); ?>">

<table id="my-grid" class="table tabel-transaksi" style='margin-bottom: 0px; margin-top: 10px;'>
	<thead>
		<tr>
			<th>#</th>
			<th>Kode Barang</th>
			<th>Nama Barang</th>
			<th>Qty</th>
			<th>Satuan</th>
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
				<td>".$d->qty." <input type='hidden' name='jumlah_beli[]' value='".$d->qty."'></td>
				<td>".$d->satuan." <input type='hidden' name='satuan[]' value='".$d->satuan."'></td>
			</tr>
		";

		$no++;
	}

	?>
	</tbody>
</table>

<script>
$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";/*
	Tombol += "<button type='button' class='btn btn-primary' id='Cetaks'><i class='fa fa-print'></i> Cetak</button>";*/
	$('#ModalFooter').html(Tombol);

	$('button#Cetaks').click(function(){
		var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
		FormData += "&tanggal="+encodeURI($('#tanggal').val());
		FormData += "&id_kasir="+$('#id_kasir').val();
		FormData += "&" + $('.tabel-transaksi tbody input').serialize();
		FormData += "&catatan="+encodeURI($('#catatan').val());

		window.open("<?php echo site_url('penjualan/transaksi-cetak_medan/?'); ?>" + FormData,'_blank');
	});
});
</script>