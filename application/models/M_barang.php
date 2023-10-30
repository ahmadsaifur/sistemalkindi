<?php
class M_barang extends CI_Model
{

	function tambah_jasa($kode, $nama, $harga)
	{
		$tanggal_masuk = date('Y-m-d');

		$dt = array(

			'kode_barang' => $kode,
			'nama_barang' => $nama,
			'harga' => $harga,
			'tanggal_masuk' => $tanggal_masuk,
			'total_stok' => '100',
			'id_kategori_barang' => '0',
			'keterangan' => 'klinik',
			'ket_lain' => 'jasa',
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pj_barang', $dt);
	}

	function tambah_klinik_baru($kode_barang, $kd_barang, $nama_barang, $id_kategori_barang, $total_stok, $satuan, $harga)
	{


		$tanggal_masuk = date('Y-m-d');

		$dt = array(
			'kode_barang' => $kode_barang,
			'kd_barang' => $kd_barang,
			'nama_barang' => $nama_barang,
			'id_kategori_barang' => $id_kategori_barang,
			'total_stok' => $total_stok,
			'satuan' => $satuan,
			'harga' => $harga,
			'keterangan' => 'klinik',
			'ket_lain' => 'obat',
			'dihapus' => 'tidak',
			'tanggal_masuk' => $tanggal_masuk
		);

		return $this->db->insert('pj_barang', $dt);
	}

	function get_dari_kode($kode)
	{
		return $this->db
			->select('id_barang')
			->where('kode_barang', $kode)
			->limit(1)
			->get('pj_barang');
	}

	function barangonline($kode)
	{
		$sql = ("
			SELECT 
				a.`id_barang`, 
				a.`kode_barang`, 
				a.`nama_barang`,
				a.`total_stok`,
				a.`keterangan`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang`
				where a.`kode_barang`= '" . $kode . "'
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online' 
		");

		return $this->db->query($sql);
	}

	function ambilbarangonline($kode)
	{
		$sql = ("
			SELECT 
				a.`id_barang`, 
				a.`kode_barang`, 
				a.`kd_barang`, 
				a.`nama_barang`,
				a.`total_stok`,
				a.`keterangan`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang`
				where a.`kd_barang`= '" . $kode . "'
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online' 
		");

		return $this->db->query($sql);
	}

	function ambilbarangklinik($kode)
	{
		$sql = ("
			SELECT 
				a.`id_barang`, 
				a.`kode_barang`, 
				a.`kd_barang`, 
				a.`nama_barang`,
				a.`total_stok`,
				a.`keterangan`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang`
				where a.`kd_barang`= '" . $kode . "'
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'klinik' 
		");

		return $this->db->query($sql);
	}

	function fetch_data_barang($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_barang`, 
				a.`kode_barang`, 
				a.`nama_barang`,
				a. total_stok,
				a. satuan,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
				AND a.`ket_lain` = 'obat'
		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				a.`kode_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`nama_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`keterangan` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR b.`kategori` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'a.`kode_barang`',
			2 => 'a.`nama_barang`',
			3 => 'b.`kategori`',
			4 => 'a.`total_stok`',
			5 => '`harga`',
			6 => 'a.`keterangan`'
		);

		$sql .= " ORDER BY " . $columns_order_by[$column_order] . " " . $column_dir . ", nomor ";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function fetch_data_barang_kadaluarsa($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$tanggal = date('Y-m-d');
		$tanggal2 = date('Y-m-d', strtotime('+3 months', strtotime($tanggal))); //operasi pengurangan tanggal sebanyak 3 hari

		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				id_barang, 
				nama_barang,
				DATE_FORMAT(tanggal_masuk, '%d %b %Y') AS tanggal_masuk,
				DATE_FORMAT(tgl_kadaluarsa, '%d %b %Y') AS tanggal_kadaluarsa,
				keterangan
			FROM 
				`pj_history_stok_barang`, (SELECT @row := 0) r 
			WHERE 1=1
			    AND SUBSTR(tgl_kadaluarsa, 1, 10)  BETWEEN '" . $tanggal . "' AND '" . $tanggal2 . "'
				AND dihapus = 'tidak'  
		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				nama_barang LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'nama_barang'
		);

		$sql .= " ORDER BY tgl_kadaluarsa desc ";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function fetch_data_barang_sudah_kadaluarsa($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$tanggal = date('Y-m-d');
		$tanggal2 = date('Y-m-d', strtotime('-2 months', strtotime($tanggal))); //operasi pengurangan tanggal sebanyak 3 hari

		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				id_barang, 
				nama_barang,
				DATE_FORMAT(tanggal_masuk, '%d %b %Y') AS tanggal_masuk,
				DATE_FORMAT(tgl_kadaluarsa, '%d %b %Y') AS tanggal_kadaluarsa,
				keterangan
			FROM 
				`pj_history_stok_barang`, (SELECT @row := 0) r 
			WHERE 1=1
			    AND SUBSTR(tgl_kadaluarsa, 1, 10)  BETWEEN '" . $tanggal2 . "' AND '" . $tanggal . "'
				AND dihapus = 'tidak'  
		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				nama_barang LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'nama_barang'
		);

		$sql .= " ORDER BY tgl_kadaluarsa desc ";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function fetch_data_barang_online($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_barang`, 
				a.`kode_barang`, 
				a.`tanggal_masuk`,
				a.`nama_barang`,
				a. total_stok,
				a. satuan,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				a.`info_tambahan`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'/*
				AND `total_stok` > 0 */
				AND a.`ket_lain` = 'obat'
		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				a.`kode_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`nama_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`keterangan` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR b.`kategori` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'a.`kode_barang`',
			2 => 'a.`nama_barang`',
			3 => 'b.`kategori`',
			4 => 'a.`total_stok`',
			5 => '`harga`',
			6 => 'a.`keterangan`'
		);

		$sql .= " ORDER BY " . $columns_order_by[$column_order] . " " . $column_dir . ", nomor ";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function fetch_data_barang_online_herbal($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_barang`, a.`satuan`,
				a.`kode_barang`, 
				a.`tanggal_masuk`,
				a.`nama_barang`,
				a. total_stok,
				a. satuan,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				a.`info_tambahan`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'/*
				AND `total_stok` > 0 */ 
				AND a.`id_kategori_barang` = '1'
				AND a.`ket_lain` = 'obat'
		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				a.`kode_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`nama_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`keterangan` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR b.`kategori` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'a.`kode_barang`',
			2 => 'a.`nama_barang`',
			3 => 'b.`kategori`',
			4 => 'a.`total_stok`',
			5 => '`harga`',
			6 => 'a.`keterangan`'
		);

		$sql .= " ORDER BY " . $columns_order_by[$column_order] . " " . $column_dir . ", nomor ";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function fetch_data_barang_online_kimia($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_barang`, 
				a.`kode_barang`, 
				a.`tanggal_masuk`,
				a.`nama_barang`,
				a. total_stok,
				c. standar_strip,
				c. standar_pcs,
				a. satuan,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				a.`info_tambahan`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
				LEFT JOIN `pj_barang_standar` AS c ON a.`id_barang` = c.`id_barang` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'/*
				AND `total_stok` > 0 */ 
				AND a.`id_kategori_barang` = '2'
				AND a.`ket_lain` = 'obat'
		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				a.`kode_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`nama_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`keterangan` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR b.`kategori` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'a.`kode_barang`',
			2 => 'a.`nama_barang`',
			3 => 'b.`kategori`',
			4 => 'a.`total_stok`',
			5 => '`harga`',
			6 => 'a.`keterangan`'
		);

		$sql .= " ORDER BY " . $columns_order_by[$column_order] . " " . $column_dir . ", nomor ";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function fetch_data_barang_kimia_standar($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_barang`, 
				a.`kode_barang`, 
				a.`tanggal_masuk`,
				a.`nama_barang`,
				a. standar_strip,
				a. standar_pcs,
				a. satuan,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				b.`kategori`
			FROM 
				`pj_barang_standar` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND a.`ket_lain` = 'obat'
		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				a.`kode_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`nama_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR IF(a.`standar_strip` = 0, 'Kosong', a.`standar_strip`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR IF(a.`standar_pcs` = 0, 'Kosong', a.`standar_pcs`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`keterangan` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR b.`kategori` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'a.`kode_barang`',
			2 => 'a.`nama_barang`',
			3 => 'b.`kategori`',
			4 => 'a.`standar_strip`',
			5 => 'a.`standar_pcs`',
			6 => '`harga`'
		);

		$sql .= " ORDER BY " . $columns_order_by[$column_order] . " " . $column_dir . ", nomor ";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function fetch_data_barang_history_online2($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_barang`, a.`satuan`,
				a.`tanggal_masuk`,
				a.`nama_barang`,
				a. total_stok,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				c.`nama` AS kasir,
				b.`kategori`
			FROM 
				`pj_history_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
				LEFT JOIN `pj_user` AS c ON a.`id_user` = c.`id_user` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND a.`ket_lain` = 'obat'
		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				a.`kode_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`nama_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`keterangan` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR b.`kategori` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'a.`kode_barang`',
			2 => 'a.`nama_barang`',
			3 => 'b.`kategori`',
			4 => 'a.`total_stok`',
			5 => '`harga`',
			6 => 'a.`keterangan`'
		);

		$sql .= " ORDER BY a.`tanggal_masuk` DESC";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function fetch_data_barang_history_stok_online($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_barang`, a.`satuan`,
				a.`tanggal_masuk`,
				DATE_FORMAT(a.`tgl_kadaluarsa`, '%d %b %Y') AS tanggal_kadaluarsa,
				a.`nama_barang`,
				a. total_stok,
				c.`nama` AS kasir,
				a.`keterangan`
			FROM 
				`pj_history_stok_barang` AS a 
				LEFT JOIN `pj_user` AS c ON a.`id_user` = c.`id_user` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND a.`ket_lain` = 'obat'
		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				a.`nama_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`keterangan` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'a.`nama_barang`',
			2 => 'a.`total_stok`',
			3 => 'a.`keterangan`'
		);

		$sql .= " ORDER BY a.`tanggal_masuk` DESC";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function fetch_data_barang_klinik($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_barang`, 
				a.`kode_barang`,
				a.`tanggal_masuk`, 
				a.`nama_barang`,
				a. total_stok,
				a. total_isi,
				a. satuan,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'klinik'
				AND a.`ket_lain` = 'obat'

		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				a.`kode_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`nama_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR a.`tanggal_masuk` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`keterangan` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR b.`kategori` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'a.`nama_barang`',
			2 => 'b.`kategori`',
			3 => 'a.`total_stok`',
			4 => 'a. total_isi,',
			5 => 'a. satuan',
			6 => 'a.`keterangan`'
		);

		$sql .= " ORDER BY " . $columns_order_by[$column_order] . " " . $column_dir . ", nomor ";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function fetch_data_barang_history_klinik($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_barang`, 
				a.`kode_barang`,
				a.`tanggal_masuk`, 
				a.`satuan`,
				a.`nama_barang`,
				a. total_stok,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				c.`nama` AS kasir,
				b.`kategori`
			FROM 
				`pj_history_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
				LEFT JOIN `pj_user` AS c ON a.`id_user` = c.`id_user` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'klinik'
				AND `total_stok` >= 0 
				AND a.`ket_lain` = 'obat'

		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				a.`kode_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`nama_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR a.`tanggal_masuk` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`keterangan` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR b.`kategori` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'a.`kode_barang`',
			2 => 'a.`tanggal_masuk`,',
			3 => '`nama_barang`',
			4 => 'b.`kategori`',
			5 => 'a. total_stok',
			6 => 'a.`satuan`'
		);

		$sql .= " ORDER BY " . $columns_order_by[$column_order] . " " . $column_dir . ", nomor ";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function hapus_barang($id_barang)
	{
		$dt['dihapus'] = 'ya';
		return $this->db
			->where('id_barang', $id_barang)
			->update('pj_barang', $dt);
	}

	function hapus_barang_standar($id_barang)
	{
		$dt['dihapus'] = 'ya';
		return $this->db
			->where('id_barang', $id_barang)
			->update('pj_barang_standar', $dt);
	}

	function tambah_baru($kd_barang, $kode_barang2, $nama, $id_kategori_barang, $satuan, $stok, $harga, $keterangan)
	{
		$tanggal_masuk = date('Y-m-d');

		$dt = array(
			'kode_barang' => $kode_barang2,
			'kd_barang' => $kd_barang,
			'tanggal_masuk' => $tanggal_masuk,
			'satuan' => $satuan,
			'nama_barang' => $nama,
			'total_stok' => $stok,
			'harga' => $harga,
			'id_kategori_barang' => $id_kategori_barang,
			'keterangan' => $keterangan,
			'ket_lain' => 'obat',
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pj_barang', $dt);
	}

	function tambah_baru_history($kd_barang, $kode_barang2, $nama, $id_kategori_barang, $satuan, $stok, $harga, $keterangan, $id_kasir)
	{
		$tanggal_masuk = date('Y-m-d');

		$dt = array(
			'kode_barang' => $kode_barang2,
			'kd_barang' => $kd_barang,
			'tanggal_masuk' => $tanggal_masuk,
			'satuan' => $satuan,
			'nama_barang' => $nama,
			'total_stok' => $stok,
			'harga' => $harga,
			'id_kategori_barang' => $id_kategori_barang,
			'keterangan' => $keterangan,
			'id_user' => $id_kasir,
			'ket_lain' => 'obat',
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pj_history_barang', $dt);
	}

	function tambah_baru_online($kode, $kd_barang2, $nama, $id_kategori_barang, $satuan, $stok, $harga, $keterangan)
	{
		$tanggal_masuk = date('Y-m-d');

		$dt = array(
			'kode_barang' => $kode,
			'kd_barang' => $kd_barang2,
			'nama_barang' => $nama,
			'tanggal_masuk' => $tanggal_masuk,
			'total_stok' => $stok,
			'satuan' => $satuan,
			'harga' => $harga,
			'id_kategori_barang' => $id_kategori_barang,
			'keterangan' => $keterangan,
			'ket_lain' => 'obat',
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pj_barang', $dt);
	}

	function tambah_baru_online2($kode, $kd_barang2, $nama, $id_kategori_barang, $satuan, $stok, $harga, $keterangan, $id_kasir)
	{
		$tanggal_masuk = date('Y-m-d');

		$dt = array(
			'kode_barang' => $kode,
			'kd_barang' => $kd_barang2,
			'nama_barang' => $nama,
			'tanggal_masuk' => $tanggal_masuk,
			'total_stok' => $stok,
			'satuan' => $satuan,
			'harga' => $harga,
			'id_kategori_barang' => $id_kategori_barang,
			'keterangan' => $keterangan,
			'ket_lain' => 'obat',
			'id_user' => $id_kasir,
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pj_history_barang', $dt);
	}

	function tambah_history_stok_online_herbal($id_barang, $nama_barang, $stok, $satuan, $id_kasir)
	{
		$tanggal_masuk = date('Y-m-d H:i:s');

		$dt = array(
			'id_barang' => $id_barang,
			'nama_barang' => $nama_barang,
			'tanggal_masuk' => $tanggal_masuk,
			'total_stok' => $stok,
			'satuan' => $satuan,
			'keterangan' => 'online',
			'ket_lain' => 'obat',
			'id_user' => $id_kasir,
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pj_history_stok_barang', $dt);
	}

	function get_kadaluarsa($id_barang)
	{
		$sql = "
			SELECT 
				a.`id_barang`, 
				a.`nama_barang`,
				a.`tanggal_masuk`,
				a.`total_stok`,
				a.`satuan`,
				a.`keterangan`,
				a.`tgl_kadaluarsa`,
				a.`ket_lain`,
				a.`dihapus`
			FROM 
				`pj_history_stok_barang` AS a 
			WHERE 
				a.`id_barang` = '" . $id_barang . "' 
		";
		return $this->db->query($sql);
	}

	function tambah_history_stok_online($id_barang, $nama_barang, $stok, $satuan, $date, $id_kasir)
	{
		$tanggal_masuk = date('Y-m-d H:i:s');

		$dt = array(
			'id_barang' => $id_barang,
			'nama_barang' => $nama_barang,
			'tanggal_masuk' => $tanggal_masuk,
			'total_stok' => $stok,
			'satuan' => $satuan,
			'keterangan' => 'online',
			'tgl_kadaluarsa' => $date,
			'ket_lain' => 'obat',
			'id_user' => $id_kasir,
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pj_history_stok_barang', $dt);
	}

	function tambah_standar_obat_kimia($id_barang, $kd_barang, $kode_barang, $nama_barang, $standar_strip, $standar_pcs, $harga, $satuan)
	{
		$tanggal_masuk = date('Y-m-d');

		$dt = array(
			'id_barang' => $id_barang,
			'kode_barang' => $kode_barang,
			'kd_barang' => $kd_barang,
			'nama_barang' => $nama_barang,
			'tanggal_masuk' => $tanggal_masuk,
			'standar_pcs' => $standar_pcs,
			'standar_strip' => $standar_strip,
			'satuan' => $satuan,
			'harga' => $harga,
			'id_kategori_barang' => '2',
			'keterangan' => 'online',
			'ket_lain' => 'obat',
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pj_barang_standar', $dt);
	}

	function tambah_baru_histori($kode, $kode_barang2, $nama, $id_kategori_barang, $stok, $harga, $keterangan)
	{
		$tanggal_masuk = date('Y-m-d');

		$dt = array(
			'kode_barang' => $kode_barang2,
			'kd_barang' => $kode,
			'tanggal_masuk' => $tanggal_masuk,
			'nama_barang' => $nama,
			'total_stok' => $stok,
			'harga' => $harga,
			'id_kategori_barang' => $id_kategori_barang,
			'keterangan' => $keterangan,
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pj_barang_klinik', $dt);
	}

	public function ambilkodeobat()
	{
		$this->db->order_by('id_barang', 'desc');
		$this->db->limit(1, 0);
		$sql = $this->db->get('pj_barang');
		return $sql->result();
	}

	public function ambilkodeobat2()
	{
		$this->db->order_by('kode_barang', 'desc');
		$this->db->limit(1, 0);
		$sql = $this->db->get('pj_barang');
		return $sql->result();
	}

	public function ambilkodeobat3()
	{
		$this->db->order_by('kd_barang', 'desc');
		$this->db->limit(1, 0);
		$sql = $this->db->get('pj_barang');
		return $sql->result();
	}

	function cek_kode($kode)
	{
		return $this->db
			->select('id_barang')
			->where('kode_barang', $kode)
			->where('dihapus', 'tidak')
			->limit(1)
			->get('pj_barang');
	}

	function get_baris_standar($id_barang)
	{
		return $this->db
			->select('id_barang, kode_barang, nama_barang, standar_pcs, standar_strip, id_kategori_barang, satuan, keterangan')
			->where('id_barang', $id_barang)
			->limit(1)
			->get('pj_barang_standar');
	}

	function get_baris($id_barang)
	{
		return $this->db
			->select('id_barang, kode_barang, nama_barang, total_stok, total_isi, satuan, harga, id_kategori_barang, keterangan, info_tambahan')
			->where('id_barang', $id_barang)
			->limit(1)
			->get('pj_barang');
	}

	function get_baris_kode($kode)
	{
		return $this->db
			->select('id_barang, kode_barang, nama_barang, total_stok, satuan, harga, id_kategori_barang, keterangan, info_tambahan')
			->where('kode_barang', $kode)
			->limit(1)
			->get('pj_barang');
	}

	function get_baris2($id_barang)
	{
		$sql = "
			SELECT 
				a.`id_barang`, 
				a.`kode_barang`, 
				a.`kd_barang`,
				a.`nama_barang`,
				a.`total_stok`,
				a.`satuan`,
				a.`harga`,
				a.`keterangan`,
				b.`id_kategori_barang`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
			WHERE  
				a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				
				/*AND a.`total_stok` >= 0 */
				
				AND a.`kd_barang` = '" . $id_barang . "'

		";

		return $this->db->query($sql);
	}



	function update_barang($id_barang, $kode_barang, $nama, $id_kategori_barang, $stok, $satuan, $harga, $keterangan, $info_tambahan)
	{
		$dt = array(
			'kode_barang' => $kode_barang,
			'satuan' => $satuan,
			'nama_barang' => $nama,
			'total_stok' => $stok,
			'harga' => $harga,
			'id_kategori_barang' => $id_kategori_barang,
			'keterangan' => $keterangan,
			'info_tambahan' => $info_tambahan
		);

		return $this->db
			->where('id_barang', $id_barang)
			->update('pj_barang', $dt);
	}

	function update_barang_rincian($id_barang, $kode_barang, $nama, $id_kategori_barang, $total_isi, $satuan, $harga, $keterangan, $info_tambahan)
	{
		$dt = array(
			'kode_barang' => $kode_barang,
			'satuan' => $satuan,
			'nama_barang' => $nama,
			'total_isi' => $total_isi,
			'harga' => $harga,
			'id_kategori_barang' => $id_kategori_barang,
			'keterangan' => $keterangan,
			'info_tambahan' => $info_tambahan
		);

		return $this->db
			->where('id_barang', $id_barang)
			->update('pj_barang', $dt);
	}

	function update_barang_standar($id_barang, $standar_pcs, $standar_strip)
	{
		$dt = array(
			'standar_pcs' => $standar_pcs,
			'standar_strip' => $standar_strip
		);

		return $this->db
			->where('id_barang', $id_barang)
			->update('pj_barang_standar', $dt);
	}

	function cari_kode_rincian($keyword, $registered)
	{
		$not_in = '';

		$koma = explode(',', $registered);
		if (count($koma) > 1) {
			$not_in .= " AND `kode_barang` NOT IN (";
			foreach ($koma as $k) {
				$not_in .= " '" . $k . "', ";
			}
			$not_in = rtrim(trim($not_in), ',');
			$not_in = $not_in . ")";
		}
		if (count($koma) == 1) {
			$not_in .= " AND `kode_barang` != '" . $registered . "' ";
		}

		$sql = "
			SELECT 
				`kode_barang`,`tanggal_masuk`, `nama_barang`, `harga`, `keterangan` ,`total_isi`, `satuan`  
			FROM 
				`pj_barang_rincian` 
			WHERE 
				`dihapus` = 'tidak' 
				AND `keterangan` = 'klinik'
				AND ( 
					`kode_barang` LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
					OR `nama_barang` LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
				) 
				" . $not_in . " 
		";

		return $this->db->query($sql);
	}

	function cari_kode($keyword, $registered)
	{
		$not_in = '';

		$koma = explode(',', $registered);
		if (count($koma) > 1) {
			$not_in .= " AND `kode_barang` NOT IN (";
			foreach ($koma as $k) {
				$not_in .= " '" . $k . "', ";
			}
			$not_in = rtrim(trim($not_in), ',');
			$not_in = $not_in . ")";
		}
		if (count($koma) == 1) {
			$not_in .= " AND `kode_barang` != '" . $registered . "' ";
		}

		$sql = "
			SELECT 
				`kode_barang`,`tanggal_masuk`, `nama_barang`, `harga`, `keterangan` ,`total_stok`, `satuan`,`total_isi`  
			FROM 
				`pj_barang` 
			WHERE 
				`dihapus` = 'tidak' 
				AND `keterangan` = 'klinik'/*
				AND `total_stok` > 0 */
				AND ( 
					`kode_barang` LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
					OR `nama_barang` LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
				) 
				" . $not_in . " 
		";

		return $this->db->query($sql);
	}

	function cari_kode2($keyword, $registered)
	{
		$not_in = '';

		$koma = explode(',', $registered);
		if (count($koma) > 1) {
			$not_in .= " AND `kode_barang` NOT IN (";
			foreach ($koma as $k) {
				$not_in .= " '" . $k . "', ";
			}
			$not_in = rtrim(trim($not_in), ',');
			$not_in = $not_in . ")";
		}
		if (count($koma) == 1) {
			$not_in .= " AND `kode_barang` != '" . $registered . "' ";
		}

		$sql = "
			SELECT 
				`kode_barang`,`tanggal_masuk`, `nama_barang`, `harga`, `keterangan` ,`total_stok`,`ket_lain`, `satuan` 
			FROM 
				`pj_barang` 
			WHERE 
				`dihapus` = 'tidak' 
				AND `keterangan` = 'online'/*
				AND `total_stok` > 0 */
				AND ( 
					`kode_barang` LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
					OR `nama_barang` LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
				) 
				" . $not_in . " 
		";

		return $this->db->query($sql);
	}

	function get_stok($kode_barang)
	{/*
		return $this->db
			->select('nama_barang, total_stok')
			->where('kode_barang', $kode)
			->limit(1)
			->get('pj_barang');*/

		return $this->db->query("
			SELECT 
				`nama_barang`, `total_stok`
			FROM 
				`pj_barang` 
			WHERE 
			    `keterangan` = 'online' 
				AND `kode_barang`= '" . $kode_barang . "'
			limit 1
		");
	}

	function get_stok2($kode_barang)
	{/*
		return $this->db
			->select('nama_barang, total_stok')
			->where('kd_barang', $kode)
			->limit(1)
			->get('pj_barang');*/

		return $this->db->query("
			SELECT 
				`nama_barang`, `total_stok`
			FROM 
				`pj_barang` 
			WHERE 
			    `keterangan` = 'online' 
				AND `kd_barang`= '" . $kode_barang . "'
			limit 1
		");
	}

	function get_id($kode_barang)
	{
		return $this->db->query("
			SELECT 
				`id_barang`, `nama_barang`, `satuan`
			FROM 
				`pj_barang` 
			WHERE 
				`dihapus` = 'tidak' 
				AND `keterangan` = 'klinik' 
				AND `kode_barang`= '" . $kode_barang . "'
		");
	}

	function get_id_asuransi($kode_barang)
	{
		return $this->db->query("
			SELECT 
				`id_barang`, `nama_barang`
			FROM 
				`pj_barang` 
			WHERE 
				`dihapus` = 'tidak' 
				AND `keterangan` = 'klinik' 
				AND `kode_barang`= '" . $kode_barang . "'
		");
	}

	function get_id_medan($kode_barang)
	{
		return $this->db->query("
			SELECT 
				`id_barang`, `nama_barang`
			FROM 
				`pj_barang` 
			WHERE 
				`dihapus` = 'tidak' 
				AND `keterangan` = 'online' 
				AND `kode_barang`= '" . $kode_barang . "'
		");
	}

	function get_id2($kode_barang)
	{
		return $this->db->query("
			SELECT 
				`id_barang`, `nama_barang`
			FROM 
				`pj_barang` 
			WHERE 
				`dihapus` = 'tidak' 
				AND `keterangan` = 'online' 
				AND `kode_barang`= '" . $kode_barang . "'
		");
	}

	function get_id_online($kode_barang)
	{
		return $this->db->query("
			SELECT 
				`id_barang`, `nama_barang`
			FROM 
				`pj_barang` 
			WHERE 
				`dihapus` = 'tidak' 
				AND `keterangan` = 'online' 
				AND `kode_barang`= '" . $kode_barang . "'
		");
		/*return $this->db
			->select('id_barang, nama_barang')
			->where('kode_barang', $kode_barang)
			->limit(1)
			->get('pj_barang');*/
	}

	function get_id_klinik($kode_barang)
	{

		return $this->db->query("
			SELECT 
				`id_barang`, `nama_barang`
			FROM 
				`pj_barang` 
			WHERE 
				`dihapus` = 'tidak' 
				AND `keterangan` = 'online' 
				AND `kd_barang`= '" . $kode_barang . "''
		");
	}


	function update_stok($id_barang, $jumlah_beli)
	{
		$sql = "
			UPDATE `pj_barang` SET `total_stok` = `total_stok` - " . $jumlah_beli . " WHERE `id_barang` = '" . $id_barang . "' AND `id_barang` NOT IN ('4', '3', '7')
		";

		return $this->db->query($sql);
	}

	function update_stok_online($id_barang, $stok)
	{
		$sql = "
			UPDATE `pj_barang` SET `total_stok` = `total_stok` + " . $stok . " WHERE `kode_barang` = '" . $id_barang . "' AND `keterangan` = 'online' 
		";

		return $this->db->query($sql);
	}

	function update_stok_online_tambah($id_barang, $stok)
	{
		$sql = "
			UPDATE `pj_barang` SET `total_stok` = `total_stok` + " . $stok . " WHERE `id_barang` = '" . $id_barang . "' AND `keterangan` = 'online' 
		";

		return $this->db->query($sql);
	}

	function update_stok_online_kimia_tambah_pcs($id_barang, $total_stok_pcs, $date)
	{
		$sql = "
			UPDATE `pj_barang` SET `total_stok` = `total_stok` + " . $total_stok_pcs . " WHERE `id_barang` = '" . $id_barang . "' AND `keterangan` = 'online' 
		";


		$this->db->query($sql);

		$dt['tgl_kadaluarsa'] = $date;
		return $this->db->where('id_barang', $id_barang)->update('pj_barang', $dt);
	}

	function update_stok_online_kimia_tambah_strip($id_barang, $total_stok_strip, $date)
	{
		$sql = "
			UPDATE `pj_barang` SET `total_stok` = `total_stok` + " . $total_stok_strip . " WHERE `id_barang` = '" . $id_barang . "' AND `keterangan` = 'online' 
		";

		$this->db->query($sql);

		$dt['tgl_kadaluarsa'] = $date;
		return $this->db->where('id_barang', $id_barang)->update('pj_barang', $dt);
	}

	function update_stok_klinik($kode, $stok)
	{
		$sql = "
			UPDATE `pj_barang` SET `total_stok` = `total_stok` + " . $stok . " WHERE `kd_barang` = '" . $kode . "' AND `keterangan` = 'klinik'
		";

		return $this->db->query($sql);
	}

	function update_stok2($id_barang, $stok)
	{
		$sql = "
			UPDATE `pj_barang` SET `total_stok` = `total_stok` - " . $stok . " WHERE `id_barang` = '" . $id_barang . "' 
		";

		return $this->db->query($sql);
	}

	function update_stok3($id_barang, $jumlah_beli)
	{
		$sql = "
			UPDATE `pj_barang` SET `total_stok` = `total_stok` - " . $jumlah_beli . " WHERE `id_barang` = '" . $id_barang . "' AND `id_barang` NOT IN ('4', '3', '7', '9')
		";

		return $this->db->query($sql);
	}

	/*================================== JASA ==================================*/

	function cari_kode_jasa($keyword, $registered)
	{
		$not_in = '';

		$koma = explode(',', $registered);
		if (count($koma) > 1) {
			$not_in .= " AND `kode_barang` NOT IN (";
			foreach ($koma as $k) {
				$not_in .= " '" . $k . "', ";
			}
			$not_in = rtrim(trim($not_in), ',');
			$not_in = $not_in . ")";
		}
		if (count($koma) == 1) {
			$not_in .= " AND `kode_barang` != '" . $registered . "' ";
		}

		$sql = "
			SELECT 
				`kode_barang`, `nama_jasa`, `harga` 
			FROM 
				`pj_jasa` 
			WHERE 
				`dihapus` = 'tidak' 
				AND ( 
					`kode_barang` LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
					OR `nama_jasa` LIKE '%" . $this->db->escape_like_str($keyword) . "%' 
				) 
				" . $not_in . " 
		";

		return $this->db->query($sql);
	}

	function get_id_jasa($kode_barang)
	{
		return $this->db
			->select('nama_barang')
			->where('kode_barang', $kode_barang)
			->limit(1)
			->get('pj_barang');
	}

	function fetch_data_jasa($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_barang`, 
				a.`kode_barang`, 
				a.`nama_barang`,
				a. total_stok,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
				AND a.`ket_lain` = 'jasa'
		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				a.`kode_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`nama_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`keterangan` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR b.`kategori` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'a.`kode_barang`',
			2 => 'a.`nama_barang`',
			3 => '`harga`',

		);

		$sql .= " ORDER BY " . $columns_order_by[$column_order] . " " . $column_dir . ", nomor ";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}
	function fetch_data_by_id($table, $id = null)
	{
		$this->db->select('*');
		$this->db->from($table);
		if ($id) {
			$this->db->where('id', $id);
		}
		return $this->db->get();
	}
	function fetch_data($table, $where)
	{
		$this->db->select('*');
		$this->db->from($table);
		if ($where) {
			$this->db->where($where);
		}
		return $this->db->get();
	}

	function fetch_data_barang_history_herbal2($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_barang`, a.`satuan`,
				a.`kode_barang`, 
				a.`tanggal_masuk`,
				a.`nama_barang`,
				a. total_stok,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				c.`nama` AS kasir,
				b.`kategori`
			FROM 
				`pj_history_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
				LEFT JOIN `pj_user` AS c ON a.`id_user` = c.`id_user` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND a.`id_kategori_barang` = '1'
				AND a.`ket_lain` = 'obat'
		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				a.`kode_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`nama_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`keterangan` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR b.`kategori` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'a.`kode_barang`',
			2 => 'a.`nama_barang`',
			3 => 'b.`kategori`',
			4 => 'a.`total_stok`',
			5 => '`harga`',
			6 => 'a.`keterangan`'
		);

		$sql .= " ORDER BY a.`tanggal_masuk` DESC";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function fetch_data_barang_history_kimia2($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_barang`, 
				a.`kode_barang`, 
				a.`tanggal_masuk`,
				a.`nama_barang`,
				a. total_stok,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				c.`nama` AS kasir,
				b.`kategori`
			FROM 
				`pj_history_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
				LEFT JOIN `pj_user` AS c ON a.`id_user` = c.`id_user` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND a.`id_kategori_barang` = '2'
				AND a.`ket_lain` = 'obat'
		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				a.`kode_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`nama_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`keterangan` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR b.`kategori` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'a.`kode_barang`',
			2 => 'a.`nama_barang`',
			3 => 'b.`kategori`',
			4 => 'a.`total_stok`',
			5 => '`harga`',
			6 => 'a.`keterangan`'
		);

		$sql .= " ORDER BY a.`tanggal_masuk` DESC";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}
	function fetch_data_barang_history_herbal($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id`,a.`satuan`,
				a.`id_barang`, 
				a.`tanggal_masuk`,
				a.`nama_barang`,
				a. total_stok,
				CONCAT('Rp. ', REPLACE(FORMAT(b.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				c.`nama` AS kasir,
				b.`id_kategori_barang`
			FROM 
				`pj_history_stok_barang` AS a 
				LEFT JOIN `pj_barang` AS b ON a.`id_barang` = b.`id_barang` 
				LEFT JOIN `pj_user` AS c ON a.`id_user` = c.`id_user` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND b.`id_kategori_barang` = '1'
				AND a.`ket_lain` = 'obat'
		";
		// var_dump($sql);
		// die;
		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				a.`kode_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`nama_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`keterangan` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR b.`kategori` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'id_barang',
			2 => 'nama_barang',
			3 => 'tanggal_masuk',
			4 => 'harga',
			5 => 'total_stok',
			6 => 'keterangan',
			7 => 'kasir',
			9 => 'id',
			10 => 'satuan'
		);

		$sql .= " ORDER BY a.`id` DESC";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}
	function fetch_data_barang_history_kimia($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id`,a.`satuan`,
				a.`id_barang`, 
				a.`tanggal_masuk`,
				a.`nama_barang`,
				a. total_stok,
				CONCAT('Rp. ', REPLACE(FORMAT(b.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				c.`nama` AS kasir,
				b.`id_kategori_barang`
			FROM 
				`pj_history_stok_barang` AS a 
				LEFT JOIN `pj_barang` AS b ON a.`id_barang` = b.`id_barang` 
				LEFT JOIN `pj_user` AS c ON a.`id_user` = c.`id_user` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND b.`id_kategori_barang` = '2'
				AND a.`ket_lain` = 'obat'
		";
		// var_dump($sql);
		// die;
		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				a.`kode_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`nama_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`keterangan` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR b.`kategori` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'id_barang',
			2 => 'nama_barang',
			3 => 'tanggal_masuk',
			4 => 'harga',
			5 => 'total_stok',
			6 => 'keterangan',
			7 => 'kasir',
			8 => 'id',
			9 => 'satuan'
		);

		$sql .= " ORDER BY a.`id` DESC";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}
	function fetch_data_barang_history_online($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id`,a.`satuan`,
				a.`id_barang`, 
				a.`tanggal_masuk`,
				a.`nama_barang`,
				a. total_stok,
				CONCAT('Rp. ', REPLACE(FORMAT(b.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				c.`nama` AS kasir,
				d.`kategori` as kategori
			FROM 
				`pj_history_stok_barang` AS a 
				LEFT JOIN `pj_barang` AS b ON a.`id_barang` = b.`id_barang` 
				LEFT JOIN `pj_kategori_barang` AS d ON b.`id_kategori_barang` = d.`id_kategori_barang` 
				LEFT JOIN `pj_user` AS c ON a.`id_user` = c.`id_user` 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND a.`ket_lain` = 'obat'
		";

		$data['totalData'] = $this->db->query($sql)->num_rows();

		if (!empty($like_value)) {
			$sql .= " AND ( ";
			$sql .= "
				a.`kode_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`nama_barang` LIKE '%" . $this->db->escape_like_str($like_value) . "%'
				OR IF(a.`total_stok` = 0, 'Kosong', a.`total_stok`) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR a.`keterangan` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
				OR b.`kategori` LIKE '%" . $this->db->escape_like_str($like_value) . "%' 
			";
			$sql .= " ) ";
		}

		$data['totalFiltered']	= $this->db->query($sql)->num_rows();

		$columns_order_by = array(
			0 => 'nomor',
			1 => 'id_barang',
			2 => 'nama_barang',
			3 => 'tanggal_masuk',
			4 => 'harga',
			5 => 'total_stok',
			6 => 'keterangan',
			7 => 'kasir',
			8 => 'kategori',
			9 => 'id',
			10 => 'satuan'

		);

		$sql .= " ORDER BY a.`id` DESC";
		$sql .= " LIMIT " . $limit_start . " ," . $limit_length . " ";

		$data['query'] = $this->db->query($sql);
		return $data;
	}
	function update_data($data, $where, $table)
	{
		$this->db->where($where);
		$update = $this->db->update($table, $data);
		if ($update) {
			return "success";
		} else {
			return "failed";
		}
	}
	function deleteMasterData($table, $where)
	{

		$this->db->where($where);
		$query = $this->db->delete($table);
		if ($query) {
			return "success";
		} else {
			return "failed";
		}
	}
}
