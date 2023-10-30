<?php echo form_open('barang/edit_standar/'.$barang->id_barang, array('id' => 'FormEditBarang')); ?>
<?php
$level = $this->session->userdata('ap_level');
?>
<div class="form-horizontal">
	<div class="form-group">
		<label class="col-sm-3 control-label">Kode Barang</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'name' => 'kode_barang',
				'class' => 'form-control',
				'readonly' => 'readonly',
				'value' => $barang->kode_barang
			));
			echo form_hidden('id_barang', $barang->id_barang);
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Nama Barang</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'name' => 'nama_barang',
				'class' => 'form-control',
				'readonly' => 'readonly',
				'value' => $barang->nama_barang
			));
			?>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Kategori</label>
		<div class="col-sm-8">
			<select name='id_kategori_barang' class='form-control' readonly = 'readonly'>
				<option value=''>---- kategori ----</option>
				<?php
				foreach($kategori->result() as $k)
				{
					$selected = '';
					if($barang->id_kategori_barang == $k->id_kategori_barang){
						$selected = 'selected';
					}
					
					echo "<option value='".$k->id_kategori_barang."' ".$selected.">".$k->kategori."</option>";
				}
				?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-3 control-label">Standar Strip</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'name' => 'standar_strip',
				'class' => 'form-control',
				'value' => $barang->standar_strip
			));
			?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-3 control-label">Standar PCS</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'name' => 'standar_pcs',
				'class' => 'form-control',
				'value' => $barang->standar_pcs
			));
			?>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-sm-3 control-label">Satuan</label>
		<div class="col-sm-8">
			<select name='satuan' class='form-control' readonly = 'readonly'>
				<option value=''>---- satuan ----</option>
				<?php
				foreach($satuan->result() as $k)
				{
					$selected = '';
					if($barang->satuan == $k->satuan){
						$selected = 'selected';
					}
					
					echo "<option value='".$k->satuan."' ".$selected.">".$k->satuan."</option>";
				}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">Keterangan</label>
		<div class="col-sm-8">
			<?php 
			echo form_input(array(
				'name' => 'keterangan',
				'class' => 'form-control',
				'readonly' => 'readonly',
				'value' => $barang->keterangan
			));
			?>
		</div>
	</div>
</div>
<?php echo form_close(); ?>

<div id='ResponseInput'></div>

<script>
$(document).ready(function(){
	var Tombol = "<button type='button' class='btn btn-primary' id='SimpanEditBarang'>Update Data</button>";
	Tombol += "<button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>";
	$('#ModalFooter').html(Tombol);

	$('#SimpanEditBarang').click(function(){
		$.ajax({
			url: $('#FormEditBarang').attr('action'),
			type: "POST",
			cache: false,
			data: $('#FormEditBarang').serialize(),
			dataType:'json',
			success: function(json){
				if(json.status == 1){ 
					$('#ResponseInput').html(json.pesan);
					setTimeout(function(){ 
				   		$('#ResponseInput').html('');
				    }, 3000);
					$('#my-grid').DataTable().ajax.reload( null, false );
				}
				else {
					$('#ResponseInput').html(json.pesan);
				}
			}
		});
	});
});
</script>