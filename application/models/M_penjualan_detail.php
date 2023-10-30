<?php
class M_penjualan_detail extends CI_Model
{
	function insert_detail($id_master, $id_barang, $kode_barang, $jumlah_beli, $satuan, $harga_satuan,$discount,$discountnya, $sub_total, $grand_total, $tanggal, $nama_herbalis_ori, $nama_herbalis, $aty_kota, $id_pelanggan)
	{
		$dt = array(
			'id_penjualan_m' => $id_master,
			'id_barang' => $id_barang,
			'kode_barang' => $kode_barang,
			'jumlah_beli' => $jumlah_beli,
			'satuan' => $satuan,
			'harga_satuan' => $harga_satuan,
			'disc' => $discount,
			'discount' => $discountnya,
			'total' => $sub_total,
			'grand_total' => $grand_total,
			'tanggal' => $tanggal,
			'nama_herbalis' => $nama_herbalis_ori,
			'nama_sales' => $nama_herbalis,
			'ATY_kota' => $aty_kota,
			'id_pelanggan' => $id_pelanggan,
			'keterangan' => 'pasien online',
			'status' => 'ok'
		);

		return $this->db->insert('pj_penjualan_detail', $dt);
	}
	
	function insert_detail_asuransi($id_master, $id_barang, $jumlah_beli, $satuan, $tanggal, $id_herbalis, $id_pelanggan, $catatan)
	{
		$dt = array(
			'id_asuransi_m' => $id_master,
			'id_barang' => $id_barang,
			'qty' => $jumlah_beli,
			'satuan' => $satuan,
			'tanggal' => $tanggal,
			'nama_herbalis' => $id_herbalis,
			'nama_karyawan' => $id_pelanggan,
			'keterangan' => $catatan,
			'status' => 'ok'
		);

		return $this->db->insert('pj_asuransi_detail', $dt);
	}
	
	function insert_detail_medan($id_master, $id_barang, $jumlah_beli, $satuan, $tanggal, $catatan)
	{
		$dt = array(
			'id_medan_m' => $id_master,
			'id_barang' => $id_barang,
			'qty' => $jumlah_beli,
			'satuan' => $satuan,
			'tanggal' => $tanggal,
			'keterangan' => $catatan,
			'status' => 'ok'
		);

		return $this->db->insert('pj_trmedan_detail', $dt);
	}
	
	function insert_detail_pending($id_master, $id_barang, $jumlah_beli, $satuan, $harga_satuan,$discount,$discountnya, $sub_total, $grand_total, $tanggal, $nama_herbalis_ori, $nama_herbalis, $aty_kota, $id_pelanggan)
	{
		$dt = array(
			'id_penjualan_m' => $id_master,
			'id_barang' => $id_barang,
			'jumlah_beli' => $jumlah_beli,
			'satuan' => $satuan,
			'harga_satuan' => $harga_satuan,
			'disc' => $discount,
			'discount' => $discountnya,
			'total' => $sub_total,
			'grand_total' => $grand_total,
			'tanggal' => $tanggal,
			'nama_herbalis' => $nama_herbalis_ori,
			'nama_sales' => $nama_herbalis,
			'ATY_kota' => $aty_kota,
			'id_pelanggan' => $id_pelanggan,
			'keterangan' => 'pasien online',
			'status' => 'ok'
		);

		return $this->db->insert('pj_penjualan_detail', $dt);
	}
	
		function update_detail2($id_detail,$id_master, $id_barang, $jumlah_beli, $satuan, $harga_satuan,$discount,$discountnya, $sub_total, $grand_total, $tanggal, $nama_herbalis, $id_pelanggan, $sales_pam)
	{

		$dt = array(
			'id_penjualan_m' => $id_master,
			'id_barang	' => $id_barang,
			'jumlah_beli' => $jumlah_beli,
			'satuan' => $satuan,
			'harga_satuan' => $harga_satuan,
			'disc' => $discount,
			'discount' => $discountnya,
			'total' => $sub_total,
			'grand_total' => $grand_total,
			'tanggal' => $tanggal,
			'nama_herbalis' => $nama_herbalis,
			'id_pelanggan' => $id_pelanggan,
			'keterangan' => 'pasien klinik',
			'status' => 'ok',
			'nama_sales' => $sales_pam,
		);

		/*return $this->db->where('id_penjualan_d', $id_detail)->update('pj_penjualan_detail', $dt);*/
		return $this->db->insert('pj_penjualan_detail', $dt);

	}

	function insert_detail2_pending($id_master, $id_barang, $jumlah_beli, $satuan, $harga_satuan,$discount,$discountnya, $sub_total, $grand_total, $tanggal, $nama_herbalis, $id_pelanggan, $sales_pam)
	{
		$dt = array(
			'id_penjualan_m' => $id_master,
			'id_barang	' => $id_barang,
			'jumlah_beli' => $jumlah_beli,
			'satuan' => $satuan,
			'harga_satuan' => $harga_satuan,
			'disc' => $discount,
			'discount' => $discountnya,
			'total' => $sub_total,
			'grand_total' => $grand_total,
			'tanggal' => $tanggal,
			'nama_herbalis' => $nama_herbalis,
			'id_pelanggan' => $id_pelanggan,
			'keterangan' => 'pasien klinik',
			'status' => 'ok',
			'nama_sales' => $sales_pam,
		);

		return $this->db->insert('pj_penjualan_detail', $dt);
	}

	function insert_detail2($id_master, $id_barang, $jumlah_kebutuhan, $satuan, $harga_satuan,$discount,$discountnya, $sub_total, $grand_total, $tanggal, $nama_herbalis, $id_pelanggan, $sales_pam)
	{
		$dt = array(
			'id_penjualan_m' => $id_master,
			'id_barang	' => $id_barang,
			'jumlah_beli' => $jumlah_kebutuhan,
			'satuan' => $satuan,
			'harga_satuan' => $harga_satuan,
			'disc' => $discount,
			'discount' => $discountnya,
			'total' => $sub_total,
			'grand_total' => $grand_total,
			'tanggal' => $tanggal,
			'nama_herbalis' => $nama_herbalis,
			'id_pelanggan' => $id_pelanggan,
			'keterangan' => 'pasien klinik',
			'status' => 'ok',
			'nama_sales' => $sales_pam,
		);

		return $this->db->insert('pj_penjualan_detail', $dt);

	}
	
	function insert_detail2_rincian($id_master_rincian, $id_barang, $jumlah_dosis1, $jumlah_dosis2, $isi,$jumlah_kebutuhan, $harga_satuan,$discount,$discountnya, $sub_total, $grand_total, $tanggal, $nama_herbalis, $id_pelanggan, $sales_pam)
	{
		$dt = array(
			'id_rincian' => $id_master_rincian,
			'id_barang	' => $id_barang,
			'dosis1' => $jumlah_dosis1,
			'dosis2' => $jumlah_dosis2,
			'isi' => $isi,
			'jumlah_beli' => $jumlah_kebutuhan,
			'harga_satuan' => $harga_satuan,
			'disc' => $discount,
			'discount' => $discountnya,
			'total' => $sub_total,
			'grand_total' => $grand_total,
			'tanggal' => $tanggal,
			'nama_herbalis' => $nama_herbalis,
			'id_pelanggan' => $id_pelanggan,
			'keterangan' => 'pasien klinik',
			'status' => 'ok',
			'nama_sales' => $sales_pam,
		);

		return $this->db->insert('pj_rincian_pasien_detail', $dt);

	}

	function update_pelanggan2($nama_herbalis,$id_pelanggan,$tanggal_kembali)
	{
		$sql = "
			UPDATE `pj_pelanggan` SET `id_herbalis` = '".$nama_herbalis."', `tgl_kembali` = '".$tanggal_kembali."' WHERE `id_pelanggan` = '".$id_pelanggan."'
		";

		return $this->db->query($sql);
	}

	function update_pelanggan($id_herbalis, $tanggal_kembali,$id_pelanggan)
	{
		$sql = "
			UPDATE `pj_pelanggan` SET `sales` = '".$id_herbalis."', `tgl_kembali` = '".$tanggal_kembali."' WHERE `id_pelanggan` = '".$id_pelanggan."'
		";

		return $this->db->query($sql);
	}
	
	function get_detail_medan($id_medan)
	{
		$sql = "
			SELECT 
				a.`id_medan_d`,
				b.`kode_barang`,  
				b.`nama_barang`, 
				a.`qty`,
				a.`satuan` AS satuan
			FROM 
				`pj_trmedan_detail` a 
				LEFT JOIN `pj_barang` b ON a.`id_barang` = b.`id_barang` 
			WHERE 
				a.`id_medan_m` = '".$id_medan."' 
			ORDER BY 
				a.`id_medan_d` ASC 
		";

		return $this->db->query($sql);
	}
	
	function get_detail_asuransi($id_asuransi)
	{
		$sql = "
			SELECT 
				a.`id_asuransi_d`,
				b.`kode_barang`,  
				b.`nama_barang`, 
				a.`qty`,
				a.`satuan` AS satuan
			FROM 
				`pj_asuransi_detail` a 
				LEFT JOIN `pj_barang` b ON a.`id_barang` = b.`id_barang` 
			WHERE 
				a.`id_asuransi_m` = '".$id_asuransi."' 
			ORDER BY 
				a.`id_asuransi_d` ASC 
		";

		return $this->db->query($sql);
	}
	
	function get_detail_rincian($id_penjualan)
	{
		$sql = "
			SELECT 
				a.`id_rincian_d`,
				b.`kode_barang`,  
				b.`nama_barang`, 
				a.`dosis1`,
				a.`dosis2`,
				a.`isi`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga_satuan`, 0),',','.') ) AS harga_satuan, 
				a.`harga_satuan` AS harga_satuan_asli, 
				a.`jumlah_beli`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`grand_total`, 0),',','.') ) AS sub_total,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`total`, 0),',','.') ) AS sub_total_awal,
				a.`disc` AS discnya,
				a.`satuan` AS satuan,
				CONCAT(REPLACE(FORMAT(a.`disc`, 0),',','.'),' %') AS disc, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`discount`, 0),',','.') ) AS discount, 
				a.`discount` AS discountnya, 
				a.`grand_total` AS sub_total_asli,  
				a.`total` AS sub_total_asli_awal
			FROM 
				`pj_rincian_pasien_detail` a 
				LEFT JOIN `pj_barang` b ON a.`id_barang` = b.`id_barang` 
			WHERE 
				a.`id_rincian` = '".$id_penjualan."' 
			ORDER BY 
				a.`id_rincian_d` ASC 
		";

		return $this->db->query($sql);
	}

	function get_detail($id_penjualan)
	{
		$sql = "
			SELECT 
				a.`id_penjualan_d`,
				b.`kode_barang`,  
				b.`nama_barang`, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga_satuan`, 0),',','.') ) AS harga_satuan, 
				a.`harga_satuan` AS harga_satuan_asli, 
				a.`jumlah_beli`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`grand_total`, 0),',','.') ) AS sub_total,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`total`, 0),',','.') ) AS sub_total_awal,
				a.`disc` AS discnya,
				a.`satuan` AS satuan,
				CONCAT(REPLACE(FORMAT(a.`disc`, 0),',','.'),' %') AS disc, 
				CONCAT('Rp. ', REPLACE(FORMAT(a.`discount`, 0),',','.') ) AS discount, 
				a.`discount` AS discountnya, 
				a.`grand_total` AS sub_total_asli,  
				a.`total` AS sub_total_asli_awal
			FROM 
				`pj_penjualan_detail` a 
				LEFT JOIN `pj_barang` b ON a.`id_barang` = b.`id_barang` 
			WHERE 
				a.`id_penjualan_m` = '".$id_penjualan."' 
			ORDER BY 
				a.`id_penjualan_d` ASC 
		";

		return $this->db->query($sql);
	}
}