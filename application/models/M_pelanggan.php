<?php
class M_pelanggan extends CI_Model
{
	function get_all()
	{

	$sql = ("
			SELECT 
				a.`id_pelanggan`,
				a.`nrmp`,
				a.`nama`,
				b.`nama` AS nama_herbalis,
				a.`alamat`,
				a.`telp`,
				a.`info_tambahan`,
				DATE_FORMAT(a.`waktu_input`, '%d %b %Y - %H:%i:%s') AS waktu_input 
			FROM 
				`pj_pelanggan` AS a 
				LEFT JOIN `pj_herbalis` AS b ON a.`id_herbalis` = b.`id_herbalis`
				 where a.`dihapus` = 'tidak'
				 AND a.`keterangan` = 'pasien klinik'  
		");
		
	return $this->db->query($sql);
	
	}
	
	function get_all_jmo()
	{

	$sql = ("
			SELECT 
				a.`id_pelanggan`,
				a.`nrmp`,
				a.`nama`,
				b.`nama` AS nama_herbalis,
				a.`alamat`,
				a.`telp`,
				a.`info_tambahan`,
				DATE_FORMAT(a.`waktu_input`, '%d %b %Y - %H:%i:%s') AS waktu_input 
			FROM 
				`pj_pelanggan` AS a 
				LEFT JOIN `pj_herbalis` AS b ON a.`id_herbalis` = b.`id_herbalis`/*
				LEFT JOIN `pj_jmo` AS c ON a.`id_pelanggan` = c.`id_pelanggan`*/
				where a.`dihapus` = 'tidak'/*
				AND a.`id_pelanggan` NOT IN (c.`id_pelanggan`)*/
		");
		
	return $this->db->query($sql);
	
	}


	function get_all_online()
	{

	$sql = ("
			SELECT 
				a.`id_pelanggan`,
				a.`nrmp`,
				a.`nama`,
				b.`nama` AS nama_herbalis,
				a.`alamat`,
				a.`telp`,
				a.`info_tambahan`,
				DATE_FORMAT(a.`waktu_input`, '%d %b %Y - %H:%i:%s') AS waktu_input 
			FROM 
				`pj_pelanggan` AS a 
				LEFT JOIN `pj_herbalis` AS b ON a.`id_herbalis` = b.`id_herbalis`
				 where a.`dihapus` = 'tidak'
				 AND a.`keterangan` = 'pasien online'  
		");
		
	return $this->db->query($sql);
	
	}

	function get_baris($id_pelanggan)
	{
		return $this->db
			->select('id_pelanggan, nrmp, nama, id_herbalis, tgl_kembali, alamat, telp, info_tambahan')
			->where('id_pelanggan', $id_pelanggan)
			->limit(1)
			->get('pj_pelanggan');
	}
	
	function get_baris_jmo($id_jmo)
	{
		return $this->db
			->select('id_jmo, nrmp, nama, herbalis, keterangan, info_tambahan')
			->where('id_jmo', $id_jmo)
			->limit(1)
			->get('pj_jmo');
	}

	function get_baris2($id_pelanggan)
	{
		$sql = ("
			SELECT 
				`id_pelanggan`,
				`nrmp`,
				`nama`,
				`id_herbalis`,
				`alamat`,
				`telp`,
				`info_tambahan`,
				`keterangan`,
				`tgl_kembali`,
				DATE_FORMAT(`waktu_input`, '%d %b %Y - %H:%i:%s') AS waktu_input 
			FROM 
				`pj_pelanggan`
				where `id_pelanggan`= '".$id_pelanggan."'
				AND `dihapus` = 'tidak'
				AND `keterangan` = 'pasien klinik' 
		");
		
	return $this->db->query($sql);
	
	}
	
	function get_baris_herbalis($id_pelanggan)
	{
		$sql = ("
			SELECT 
				(@row:=@row+1) AS nomor,
				max(b.id_penjualan_m) AS id_penjualan_m,
				b.tanggal,
				a.tgl_kembali,
				DATE_FORMAT(a.tgl_kembali, '%d %M %Y') AS tgl_kembali2,
				b.tanggal_kembali,
				a.keterangan_lain,
				a.id_pelanggan,
				a.nama,
				a.nrmp,
				b.nama_herbalis,
				a.info_tambahan,
				a.keterangan
			FROM 
				`pj_pelanggan` AS a
                LEFT JOIN `pj_penjualan_master` AS b ON b.`id_pelanggan` = a.`id_pelanggan` 
                , (SELECT @row := 0) r 
			WHERE 1=1
				AND b.id_pelanggan= '".$id_pelanggan."'
			    AND b.keterangan = 'pasien online'
				AND b.status = 'ok'
            GROUP BY a.nama
		");
		
	return $this->db->query($sql);
	
	}
	
	function get_baris2_jmo($id_pelanggan)
	{
		$sql = ("
			SELECT 
				`id_pelanggan`,
				`nrmp`,
				`nama`,
				`id_herbalis`,
				`alamat`,
				`telp`,
				`info_tambahan`,
				`keterangan`,
				`tgl_kembali`,
				DATE_FORMAT(`waktu_input`, '%d %b %Y - %H:%i:%s') AS waktu_input 
			FROM 
				`pj_pelanggan`
				where `id_pelanggan`= '".$id_pelanggan."'
				AND `dihapus` = 'tidak'
		");
		
	return $this->db->query($sql);
	
	}

	function get_baris3($id_pelanggan)
	{
		$sql = ("
			SELECT 
				a.`id_pelanggan`,
				a.`nrmp`,
				a.`nama`,
				b.`nama_herbalis`,
				a.`alamat`,
				a.`telp`,
				a.`info_tambahan`,
				a.`sales`,
				a.`keterangan`,
				a.`tgl_kembali`,
				DATE_FORMAT(a.`waktu_input`, '%d %b %Y - %H:%i:%s') AS waktu_input 
			FROM 
				`pj_pelanggan` AS a 
				LEFT JOIN `pj_herbalis` AS b ON a.`id_herbalis` = b.`id_herbalis`
				where a.`id_pelanggan`= '".$id_pelanggan."'
				AND a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'pasien online' 
		");
		
	return $this->db->query($sql);
	
	}
	
	function fetch_data_pelanggan_JMO($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_jmo`, 
				a.`id_pelanggan`, 
				a.`nrmp`, 
				a.`nama`, 
				a.`herbalis`, 
				a.`keterangan`,
				a.`info_tambahan`
			FROM 
				`pj_jmo` AS a 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak'
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`herbalis` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`nrmp` LIKE '%".$this->db->escape_like_str($like_value)."%'
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`nama`',
			2 => 'a.`herbalis`',
			3 => 'a.`nrmp`'
		);

		$sql .= " ORDER BY a.`id_jmo` DESC ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function fetch_data_pelanggan($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_pelanggan`, 
				a.`nrmp`, 
				a.`nama`, 
				a.`id_herbalis`, 
				DATE_FORMAT(a.`tgl_kembali`, '%d %M %Y') AS tgl_kembali, 
				a.`alamat`,
				a.`telp`,
				a.`info_tambahan`,
				a.`keterangan`,
				DATE_FORMAT(a.`waktu_input`, '%d %b %Y') AS waktu_input 
			FROM 
				`pj_pelanggan` AS a 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak' 
				AND a.`keterangan` = 'pasien klinik' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`alamat` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`telp` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`info_tambahan` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR DATE_FORMAT(a.`waktu_input`, '%d %b %Y - %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`nama`',
			2 => 'a.`alamat`',
			3 => 'a.`telp`',
			4 => 'a.`info_tambahan`',
			5 => 'a.`waktu_input`'
		);

		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function fetch_data_pelanggan_online($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_pelanggan`,
				a.`nrmp`,
				a.`nama`, 
				a.`alamat`,
				DATE_FORMAT(a.`tgl_kembali`, '%d %M %Y') AS tgl_kembali,
				a.`telp`,
				a.`info_tambahan`,
				a.`keterangan`,
				DATE_FORMAT(a.`waktu_input`, '%d %b %Y') AS waktu_input 
			FROM 
				`pj_pelanggan` AS a 
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak' 
				AND a.`keterangan` = 'pasien online' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`alamat` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`telp` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`info_tambahan` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR DATE_FORMAT(a.`waktu_input`, '%d %b %Y - %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`nama`',
			2 => 'a.`alamat`',
			3 => 'a.`telp`',
			4 => 'a.`info_tambahan`',
			5 => 'a.`waktu_input`'
		);

		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	
	function fetch_data_pelanggan_zoom($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				a.`id_pelanggan`,
				a.`nrmp`,
				a.`nama`, 
				a.`alamat`,
				a.`id_herbalis`,
				DATE_FORMAT(a.`tgl_kembali`, '%d %M %Y') AS tgl_kembali,
				a.`telp`,
				a.`info_tambahan`,
				a.`keterangan`,
				DATE_FORMAT(a.`waktu_input`, '%d %b %Y') AS waktu_input 
			FROM 
				`pj_pelanggan` AS a 
				LEFT JOIN `pj_penjualan_master` AS b ON a.`id_pelanggan` = b.`id_pelanggan`
				, (SELECT @row := 0) r WHERE 1=1 
				AND a.`dihapus` = 'tidak' 
				AND b.`keterangan_lain` = 'zoom'
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				a.`nama` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`alamat` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`telp` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR a.`info_tambahan` LIKE '%".$this->db->escape_like_str($like_value)."%' 
				OR DATE_FORMAT(a.`waktu_input`, '%d %b %Y - %H:%i:%s') LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'a.`nama`',
			2 => 'a.`alamat`',
			3 => 'a.`telp`',
			4 => 'a.`info_tambahan`',
			5 => 'a.`waktu_input`'
		);
		
        $sql .= " GROUP BY a.`nama`";
		$sql .= " ORDER BY a.`id_pelanggan` DESC";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}
	
	function tambah_pelanggan_jmo($nrmp, $nama, $id_pelanggan, $herbalis, $keterangan, $info_tambahan)
	{
		date_default_timezone_set("Asia/Jakarta");
		$dt = array(
			'nrmp' => $nrmp,
			'id_pelanggan' => $id_pelanggan,
			'nama' => $nama,
			'herbalis' => $herbalis,
			'keterangan' => $keterangan,
			'info_tambahan' =>  $info_tambahan,
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pj_jmo', $dt);
	}

	function tambah_pelanggan($nrmp, $nama, $alamat, $telepon, $info, $unique, $herbalis, $tgl_kembali)
	{
		date_default_timezone_set("Asia/Jakarta");
		$dt = array(
			'nrmp' => $nrmp,
			'nama' => $nama,
			'id_herbalis' => $herbalis,
			'alamat' => $alamat,
			'telp' => $telepon,
			'info_tambahan' => $info,
			'waktu_input' => date('Y-m-d H:i:s'),
			'dihapus' => 'tidak',
			'kode_unik' => $unique,
			'tgl_kembali' =>$tgl_kembali,
			'keterangan' => 'pasien klinik'
			 /*date('d F Y', strtotime($tgl_kembali))*/
		);

		return $this->db->insert('pj_pelanggan', $dt);
	}

	function tambah_pelanggan_online($nrmp, $nama, $tgl_kembali, $alamat, $telepon, $info, $unique)
	{
		date_default_timezone_set("Asia/Jakarta");

		$dt = array(
			'nrmp' => $nrmp,
			'nama' => $nama,
			'alamat' => $alamat,
			'telp' => $telepon,
			'info_tambahan' => $info,
			'waktu_input' => date('Y-m-d H:i:s'),
			'dihapus' => 'tidak',
			'kode_unik' => $unique,
			'tgl_kembali' =>$tgl_kembali,
			'keterangan' => 'pasien online'
		);

		return $this->db->insert('pj_pelanggan', $dt);
	}
    
    function update_pelanggan($id_pelanggan, $nrmp, $nama, $herbalis, $tgl_kembali, $info)
	{
		$dt = array(
			'nrmp' => $nrmp,
			'nama' => $nama,
			'id_herbalis' => $herbalis,
			'tgl_kembali' => $tgl_kembali,
			'info_tambahan' => $info
		);

		return $this->db
			->where('id_pelanggan', $id_pelanggan)
			->update('pj_pelanggan', $dt);
	}
	
	function update_pelanggan_jmo($id_jmo, $nrmp, $nama, $herbalis, $keterangan, $info_tambahan)
	{
		$dt = array(
			'nrmp' => $nrmp,
			'nama' => $nama,
			'herbalis' => $herbalis,
			'keterangan' => $keterangan,
			'info_tambahan' => $info_tambahan
		);

		return $this->db
			->where('id_jmo', $id_jmo)
			->update('pj_jmo', $dt);
	}
    
	function update_pelanggan2($id_pelanggan, $nrmp, $nama, $tgl_kembali, $alamat, $telepon, $info)
	{
		$dt = array(
			'nrmp' => $nrmp,
			'nama' => $nama,
			'alamat' => $alamat,
			'tgl_kembali' => $tgl_kembali,
			'telp' => $telepon,
			'info_tambahan' => $info
		);

		return $this->db
			->where('id_pelanggan', $id_pelanggan)
			->update('pj_pelanggan', $dt);
	}
	
	function update_pelanggan_datang_kembali($id_pelanggan, $nrmp, $nama,$tgl_kembali, $info, $keterangan_pasien)
	{
		$dt = array(
			'nrmp' => $nrmp,
			'nama' => $nama,
			'tgl_kembali' => $tgl_kembali,
			'keterangan_lain' => $keterangan_pasien,
			'info_tambahan' => $info
		);

		return $this->db
			->where('id_pelanggan', $id_pelanggan)
			->update('pj_pelanggan', $dt);
	}
	
	function update_penjualanmaster_datang_kembali($id_penjualan_m,$tgl_kembali)
	{
		$dt = array(
			'tanggal_kembali' =>date('d F Y', strtotime($tgl_kembali))
		);

		return $this->db
			->where('id_penjualan_m', $id_penjualan_m)
			->update('pj_penjualan_master', $dt);
	}

	function hapus_pelanggan($id_pelanggan)
	{
		$dt = array(
			'dihapus' => 'ya'
		);

		return $this->db
			->where('id_pelanggan', $id_pelanggan)
			->update('pj_pelanggan', $dt);
	}
	
	function hapus_pelanggan_jmo($id_jmo)
	{
		return $this->db->where('id_jmo', $id_jmo)->delete('pj_jmo');
	}
	
	

	function get_dari_kode($kode_unik)
	{
		return $this->db
			->select('id_pelanggan')
			->where('kode_unik', $kode_unik)
			->limit(1)
			->get('pj_pelanggan');
	}


	/*================== HERBALIS ===================*/
	function get_all_herbalis()
	{
		return $this->db
			->select('id_herbalis, nama, nama_herbalis')
			->order_by('nama_herbalis','asc')
			->get('pj_herbalis');
	}

	function get_all_sales()
	{
		return $this->db
			->select('id_sales, nama_sales')
			->order_by('nama_sales','asc')
			->get('pj_sales');
	}
}