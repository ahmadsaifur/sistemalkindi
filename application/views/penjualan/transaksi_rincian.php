<?php $this->load->view('include/header'); ?>
<?php $this->load->view('include/navbar'); ?>

<style>
.footer {
	margin-bottom: 22px;
}
.panel-primary .form-group {
	margin-bottom: 10px;
}
.form-control {
	border-radius: 0px;
	box-shadow: none;
}
.error_validasi { margin-top: 0px; }
</style>

<?php
$level 		= $this->session->userdata('ap_level');
$readonly	= '';
$disabled	= '';
if($level !== 'admin')
{
	$readonly	= 'readonly';
	$disabled	= 'disabled';
}
?>

<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-body">

			<div class='row'>
				<div class='col-sm-12'>
				    <h5 class='judul-transaksi'>
						<i class='fa fa-shopping-cart fa-fw'></i> Penjualan <i class='fa fa-angle-right fa-fw'></i> <b>Transaksi Rincian Pasien</b>
						<a href="<?php echo site_url('penjualan/transaksi_rincian'); ?>" class='pull-right'><i class='fa fa-refresh fa-fw'></i> Refresh Halaman</a>
					</h5>
					<div class="panel panel-primary" >
						<div class="panel-heading"><i class='fa fa-file-text-o fa-fw'></i> Informasi Nota pasien</div>
						<div class="panel-body">

							<div class="form-horizontal">
							    
							    
								<div class="form-group">
									<label class="col-sm-1 control-label">No. Nota</label>
									<div class="col-sm-11">
										<input type='text' name='nomor_nota' class='form-control input-sm' id='nomor_nota' value="<?php echo strtoupper(uniqid()).$this->session->userdata('ap_id_user'); ?>" <?php echo $readonly; ?>>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-1 control-label">Tanggal</label>
									<div class="col-sm-11">
										<input type='text' name='tanggal' class='form-control input-sm' id='tanggal' value="<?php echo date('Y-m-d H:i:s'); ?>">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-1 control-label">Kasir</label>
									<div class="col-sm-11">
										<select name='id_kasir' id='id_kasir' class='form-control input-sm' <?php echo $disabled; ?>>
											<?php
											if($kasirnya->num_rows() > 0)
											{
												foreach($kasirnya->result() as $k)
												{
													$selected = '';
													if($k->id_user == $this->session->userdata('ap_id_user')){
														$selected = 'selected';
													}

													echo "<option value='".$k->id_user."' ".$selected.">".$k->nama."</option>";
												}
											}
											?>
										</select>
									</div>
								</div>
							    
							    <div class="form-group">
    								<label class="col-sm-1 control-label">Pasien</label>
									<div class="col-sm-11">
    								<select name='id_pelanggan' id='id_pelanggan' class='form-control input-sm' style='cursor: pointer;'>
    									<option value=''>--- Umum ---</option>
    									<?php
    									if($pelanggan->num_rows() > 0)
    									{
    										foreach($pelanggan->result() as $p)
    										{
    											echo "<option value='".$p->id_pelanggan."'>".$p->nrmp.' - '.$p->nama."</option>";
    										}
    									}
    									?>
    								</select>
									</div>
							    </div>
							    
							    
							<div class="form-horizontal">
								<!-- <div class="form-group">
									<label class="col-sm-4 control-label">Telp / HP</label>
									<div class="col-sm-8">
										<div id='telp_pelanggan'><small><i>Tidak ada</i></small></div>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-4 control-label">Alamat</label>
									<div class="col-sm-8">
										<div id='alamat_pelanggan'><small><i>Tidak ada</i></small></div>
									</div>
								</div> -->
								<div class="form-group">
										<input id="nrmp" class="form-control" type="hidden" name="nrmp">
								</div>
								<div class="form-group">
									<label class="col-sm-1 control-label">Herbalis</label>
									<div class="col-sm-11">
										<input id="id_herbalis" class="form-control" type="text" name="nama_herbalis">
										<!--<select name='nama_herbalis' id='id_herbalis' class='form-control input-sm' style='cursor: pointer;'>
											<option value=''>-- Pilih Herbalis --</option>
											<option value='BM - DN'>BM - DN</option>
											<option value='AY - DN'>AY - DN</option>
											<option value='BW - DN'>BW - DN</option>
											<option value='BM'>BM</option>
											<option value='AY'>AY</option>
											<option value='BW'>BW</option>
											<option value='DR. FARUQ'>DR. FARUQ</option>
											
										</select>-->
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-1 control-label">Tanggal Kembali</label>
									<div class="col-sm-11">
										<input type="date" name="tanggal_kembali" class="form-control input-sm" id="tanggal_kembali">
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-1 control-label">Sales</label>
									<div class="col-sm-11">
										<!--<input type="text" name="sales_pam" class="form-control input-sm" id="sales_pam">-->
										<select name='sales_pam' id='sales_pam' class='form-control input-sm' style='cursor: pointer;'>
										    <option value=''>--- Pilih --</option>
											<option value='  '>Klinik</option>
											<option value='PAM'>PAM</option>
										</select>
									</div>
								</div>
							</div>
							    
							</div>

						</div>
					</div>
				</div>
				<div class='col-sm-12'>
					
					<h5 id="judul_b" style='color:blue'>
						<i class='fa fa-shopping-cart fa-fw'></i><b>Transaksi Rincian Pasien 1 bulan</b>
					</h5>
					
					<table class='table table-bordered' id='TabelTransaksi'>
						<thead>
							<tr>
								<th style='width:25px;'>#</th>
								<th style='width:150px;'>Kode Barang</th>
								<th style='width:250px;'>Nama Barang</th>
								<th colspan="3" style='width:20px;text-align:center'>Dosis</th>
								<th style='width:50px;'>Isi</th>
								<th style='width:110px;'>Harga</th>
								<th style='width:50px;'>Kebutuhan 1 Bulan</th>
								<th style='width:135px;'>Sub Total</th>
								<th style='width:75px;'>Disc %</th>
								<th style='width:120px;'>Discount</th>
								<th style='width:135px;'>Grand Total</th>
								<th style='width:100px;'>action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>

					<div class='alert alert-info TotalBayar'>
						<button id='BarisBaru' class='btn btn-default pull-left'><i class='fa fa-plus fa-fw'></i> Baris Baru (F7)</button>
						<button id='1minggu' class='btn btn-danger pull-left'>Rincian 1 Minggu</button>
						<h2>Total : <span id='TotalBayar'>Rp. 0</span></h2>
						<input type="hidden" id='TotalBayarHidden'>
						<input type="hidden" id='Totaldiscounthidden'>
						<input type="hidden" id='Totalitemdiscount'>
						<input type="hidden" id='TotalBayarHidden2'>
					</div>
					
					<h5 id="judul_m" style='color:red;'>
						<i class='fa fa-shopping-cart fa-fw' ></i><b>Transaksi Rincian Pasien 2 Minggu</b>
					
						<button id='1minggu_t' style="margin-bottom:10px" class='btn btn-danger pull-right'>X Tutup Rincian 2 Minggu </button>
					</h5>
					
					<table class='table table-bordered'  id='TabelTransaksi_m'>
						<thead>
							<tr>
								<th style='width:25px;'>#</th>
								<th style='width:150px;'>Kode Barang</th>
								<th style='width:250px;'>Nama Barang</th>
								<th colspan="3" style='width:20px;text-align:center'>Dosis</th>
								<th style='width:50px;'>Isi</th>
								<th style='width:110px;'>Harga</th>
								<th style='width:50px;'>Kebutuhan 2 Minggu</th>
								<th style='width:135px;'>Sub Total</th>
								<th style='width:75px;'>Disc %</th>
								<th style='width:120px;'>Discount</th>
								<th style='width:135px;'>Grand Total</th>
								<th style='width:100px;'>action</th>
							</tr>
						</thead>
						<tbody></tbody>
					</table>

					<div class='alert alert-info TotalBayar' id='T_minggu'>
					    <button id='BarisBaru_m' class='btn btn-default pull-left'><i class='fa fa-plus fa-fw'></i> Baris Baru (F7)</button>
						<h2>Total : <span id='TotalBayar_m'>Rp. 0</span></h2>
						<input type="hidden" id='TotalBayarHidden_m'>
						<input type="hidden" id='Totaldiscounthidden_m'>
						<input type="hidden" id='Totalitemdiscount_m'>
						<input type="hidden" id='TotalBayarHidden2_m'>
					</div>

					<div class='row'>
						<div class='col-sm-7'>
							<textarea name='catatan' id='catatan' class='form-control' rows='2' placeholder="Catatan Transaksi (Jika Ada)" style='resize: vertical; width:83%;'></textarea>
							
							<br />
							<p><i class='fa fa-keyboard-o fa-fw'></i> <b>Shortcut Keyboard : </b></p>
							<div class='row'>
								<div class='col-sm-6'>F7 = Tambah baris baru</div>
								<div class='col-sm-6'>F9 = Cetak Struk</div>
								<div class='col-sm-6'>F8 = Fokus ke field bayar</div>
								<div class='col-sm-6'>F10 = Simpan Transaksi</div>
							</div> 
						</div>
						<div class='col-sm-5'>
							<div class="form-horizontal">
								<div class="form-group ak">
									<label class="col-sm-2 control-label">Disc%</label>
									<div class="col-sm-3">
										<input type='number' id='discc' class='form-control'>
									</div> 
									<label class="col-sm-2 control-label">Discount</label>
									<div class="col-sm-5">
										<input type='text' id='discount_all' class='form-control'>
									</div>
								</div>
								<div class="form-group ak">
									<label class="col-sm-6 control-label">Total Setelah Discount</label>
									<div class="col-sm-6">
										<input type='text' id='TotalBayarHidden3' class='form-control' disabled>
									</div>
								</div>
								<div class="form-group ak">
									<label class="col-sm-6 control-label">Bayar (F8)</label>
									<div class="col-sm-6">
										<input type='text' name='cash' id='UangCash' class='form-control' onkeypress='return check_int(event)'>
									</div>
								</div>
								<div class="form-group ak">
									<label class="col-sm-6 control-label">Kembali</label>
									<div class="col-sm-6">
										<input type='text' id='UangKembali' class='form-control' disabled>
									</div>
								</div>
								
								<div class='row'>
									<div class='col-sm-6' id="save">
									  
									</div>
									<div class='col-sm-3' style='padding-right: 0px;'>
									    <button type='button' class='btn btn-warning btn-block' id='CetakStruk'>
											<i class='fa fa-print'></i> Cetak
										</button>
									</div>
									<div class='col-sm-3' style='padding-right: 0px;'>
										<button type='button' class='btn btn-primary btn-block' id='CetakStruk_all'>
											<i class='fa fa-print'></i> Cetak All
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>

					<br />
				</div>
			</div>

		</div>
	</div>
</div>

<p class='footer'><?php echo config_item('web_footer'); ?></p>

<link rel="stylesheet" type="text/css" href="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.css"/>
<script src="<?php echo config_item('plugin'); ?>datetimepicker/jquery.datetimepicker.js"></script>
<script>
$('#tanggal').datetimepicker({
	lang:'en',
	timepicker:true,
	format:'Y-m-d H:i:s'
});


$(document).ready(function(){
    
    for(B=1; B<=1; B++){
		BarisBaru();
	}

	$("#simpan").hide();
    $("#1minggu").hide();/*
    $("#save").hide();*/
    $(".ak").hide();
	    BarisBaru_m();
	    /*
    $("#TabelTransaksi_m").hide();
	$("#T_minggu").hide();
	$("#judul_m").hide();*/
	
    $("#1minggu").click(function () {
        $("#TabelTransaksi_m").show();
	    $("#T_minggu").show();
        $("#judul_m").show();
        
        $(this).hide();
	    BarisBaru_m();
	    
    });
    
    $("#1minggu_t").click(function () {
        $("#TabelTransaksi_m").hide();
	    $("#T_minggu").hide();
	    $("#judul_m").hide();
	    
        $("#1minggu").show();
        $("#save" ).replaceWith( "<div class='col-sm-6' id='save'><button type='button' class='btn btn-success btn-block' id='Simpann'><i class='fa fa-floppy-o'></i> Simpan (F10)</button></div>");
										
        $(".ak").show();/*
	    $('#TabelTransaksi_m tbody tr').remove();*/
    });

	$("#klik").click(function () {

       		$("#id_herbalis" ).replaceWith( "<select name='id_herbalis' id='id_herbalis' class='form-control input-sm' style='cursor: pointer;'><option value=''>-- pilih herbalis --</option><?php if($herbalis->num_rows() > 0)
											{
												foreach($herbalis->result() as $p)
												{
													echo "<option value='".$p->nama_herbalis."'>".$p->nama_herbalis."</option>";
												}
											}
											?></select>");
       		$(this).hide();/*
       		$(".save").show();*/
       		// $(".foto").show();
   		});
		$(document).on('click', '#editharga', function(){
			var Indexnya = $(this).parent().parent().index();
	        var Harga = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').val();
       		$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').prop('type','text').val(Harga);
       		$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) span').hide();
	        $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(9) input').removeAttr('readonly').val(0);
       		HitungTotalBayar();
   		});

	/*$(document).on('click', '#HapusBaris', function(e){
	e.preventDefault();
	$(this).parent().parent().remove();

	var Nomor = 1;
	$('#TabelTransaksi tbody tr').each(function(){
		$(this).find('td:nth-child(1)').html(Nomor);
		Nomor++;
	});

	HitungTotalBayar();
	});*/


    $('#id_pelanggan').select2({
      placeholder: 'Pilih Pasien',
      allowClear: true
    });

	$('#id_pelanggan').change(function(){
		if($(this).val() !== '')
		{
			$.ajax({
				url: "<?php echo site_url('penjualan/ajax_pelanggan'); ?>",
				type: "POST",
				cache: false,
				data: "id_pelanggan="+$(this).val(),
				dataType:'json',
				success: function(json){
					$('#telp_pelanggan').html(json.telp);
					$('#alamat_pelanggan').html(json.alamat);
					$('#info_tambahan_pelanggan').html(json.info_tambahan);
					$('#id_herbalis').val(json.herbalis);
					$('#nrmp').val(json.nrmp);
					$('#tanggal_kembali').val(json.tgl_kembali);/*
					$(".id_herbalis2" ).replaceWith( "<input id='id_herbalis' readonly='readonly' class='form-control' type='text' name='nama_herbalis'> value='"+val(json.herbalis)+"'");*/
				}
			});
		}
		else
		{
			$('#telp_pelanggan').html('<small><i>Tidak ada</i></small>');
			$('#alamat_pelanggan').html('<small><i>Tidak ada</i></small>');
			$('#info_tambahan_pelanggan').html('<small><i>Tidak ada</i></small>');
		}
	});

	$('#BarisBaru').click(function(){
		BarisBaru();
	});
	
	$('#BarisBaru_m').click(function(){
		BarisBaru_m();
	});

	$("#TabelTransaksi tbody").find('input[type=text],textarea,select').filter(':visible:first').focus();
});

function BarisBaru()
{
	var Nomor = $('#TabelTransaksi tbody tr').length + 1;
	var Baris = "<tr>";
		Baris += "<td>"+Nomor+"</td>";
		Baris += "<td>";
			Baris += "<input type='text' class='form-control' name='kode_barang[]' id='pencarian_kode' placeholder='Ketik Kode' autocomplete='text'>";
			Baris += "<div id='hasil_pencarian'></div>";
		Baris += "</td>";
		Baris += "<td></td>";
		Baris += "<td><input type='text' class='form-control' id='jumlah_beli' name='jumlah_beli[]' onkeypress='return check_int(event)' disabled></td>";
		Baris += "<td> X </td>";
		Baris += "<td><select name='jumlah_dosis2[]' id='jumlah_dosis2' class='form-control ' style='cursor: pointer;width:70px;' disabled><option value='0'>0</option><option value='0.25'>1/4</option><option value='0.5'>1/2</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option><option value='5'>5</option><option value='6'>6</option><option value='7'>7</option><option value='8'>8</option><option value='9'>9</option><option value='10'>10</option><option value='11'>11</option><option value='12'>12</option><option value='13'>13</option><option value='14'>14</option><option value='15'>15</option></select><input type='hidden' class='form-control' id='jumlah_beli_2' name='jumlah_beli_2[]' readonly></td>";
		Baris += "<td>";
			Baris += "<input type='hidden' class='form-control' id='isi' name='isi[]'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td>";
			Baris += "<input type='hidden' class='form-control' name='harga_satuan[]' id='hargasatuannya2'>";
			Baris += "<span id='hargasatuannya'></span>";
		Baris += "</td>";
		Baris += "<td><input type='text' class='form-control' id='kebutuhan' name='kebutuhan[]' onkeypress='return check_int(event)' readonly></td>";
		Baris += "<td>";
			Baris += "<input type='hidden' name='sub_total_awal[]' id='valtotal'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td><input type='text' step='any' class='form-control' id='discount' name='discount[]'onkeypress='return check_int(event)' disabled></td>";
		Baris += "<td>";
			Baris += "<input type='hidden' step='any' name='discountnya[]' id='discountnya'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td>";
			Baris += "<input type='hidden' name='sub_total[]' id='valtotal2'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td><button class='btn btn-default' id='HapusBaris'><i class='fa fa-times' style='color:red;'></i></button> <button class='btn btn-default' id='editharga'><i class='fa fa-check' style='color:red;'></i></button></td>";
		Baris += "</tr>";

	$('#TabelTransaksi tbody').append(Baris);

	$('#TabelTransaksi tbody tr').each(function(){
		$(this).find('td:nth-child(2) input').focus();
	});

	HitungTotalBayar();
	HitungTotalBayar_m();
}

function BarisBaru_m()
{
	var Nomor = $('#TabelTransaksi_m tbody tr').length + 1;
	var Baris = "<tr>";
		Baris += "<td>"+Nomor+"</td>";
		Baris += "<td>";
			Baris += "<input type='text' class='form-control' name='kode_barang_m[]' id='pencarian_kode_m' placeholder='Ketik Kode' autocomplete='text' readonly>";
			Baris += "<div id='hasil_pencarian_m'></div>";
		Baris += "</td>";
		Baris += "<td></td>";
		Baris += "<td><input type='text' class='form-control' id='jumlah_beli_m' name='jumlah_beli_m[]' onkeypress='return check_int(event)' readonly></td>";
		Baris += "<td> X </td>";
		Baris += "<td><select name='jumlah_dosis2_m[]' id='jumlah_dosis2_m' class='form-control ' style='cursor: pointer;width:70px;' disabled><option value='0'>0</option><option value='0.25'>1/4</option><option value='0.5'>1/2</option><option value='1'>1</option><option value='2'>2</option><option value='3'>3</option><option value='4'>4</option></select><input type='hidden' class='form-control' id='jumlah_beli_2_m' name='jumlah_beli_2_m[]' readonly></td>";
		Baris += "<td>";
			Baris += "<input type='hidden' class='form-control' id='isi_m' name='isi_m[]'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td>";
			Baris += "<input type='hidden' class='form-control' name='harga_satuan_m[]' id='hargasatuannya2_m'>";
			Baris += "<span id='hargasatuannya_m'></span>";
		Baris += "</td>";
		Baris += "<td><input type='text' class='form-control' id='kebutuhan' name='kebutuhan_m[]' onkeypress='return check_int(event)' readonly></td>";
		Baris += "<td>";
			Baris += "<input type='hidden' name='sub_total_awal_m[]' id='valtotal'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td><input type='text' step='any' class='form-control' id='discount_m' name='discount_m[]'onkeypress='return check_int(event)' readonly></td>";
		Baris += "<td>";
			Baris += "<input type='hidden' step='any' name='discountnya_m[]' id='discountnya_m'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td>";
			Baris += "<input type='hidden' name='sub_total_m[]' id='valtotal2_m'>";
			Baris += "<span></span>";
		Baris += "</td>";
		Baris += "<td><button class='btn btn-default' id='HapusBaris'><i class='fa fa-times' style='color:red;'></i></button> <button class='btn btn-default' id='editharga'><i class='fa fa-check' style='color:red;'></i></button></td>";
		Baris += "</tr>";

	$('#TabelTransaksi_m tbody').append(Baris);

	/*$('#TabelTransaksi_m tbody tr').each(function(){
		$(this).find('td:nth-child(2) input').focus();
	});*/

	HitungTotalBayar_m();
}

$(document).on('click', '#HapusBaris', function(e){
	e.preventDefault();
	$(this).parent().parent().remove();

	var Nomor = 1;
	$('#TabelTransaksi tbody tr').each(function(){
		$(this).find('td:nth-child(1)').html(Nomor);
		Nomor++;
	});

	HitungTotalBayar();
});

function AutoCompleteGue(Lebar, KataKunci, Indexnya)
{
	$('div#hasil_pencarian').hide();
	var Lebar = Lebar + 25;

	var Registered = '';
	$('#TabelTransaksi tbody tr').each(function(){
		if(Indexnya !== $(this).index())
		{
			if($(this).find('td:nth-child(2) input').val() !== '')
			{
				Registered += $(this).find('td:nth-child(2) input').val() + ',';
			}
		}
	});
	
	$('#TabelTransaksi tbody tr').each(function(){
		if(Indexnya !== $(this).index())
		{
			if($(this).find('td:nth-child(2) input').val() !== '')
			{
				Registered += $(this).find('td:nth-child(2) input').val() + ',';
			}
		}
	});

	if(Registered !== ''){
		Registered = Registered.replace(/,\s*$/,"");
	}

	$.ajax({
		url: "<?php echo site_url('penjualan/ajax_kode_rincian'); ?>",
		type: "POST",
		cache: false,
		data:'keyword=' + KataKunci + '&registered=' + Registered,
		dataType:'json',
		success: function(json){
			if(json.status == 1)
			{
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').css({ 'width' : Lebar+'px' });
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').show('fast');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').html(json.datanya);
			}
			if(json.status == 0)
			{
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').prop('disabled', true).val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) select').prop('disabled', true);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(7) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(7) span').html('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').val('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) span').html('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) input').val(0);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) span').html('');
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(11) input').prop('disabled', true).val('');
				
				/*Tabel Minggu*/
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(3)').html('');
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(4) input').prop('disabled', true).val('');
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(6) select').prop('disabled', true);
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(7) input').val('');
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(7) span').html('');
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(8) input').val('');
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(8) span').html('');
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(10) input').val(0);
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(10) span').html('');
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(11) input').prop('disabled', true).val('');
			}
		}
	});

	HitungTotalBayar();
	HitungTotalBayar_m();
}

/*function AutoCompleteGue_m(Lebar, KataKunci, Indexnya)
{
	$('div#hasil_pencarian_m').hide();
	var Lebar = Lebar + 25;

	var Registered = '';
	$('#TabelTransaksi_m tbody tr').each(function(){
		if(Indexnya !== $(this).index())
		{
			if($(this).find('td:nth-child(2) input').val() !== '')
			{
				Registered += $(this).find('td:nth-child(2) input').val() + ',';
			}
		}
	});
	
	$('#TabelTransaksi_m tbody tr').each(function(){
		if(Indexnya !== $(this).index())
		{
			if($(this).find('td:nth-child(2) input').val() !== '')
			{
				Registered += $(this).find('td:nth-child(2) input').val() + ',';
			}
		}
	});

	if(Registered !== ''){
		Registered = Registered.replace(/,\s*$/,"");
	}

	$.ajax({
		url: "<?php echo site_url('penjualan/ajax_kode_rincian'); ?>",
		type: "POST",
		cache: false,
		data:'keyword=' + KataKunci + '&registered=' + Registered,
		dataType:'json',
		success: function(json){
			if(json.status == 1)
			{
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian_m').css({ 'width' : Lebar+'px' });
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian_m').show('fast');
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian_m').html(json.datanya);
			}
			if(json.status == 0)
			{
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(3)').html('');
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(4) input').prop('disabled', true).val('');
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(6) select').prop('disabled', true);
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(7) input').val('');
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(7) span').html('');
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(8) input').val('');
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(8) span').html('');
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(10) input').val(0);
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(10) span').html('');
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(11) input').prop('disabled', true).val('');
			}
		}
	});

	HitungTotalBayar();
}*/

$(document).on('keyup', '#pencarian_kode', function(e){
	if($(this).val() !== '')
	{
		var charCode = e.which || e.keyCode;
		if(charCode == 40)
		{
			if($('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').length > 0)
			{
				var Selanjutnya = $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').next();
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').removeClass('autocomplete_active');

				Selanjutnya.addClass('autocomplete_active');
			}
			else
			{
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li:first').addClass('autocomplete_active');
			}
		} 
		else if(charCode == 38)
		{
			if($('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').length > 0)
			{
				var Sebelumnya = $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').prev();
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li.autocomplete_active').removeClass('autocomplete_active');
			
				Sebelumnya.addClass('autocomplete_active');
			}
			else
			{
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian li:first').addClass('autocomplete_active');
			}
		}
		else if(charCode == 13)
		{
			var Field = $('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)');
			var Field_m = $('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)');
			var Kodenya = Field.find('div#hasil_pencarian li.autocomplete_active span#kodenya').html();
			var Barangnya = Field.find('div#hasil_pencarian li.autocomplete_active span#barangnya').html();
			var Harganya = Field.find('div#hasil_pencarian li.autocomplete_active span#harganya').html();
			var isinya = Field.find('div#hasil_pencarian li.autocomplete_active span#isinya').html();
			
			Field.find('div#hasil_pencarian').hide();
			Field.find('input').val(Kodenya);

			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(3)').html(Barangnya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(4) input').removeAttr('disabled').val(0);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(6) select').removeAttr('disabled');
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(7) input').val(isinya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(7) span').html(isinya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(8) input').val(Harganya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(8) span').html(to_rupiah(Harganya));
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(9) input').val('1');
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(10) input').val(Harganya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(10) span').html(to_rupiah(Harganya));
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(11) input').removeAttr('disabled').val('0');
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(13) input').val(Harganya);
			$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(13) span').html(to_rupiah(Harganya));
			
			/*Tabel Minggu*/
			
			Field_m.find('div#hasil_pencarian_h').hide();
			Field_m.find('input').val(Kodenya);
			
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(3)').html(Barangnya);
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(4) input').removeAttr('disabled').val(0);
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(6) select').removeAttr('disabled');
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(7) input').val(isinya);
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(7) span').html(isinya);
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(8) input').val(Harganya);
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(8) span').html(to_rupiah(Harganya));
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(9) input').val('1');
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(10) input').val(Harganya);
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(10) span').html(to_rupiah(Harganya));
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(11) input').removeAttr('disabled').val('0');
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(13) input').val(Harganya);
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(13) span').html(to_rupiah(Harganya));
			
			var IndexIni = $(this).parent().parent().index() + 1;
			var TotalIndex = $('#TabelTransaksi tbody tr').length;
			if(IndexIni == TotalIndex){
				BarisBaru();
				BarisBaru_m();

				$('html, body').animate({ scrollTop: $(document).height() }, 0);
			}
			else {
				$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(6) input').focus();
			}
		}
		else 
		{
			AutoCompleteGue($(this).width(), $(this).val(), $(this).parent().parent().index());
		}
	}
	else
	{
		$('#TabelTransaksi tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian').hide();
	}

	HitungTotalBayar();
	HitungTotalBayar_m();
});

/*
$(document).on('keyup', '#pencarian_kode_m', function(e){
	if($(this).val() !== '')
	{
		var charCode = e.which || e.keyCode;
		if(charCode == 40)
		{
			if($('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian_m li.autocomplete_active').length > 0)
			{
				var Selanjutnya = $('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian_m li.autocomplete_active').next();
				$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian_m li.autocomplete_active').removeClass('autocomplete_active');

				Selanjutnya.addClass('autocomplete_active');
			}
			else
			{
				$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian_m li:first').addClass('autocomplete_active');
			}
		} 
		else if(charCode == 38)
		{
			if($('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian_m li.autocomplete_active').length > 0)
			{
				var Sebelumnya = $('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian_m li.autocomplete_active').prev();
				$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian_m li.autocomplete_active').removeClass('autocomplete_active');
			
				Sebelumnya.addClass('autocomplete_active');
			}
			else
			{
				$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian_m li:first').addClass('autocomplete_active');
			}
		}
		else if(charCode == 13)
		{
			var Field = $('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)');
			var Kodenya = Field.find('div#hasil_pencarian_m li.autocomplete_active span#kodenya').html();
			var Barangnya = Field.find('div#hasil_pencarian_m li.autocomplete_active span#barangnya').html();
			var Harganya = Field.find('div#hasil_pencarian_m li.autocomplete_active span#harganya').html();
			var isinya = Field.find('div#hasil_pencarian_m li.autocomplete_active span#isinya').html();
			
			Field.find('div#hasil_pencarian_m').hide();
			Field.find('input').val(Kodenya);

			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(3)').html(Barangnya);
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(4) input').removeAttr('disabled').val(0);
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(6) select').removeAttr('disabled');
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(7) input').val(isinya);
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(7) span').html(isinya);
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(8) input').val(Harganya);
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(8) span').html(to_rupiah(Harganya));
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(9) input').val('1');
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(10) input').val(Harganya);
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(10) span').html(to_rupiah(Harganya));
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(11) input').removeAttr('disabled').val('0');
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(13) input').val(Harganya);
			$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(13) span').html(to_rupiah(Harganya));
			
			var IndexIni = $(this).parent().parent().index() + 1;
			var TotalIndex = $('#TabelTransaksi_m tbody tr').length;
			if(IndexIni == TotalIndex){
				BarisBaru();

				$('html, body').animate({ scrollTop: $(document).height() }, 0);
			}
			else {
				$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(6) input').focus();
			}
		}
		else 
		{
			AutoCompleteGue_m($(this).width(), $(this).val(), $(this).parent().parent().index());
		}
	}
	else
	{
		$('#TabelTransaksi_m tbody tr:eq('+$(this).parent().parent().index()+') td:nth-child(2)').find('div#hasil_pencarian_m').hide();
	}

	HitungTotalBayar_m();
});*/

$(document).on('click', '#daftar-autocomplete li', function(){
	$(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());
	
	var kodebr = $(this).parent().parent().parent().find('input').val($(this).find('span#kodenya').html());
	var Indexnya = $(this).parent().parent().parent().parent().index();
	var NamaBarang = $(this).find('span#barangnya').html();
	var Harganya = $(this).find('span#harganya').html();
	var isinya = $(this).find('span#isinya').html();

	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian').hide();
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').removeAttr('disabled').val(0);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) select').removeAttr('disabled');
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(7) input').val(isinya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(7) span').html(isinya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').val(Harganya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) span').html(to_rupiah(Harganya));
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(9) input').val('1');
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) input').val(Harganya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) span').html(to_rupiah(Harganya));
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(11) input').removeAttr('disabled').val('0');
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) input').val(Harganya);
	$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) span').html(to_rupiah(Harganya));
	
	/*Tabel Minggu*/
	$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(2)').find('div#hasil_pencarian_h').hide();
	$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(2)').find('input').val($(this).find('span#kodenya').html());
	$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(3)').html(NamaBarang);
	$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(4) input').removeAttr('disabled').val(0);
	$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(6) select').removeAttr('disabled');
	$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(7) input').val(isinya);
	$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(7) span').html(isinya);
	$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(8) input').val(Harganya);
	$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(8) span').html(to_rupiah(Harganya));
	$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(9) input').val('1');
	$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(10) input').val(Harganya);
	$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(10) span').html(to_rupiah(Harganya));
	$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(11) input').removeAttr('disabled').val('0');
	$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(13) input').val(Harganya);
	$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(13) span').html(to_rupiah(Harganya));

	var IndexIni = Indexnya + 1;
	var TotalIndex = $('#TabelTransaksi tbody tr').length;
	if(IndexIni == TotalIndex){
		BarisBaru();
		BarisBaru_m();
		$('html, body').animate({ scrollTop: $(document).height() }, 0);
	}
	else {
		$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').focus();
	}

	HitungTotalBayar();
	HitungTotalBayar_m();
});

$(document).on('keyup', '#jumlah_beli', function(){
	var Indexnya = $(this).parent().parent().index();
	var JumlahBeli = $(this).val();
	var dosis2 = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) select').val();
	var isi = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(7) input').val();
	var Harga = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').val();
	var KodeBarang = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2) input').val();
	
	/*Tabel Minggu*/
	var dosis2_m = $('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(6) select').val();
	var isi_m = $('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(7) input').val();
	var Harga_m = $('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(8) input').val();
	var KodeBarang_m = $('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(2) input').val();
	            
	            if(dosis2 == 0.5){
	               
                    var Kebutuhan = ( parseInt(JumlahBeli) * 0.5 * 30 ) / parseInt(isi);
                    
                    var Kebutuhan_akhir = Math.round(Kebutuhan);
                    
                    var SubTotal = parseInt(Harga) * parseInt(Kebutuhan_akhir);
    				
    				if(SubTotal > 0){
    					var SubTotalVal = SubTotal;
    					SubTotal = to_rupiah(SubTotal);
    				} else {
    					SubTotal = '';
    					var SubTotalVal = 0;
    				}
                
	            } else if (dosis2 == 0.25){
	                
				    var Kebutuhan = ( parseInt(JumlahBeli) * 0.25 * 30 ) / parseInt(isi);
				    
				    var Kebutuhan_akhir = Math.round(Kebutuhan);
				    
				    var SubTotal = parseInt(Harga) * parseInt(Kebutuhan_akhir);
    				
    				if(SubTotal > 0){
    					var SubTotalVal = SubTotal;
    					SubTotal = to_rupiah(SubTotal);
    				} else {
    					SubTotal = '';
    					var SubTotalVal = 0;
    				}
				} else {
	            
                    var Kebutuhan = ( parseInt(JumlahBeli) * parseInt(dosis2) * 30 ) / parseInt(isi);
                    
                     var Kebutuhan_akhir = Math.round(Kebutuhan);
                    
    				var SubTotal = parseInt(Harga) * parseInt(Kebutuhan_akhir);
    				
    				if(SubTotal > 0){
    					var SubTotalVal = SubTotal;
    					SubTotal = to_rupiah(SubTotal);
    				} else {
    					SubTotal = '';
    					var SubTotalVal = 0;
    				}
				
				}
				
				/*Tabel Minggu*/
				if(dosis2_m == 0.5){
	               
                    var Kebutuhan_m = ( parseInt(JumlahBeli) * 0.5 * 14 ) / parseInt(isi_m);
                    
                    var Kebutuhan_akhir_m= Math.round(Kebutuhan_m);
                    
                    var SubTotal_m = parseInt(Harga_m) * parseInt(Kebutuhan_akhir_m);
    				
    				if(SubTotal_m > 0){
    					var SubTotalVal_m = SubTotal_m;
    					SubTotal_m = to_rupiah(SubTotal_m);
    				} else {
    					SubTotal_m = '';
    					var SubTotalVal_m = 0;
    				}
                
	            } else if (dosis2_m == 0.25){
	                
				    var Kebutuhan_m = ( parseInt(JumlahBeli) * 0.25 * 14 ) / parseInt(isi_m);
				    
				    var Kebutuhan_akhir_m = Math.round(Kebutuhan_m);
				    
				    var SubTotal_m = parseInt(Harga_m) * parseInt(Kebutuhan_akhir_m);
    				
    				if(SubTotal_m > 0){
    					var SubTotalVal_m = SubTotal_m;
    					SubTotal_m = to_rupiah(SubTotal_m);
    				} else {
    					SubTotal_m = '';
    					var SubTotalVal_m = 0;
    				}
				} else {
	            
                    var Kebutuhan_m = ( parseInt(JumlahBeli) * parseInt(dosis2_m) * 14 ) / parseInt(isi_m);
                    
                     var Kebutuhan_akhir_m = Math.round(Kebutuhan_m);
                    
    				var SubTotal_m = parseInt(Harga_m) * parseInt(Kebutuhan_akhir_m);
    				
    				if(SubTotal_m > 0){
    					var SubTotalVal_m = SubTotal_m;
    					SubTotal_m = to_rupiah(SubTotal_m);
    				} else {
    					SubTotal_m = '';
    					var SubTotalVal_m = 0;
    				}
				
				}
				
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(9) input').val(Kebutuhan_akhir);

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) input').val(SubTotalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) span').html(SubTotal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) input').val(SubTotalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) span').html(SubTotal);
				
				/*Tabel Minggu*/
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(4) input').val(JumlahBeli);
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(9) input').val(Kebutuhan_akhir_m);

				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(10) input').val(SubTotalVal_m);
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(10) span').html(SubTotal_m);
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(13) input').val(SubTotalVal_m);
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(13) span').html(SubTotal_m);
				
				HitungTotalBayar();
				
				HitungTotalBayar_m();
		
});
    
$(document).on('change', '#jumlah_dosis2', function(){
	var Indexnya = $(this).parent().parent().index();
	var JumlahBeli = $(this).val();
	var dosis1 = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
	var isi = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(7) input').val();
	var Harga = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').val();
	var KodeBarang = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2) input').val();
	            
	
	/*Tabel Minggu*/
	var dosis1_m = $('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(4) input').val();
	var isi_m = $('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(7) input').val();
	var Harga_m = $('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(8) input').val();
	var KodeBarang_m = $('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(2) input').val();            
	
	            if(JumlahBeli == 0.5){
	               
                    var Kebutuhan = ( parseInt(dosis1) * 0.5 * 30 ) / parseInt(isi);
                    
                    var Kebutuhan_akhir = Math.round(Kebutuhan);
                    
                    var SubTotal = parseInt(Harga) * parseInt(Kebutuhan_akhir);
    				
    				if(SubTotal > 0){
    					var SubTotalVal = SubTotal;
    					SubTotal = to_rupiah(SubTotal);
    				} else {
    					SubTotal = '';
    					var SubTotalVal = 0;
    				}
    				
    				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val('1/2');
                
	            } else if (JumlahBeli == 0.25){
	                
				    var Kebutuhan = ( parseInt(dosis1) * 0.25 * 30 ) / parseInt(isi);
				    
				    var Kebutuhan_akhir = Math.round(Kebutuhan);
				    
				    var SubTotal = parseInt(Harga) * parseInt(Kebutuhan_akhir);
    				
    				if(SubTotal > 0){
    					var SubTotalVal = SubTotal;
    					SubTotal = to_rupiah(SubTotal);
    				} else {
    					SubTotal = '';
    					var SubTotalVal = 0;
    				}
    				
    				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val('1/4');
    				
				} else {
	            
                    var Kebutuhan = ( parseInt(dosis1) * parseInt(JumlahBeli) * 30 ) / parseInt(isi);
                    
                     var Kebutuhan_akhir = Math.round(Kebutuhan);
                    
    				var SubTotal = parseInt(Harga) * parseInt(Kebutuhan_akhir);
    				
    				if(SubTotal > 0){
    					var SubTotalVal = SubTotal;
    					SubTotal = to_rupiah(SubTotal);
    				} else {
    					SubTotal = '';
    					var SubTotalVal = 0;
    				}
    				
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(JumlahBeli);
				
				}
				
				/*Tabel Minggu*/
				
				if(JumlahBeli == 0.5){
	               
                    var Kebutuhan_m = ( parseInt(dosis1_m) * 0.5 * 14 ) / parseInt(isi_m);
                    
                    var Kebutuhan_akhir_m = Math.round(Kebutuhan_m);
                    
                    var SubTotal_m = parseInt(Harga_m) * parseInt(Kebutuhan_akhir_m);
    				
    				if(SubTotal_m > 0){
    					var SubTotalVal_m = SubTotal_m;
    					SubTotal_m = to_rupiah(SubTotal_m);
    				} else {
    					SubTotal_m = '';
    					var SubTotalVal_m = 0;
    				}
    				
    				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(6) input').val('1/2');
    				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(6) select').val('0.5');
                
	            } else if (JumlahBeli == 0.25){
	                
				    var Kebutuhan_m = ( parseInt(dosis1_m) * 0.25 * 14 ) / parseInt(isi_m);
				    
				    var Kebutuhan_akhir_m = Math.round(Kebutuhan_m);
				    
				    var SubTotal_m = parseInt(Harga_m) * parseInt(Kebutuhan_akhir_m);
    				
    				if(SubTotal_m > 0){
    					var SubTotalVal_m = SubTotal_m;
    					SubTotal_m = to_rupiah(SubTotal_m);
    				} else {
    					SubTotal_m = '';
    					var SubTotalVal = 0;
    				}
    				
    				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(6) input').val('1/4');
				    $('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(6) select').val('0.25');
    				
				} else {
	            
                    var Kebutuhan_m = ( parseInt(dosis1_m) * parseInt(JumlahBeli) * 14 ) / parseInt(isi_m);
                    
                     var Kebutuhan_akhir_m = Math.round(Kebutuhan_m);
                    
    				var SubTotal_m = parseInt(Harga_m) * parseInt(Kebutuhan_akhir_m);
    				
    				if(SubTotal_m > 0){
    					var SubTotalVal_m = SubTotal_m;
    					SubTotal_m = to_rupiah(SubTotal_m);
    				} else {
    					SubTotal_m = '';
    					var SubTotalVal_m = 0;
    				}
    				
				    $('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(6) input').val(JumlahBeli);
				    $('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(6) select').val(JumlahBeli);
				
				}
				
				
				
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(9) input').val(Kebutuhan_akhir);

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) input').val(SubTotalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) span').html(SubTotal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) input').val(SubTotalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) span').html(SubTotal);
				
				HitungTotalBayar();
				
				/*Tabel Minggu*/
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(9) input').val(Kebutuhan_akhir_m);

				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(10) input').val(SubTotalVal_m);
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(10) span').html(SubTotal_m);
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(13) input').val(SubTotalVal_m);
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(13) span').html(SubTotal_m);
				
				HitungTotalBayar_m();
		
});

$(document).on('keyup', '#kebutuhan', function(){
	var Indexnya = $(this).parent().parent().index();
	var JumlahBeli = $(this).val();
	var Harga = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(8) input').val();
	var KodeBarang = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(2) input').val();
                
				var SubTotal = parseInt(Harga) * parseInt(JumlahBeli);
				
				if(SubTotal > 0){
					var SubTotalVal = SubTotal;
					SubTotal = to_rupiah(SubTotal);
				} else {
					SubTotal = '';
					var SubTotalVal = 0;
				}
				

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) input').val(SubTotalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) span').html(SubTotal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) input').val(SubTotalVal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) span').html(SubTotal);
				HitungTotalBayar();
		
});

$(document).on('keyup', '#discount', function(){
	var Indexnya = $(this).parent().parent().index();
	var Harga = $('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(10) input').val();
	var Harga_m = $('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(10) input').val();
	var discount = $(this).val();


				var SubTotal = parseInt(Harga) * parseInt(discount) / 100;
					var SubTotalVal = parseInt(Harga) - parseInt(SubTotal);
					
				if(SubTotal > 0){
					var SubTotal2 = SubTotal;
					SubTotal = to_rupiah(SubTotal);
				} else {
					SubTotal = '';
					var SubTotal2 = 0;
				}
				if(SubTotalVal > 0){
					var SubTotalVal2 = SubTotalVal;
					SubTotalVal = to_rupiah(SubTotalVal);
				} else {
					SubTotalVal = '';
					var SubTotalVal2 = 0;
				}
				
				
				/*Tabel Minggu*/
				var SubTotal_m = parseInt(Harga_m) * parseInt(discount) / 100;
					var SubTotalVal_m = parseInt(Harga_m) - parseInt(SubTotal_m);
					
				if(SubTotal_m > 0){
					var SubTotal2_m = SubTotal_m;
					SubTotal_m = to_rupiah(SubTotal_m);
				} else {
					SubTotal_m = '';
					var SubTotal2_m = 0;
				}
				if(SubTotalVal_m > 0){
					var SubTotalVal2_m = SubTotalVal_m;
					SubTotalVal_m = to_rupiah(SubTotalVal_m);
				} else {
					SubTotalVal_m = '';
					var SubTotalVal2_m = 0;
				}
				
				/*---------------------------------*/

				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(12) input').val(SubTotal2);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(12) span').html(SubTotal);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) input').val(SubTotalVal2);
				$('#TabelTransaksi tbody tr:eq('+Indexnya+') td:nth-child(13) span').html(SubTotalVal);

				HitungTotalBayar();
				
				HitungTotaldiscount();	
			    
			    /*Tabel Minggu*/
			    $('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(11) input').val(discount);
			    $('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(12) input').val(SubTotal2_m);
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(12) span').html(SubTotal_m);
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(13) input').val(SubTotalVal2_m);
				$('#TabelTransaksi_m tbody tr:eq('+Indexnya+') td:nth-child(13) span').html(SubTotalVal_m);

				HitungTotalBayar_m();
				HitungTotaldiscount_m();
				
});

$(document).on('keyup', '#discc', function(){
	var Indexnya = $(this).parent().parent().index();
	var Harga = $('#Totalitemdiscount').val();
	var discount = $(this).val();


				var SubTotal = parseInt(Harga) * parseInt(discount) / 100;
					var SubTotalVal = parseInt(Harga) - parseInt(SubTotal);
				if(SubTotal > 0){
					var SubTotal2 = SubTotal;
					SubTotal = to_rupiah(SubTotal);
				} else {
					SubTotal = '';
					var SubTotal2 = 0;
				}
				if(SubTotalVal > 0){
					var SubTotalVal2 = SubTotalVal;
					SubTotalVal = to_rupiah(SubTotalVal);
				} else {
					SubTotalVal = '';
					var SubTotalVal2 = 0;
				}

				if(parseInt(Harga) >= parseInt(SubTotal2)){
					var Selisih = parseInt(Harga) - parseInt(SubTotal2);
					$('#TotalBayarHidden3').val(to_rupiah(Selisih));
					$('#TotalBayarHidden2').val(Selisih);
					$('#TotalBayarHidden').val(Selisih);
					$('#Totaldiscounthidden').val(SubTotal2);
					$('#discount_all').val(SubTotal2);
				} else {
					$('#TotalBayarHidden3').val('');
				}
			
});

/*$(document).on('keyup', '#discount_all', function(){
	var Indexnya = $(this).parent().parent().index();
	var Harga = $('#TotalBayarHidden2').val();
	var discount = $('#disc').val();


				var SubTotal = parseInt(Harga) * parseInt(discount) / 100;
					var SubTotalVal = parseInt(Harga) - parseInt(SubTotal);
				if(SubTotal > 0){
					var SubTotal2 = SubTotal;
					SubTotal = to_rupiah(SubTotal);
				} else {
					SubTotal = '';
					var SubTotal2 = 0;
				}
				if(SubTotalVal > 0){
					var SubTotalVal2 = SubTotalVal;
					SubTotalVal = to_rupiah(SubTotalVal);
				} else {
					SubTotalVal = '';
					var SubTotalVal2 = 0;
				}

				$('#discount_all').val(SubTotal2);
				$('#TotalBayarHidden').val(SubTotalVal2);
				$('#TotalBayarHidden3').val(SubTotalVal2);
			
});*/

$(document).on('keydown', '#discount', function(e){
	var charCode = e.which || e.keyCode;
	if(charCode == 9){
		var Indexnya = $(this).parent().parent().index() + 1;
		var TotalIndex = $('#TabelTransaksi tbody tr').length;
		if(Indexnya == TotalIndex){
			BarisBaru();
			return false;
		}
	}

	HitungTotaldiscount();
});
	
$(document).on('keydown', '#jumlah_beli', function(e){
	var charCode = e.which || e.keyCode;
	if(charCode == 9){
		var Indexnya = $(this).parent().parent().index() + 1;
		var TotalIndex = $('#TabelTransaksi tbody tr').length;
		if(Indexnya == TotalIndex){
			BarisBaru();
			return false;
		}
	}

	HitungTotalBayar();
});

$(document).on('keyup', '#UangCash', function(){
	HitungTotalKembalian();
});

$(document).on('keyup', '#discount_all', function(){
	HitungTotalalldiscount();
});

function HitungTotalBayar()
{   
    
	var Total = 0;
	$('#TabelTransaksi tbody tr').each(function(){
		if($(this).find('td:nth-child(10) input').val() > 0)
		{
			var SubTotal = $(this).find('td:nth-child(10) input').val();
			Total = parseInt(Total) + parseInt(SubTotal);
		}
	});

	$('#TotalBayar').html(to_rupiah(Total));
	$('#TotalBayarHidden').val(Total);
	$('#Totalitemdiscount').val(Total);
	$('#TotalBayarHidden2').val(Total);

	$('#UangCash').val('');
	$('#UangKembali').val('');
}

function HitungTotalBayar_m()
{   
    
	var Total = 0;
	$('#TabelTransaksi_m tbody tr').each(function(){
		if($(this).find('td:nth-child(10) input').val() > 0)
		{
			var SubTotal = $(this).find('td:nth-child(10) input').val();
			Total = parseInt(Total) + parseInt(SubTotal);
		}
	});

	$('#TotalBayar_m').html(to_rupiah(Total));
	$('#TotalBayarHidden_m').val(Total);
	$('#Totalitemdiscount_m').val(Total);
	$('#TotalBayarHidden2_m').val(Total);

	$('#UangCash_m').val('');
	$('#UangKembali_m').val('');
}

function HitungTotaldiscount()
{   
    var TotalBayar = $('#Totalitemdiscount').val();
	var Total = 0;
	var Total2 = 0;
	$('#TabelTransaksi tbody tr').each(function(){
		if($(this).find('td:nth-child(12) input').val() > 0)
		{
			var SubTotal = $(this).find('td:nth-child(12) input').val();
			Total = parseInt(Total) + parseInt(SubTotal);
			TotalBayar_2 = parseInt(TotalBayar) - parseInt(Total);
		}
	});
	
    /*
    $('#TotalBayar').html(to_rupiah(TotalBayar));*/
    $('#TotalBayar').html(to_rupiah(TotalBayar_2));
	$('#TotalBayarHidden2').val(TotalBayar_2);
	$('#TotalBayarHidden3').val(to_rupiah(TotalBayar_2));
	$('#Totaldiscounthidden').val(Total);
	$('#discount_all').val(Total);
	$('#TotalBayarHidden').val(TotalBayar_2);
}

function HitungTotaldiscount_m()
{   
    var TotalBayar = $('#Totalitemdiscount_m').val();
	var Total = 0;
	var Total2 = 0;
	$('#TabelTransaksi_m tbody tr').each(function(){
		if($(this).find('td:nth-child(12) input').val() > 0)
		{
			var SubTotal = $(this).find('td:nth-child(12) input').val();
			Total = parseInt(Total) + parseInt(SubTotal);
			TotalBayar_2 = parseInt(TotalBayar) - parseInt(Total);
		}
	});
	
    /*
    $('#TotalBayar').html(to_rupiah(TotalBayar));*/
    $('#TotalBayar_m').html(to_rupiah(TotalBayar_2));
	$('#TotalBayarHidden2_m').val(TotalBayar_2);/*
	$('#TotalBayarHidden3_m').val(to_rupiah(TotalBayar_2));*/
	$('#Totaldiscounthidden_m').val(Total);/*
	$('#discount_all').val(Total);*/
	$('#TotalBayarHidden_m').val(TotalBayar_2);
}


function HitungTotalKembalian()
{
	var Cash = $('#UangCash').val();
	var TotalBayar = $('#TotalBayarHidden2').val();

	if(parseInt(Cash) >= parseInt(TotalBayar)){
		var Selisih = parseInt(Cash) - parseInt(TotalBayar);
		$('#UangKembali').val((Selisih));
	} else {
		$('#UangKembali').val('');
	}
}

function HitungTotalalldiscount()
{
	var Cash = $('#discount_all').val();
	var TotalBayar = $('#Totalitemdiscount').val();

	if(parseInt(TotalBayar) >= parseInt(Cash)){
		var Selisih = parseInt(TotalBayar) - parseInt(Cash);
		$('#TotalBayarHidden3').val(to_rupiah(Selisih));
		$('#TotalBayarHidden2').val(Selisih);
		$('#TotalBayarHidden').val(Selisih);
		$('#Totaldiscounthidden').val(Cash);
	} else {
		$('#TotalBayarHidden3').val('');
	}
}

function to_rupiah(angka){
    var rev     = parseInt(angka, 10).toString().split('').reverse().join('');
    var rev2    = '';
    for(var i = 0; i < rev.length; i++){
        rev2  += rev[i];
        if((i + 1) % 3 === 0 && i !== (rev.length - 1)){
            rev2 += '.';
        }
    }
    return 'Rp. ' + rev2.split('').reverse().join('');
}

function check_int(evt) {
	var charCode = ( evt.which ) ? evt.which : event.keyCode;
	return ( charCode >= 48 && charCode <= 57 || charCode == 8 );
}

$(document).on('keydown', 'body', function(e){
	var charCode = ( e.which ) ? e.which : event.keyCode;

	if(charCode == 117) //F6
	{
		HapusBaris();
		return false;
	}

	if(charCode == 118) //F7
	{
		BarisBaru();
		return false;
	}

	if(charCode == 119) //F8
	{
		$('#UangCash').focus();
		return false;
	}

	if(charCode == 120) //F9
	{
		CetakStruk();
		return false;
	}

	if(charCode == 121) //F10
	{
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Konfirmasi');
		$('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='SimpanTransaksi'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
		$('#ModalGue').modal('show');

		setTimeout(function(){ 
	   		$('button#SimpanTransaksi').focus();
	    }, 500);

		return false;
	}

});

$(document).on('click', '#Simpann', function(){
	$('.modal-dialog').removeClass('modal-lg');
	$('.modal-dialog').addClass('modal-sm');
	$('#ModalHeader').html('Konfirmasi');
	$('#ModalContent').html("Apakah anda yakin ingin menyimpan transaksi ini ?");
	$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='SimpanTransaksi'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
	$('#ModalGue').modal('show');

	setTimeout(function(){ 
   		$('button#SimpanTransaksi').focus();
    }, 500);
});

$(document).on('click', '#pending', function(){
	$('.modal-dialog').removeClass('modal-lg');
	$('.modal-dialog').addClass('modal-sm');
	$('#ModalHeader').html('Konfirmasi');
	$('#ModalContent').html("Apakah anda yakin ingin Pending transaksi ini ?");
	$('#ModalFooter').html("<button type='button' class='btn btn-primary' id='pending2'>Ya, saya yakin</button><button type='button' class='btn btn-default' data-dismiss='modal'>Batal</button>");
	$('#ModalGue').modal('show');

	setTimeout(function(){ 
   		$('button#pending2').focus();
    }, 500);
});

$(document).on('click', 'button#SimpanTransaksi', function(){
	SimpanTransaksi();
});

$(document).on('click', 'button#CetakStruk', function(){
	CetakStruk();
});

$(document).on('click', 'button#CetakStruk_all', function(){
	CetakStruk_all();
});

$(document).on('click', 'button#pending2', function(){
	pending();
});

function SimpanTransaksi()
{
	var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
	FormData += "&tanggal="+encodeURI($('#tanggal').val());
	FormData += "&id_kasir="+$('#id_kasir').val();
	FormData += "&id_pelanggan="+$('#id_pelanggan').val();
	FormData += "&nama_herbalis="+$('#id_herbalis').val();
	FormData += "&tanggal_kembali="+$('#tanggal_kembali').val();
	FormData += "&" + $('#TabelTransaksi tbody input').serialize();
	FormData += "&cash="+$('#UangCash').val();
	FormData += "&catatan="+encodeURI($('#catatan').val());
	FormData += "&grand_total="+$('#TotalBayarHidden').val();
	FormData += "&total_discount="+$('#Totaldiscounthidden').val();
	FormData += "&total_awal="+$('#Totalitemdiscount').val();
	FormData += "&sales_pam="+$('#sales_pam').val();

	$.ajax({
		url: "<?php echo site_url('penjualan/transaksi_rincian'); ?>",
		type: "POST",
		cache: false,
		data: FormData,
		dataType:'json',
		beforeSend:function(){
				$('#SimpanTransaksi').html("Menyimpan Data, harap tunggu ...");
					},
		success: function(data){
			if(data.status == 1)
			{
				alert(data.pesan);
				window.location.href="<?php echo site_url('penjualan/transaksi_rincian'); ?>";
			}
			else 
			{
				$('.modal-dialog').removeClass('modal-lg');
				$('.modal-dialog').addClass('modal-sm');
				$('#ModalHeader').html('Oops !');
				$('#ModalContent').html(data.pesan);
				$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
				$('#ModalGue').modal('show');
			}	
		}
	});

	if($('#TotalBayarHidden').val() > 0)
	{
		if($('#UangCash').val() !== '')
		{
			var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
			FormData += "&tanggal="+encodeURI($('#tanggal').val());
			FormData += "&id_kasir="+$('#id_kasir').val();
			FormData += "&id_pelanggan="+$('#id_pelanggan').val();
			FormData += "&" + $('#TabelTransaksi tbody input').serialize();
			FormData += "&cash="+$('#UangCash').val();
			FormData += "&catatan="+encodeURI($('#catatan').val());
			FormData += "&grand_total="+$('#TotalBayarHidden').val();
			FormData += "&total_discount="+$('#Totaldiscounthidden').val();
			FormData += "&total_awal="+$('#Totalitemdiscount').val();
			FormData += "&nama_herbalis="+$('#id_herbalis').val();
			FormData += "&tanggal_kembali="+$('#tanggal_kembali').val();
			FormData += "&sales_pam="+$('#sales_pam').val();
			FormData += "&nrmp="+$('#nrmp').val();

			window.open("<?php echo site_url('penjualan/tr_cetak_rincian/?'); ?>" + FormData,'_blank');
		}
		else
		{
			$('.modal-dialog').removeClass('modal-lg');
			$('.modal-dialog').addClass('modal-sm');
			$('#ModalHeader').html('Oops !');
			$('#ModalContent').html('Harap masukan Total Bayar');
			$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
			$('#ModalGue').modal('show');
		}
	}
	else
	{
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Oops !');
		$('#ModalContent').html('Harap pilih barang terlebih dahulu');
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
		$('#ModalGue').modal('show');

	}
}

$(document).on('click', '#TambahPelanggan', function(e){
	e.preventDefault();

	$('.modal-dialog').removeClass('modal-sm');
	$('.modal-dialog').removeClass('modal-lg');
	$('#ModalHeader').html('Tambah Pelanggan');
	$('#ModalContent').load($(this).attr('href'));
	$('#ModalGue').modal('show');
});


function CetakStruk()
{
		if($('#TotalBayarHidden').val() > 0)
	{
			var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
			FormData += "&tanggal="+encodeURI($('#tanggal').val());
			FormData += "&id_kasir="+$('#id_kasir').val();
			FormData += "&id_pelanggan="+$('#id_pelanggan').val();
			FormData += "&" + $('#TabelTransaksi tbody input').serialize();
			FormData += "&cash="+$('#UangCash').val();
			FormData += "&catatan="+encodeURI($('#catatan').val());
			FormData += "&grand_total="+$('#TotalBayarHidden').val();
			FormData += "&total_discount="+$('#Totaldiscounthidden').val();
			FormData += "&total_awal="+$('#Totalitemdiscount').val();
			FormData += "&nama_herbalis="+$('#id_herbalis').val();
			FormData += "&tanggal_kembali="+$('#tanggal_kembali').val();
			FormData += "&sales_pam="+$('#sales_pam').val();
			FormData += "&nrmp="+$('#nrmp').val();

			window.open("<?php echo site_url('penjualan/tr_cetak_rincian/?'); ?>" + FormData,'_blank');
		
	}
	else
	{
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Oops !');
		$('#ModalContent').html('Harap pilih barang terlebih dahulu');
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
		$('#ModalGue').modal('show');

	}
}

function CetakStruk_all()
{
		if($('#TotalBayarHidden').val() > 0)
	{
			var FormData = "nomor_nota="+encodeURI($('#nomor_nota').val());
			FormData += "&tanggal="+encodeURI($('#tanggal').val());
			FormData += "&id_kasir="+$('#id_kasir').val();
			FormData += "&id_pelanggan="+$('#id_pelanggan').val();
			FormData += "&" + $('#TabelTransaksi tbody input').serialize();
			FormData += "&" + $('#TabelTransaksi_m tbody input').serialize();
			FormData += "&cash="+$('#UangCash').val();
			FormData += "&catatan="+encodeURI($('#catatan').val());
			FormData += "&grand_total="+$('#TotalBayarHidden').val();
			FormData += "&total_discount="+$('#Totaldiscounthidden').val();
			FormData += "&total_awal="+$('#Totalitemdiscount').val();
			FormData += "&grand_total_m="+$('#TotalBayarHidden_m').val();
			FormData += "&total_discount_m="+$('#Totaldiscounthidden_m').val();
			FormData += "&total_awal_m="+$('#Totalitemdiscount_m').val();
			FormData += "&nama_herbalis="+$('#id_herbalis').val();
			FormData += "&tanggal_kembali="+$('#tanggal_kembali').val();
			FormData += "&sales_pam="+$('#sales_pam').val();
			FormData += "&nrmp="+$('#nrmp').val();

			window.open("<?php echo site_url('penjualan/tr_cetak_rincian_all/?'); ?>" + FormData,'_blank');
		
	}
	else
	{
		$('.modal-dialog').removeClass('modal-lg');
		$('.modal-dialog').addClass('modal-sm');
		$('#ModalHeader').html('Oops !');
		$('#ModalContent').html('Harap pilih barang terlebih dahulu');
		$('#ModalFooter').html("<button type='button' class='btn btn-primary' data-dismiss='modal' autofocus>Ok</button>");
		$('#ModalGue').modal('show');

	}
}

</script>

<?php $this->load->view('include/footer'); ?>