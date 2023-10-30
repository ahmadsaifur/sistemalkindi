<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<?php
$level = $this->session->userdata('ap_level');
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-file-text-o fa-fw'></i> Laporan Rekap Data Pasien  <b><?php echo $nama_pasien ?> </b></h5>
			<hr />
			
			<div id='result'></div>
			<table id="my-grid" class="table table-striped table-bordered" >
					<thead>
						<tr>
							<th>#</th>
							<th>Nomor Nota</th>
							<th>Tanggal</th>
							<th>NRMP</th>
							<th>Nama</th>
							<th>Datang Kembali</th>
							<th>Herbalis</th>
							<th>Keterangan Konsul</th>
							<th>Keterangan Pasien</th>
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
            				        <td> <a href='".site_url('penjualan/detail_transaksi/'.$p->id_penjualan_m)."' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> ".$p->nomor_nota."</a></td>
            				        <td>".$p->tanggal."</td>
            				        <td>".$p->nrmp."</td>
            				        <td>".$p->nama_pelanggan."</td>
            						<td>".$p->tgl_kembali."</td>
            						<td>".$p->herbalis."</td>
            				        <td>".$p->Keterangan_Konsul."</td>
            						<td>".$p->keterangan."</td>
            						    
            				    </tr>
            				    ";
            				    $no++;
            			}	    
            			    
            			?>
            		</tbody>
	        </table>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function() {
      $('#tabeluser').DataTable();
  });
  </script>

<?php $this->load->view('include/footer'); ?>