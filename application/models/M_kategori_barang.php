<?php
class M_kategori_barang extends CI_Model 
{
	function get_all()
	{
		return $this->db
			->select('id_kategori_barang, kategori')
			->where('dihapus', 'tidak')
			->order_by('kategori', 'asc')
			->get('pj_kategori_barang');
	}
	
	function get_all_satuan()
	{
		return $this->db
			->select('id_satuan, satuan')
			->where('dihapus', 'tidak')
			->order_by('satuan', 'asc')
			->get('pj_satuan');
	}

	/*function get_all_barang()
	{
		return $this->db
			->select('id_barang, harga, nama_barang, total_stok, keterangan')
			->where('dihapus', 'tidak')
			->order_by('nama_barang', 'asc')
			->get('pj_barang');
	}*/
	
	function get_baris_update_barang_online_kimia($kd_barang)
	{
		$sql = ("
				
			SELECT 
				a.`id_barang`, 
				a.`kode_barang`,
				a.`kd_barang`, 
				a.`nama_barang`,
				a.`total_stok`,
				a.`satuan`,
				a.`harga`,
				a.`keterangan`,
				a.`id_kategori_barang`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
			WHERE  
				a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND a.`kd_barang` = '".$kd_barang."'
				AND a.`ket_lain` = 'obat'
		");
		
	return $this->db->query($sql);
	
	}
	
	function get_baris_barang_online($id_barang)
	{
		$sql = ("
				
			SELECT 
				a.`id_barang`, 
				a.`kode_barang`,
				a.`kd_barang`, 
				a.`nama_barang`,
				a. `total_stok`,
				a.`satuan`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
			WHERE  
				a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND a.`id_barang` = '".$id_barang."'
				AND a.`ket_lain` = 'obat'
		");
		
	return $this->db->query($sql);
	
	}

	function get_baris_barang_online_kimia_standar($id_barang)
	{
		$sql = ("
				
			SELECT 
				a.`id_barang`, 
				a.`kode_barang`,
				a.`kd_barang`, 
				a.`nama_barang`,
				a.`satuan`,
				a.`standar_strip`,
				a.`standar_pcs`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				b.`kategori`
			FROM 
				`pj_barang_standar` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang`
			WHERE  
				a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND a.`id_barang` = '".$id_barang."'
		");
		
	return $this->db->query($sql);
	
	}
	
	function get_baris_barang_online_kimia($id_barang)
	{
		$sql = ("
				
			SELECT 
				a.`id_barang`, 
				a.`kode_barang`,
				a.`kd_barang`, 
				a.`nama_barang`,
				a.`satuan`,
				a.`harga`,
				a.`keterangan`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang`
			WHERE  
				a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND a.`id_kategori_barang` = '2'
				AND a.`id_barang` = '".$id_barang."'
		");
		
	return $this->db->query($sql);
	
	}

	function get_all_barang()
	{
		$sql = "
			SELECT 
				a.`id_barang`, 
				a.`kode_barang`,
				a.`kd_barang`, 
				a.`nama_barang`,
				a. `total_stok`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
			WHERE  
				a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND a.`ket_lain` = 'obat'

		";

		return $this->db->query($sql);
		 
	}
	
	function get_all_barang_herbal_online()
	{
		$sql = "
			SELECT 
				a.`id_barang`, 
				a.`kode_barang`,
				a.`kd_barang`, 
				a.`nama_barang`,
				a. `total_stok`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
			WHERE  
				a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND a.`id_kategori_barang` NOT IN ('2') 
				AND a.`ket_lain` = 'obat'

		";

		return $this->db->query($sql);
		 
	}
	
	function get_all_barang_kimia()
	{
		$sql = "
			SELECT 
				a.`id_barang`, 
				a.`kode_barang`,
				a.`kd_barang`, 
				a.`nama_barang`,
				a. `total_stok`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
			WHERE  
				a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND a.`id_kategori_barang` = '2'
				AND a.`ket_lain` = 'obat'

		";

		return $this->db->query($sql);
		 
	}
	
	function get_all_barang_standar2()
	{
		$sql = "
			SELECT 
				a.`id_barang`, 
				a.`kode_barang`,
				a.`kd_barang`, 
				a.`nama_barang`,
				c.`standar_strip`,
				c.`standar_pcs`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				b.`kategori`
			FROM 
				`pj_barang` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
				LEFT JOIN `pj_barang_standar` AS c ON a.`id_barang` = c.`id_barang`
			WHERE  
				a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online'
				AND a.`id_kategori_barang` = '2' 
				AND a.`ket_lain` = 'obat'

		";

		return $this->db->query($sql);
		 
	}
	
	function get_all_barang_standar()
	{
		$sql = "
			SELECT 
				a.`id_barang`, 
				a.`kode_barang`,
				a.`kd_barang`, 
				a.`nama_barang`,
				a.`standar_strip`,
				a.`standar_pcs`,
				CONCAT('Rp. ', REPLACE(FORMAT(a.`harga`, 0),',','.') ) AS harga,
				a.`keterangan`,
				b.`kategori`
			FROM 
				`pj_barang_standar` AS a 
				LEFT JOIN `pj_kategori_barang` AS b ON a.`id_kategori_barang` = b.`id_kategori_barang` 
			WHERE  
				a.`dihapus` = 'tidak'
				AND a.`keterangan` = 'online' 
				AND a.`ket_lain` = 'obat'

		";

		return $this->db->query($sql);
		 
	}

	function fetch_data_kategori($like_value = NULL, $column_order = NULL, $column_dir = NULL, $limit_start = NULL, $limit_length = NULL)
	{
		$sql = "
			SELECT 
				(@row:=@row+1) AS nomor, 
				id_kategori_barang, 
				kategori  
			FROM 
				`pj_kategori_barang`, (SELECT @row := 0) r WHERE 1=1 
				AND dihapus = 'tidak' 
		";
		
		$data['totalData'] = $this->db->query($sql)->num_rows();
		
		if( ! empty($like_value))
		{
			$sql .= " AND ( ";    
			$sql .= "
				kategori LIKE '%".$this->db->escape_like_str($like_value)."%' 
			";
			$sql .= " ) ";
		}
		
		$data['totalFiltered']	= $this->db->query($sql)->num_rows();
		
		$columns_order_by = array( 
			0 => 'nomor',
			1 => 'kategori'
		);
		
		$sql .= " ORDER BY ".$columns_order_by[$column_order]." ".$column_dir.", nomor ";
		$sql .= " LIMIT ".$limit_start." ,".$limit_length." ";
		
		$data['query'] = $this->db->query($sql);
		return $data;
	}

	function tambah_kategori($kategori)
	{
		$dt = array(
			'kategori' => $kategori,
			'dihapus' => 'tidak'
		);

		return $this->db->insert('pj_kategori_barang', $dt);
	}

	function hapus_kategori($id_kategori_barang)
	{
		$dt = array(
			'dihapus' => 'ya'
		);

		return $this->db
			->where('id_kategori_barang', $id_kategori_barang)
			->update('pj_kategori_barang', $dt);
	}

	function get_baris($id_kategori_barang)
	{
		return $this->db
			->select('id_kategori_barang, kategori')
			->where('id_kategori_barang', $id_kategori_barang)
			->limit(1)
			->get('pj_kategori_barang');
	}

	function update_kategori($id_kategori_barang, $kategori)
	{
		$dt = array(
			'kategori' => $kategori
		);

		return $this->db
			->where('id_kategori_barang', $id_kategori_barang)
			->update('pj_kategori_barang', $dt);
	}
}