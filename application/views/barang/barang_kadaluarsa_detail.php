
<table id="my-grid" class="table tabel-transaksi" style='margin-bottom: 0px; margin-top: 10px;'>
	<thead>
		<tr>
			<th>#</th>
			<th>Nama Barang</th>
			<th>Tanggal Masuk</th>
			<th>Tanggal Kadaluarsa</th>
			<th>Qty</th>
			<th>Keterangan</th>
		</tr>
	</thead>
	<tbody>
	    
	<?php
	$no 			= 1;
	foreach($master->result() as $d)
	{
		echo "
			<tr>
				<td>".$no."</td>
				<td>".$d->nama_barang."</td>
				<td>".$d->tanggal_masuk."</td>
				<td>".$d->tgl_kadaluarsa."</td>
				<td>".$d->total_stok."</td>
				<td>".$d->keterangan."</td>
			</tr>
		";

		$no++;
	}
	?>
	</tbody>
</table>

<script>
$(document).ready(function(){
	var Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
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

		window.open("<?php echo site_url('penjualan/transaksi-cetak/?'); ?>" + FormData,'_blank');
	});
});
</script>