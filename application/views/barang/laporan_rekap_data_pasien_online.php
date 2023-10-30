<?php if($penjualan->num_rows() > 0) { ?>
<?php
$level = $this->session->userdata('ap_level');
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

<table id="my-grid" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>Nomor</th>
							<th>Tanggal Transaksi</th>
							<th>NRMP</th>
							<th>Nama Pelanggan</th>
							<th>Sales</th>
							<th>Jadwal Datang Kembali</th>
							<th>Keterangan</th>
							<?php if($level == 'admin' OR $level == 'kasir') { ?>
							<th class='no-sort'>Action</th>
							<?php } ?>
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
				        <td>".$p->nrmp."</td>
				        <td>".$p->nama_pelanggan."</td>
						<td>".$p->sales."</td>
						<td>".$p->tgl_kembali."</td>
            		    <td>".$p->keterangan."</td>
						";
						if($level == 'admin') { 
				echo "
				<td><a type='button' class='btn btn-primary' href='".site_url('penjualan/lihat_transaksi_online/'.$p->id_pelanggan.'/'.$p->tahun)."'><i class='fa fa-book'></i> Lihat</td>
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
				
<?php } ?>
<?php if($penjualan->num_rows() == 0) { ?>
<div class='alert alert-info'>
Data dari tanggal <b><?php echo $from; ?></b> sampai tanggal <b><?php echo $to; ?></b> tidak ditemukan
</div>
<br />
<?php } ?>

<script type="text/javascript" language="javascript" >
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.19/js/jquery.dataTables.min.js"></script>
  <script type="text/javascript">
  $(document).ready(function() {
      $('#my-grid').DataTable();
  });
  </script>