<?php if($penjualan->num_rows() > 0) { ?>
<?php
$level = $this->session->userdata('ap_level');
?>  
    
    <?php if($level == 'admin') { ?>
    <a href="<?php echo site_url('penjualan/pelanggan_online');?>" type="button" class="btn btn-success">Tambah Pasien</a>
    
    <a href="<?php echo site_url('penjualan/tambah-pelanggan2');?>" type="button" class="btn btn-success" id='TambahPelanggan'>Tambah Pasien BARU Online</a>
    <?php } ?>
    
	<table class='table table-striped table-bordered' style="margin-top:10px">
	    <br>
	    <a style="color:black" id="ilang3" style="margin-bottom:10px">Data Jadwal Datang Kembali Pasien Online Tanggal <b style="color:red"> <b><?php echo $from; ?></b> !!!</b></a>
		<thead>
			<tr>
				<th>#</th>
				<th>NRMP</th>
				<th>Nama</th>
				<th>Jadwal Konsul</th>
				<th>Datang Kembali</th>
				<th>Herbalis</th>
				<th>Info Tambahan</th>
				<th>Keterangan Pasien</th>
				<?php if($level == 'admin') { ?>
				<th>Action</th>
				<?php } ?>
			</tr>
		</thead>
		<tbody>
			<?php
			$no = 1;
			$total_penjualan = 0;
			$total_qty = 0;
			$total_modal2 = 0;
			$total_menu_offline = 0;
			$total_harga_modal = 0;
			$laba = 0;
			$total_laba = 0;
			$total_offline2 = 0;
			$uang_sisa = 0;
			
			foreach($penjualan->result() as $p)
			{   
			     echo "  
				    <tr>
				        <td>".$no."</td>
				        <td>".$p->nrmp."</td>
				        <td>".$p->nama."</td>
            			<td>".$p->tanggal_kembali."</td>
						<td>".$p->tgl_kembali2."</td>
						<td>".$p->id_herbalis."</td>
						<td>".$p->info_tambahan."</td>
            		    <td>".$p->keterangan_lain."</td>
						";
						if($level == 'admin') { 
				echo "
						<td><a type='button' class='btn btn-success' href='".site_url('penjualan/pelanggan_edit_datang_kembali/'.$p->id_pelanggan.'/'.$p->id_penjualan_m)."' id='EditPelanggan'><i class='fa fa-pencil'></i> Edit</td>
						";
				
				         } 
				echo "        
				    </tr>
				    ";
				    $no++;
			}	    
			    
			?>
		</tbody>
	</table>

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
	$(document).on('click', '#TambahPelanggan, #EditPelanggan', function(e){
		e.preventDefault();

		$('.modal-dialog').removeClass('modal-sm');
		$('.modal-dialog').removeClass('modal-lg');
		if($(this).attr('id') == 'TambahPelanggan')
		{
			$('#ModalHeader').html('Tambah Pelanggan');
		}
		if($(this).attr('id') == 'EditPelanggan')
		{
			$('#ModalHeader').html('Edit Pesan');
		}
		$('#ModalContent').load($(this).attr('href'));
		$('#ModalGue').modal('show');
	});
</script>