<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<?php
$level = $this->session->userdata('ap_level');

$tanggal = date('d-M-Y');
?>

<div class="container">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5><i class='fa fa-file-text-o fa-fw'></i> Laporan Pasien Datang Kembali Klinik</h5>
			<hr />
            
			<table id="my-grid" class="table table-striped table-bordered" >
			    
			    <a style="color:black" id="ilang3" style="margin-bottom:10px">Data Jadwal Datang Kembali Pasien Pending </a>
					<thead>
						<tr>
							<th>#</th>
							<th>NRMP</th>
							<th>Nama</th>
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
            						<td>".$p->tgl_kembali2."</td>
            						<td>".$p->id_herbalis."</td>
            						<td>".$p->info_tambahan."</td>
            						<td>".$p->keterangan_lain."</td>
            						";
            						if($level == 'admin') { 
            				echo "
            						<td><a type='button' class='btn btn-success' href='".site_url('penjualan/pelanggan_edit_datang_kembali/'.$p->id_pelanggan)."' id='EditPelanggan'><i class='fa fa-pencil'></i> Edit</td>
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
	
$(document).ready(function(){
	    $('#FormLaporan').submit(function(e){
		e.preventDefault();

		var TanggalDari = $('#tanggal_dari').val();
		var TanggalSampai = $('#tanggal_sampai').val();

		if(TanggalDari == '' || TanggalSampai == '')
		{
			$('.modal-dialog').removeClass('modal-lg');
			$('.modal-dialog').addClass('modal-sm');
			$('#ModalHeader').html('Oops !');
			$('#ModalContent').html("Tanggal harus diisi !");
			$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok, Saya Mengerti</button>");
			$('#ModalGue').modal('show');
		}
		else
		{

			var URL = "<?php echo site_url('penjualan/data_pasien_datang_kembali_klinik'); ?>/" + TanggalDari;
			$('#result').load(URL);
			$("#my-grid").hide();
			$("#ilang").hide();
			$("#TambahPelanggan").hide();
			$("#ilang3").hide();
			
		}
	});
});


</script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/jquery.dataTables.js"></script>
<script type="text/javascript" language="javascript" src="<?php echo config_item('plugin'); ?>datatables/js/dataTables.bootstrap.js"></script>

<?php $this->load->view('include/footer'); ?>