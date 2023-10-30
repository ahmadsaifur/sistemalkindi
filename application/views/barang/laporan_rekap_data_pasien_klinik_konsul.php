<?php if($penjualan->num_rows() > 0) { ?>
<?php
$level = $this->session->userdata('ap_level');
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<input type="hidden" id="tahun" value="<?php echo $tahun; ?>"></input>
        <table id="my-grid" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Nomor</th>
							<th>Tanggal Konsul</th>
							<th>Nomor Nota</th>
							<th>NRMP</th>
							<th>Nama Pelanggan</th>
							<th>Herbalis</th><!--
							<th>Jadwal Datang Kembali</th>-->
							<th>Keterangan</th><!--
							<?php if($level == 'admin' OR $level == 'kasir') { ?>
							<th class='no-sort'>Action</th>
							<?php } ?>-->
						</tr>
					</thead>
		<tbody>
			<?php
			$no = 1;
			
			foreach($penjualan->result() as $p)
			{   
			     echo "  
				    <tr>
				        <td>".$no."</td>
				        <td>".$p->tanggal."</td>
				        <td><a href='".site_url('penjualan/detail_transaksi/'.$p->id_penjualan_m)."' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> ".$p->nomor_nota."</a></td>
				        <td>".$p->nrmp."</td>
				        <td>".$p->nama_pelanggan."</td>
						<td>".$p->herbalis."</td>
            		    <td>".$p->keterangan."</td>     
				    </tr>
				    ";
				    $no++;
			}	    
			    
			?>
		</tbody>
				</table>
	<br />
	
<?php } ?>
<!--<a href="<?php echo site_url('laporan/pdf_rekap_data_pasien_klinik/'.$tahun); ?>" target='blank' class='btn btn-default'><img src="<?php echo config_item('img'); ?>pdf.png"> Export ke PDF Data Pasien Tahun <?php echo '"'.$tahun.'"';?></a>-->
<?php if($penjualan->num_rows() == 0) { ?>
<div class='alert alert-info'>
Data dari tanggal <b><?php echo $from; ?></b> sampai tanggal <b><?php echo $to; ?></b> tidak ditemukan
</div>
<br />
<?php } ?>


<script type="text/javascript" language="javascript" >

/*$(document).ready(function() {
        e.preventDefault();
        var TanggalDari = $('#tahun').val();
		var dataTable = $('#my-grid').DataTable( {
			"serverSide": true,
			"stateSave" : false,
			"bAutoWidth": true,
			"oLanguage": {
				"sSearch": "<i class='fa fa-search fa-fw'></i> Pencarian : ",
				"sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per Halaman <?php echo $tambahan; ?>",
				"sInfo": "Menampilkan _START_ s/d _END_ dari <b>_TOTAL_ data</b>",
				"sInfoFiltered": "(difilter dari _MAX_ total data)", 
				"sZeroRecords": "Pencarian tidak ditemukan", 
				"sEmptyTable": "Data kosong", 
				"sLoadingRecords": "Harap Tunggu...", 
				"oPaginate": {
					"sPrevious": "Prev",
					"sNext": "Next"
				}
			},
			"aaSorting": [[ 0, "desc" ]],
			"columnDefs": [ 
				{
					"targets": 'no-sort',
					"orderable": false,
				}
	        ],
			"sPaginationType": "simple_numbers", 
			"iDisplayLength": 10,
			"aLengthMenu": [[10, 20, 50, 100, 150], [10, 20, 50, 100, 150]],
			"ajax":{
				url :"<?php echo site_url('penjualan/rekap_laporan_tahun_data_pasien_klinik_json'); ?>/" + TanggalDari",
				type: "post",
				error: function(){ 
					$(".my-grid-error").html("");
					$("#my-grid").append('<tbody class="my-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
					$("#my-grid_processing").css("display","none");
				}
			}
		} );
	});*/
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
      $('#my-grid').DataTable();
  });
  </script>