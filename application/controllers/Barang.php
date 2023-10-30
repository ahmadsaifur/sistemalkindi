<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------
 * CLASS NAME : Barang
 * ------------------------------------------------------------------------
 *
 * @author     Muhammad Akbar <muslim.politekniktelkom@gmail.com>
 * @copyright  2016
 * @license    http://aplikasiphp.net
 *
 */

class Barang extends MY_Controller
{
	public function index()
	{
		$this->output->cache(0.1);
		$this->load->view('barang/barang_data');
	}

	public function tabel_data_kadaluarsa()
	{
		$this->output->cache(0.1);
		$this->load->view('barang/tabel_data_kadaluarsa');
	}

	public function barang_kadaluarsa()
	{
		$this->output->cache(0.1);
		$this->load->view('barang/barang_kadaluarsa');
	}

	public function barang_kimia_standar()
	{
		$this->output->cache(0.1);
		$this->load->view('barang/standar_barang_kimia');
	}

	public function barang_online_kimia()
	{
		$this->output->cache(0.1);
		$this->load->view('barang/barang_online_kimia');
	}

	public function barang_online_herbal()
	{
		$this->output->cache(0.1);
		$this->load->view('barang/barang_online_herbal');
	}

	public function barang_online()
	{
		$this->output->cache(0.1);
		$this->load->view('barang/barang_online');
	}

	public function barang_klinik()
	{
		$this->output->cache(0.1);
		$this->load->view('barang/barang_klinik');
	}

	public function history_brg_online()
	{
		$this->output->cache(0.1);
		$this->load->view('barang/barang_history_online');
	}
	public function history_brg_herbal()
	{
		$this->output->cache(0.1);
		$this->load->view('barang/barang_history_stok_herbal');
	}
	public function history_brg_kimia()
	{
		$this->output->cache(0.1);
		$this->load->view('barang/barang_history_stok_kimia');
	}
	public function history_update_stok_online()
	{
		$this->output->cache(0.1);
		$this->load->view('barang/barang_history_stok_online');
	}

	public function history_brg_klinik()
	{
		$this->output->cache(0.1);
		$this->load->view('barang/barang_history_klinik');
	}

	public function obat_kadaluarsa_json()
	{
		$this->load->model('m_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_barang->fetch_data_barang_kadaluarsa($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['nama_barang'];
			$nestedData[]	= $row['tanggal_masuk'];
			$nestedData[]	= $row['tanggal_kadaluarsa'];
			$nestedData[]	= 'Akan Kadaluarsa';
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval($requestData['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}

	public function obat_sudah_kadaluarsa_json()
	{
		$this->load->model('m_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_barang->fetch_data_barang_sudah_kadaluarsa($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['nama_barang'];
			$nestedData[]	= $row['tanggal_masuk'];
			$nestedData[]	= $row['tanggal_kadaluarsa'];
			$nestedData[]	= 'Sudah Kadaluarsa';
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval($requestData['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}

	public function barang_json_klinik()
	{
		$this->load->model('m_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_barang->fetch_data_barang_klinik($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];/*
			$nestedData[]	= $row['kode_barang'];*//*
			$nestedData[]	= $row['tanggal_masuk'];*/
			$nestedData[]	= $row['nama_barang'];
			$nestedData[]	= $row['kategori'];
			$nestedData[]	= ($row['total_stok'] == 'Kosong') ? "<font color='red'><b>" . $row['total_stok'] . "</b></font>" : $row['total_stok'];
			$nestedData[]	= ($row['total_isi'] == 'Kosong') ? "<font color='red'><b>" . $row['total_isi'] . "</b></font>" : "<font color='red'><b>" . $row['total_isi'] . "</b></font>";
			$nestedData[]	= $row['satuan'];
			$nestedData[]	= $row['harga'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('barang/edit_rincian/' . $row['id_barang']) . "' id='EditBarang'><i class='fa fa-pencil'></i> EDIT STANDAR</a>";
				$nestedData[]	= "<a href='" . site_url('barang/edit/' . $row['id_barang']) . "' id='EditBarang'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='" . site_url('barang/hapus/' . $row['id_barang']) . "' id='HapusBarang'><i class='fa fa-trash-o'></i> Hapus</a>";
			}

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval($requestData['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}

	public function barang_json_history_klinik()
	{
		$this->load->model('m_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_barang->fetch_data_barang_history_klinik($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['kode_barang'];
			$nestedData[]	= $row['tanggal_masuk'];
			$nestedData[]	= $row['nama_barang'];
			$nestedData[]	= $row['kategori'];
			$nestedData[]	= ($row['total_stok'] == 'Kosong') ? "<font color='red'><b>" . $row['total_stok'] . "</b></font>" : $row['total_stok'];
			$nestedData[]	= $row['satuan'];
			$nestedData[]	= $row['harga'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			/*if($level == 'admin' OR $level == 'inventory')
			{
				$nestedData[]	= "<a href='".site_url('barang/edit/'.$row['id_barang'])."' id='EditBarang'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='".site_url('barang/hapus/'.$row['id_barang'])."' id='HapusBarang'><i class='fa fa-trash-o'></i> Hapus</a>";
			}*/

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval($requestData['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}

	public function barang_json_online()
	{
		$this->load->model('m_barang');
		$level 			= $this->session->userdata('ap_level');
		$requestData	= $_REQUEST;
		$fetch			= $this->m_barang->fetch_data_barang_online($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['kode_barang'];
			$nestedData[]	= $row['nama_barang'];
			$nestedData[]	= $row['kategori'];
			$nestedData[]	= ($row['total_stok'] == 'Kosong') ? "<font color='red'><b>" . $row['total_stok'] . "</b></font>" : $row['total_stok'];
			$nestedData[]	= $row['satuan'];
			$nestedData[]	= $row['harga'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['info_tambahan']);

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('barang/edit/' . $row['id_barang']) . "' id='EditBarang'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='" . site_url('barang/hapus/' . $row['id_barang']) . "' id='HapusBarang'><i class='fa fa-trash-o'></i> Hapus</a>";
			}

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval($requestData['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}

	public function barang_json_online_herbal()
	{
		$this->load->model('m_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_barang->fetch_data_barang_online_herbal($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['kode_barang'];
			$nestedData[]	= $row['nama_barang'];
			$nestedData[]	= $row['kategori'];
			$nestedData[]	= ($row['total_stok'] == 'Kosong') ? "<font color='red'><b>" . $row['total_stok'] . "</b></font>" : $row['total_stok'];
			$nestedData[]	= $row['satuan'];
			$nestedData[]	= $row['harga'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['info_tambahan']);

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('barang/edit/' . $row['id_barang']) . "' id='EditBarang'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='" . site_url('barang/hapus/' . $row['id_barang']) . "' id='HapusBarang'><i class='fa fa-trash-o'></i> Hapus</a>";
			}

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval($requestData['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}

	public function barang_json_online_kimia()
	{
		$this->load->model('m_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_barang->fetch_data_barang_online_kimia($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['kode_barang'];
			$nestedData[]	= $row['nama_barang'];
			$nestedData[]	= $row['kategori'];

			if ($row['satuan'] == 'STRIP') {
				$nestedData[]	= ($row['total_stok'] / $row['standar_strip']);
				$nestedData[]	= $row['total_stok'];
				$nestedData[]	= ($row['total_stok'] / $row['standar_strip']) * $row['standar_pcs'];
			} else if ($row['satuan'] == 'PCS') {
				$nestedData[]	= $row['total_stok'] / $row['standar_pcs'];
				$nestedData[]	= $row['total_stok'] / $row['standar_strip'];
				$nestedData[]	= $row['total_stok'];
			} else if ($row['satuan'] == 'SACHET') {
				$nestedData[]	= $row['total_stok'] / $row['standar_pcs'];
				$nestedData[]	= $row['total_stok'] / $row['standar_strip'];
				$nestedData[]	= $row['total_stok'];
			} else if ($row['satuan'] == 'DUS') {
				$nestedData[]	= $row['total_stok'];
				$nestedData[]	= $row['total_stok'] * $row['standar_strip'];
				$nestedData[]	= $row['total_stok'] * $row['standar_pcs'];
			} else if ($row['satuan'] == 'BOX') {
				$nestedData[]	= $row['total_stok'];
				$nestedData[]	= $row['total_stok'] * $row['standar_strip'];
				$nestedData[]	= $row['total_stok'] * $row['standar_pcs'];
			} else {
				$nestedData[]	= "0";
				$nestedData[]	= "0";
				$nestedData[]	= "0";
			}

			/*	$nestedData[]	= ($row['satuan'] == 'STRIP') ? $row['total_stok'] : $row['total_stok'] ;
			
			$nestedData[]	= ($row['total_stok'] / $row['standar_pcs']) * $row['standar_strip'] ;
			
			$nestedData[]	= ($row['total_stok'] == 'Kosong') ? "<font color='red'><b>".$row['total_stok']."</b></font>" : $row['total_stok'];*/

			$nestedData[]	= $row['satuan'];
			$nestedData[]	= $row['harga'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['info_tambahan']);

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('barang/lihat_kadaluarsa/' . $row['id_barang']) . "' id='DetailBarang'><i class='fa fa-eye' aria-hidden='true'></i> Detail</a>";
				$nestedData[]	= "<a href='" . site_url('barang/edit/' . $row['id_barang']) . "' id='EditBarang'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='" . site_url('barang/hapus/' . $row['id_barang']) . "' id='HapusBarang'><i class='fa fa-trash-o'></i> Hapus</a>";
			}

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval($requestData['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}

	public function lihat_kadaluarsa($id_barang)
	{
		if ($this->input->is_ajax_request()) {
			$this->load->model('m_barang');

			$dt['master'] = $this->m_barang->get_kadaluarsa($id_barang);

			$this->output->cache(0.1);
			$this->load->view('barang/barang_kadaluarsa_detail', $dt);
		}
	}

	public function barang_json_kimia_standar()
	{
		$this->load->model('m_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_barang->fetch_data_barang_kimia_standar($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['kode_barang'];
			$nestedData[]	= $row['nama_barang'];
			$nestedData[]	= $row['kategori'];
			$nestedData[]	= ($row['standar_strip'] == 'Kosong') ? "<font color='red'><b>" . $row['standar_strip'] . "</b></font>" : $row['standar_strip'];
			$nestedData[]	= ($row['standar_pcs'] == 'Kosong') ? "<font color='red'><b>" . $row['standar_pcs'] . "</b></font>" : $row['standar_pcs'];
			$nestedData[]	= $row['satuan'];/*
			$nestedData[]	= $row['harga'];*/

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('barang/edit_standar/' . $row['id_barang']) . "' id='EditBarang'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='" . site_url('barang/hapus_standar/' . $row['id_barang']) . "' id='HapusBarang'><i class='fa fa-trash-o'></i> Hapus</a>";
			}

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval($requestData['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}

	public function barang_json_history_stok_online()
	{
		$this->load->model('m_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_barang->fetch_data_barang_history_stok_online($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['nama_barang'];
			$nestedData[]	= $row['tanggal_masuk'];
			$nestedData[]	= $row['tanggal_kadaluarsa'];
			$nestedData[]	= ($row['total_stok'] == 'Kosong') ? "<font color='red'><b>" . $row['total_stok'] . "</b></font>" : $row['total_stok'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval($requestData['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}

	public function barang_json_history_online()
	{
		$this->load->model('m_barang');
		$level 			= $this->session->userdata('ap_level');
		// cekdb();

		$requestData	= $_REQUEST;
		$fetch			= $this->m_barang->fetch_data_barang_history_online($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['id_barang'];
			$nestedData[]	= $row['nama_barang'];
			$nestedData[]	= $row['tanggal_masuk'];
			$nestedData[]	= $row['kategori'];
			$nestedData[]	= ($row['total_stok'] == 'Kosong') ? "<font color='red'><b>" . $row['total_stok'] . "</b></font>" : $row['total_stok'];
			$nestedData[]	= $row['satuan'];
			$nestedData[]	= $row['harga'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('barang/edit_historis_barang/' . $row['id']) . "' id='Edit_historis_Barang'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='" . site_url('barang/hapus_historis_barang/' . $row['id']) . "' id='Hapus_historis_Barang'><i class='fa fa-trash-o'></i> Hapus</a>";
			}

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval($requestData['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}

	public function barang_json()
	{
		$this->load->model('m_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_barang->fetch_data_barang($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['kode_barang'];
			$nestedData[]	= $row['nama_barang'];
			$nestedData[]	= $row['kategori'];
			$nestedData[]	= ($row['total_stok'] == 'Kosong') ? "<font color='red'><b>" . $row['total_stok'] . "</b></font>" : $row['total_stok'];
			$nestedData[]	= $row['satuan'];
			$nestedData[]	= $row['harga'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('barang/edit/' . $row['id_barang']) . "' id='EditBarang'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='" . site_url('barang/hapus/' . $row['id_barang']) . "' id='HapusBarang'><i class='fa fa-trash-o'></i> Hapus</a>";
			}

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval($requestData['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}

	public function hapus($id_barang)
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($this->input->is_ajax_request()) {
				$this->load->model('m_barang');
				$hapus = $this->m_barang->hapus_barang($id_barang);
				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Data berhasil dihapus !</font>
					"
					));
				} else {
					echo json_encode(array(
						"pesan" => "<font color='red'><i class='fa fa-warning'></i> Terjadi kesalahan, coba lagi !</font>
					"
					));
				}
			}
		}
	}

	public function hapus_standar($id_barang)
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($this->input->is_ajax_request()) {
				$this->load->model('m_barang');
				$hapus = $this->m_barang->hapus_barang_standar($id_barang);
				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Data berhasil dihapus !</font>
					"
					));
				} else {
					echo json_encode(array(
						"pesan" => "<font color='red'><i class='fa fa-warning'></i> Terjadi kesalahan, coba lagi !</font>
					"
					));
				}
			}
		}
	}

	public function tambah()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($_POST) {
				$this->load->library('form_validation');

				$no = 0;
				foreach ($_POST['kode'] as $kode) {/*
					$this->form_validation->set_rules('kode['.$no.']','Kode Barang #'.($no + 1),'trim|required|alpha_numeric|max_length[40]|callback_exist_kode[kode['.$no.']]');*/
					$this->form_validation->set_rules('nama[' . $no . ']', 'Nama Barang #' . ($no + 1), 'trim|required|max_length[60]|alpha_numeric_spaces');
					$this->form_validation->set_rules('id_kategori_barang[' . $no . ']', 'Kategori #' . ($no + 1), 'trim|required');
					$this->form_validation->set_rules('satuan[' . $no . ']', 'Satuan #' . ($no + 1), 'trim|required');
					$this->form_validation->set_rules('stok[' . $no . ']', 'Stok #' . ($no + 1), 'trim|required|numeric|max_length[10]|callback_cek_titik[stok[' . $no . ']]');
					$this->form_validation->set_rules('harga[' . $no . ']', 'Harga #' . ($no + 1), 'trim|required|numeric|min_length[1]|max_length[10]|callback_cek_titik[harga[' . $no . ']]');
					$this->form_validation->set_rules('keterangan[' . $no . ']', 'Keterangan #' . ($no + 1), 'trim|max_length[2000]');
					$no++;
				}

				$this->form_validation->set_message('required', '%s harus diisi !');
				$this->form_validation->set_message('numeric', '%s harus angka !');
				$this->form_validation->set_message('exist_kode', '%s sudah ada di database, pilih kode lain yang unik !');
				$this->form_validation->set_message('cek_titik', '%s harus angka, tidak boleh ada titik !');
				$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');
				$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');
				if ($this->form_validation->run() == TRUE) {
					$this->load->model('m_barang');

					$kd_barang		= "br" . time();

					$no_array = 0;
					$inserted = 0;
					foreach ($_POST['kode'] as $k) {
						$kode 				= $_POST['kode'][$no_array];
						$kd_barang2 		= $kd_barang;
						$nama 				= $_POST['nama'][$no_array];/*
						$kode_barang2		= $id_obat;*/
						$id_kategori_barang	= $_POST['id_kategori_barang'][$no_array];
						$satuan 			= $_POST['satuan'][$no_array];
						$stok 				= $_POST['stok'][$no_array];
						$harga 				= $_POST['harga'][$no_array];
						$id_kasir 			= $_POST['id_kasir'][$no_array];
						$keterangan 		= $this->clean_tag_input($_POST['keterangan'][$no_array]);

						$insert2 = $this->m_barang->barangonline($kode)->row();

						if ($kode == $insert2->kode_barang) {
							$insert = $this->m_barang->tambah_baru_online2($kode, $kd_barang2, $nama, $id_kategori_barang, $satuan, $stok, $harga, $keterangan, $id_kasir);
							$this->m_barang->update_stok_online($kode, $stok);

							if ($insert) {
								$inserted++;
							}
							$no_array++;
						} else {
							$insert = $this->m_barang->tambah_baru_online($kode, $kd_barang2, $nama, $id_kategori_barang, $satuan, $stok, $harga, $keterangan);
							$insert = $this->m_barang->tambah_baru_online2($kode, $kd_barang2, $nama, $id_kategori_barang, $satuan, $stok, $harga, $keterangan, $id_kasir);

							if ($insert) {
								$inserted++;
							}
							$no_array++;
						}
					}

					if ($inserted > 0) {
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<i class='fa fa-check' style='color:green;'></i> Data barang berhasil dismpan."
						));
					} else {
						$this->query_error("Oops, terjadi kesalahan, coba lagi !");
					}
				} else {
					$this->input_error();
				}
			} else {
				$this->load->model('m_kategori_barang');
				$this->load->model('m_merk_barang');
				$this->load->model('m_user');

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['kategori'] = $this->m_kategori_barang->get_all();
				$dt['satuan'] = $this->m_kategori_barang->get_all_satuan();
				$dt['merek'] 	= $this->m_merk_barang->get_all();
				$this->output->cache(0.1);
				$this->load->view('barang/barang_tambah', $dt);
			}
		} else {
			exit();
		}
	}

	public function tambah_klinik()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($_POST) {
				$this->load->library('form_validation');

				$no = 0;
				foreach ($_POST['kode'] as $kode) {
					$this->form_validation->set_rules('kode[' . $no . ']', 'Kode Barang #' . ($no + 1), 'trim|required|alpha_numeric|max_length[40]|callback_exist_kode[kode[' . $no . ']]');
					$this->form_validation->set_rules('nama[' . $no . ']', 'Nama Barang #' . ($no + 1), 'trim|required|max_length[60]|alpha_numeric_spaces');
					$this->form_validation->set_rules('id_kategori_barang[' . $no . ']', 'Kategori #' . ($no + 1), 'trim|required');
					$this->form_validation->set_rules('stok[' . $no . ']', 'Stok #' . ($no + 1), 'trim|required|numeric|max_length[10]|callback_cek_titik[stok[' . $no . ']]');
					$this->form_validation->set_rules('harga[' . $no . ']', 'Harga #' . ($no + 1), 'trim|required|numeric|min_length[1]|max_length[10]|callback_cek_titik[harga[' . $no . ']]');
					$this->form_validation->set_rules('keterangan[' . $no . ']', 'Keterangan #' . ($no + 1), 'trim|max_length[2000]');
					$no++;
				}

				$this->form_validation->set_message('required', '%s harus diisi !');
				$this->form_validation->set_message('numeric', '%s harus angka !');
				$this->form_validation->set_message('exist_kode', '%s sudah ada di database, pilih kode lain yang unik !');
				$this->form_validation->set_message('cek_titik', '%s harus angka, tidak boleh ada titik !');
				$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');
				$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

				if ($this->form_validation->run() == TRUE) {
					$this->load->model('m_barang');

					/*$id_obat ='';
			        $data['id_obat'] = $this->m_barang->ambilkodeobat();
			        if(empty($data['id_obat'])){
			            $id_obat='0001';
			        }
			        else{
			            $kd_akhir='';
			            foreach ($data['id_obat'] as $kode) {
			                $kd_akhir = $kode->kode_barang;
			            }
			            $urutan = substr($kd_akhir,3);
			            $int = (int)$urutan;
			            $next = $int+1;
			            $strlen = strlen($next);
			            $nol='';
			            for ($i=1; $i <= 4 - $strlen; $i++) { 
			                $nol=$nol.'0';
			            }
			            $id_obat =$nol.$next;
        			}*/

					$no_array = 0;
					$inserted = 0;
					foreach ($_POST['kode'] as $k) {
						$kode 				= $_POST['kode'][$no_array];
						$nama 				= $_POST['nama'][$no_array];
						$id_kategori_barang	= $_POST['id_kategori_barang'][$no_array];
						$satuan 			= $_POST['satuan_obat'][$no_array];
						$stok 				= $_POST['stok'][$no_array];
						$harga 				= $_POST['harga'][$no_array];
						$keterangan 		= $this->clean_tag_input($_POST['keterangan'][$no_array]);
						$id_kasir 			= $_POST['id_kasir'][$no_array];
						/*
           				$id_barang 			= $this->db->get_where('pj_barang',array('kd_barang' =>$kode))->row_array();*/

						$kde_barang 		= $this->m_barang->ambilbarangonline($kode)->row();

						$insert2	 		= $this->m_barang->ambilbarangklinik($kode)->row();

						$kode_barang2		= $kde_barang->kode_barang;
						$id_barang		    = $kde_barang->id_barang;



						if ($kode_barang2 == $insert2->kode_barang) {
							$insert = $this->m_barang->tambah_baru_history($kode, $kode_barang2, $nama, $id_kategori_barang, $satuan, $stok, $harga, $keterangan, $id_kasir);

							$this->m_barang->update_stok_klinik($kode, $stok);

							if ($insert) {
								$inserted++;
								$this->m_barang->update_stok2($id_barang, $stok);
							}
							$no_array++;
						} else {
							$insert = $this->m_barang->tambah_baru($kode, $kode_barang2, $nama, $id_kategori_barang, $satuan, $stok, $harga, $keterangan);
							$insert = $this->m_barang->tambah_baru_history($kode, $kode_barang2, $nama, $id_kategori_barang, $satuan, $stok, $harga, $keterangan, $id_kasir);

							if ($insert) {
								$inserted++;
								$this->m_barang->update_stok2($id_barang, $stok);
							}
							$no_array++;
						}
					}

					if ($inserted > 0) {
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<i class='fa fa-check' style='color:green;'></i> Data barang berhasil dismpan."
						));
					} else {
						$this->query_error("Oops, terjadi kesalahan, coba lagi !");
					}
				} else {
					$this->input_error();
				}
			} else {
				$this->load->model('m_kategori_barang');
				$this->load->model('m_barang');
				$this->load->model('m_user');

				$dt['kasirnya'] = $this->m_user->list_kasir();

				$dt['barang'] 	= $this->m_barang->get_baris_kode($kode);
				$dt['kategori'] = $this->m_kategori_barang->get_all();
				$dt['obat'] = $this->m_kategori_barang->get_all_barang_herbal_online();
				$this->output->cache(0.1);
				$this->load->view('barang/barang_tambah_klinik', $dt);
			}
		} else {
			exit();
		}
	}

	public function tambah_klinik_Kimia()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($_POST) {
				$kd_barang 	            = $this->input->post('kd_barang');
				$nama_barang 	        = $this->input->post('nama_barang');
				$id_kategori_barang   	= $this->input->post('id_kategori_barang');
				$stok   	            = $this->input->post('stok');
				$satuan   	            = $this->input->post('satuan');
				$harga   	            = $this->input->post('harga');
				$keterangan   	        = $this->input->post('keterangan');
				$id_kasir   	        = $this->input->post('id_kasir');

				$this->load->model('m_barang');

				$kde_barang 		= $this->m_barang->ambilbarangonline($kd_barang)->row();
				$insert2	 		= $this->m_barang->ambilbarangklinik($kd_barang)->row();
				$kode_barang2		= $kde_barang->kode_barang;
				$id_barang		    = $kde_barang->id_barang;

				if ($kode_barang2 == $insert2->kode_barang) {
					$insert = $this->m_barang->tambah_baru_history($kd_barang, $kode_barang2, $nama_barang, $id_kategori_barang, $satuan, $stok, $harga, $keterangan, $id_kasir);
					$this->m_barang->update_stok_klinik($kd_barang, $stok);

					if ($insert) {
						$inserted++;
						$this->m_barang->update_stok2($id_barang, $stok);
					}
					$no_array++;
				} else {
					$insert = $this->m_barang->tambah_baru($kd_barang, $kode_barang2, $nama_barang, $id_kategori_barang, $satuan, $stok, $harga, $keterangan);
					$insert = $this->m_barang->tambah_baru_history($kd_barang, $kode_barang2, $nama_barang, $id_kategori_barang, $satuan, $stok, $harga, $keterangan, $id_kasir);

					if ($insert) {
						$inserted++;
						$this->m_barang->update_stok2($id_barang, $stok);
					}
					$no_array++;
				}

				if ($inserted > 0) {
					echo json_encode(array(
						'status' => 1,
						'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>" . $nama_barang . "</b> berhasil di Update Stoknya.</div>",
					));
				} else {
					$this->query_error("Oops, terjadi kesalahan <b>" . $id_barang . "</b>, coba lagi !");
				}
			} else {   /*
			    $cek_id = $this->m_penjualan_master->cek_id_pelanggan_validasi($id_pelanggan);*/

				$this->load->model('m_kategori_barang');
				$this->load->model('m_user');

				$dt['kasirnya'] = $this->m_user->list_kasir();

				$dt['obat'] = $this->m_kategori_barang->get_all_barang_kimia();
				$this->load->view('barang/tambah_klinik_Kimia', $dt);
			}
		}
	}

	public function tambah_klinik_baru()
	{

		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($_POST) {
				$this->load->library('form_validation');

				$no = 0;
				foreach ($_POST as $kode) {
					$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'trim|required|alpha_numeric|max_length[40]');
					$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required|max_length[60]');
					$this->form_validation->set_rules('id_kategori_barang', 'Kategori ', 'trim|required');
					/*$this->form_validation->set_rules('harga_beli','Harga','trim|required|numeric|min_length[4]|max_length[10]');*/
				}

				$this->form_validation->set_message('required', '%s harus diisi !');
				$this->form_validation->set_message('numeric', '%s harus angka !');
				$this->form_validation->set_message('exist_kode', '%s sudah ada di database, pilih kode lain yang unik !');
				$this->form_validation->set_message('cek_titik', '%s harus angka, tidak boleh ada titik !');
				$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');
				$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

				if ($this->form_validation->run() == TRUE) {
					$this->load->model('m_barang');

					$kode_barang            = $this->input->post('kode_barang');
					$kd_barang 				= $this->input->post('kd_barang');
					$nama_barang 	        = $this->input->post('nama_barang');
					$id_kategori_barang   	= $this->input->post('id_kategori_barang');
					$total_stok 			= $this->input->post('total_stok');
					$satuan   	            = $this->input->post('satuan');
					$harga   	            = $this->input->post('harga');



					$insert = $this->m_barang->tambah_klinik_baru($kode_barang, $kd_barang, $nama_barang, $id_kategori_barang, $total_stok, $satuan, $harga);

					if ($insert > 0) {
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<i class='fa fa-check' style='color:green;'></i> Data barang berhasil dismpan."
						));
					} else {
						$this->query_error("Oops, terjadi kesalahan, coba lagi !");
					}
				} else {
					$this->input_error();
				}
			} else {
				$this->load->model('m_kategori_barang');

				$dt['kategori'] = $this->m_kategori_barang->get_all();
				$dt['satuan'] = $this->m_kategori_barang->get_all_satuan();
				$this->load->view('barang/tambah_klinik_baru', $dt);
			}
		} else {
			exit();
		}
	}

	public function update_stok_online()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($_POST) {
				$id_barang 	    = $this->input->post('id_barang');
				$nama_barang 	= $this->input->post('nama_barang');
				$stok   	    = $this->input->post('stok');
				$satuan   	    = $this->input->post('satuan');
				$id_kasir   	= $this->input->post('id_kasir');

				$this->load->model('m_barang');
				$udpate = $this->m_barang->update_stok_online_tambah($id_barang, $stok);
				$insert = $this->m_barang->tambah_history_stok_online_herbal($id_barang, $nama_barang, $stok, $satuan, $id_kasir);

				if ($udpate) {
					echo json_encode(array(
						'status' => 1,
						'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>" . $nama_barang . "</b> berhasil di Update Stoknya.</div>",
					));
				} else {
					$this->query_error("Oops," . $nama_barang . " " . $satuan . " " . $stok . " " . $id_kasir . " terjadi kesalahan, coba lagi !");
				}
			} else {   /*
			    $cek_id = $this->m_penjualan_master->cek_id_pelanggan_validasi($id_pelanggan);*/

				$this->load->model('m_kategori_barang');
				$this->load->model('m_user');

				$dt['kasirnya'] = $this->m_user->list_kasir();

				$dt['kategori'] = $this->m_kategori_barang->get_all();
				$dt['obat'] = $this->m_kategori_barang->get_all_barang();
				$this->load->view('barang/update_stok_barang', $dt);
			}
		}
	}

	public function update_stok_online_kimia()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($_POST) {
				$id_barang 	        = $this->input->post('id_barang');
				$nama_barang 	    = $this->input->post('nama_barang');
				$stok   	        = $this->input->post('stok');
				$date   	        = $this->input->post('date');
				$satuan   	        = $this->input->post('satuan');
				$total_stok_strip   = $this->input->post('total_stok_strip');
				$total_stok_pcs     = $this->input->post('total_stok_pcs');
				$id_kasir   	= $this->input->post('id_kasir');
				// cekvar($satuan);
				$this->load->model('m_barang');

				if ($satuan == 'PCS') {
					$this->m_barang->update_stok_online_kimia_tambah_pcs($id_barang, $total_stok_pcs, $date);
					$this->m_barang->tambah_history_stok_online($id_barang, $nama_barang, $stok, $satuan, $date, $id_kasir);
					echo json_encode(array(
						'status' => 1,
						'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>" . $nama_barang . "</b> berhasil di Update <b>" . $total_stok_pcs . " PCS</b>.</div>",
					));
				} else if ($satuan == 'STRIP') {
					$udpate_strip = $this->m_barang->update_stok_online_kimia_tambah_strip($id_barang, $total_stok_strip, $date);
					$insert_strip = $this->m_barang->tambah_history_stok_online($id_barang, $nama_barang, $stok, $satuan, $date, $id_kasir);

					echo json_encode(array(
						'status' => 1,
						'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>" . $nama_barang . "</b> berhasil di Update <b>" . $total_stok_strip . " STRIP</b> .</div>",
					));
				} else if ($satuan == 'SACHET') {
					$udpate_pcs = $this->m_barang->update_stok_online_kimia_tambah_pcs($id_barang, $total_stok_pcs, $date);
					$insert_pcs = $this->m_barang->tambah_history_stok_online($id_barang, $nama_barang, $stok, $satuan, $date, $id_kasir);

					echo json_encode(array(
						'status' => 1,
						'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>" . $nama_barang . "</b> berhasil di Update <b>" . $total_stok_pcs . " STRIP</b> .</div>",
					));
				} else {
					$this->query_error("Oops, terjadi kesalahan, coba lagi !");
				}
			} else {   /*
			    $cek_id = $this->m_penjualan_master->cek_id_pelanggan_validasi($id_pelanggan);*/

				$this->load->model('m_kategori_barang');
				$this->load->model('m_user');

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['kategori'] = $this->m_kategori_barang->get_all();
				$dt['obat'] = $this->m_kategori_barang->get_all_barang_standar2();
				$this->load->view('barang/update_stok_barang_kimia', $dt);
			}
		}
	}

	public function tambah_kadaluarsa_online_kimia()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($_POST) {
				$id_barang 	        = $this->input->post('id_barang');
				$nama_barang 	    = $this->input->post('nama_barang');
				$stok   	        = $this->input->post('stok');
				$date   	        = $this->input->post('date');
				$satuan   	        = $this->input->post('satuan');

				$this->load->model('m_barang');

				$insert_pcs = $this->m_barang->tambah_history_stok_online($id_barang, $nama_barang, $stok, $satuan, $date);

				if ($insert_pcs) {
					echo json_encode(array(
						'status' => 1,
						'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>" . $nama_barang . "</b> berhasil di Update</div>",
					));
				} else {
					$this->query_error("Oops, terjadi kesalahan, coba lagi !");
				}
			} else {   /*
			    $cek_id = $this->m_penjualan_master->cek_id_pelanggan_validasi($id_pelanggan);*/

				$this->load->model('m_kategori_barang');

				$dt['kategori'] = $this->m_kategori_barang->get_all();
				$dt['obat'] = $this->m_kategori_barang->get_all_barang_standar2();
				$this->load->view('barang/tambah_kadaluarsa_kimia', $dt);
			}
		}
	}

	public function tambah_standar()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($_POST) {
				$id_barang 	        = $this->input->post('id_barang');
				$kd_barang   	    = $this->input->post('kd_barang');
				$kode_barang 	    = $this->input->post('kode_barang');
				$nama_barang 	    = $this->input->post('nama_barang');
				$harga   	        = $this->input->post('harga');
				$satuan   	        = $this->input->post('satuan');
				$standar_strip      = $this->input->post('standar_strip');
				$standar_pcs        = $this->input->post('standar_pcs');

				$this->load->model('m_penjualan_master');
				$cek = $this->m_penjualan_master->cek_id_barang_standar_validasi($id_barang)->row();


				if ($id_barang == $cek->id_barang) {
					echo json_encode(array(
						'status' => 1,
						'pesan' => "<div class='alert alert-danger'><i class='fa fa-check'></i> <b>" . $nama_barang . "</b> sudah ada di data standar obat Kimia.</div>",
					));
				} else {
					$this->load->model('m_barang');
					$insert = $this->m_barang->tambah_standar_obat_kimia($id_barang, $kd_barang, $kode_barang, $nama_barang, $standar_strip, $standar_pcs, $harga, $satuan);

					if ($insert) {
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>" . $nama_barang . "</b> Berhasil ditambahkan.</div>",
						));
					} else {
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-danger'><i class='fa fa-check'></i> Maaf Terjadi Kesalahan .</div>",
						));
					}
				}
			} else {   /*
			    $cek_id = $this->m_penjualan_master->cek_id_pelanggan_validasi($id_pelanggan);*/

				$this->load->model('m_kategori_barang');

				$dt['kategori'] = $this->m_kategori_barang->get_all();
				$dt['obat'] = $this->m_kategori_barang->get_all_barang_kimia();
				$this->load->view('barang/tambah_standar_kimia', $dt);
			}
		}
	}

	public function ajax_tambah_barang_online_kimia()
	{
		if ($this->input->is_ajax_request()) {
			$kd_barang = $this->input->post('kd_barang');
			$this->load->model('m_kategori_barang');

			$data = $this->m_kategori_barang->get_baris_update_barang_online_kimia($kd_barang)->row();
			$json['stok']			= (!empty($data->total_stok)) ? $data->total_stok : "0";
			$json['nama_barang']		    = $data->nama_barang;
			$json['satuan']		            = $data->satuan;
			$json['kategori']		        = $data->kategori;
			$json['id_kategori_barang']		= $data->id_kategori_barang;
			$json['harga']			= (!empty($data->harga)) ? $data->harga : "0";
			$json['keterangan']		        = $data->keterangan;
			echo json_encode($json);
		}
	}

	public function ajax_barang_online()
	{
		if ($this->input->is_ajax_request()) {
			$id_barang = $this->input->post('id_barang');
			$this->load->model('m_kategori_barang');

			$data = $this->m_kategori_barang->get_baris_barang_online($id_barang)->row();
			$json['stok']			= (!empty($data->total_stok)) ? $data->total_stok : "0";
			$json['nama_barang']		= $data->nama_barang;
			$json['satuan']		    = $data->satuan;
			echo json_encode($json);
		}
	}

	public function ajax_barang_online_kimia_standar()
	{
		if ($this->input->is_ajax_request()) {
			$id_barang = $this->input->post('id_barang');
			$this->load->model('m_kategori_barang');

			$data = $this->m_kategori_barang->get_baris_barang_online_kimia_standar($id_barang)->row();
			$json['standar_strip']			= (!empty($data->standar_strip)) ? $data->standar_strip : "0";
			$json['standar_pcs']			= (!empty($data->standar_pcs)) ? $data->standar_pcs : "0";
			$json['nama_barang']	= $data->nama_barang;
			$json['satuan']		    = $data->satuan;
			$json['harga']		    = $data->harga;
			echo json_encode($json);
		}
	}

	public function ajax_barang_online_kimia()
	{
		if ($this->input->is_ajax_request()) {
			$id_barang = $this->input->post('id_barang');
			$this->load->model('m_kategori_barang');

			$data = $this->m_kategori_barang->get_baris_barang_online_kimia($id_barang)->row();
			$json['kd_barang']	    = $data->kd_barang;
			$json['kode_barang']	= $data->kode_barang;
			$json['nama_barang']	= $data->nama_barang;
			$json['satuan']		    = $data->satuan;
			$json['harga']		    = $data->harga;
			echo json_encode($json);
		}
	}

	public function ajax_cek_kode()
	{
		if ($this->input->is_ajax_request()) {
			$kode = $this->input->post('kodenya');
			$this->load->model('m_barang');

			$cek_kode = $this->m_barang->cek_kode($kode);
			if ($cek_kode->num_rows() > 0) {
				echo json_encode(array(
					'status' => 0,
					'pesan' => "<font color='red'>Kode sudah ada</font>"
				));
			} else {
				echo json_encode(array(
					'status' => 1,
					'pesan' => ''
				));
			}
		}
	}
	public function ajax_barang1()
	{
		if ($this->input->is_ajax_request()) {
			$id_barang = $this->input->post('kode_barang');
			$this->load->model('m_barang');

			$data = $this->m_barang->get_baris2($id_barang)->row();
			$json['nama_barang']			= (!empty($data->nama_barang)) ? $data->nama_barang : "<small><i>Tidak ada</i></small>";
			$json['id_kategori_barang']		= (!empty($data->id_kategori_barang)) ? $data->id_kategori_barang : "<small><i>Tidak ada</i></small>";
			$json['kategori']		= (!empty($data->kategori)) ? $data->kategori : "<small><i>Tidak ada</i></small>";
			$json['total_stok']				= (!empty($data->total_stok)) ? $data->total_stok : "0";
			$json['harga']					= (!empty($data->harga)) ? $data->harga : "0";
			$json['satuan']					= (!empty($data->satuan)) ? $data->satuan : "<small><i>Tidak ada</i></small>";
			echo json_encode($json);
		}
	}

	public function exist_kode($kode)
	{
		$this->load->model('m_barang');
		$cek_kode = $this->m_barang->cek_kode($kode);

		if ($cek_kode->num_rows() > 0) {
			return FALSE;
		}
		return TRUE;
	}

	public function cek_titik($angka)
	{
		$pecah = explode('.', $angka);
		if (count($pecah) > 1) {
			return FALSE;
		}
		return TRUE;
	}

	public function edit($id_barang = NULL)
	{
		if (!empty($id_barang)) {
			$level = $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'inventory') {
				if ($this->input->is_ajax_request()) {
					$this->load->model('m_barang');

					if ($_POST) {
						$this->load->library('form_validation');

						$kode_barang 		= $this->input->post('kode_barang');
						$kode_barang_old	= $this->input->post('kode_barang_old');

						$callback			= '';
						if ($kode_barang !== $kode_barang_old) {
							$callback = "|callback_exist_kode[kode_barang]";
						}

						$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'trim|required|alpha_numeric|max_length[40]' . $callback);
						$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required|max_length[60]');
						$this->form_validation->set_rules('id_kategori_barang', 'Kategori', 'trim|required');
						$this->form_validation->set_rules('satuan', 'Satuan', 'trim|required');
						$this->form_validation->set_rules('total_stok', 'Stok', 'trim|required|numeric|max_length[10]|callback_cek_titik[total_stok]');
						$this->form_validation->set_rules('harga', 'Harga', 'trim|required|numeric|min_length[1]|max_length[10]|callback_cek_titik[harga]');
						$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|max_length[2000]');

						$this->form_validation->set_message('required', '%s harus diisi !');
						$this->form_validation->set_message('numeric', '%s harus angka !');
						$this->form_validation->set_message('exist_kode', '%s sudah ada di database, pilih kode lain yang unik !');
						$this->form_validation->set_message('cek_titik', '%s harus angka, tidak boleh ada titik !');
						$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nama 				= $this->input->post('nama_barang');
							$id_kategori_barang	= $this->input->post('id_kategori_barang');
							$stok 				= $this->input->post('total_stok');
							$satuan				= $this->input->post('satuan');
							$harga 				= $this->input->post('harga');
							$keterangan 		= $this->input->post('keterangan');
							$info_tambahan 		= $this->clean_tag_input($this->input->post('info_tambahan'));

							$update = $this->m_barang->update_barang($id_barang, $kode_barang, $nama, $id_kategori_barang, $stok, $satuan, $harga, $keterangan, $info_tambahan);
							if ($update) {
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data barang berhasil diupdate.</div>"
								));
							} else {
								$this->query_error();
							}
						} else {
							$this->input_error();
						}
					} else {
						$this->load->model('m_kategori_barang');
						$this->load->model('m_merk_barang');

						$dt['barang'] 	= $this->m_barang->get_baris($id_barang)->row();
						$dt['kategori'] = $this->m_kategori_barang->get_all();
						$dt['satuan'] = $this->m_kategori_barang->get_all_satuan();
						$this->output->cache(0.1);
						$this->load->view('barang/barang_edit', $dt);
					}
				}
			}
		}
	}

	public function edit_rincian($id_barang = NULL)
	{
		if (!empty($id_barang)) {
			$level = $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'inventory') {
				if ($this->input->is_ajax_request()) {
					$this->load->model('m_barang');

					if ($_POST) {
						$this->load->library('form_validation');

						$kode_barang 		= $this->input->post('kode_barang');
						$kode_barang_old	= $this->input->post('kode_barang_old');

						$callback			= '';
						if ($kode_barang !== $kode_barang_old) {
							$callback = "|callback_exist_kode[kode_barang]";
						}

						$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'trim|required|alpha_numeric|max_length[40]' . $callback);
						$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required|max_length[60]|alpha_numeric_spaces');
						$this->form_validation->set_rules('id_kategori_barang', 'Kategori', 'trim|required');
						$this->form_validation->set_rules('satuan', 'Satuan', 'trim|required');/*
						$this->form_validation->set_rules('total_isi','Isi Standar','trim|required|numeric|max_length[10]|callback_cek_titik[total_stok]');*/
						$this->form_validation->set_rules('harga', 'Harga', 'trim|required|numeric|min_length[1]|max_length[10]|callback_cek_titik[harga]');
						$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|max_length[2000]');

						$this->form_validation->set_message('required', '%s harus diisi !');
						$this->form_validation->set_message('numeric', '%s harus angka !');
						$this->form_validation->set_message('exist_kode', '%s sudah ada di database, pilih kode lain yang unik !');
						$this->form_validation->set_message('cek_titik', '%s harus angka, tidak boleh ada titik !');
						$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nama 				= $this->input->post('nama_barang');
							$id_kategori_barang	= $this->input->post('id_kategori_barang');
							$total_isi 			= $this->input->post('total_isi');
							$satuan				= $this->input->post('satuan');
							$harga 				= $this->input->post('harga');
							$keterangan 		= $this->input->post('keterangan');
							$info_tambahan 		= $this->clean_tag_input($this->input->post('info_tambahan'));

							$update = $this->m_barang->update_barang_rincian($id_barang, $kode_barang, $nama, $id_kategori_barang, $total_isi, $satuan, $harga, $keterangan, $info_tambahan);
							if ($update) {
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data barang berhasil diupdate.</div>"
								));
							} else {
								$this->query_error();
							}
						} else {
							$this->input_error();
						}
					} else {
						$this->load->model('m_kategori_barang');
						$this->load->model('m_merk_barang');

						$dt['barang'] 	= $this->m_barang->get_baris($id_barang)->row();
						$dt['kategori'] = $this->m_kategori_barang->get_all();
						$dt['satuan'] = $this->m_kategori_barang->get_all_satuan();
						$this->output->cache(0.1);
						$this->load->view('barang/barang_edit_rincian', $dt);
					}
				}
			}
		}
	}

	public function edit_standar($id_barang = NULL)
	{
		if (!empty($id_barang)) {
			$level = $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'inventory') {
				if ($this->input->is_ajax_request()) {
					$this->load->model('m_barang');

					if ($_POST) {
						$this->load->library('form_validation');

						$kode_barang 	= $this->input->post('kode_barang');
						$id_barang	    = $this->input->post('id_barang');

						$this->form_validation->set_rules('kode_barang', 'Kode Barang', 'trim|required|alpha_numeric|max_length[40]' . $callback);
						$this->form_validation->set_rules('nama_barang', 'Nama Barang', 'trim|required|max_length[60]|alpha_numeric_spaces');
						$this->form_validation->set_rules('id_kategori_barang', 'Kategori', 'trim|required');
						$this->form_validation->set_rules('satuan', 'Satuan', 'trim|required');

						$this->form_validation->set_rules('standar_strip', 'Standar strip', 'trim|required');
						$this->form_validation->set_rules('standar_pcs', 'Standar pcs', 'trim|required');

						$this->form_validation->set_rules('keterangan', 'Keterangan', 'trim|max_length[2000]');

						$this->form_validation->set_message('required', '%s harus diisi !');
						$this->form_validation->set_message('numeric', '%s harus angka !');
						$this->form_validation->set_message('exist_kode', '%s sudah ada di database, pilih kode lain yang unik !');
						$this->form_validation->set_message('cek_titik', '%s harus angka, tidak boleh ada titik !');
						$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nama 				= $this->input->post('nama_barang');
							$standar_pcs 		= $this->input->post('standar_pcs');
							$standar_strip 		= $this->input->post('standar_strip');

							$update = $this->m_barang->update_barang_standar($id_barang, $standar_pcs, $standar_strip);

							if ($update) {
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data barang berhasil diupdate.</div>"
								));
							} else {
								$this->query_error();
							}
						} else {
							$this->input_error();
						}
					} else {
						$this->load->model('m_kategori_barang');
						$this->load->model('m_merk_barang');

						$dt['barang'] 	= $this->m_barang->get_baris_standar($id_barang)->row();
						$dt['kategori'] = $this->m_kategori_barang->get_all();
						$dt['satuan'] = $this->m_kategori_barang->get_all_satuan();
						$this->load->view('barang/barang_edit_standar', $dt);
					}
				}
			}
		}
	}

	public function list_merek()
	{
		$this->load->view('barang/merek/merek_data');
	}

	public function list_merek_json()
	{
		$this->load->model('m_merk_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_merk_barang->fetch_data_merek($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['merk'];

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('barang/edit-merek/' . $row['id_merk_barang']) . "' id='EditMerek'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='" . site_url('barang/hapus-merek/' . $row['id_merk_barang']) . "' id='HapusMerek'><i class='fa fa-trash-o'></i> Hapus</a>";
			}

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval($requestData['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}

	public function tambah_merek()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($_POST) {
				$this->load->library('form_validation');
				$this->form_validation->set_rules('merek', 'Merek', 'trim|required|max_length[40]|alpha_numeric_spaces');
				$this->form_validation->set_message('required', '%s harus diisi !');
				$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

				if ($this->form_validation->run() == TRUE) {
					$this->load->model('m_merk_barang');
					$merek 	= $this->input->post('merek');
					$insert = $this->m_merk_barang->tambah_merek($merek);
					if ($insert) {
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>" . $merek . "</b> berhasil ditambahkan.</div>"
						));
					} else {
						$this->query_error();
					}
				} else {
					$this->input_error();
				}
			} else {
				$this->load->view('barang/merek/merek_tambah');
			}
		}
	}

	public function hapus_merek($id_merk_barang)
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($this->input->is_ajax_request()) {
				$this->load->model('m_merk_barang');
				$hapus = $this->m_merk_barang->hapus_merek($id_merk_barang);
				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Data berhasil dihapus !</font>
					"
					));
				} else {
					echo json_encode(array(
						"pesan" => "<font color='red'><i class='fa fa-warning'></i> Terjadi kesalahan, coba lagi !</font>
					"
					));
				}
			}
		}
	}

	public function edit_merek($id_merk_barang = NULL)
	{
		if (!empty($id_merk_barang)) {
			$level = $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'inventory') {
				if ($this->input->is_ajax_request()) {
					$this->load->model('m_merk_barang');

					if ($_POST) {
						$this->load->library('form_validation');
						$this->form_validation->set_rules('merek', 'Merek', 'trim|required|max_length[40]|alpha_numeric_spaces');
						$this->form_validation->set_message('required', '%s harus diisi !');
						$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$merek 	= $this->input->post('merek');
							$insert = $this->m_merk_barang->update_merek($id_merk_barang, $merek);
							if ($insert) {
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data berhasil diupdate.</div>"
								));
							} else {
								$this->query_error();
							}
						} else {
							$this->input_error();
						}
					} else {
						$dt['merek'] = $this->m_merk_barang->get_baris($id_merk_barang)->row();
						$this->load->view('barang/merek/merek_edit', $dt);
					}
				}
			}
		}
	}

	public function list_kategori()
	{
		$this->load->view('barang/kategori/kategori_data');
	}

	public function list_kategori_json()
	{
		$this->load->model('m_kategori_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_kategori_barang->fetch_data_kategori($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['kategori'];

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('barang/edit-kategori/' . $row['id_kategori_barang']) . "' id='EditKategori'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='" . site_url('barang/hapus-kategori/' . $row['id_kategori_barang']) . "' id='HapusKategori'><i class='fa fa-trash-o'></i> Hapus</a>";
			}

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval($requestData['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}

	public function tambah_kategori()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($_POST) {
				$this->load->library('form_validation');
				$this->form_validation->set_rules('kategori', 'Kategori', 'trim|required|max_length[40]|alpha_numeric_spaces');
				$this->form_validation->set_message('required', '%s harus diisi !');
				$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

				if ($this->form_validation->run() == TRUE) {
					$this->load->model('m_kategori_barang');
					$kategori 	= $this->input->post('kategori');
					$insert 	= $this->m_kategori_barang->tambah_kategori($kategori);
					if ($insert) {
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>" . $kategori . "</b> berhasil ditambahkan.</div>"
						));
					} else {
						$this->query_error();
					}
				} else {
					$this->input_error();
				}
			} else {
				$this->load->view('barang/kategori/kategori_tambah');
			}
		}
	}

	public function hapus_kategori($id_kategori_barang)
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($this->input->is_ajax_request()) {
				$this->load->model('m_kategori_barang');
				$hapus = $this->m_kategori_barang->hapus_kategori($id_kategori_barang);
				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Data berhasil dihapus !</font>
					"
					));
				} else {
					echo json_encode(array(
						"pesan" => "<font color='red'><i class='fa fa-warning'></i> Terjadi kesalahan, coba lagi !</font>
					"
					));
				}
			}
		}
	}

	public function edit_kategori($id_kategori_barang = NULL)
	{
		if (!empty($id_kategori_barang)) {
			$level = $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'inventory') {
				if ($this->input->is_ajax_request()) {
					$this->load->model('m_kategori_barang');

					if ($_POST) {
						$this->load->library('form_validation');
						$this->form_validation->set_rules('kategori', 'Kategori', 'trim|required|max_length[40]|alpha_numeric_spaces');
						$this->form_validation->set_message('required', '%s harus diisi !');
						$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$kategori 	= $this->input->post('kategori');
							$insert 	= $this->m_kategori_barang->update_kategori($id_kategori_barang, $kategori);
							if ($insert) {
								echo json_encode(array(
									'status' => 1,
									'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> Data berhasil diupdate.</div>"
								));
							} else {
								$this->query_error();
							}
						} else {
							$this->input_error();
						}
					} else {
						$dt['kategori'] = $this->m_kategori_barang->get_baris($id_kategori_barang)->row();
						$this->load->view('barang/kategori/kategori_edit', $dt);
					}
				}
			}
		}
	}

	public function cek_stok()
	{
		if ($this->input->is_ajax_request()) {
			$this->load->model('m_barang');
			$kode = $this->input->post('kode_barang');
			$stok = $this->input->post('stok');

			$get_stok = $this->m_barang->get_stok($kode);/*
			if($stok > $get_stok->row()->total_stok)
			{
				echo json_encode(array('status' => 0, 'pesan' => "Stok untuk <b>".$get_stok->row()->nama_barang."</b> saat ini hanya tersisa <b>".$get_stok->row()->total_stok."</b> !"));
			}
			else
			{*/
			echo json_encode(array('status' => 1));/*
			}*/
		}
	}

	public function cek_stok2()
	{
		if ($this->input->is_ajax_request()) {
			$this->load->model('m_barang');
			$kode = $this->input->post('kd_barang');
			$stok = $this->input->post('stok');

			$get_stok = $this->m_barang->get_stok2($kode);
			if ($stok > $get_stok->row()->total_stok) {
				echo json_encode(array('status' => 0, 'pesan' => "Stok untuk <b>" . $get_stok->row()->nama_barang . "</b> saat ini hanya tersisa <b>" . $get_stok->row()->total_stok . "</b> !"));
			} else {
				echo json_encode(array('status' => 1));
			}
		}
	}

	public function cek_stok3()
	{
		if ($this->input->is_ajax_request()) {
			$this->load->model('m_barang');
			$kode = $this->input->post('kode_barang');
			$stok = $this->input->post('stok');

			$get_stok = $this->m_barang->get_stok2($kode);
			if ($stok > $get_stok->row()->total_stok) {
				echo json_encode(array('status' => 0, 'pesan' => "Stok untuk <b>" . $get_stok->row()->nama_barang . "</b> saat ini hanya tersisa <b>" . $get_stok->row()->total_stok . "</b> !"));
			} else {
				echo json_encode(array('status' => 1));
			}
		}
	}
	public function barang_json_history_herbal()
	{
		$this->load->model('m_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_barang->fetch_data_barang_history_herbal($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['id_barang'];
			$nestedData[]	= $row['nama_barang'];
			$nestedData[]	= $row['tanggal_masuk'];
			// $nestedData[]	= $row['kategori'];
			$nestedData[]	= ($row['total_stok'] == 'Kosong') ? "<font color='red'><b>" . $row['total_stok'] . "</b></font>" : $row['total_stok'];
			$nestedData[]	= $row['satuan'];
			$nestedData[]	= $row['harga'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('barang/edit_historis_barang/' . $row['id']) . "' id='Edit_historis_Barang'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='" . site_url('barang/hapus_historis_barang/' . $row['id']) . "' id='Hapus_historis_Barang'><i class='fa fa-trash-o'></i> Hapus</a>";
			}

			/*if($level == 'admin' OR $level == 'inventory')
			{
				$nestedData[]	= "<a href='".site_url('barang/edit/'.$row['id_barang'])."' id='EditBarang'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='".site_url('barang/hapus/'.$row['id_barang'])."' id='HapusBarang'><i class='fa fa-trash-o'></i> Hapus</a>";
			}*/

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval($requestData['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}
	function barang_json_history_kimia()
	{
		$this->load->model('m_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_barang->fetch_data_barang_history_kimia($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		// cekdb();
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			// $nestedData[]	= $row['id_barang'];
			$nestedData[]	= $row['nama_barang'];
			$nestedData[]	= $row['tanggal_masuk'];
			$nestedData[]	= ($row['total_stok'] == 'Kosong') ? "<font color='red'><b>" . $row['total_stok'] . "</b></font>" : $row['total_stok'];
			$nestedData[]	= $row['satuan'];
			$nestedData[]	= $row['harga'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('barang/edit_historis_barang/' . $row['id']) . "' id='Edit_historis_Barang'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='" . site_url('barang/hapus_historis_barang/' . $row['id']) . "' id='Hapus_historis_Barang'><i class='fa fa-trash-o'></i> Hapus</a>";
			}

			/*if($level == 'admin' OR $level == 'inventory')
			{
				$nestedData[]	= "<a href='".site_url('barang/edit/'.$row['id_barang'])."' id='EditBarang'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='".site_url('barang/hapus/'.$row['id_barang'])."' id='HapusBarang'><i class='fa fa-trash-o'></i> Hapus</a>";
			}*/

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval($requestData['draw']),
			"recordsTotal"    => intval($totalData),
			"recordsFiltered" => intval($totalFiltered),
			"data"            => $data
		);

		echo json_encode($json_data);
	}
	function edit_historis_barang($id_barang)
	{

		$this->load->model('m_barang');
		$dt['obat'] = $this->m_barang->fetch_data_by_id('pj_history_stok_barang', $id_barang)->row();
		// cekdb();
		$this->load->view('barang/edit_historis_barang', $dt);
	}
	function ajax_edit_historis_online($id)
	{
		$this->load->model('m_barang');
		$fetchData =  $this->m_barang->fetch_data('pj_history_stok_barang', $id)->row();
		echo json_encode($fetchData);
	}
	function update_historis_barang($id)
	{
		$this->load->model('m_barang');
		$data = [
			'total_stok' => $this->input->post("jumlah_stok"),
			'tanggal_masuk' => tgl_system($this->input->post("tanggal_masuk")),
		];
		$where = ['id' => $id];
		$sql = $this->m_barang->update_data($data, $where, 'pj_history_stok_barang');
		echo json_encode($sql);
	}

	function hapus_historis_barang($id)
	{
		$this->load->model('m_barang');
		$sql = $this->m_barang->deleteMasterData('pj_history_stok_barang', ['id' => $id]);
		echo json_encode($sql);
		redirect('barang/history_brg_online');
	}
}
