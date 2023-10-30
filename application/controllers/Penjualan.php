<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------
 * CLASS NAME : Penjualan
 * ------------------------------------------------------------------------
 *
 * @author     Muhammad Akbar <muslim.politekniktelkom@gmail.com>
 * @copyright  2016
 * @license    http://aplikasiphp.net
 *
 */

class Penjualan extends MY_Controller
{
	/*function __construct()
	{
		parent::__construct();
		if($this->session->userdata('ap_level') == 'inventory'){
			$this->history();
		}
	}*/

	public function index()
	{
		$this->transaksi();
	}

	public function jadwal_pasien_pending()
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->data_pasien_datang_kembali_pending();
		$this->load->view('barang/jadwal_pasien_datang_kembali_pending', $dt);
	}

	public function laporan_rekap_data_pasien_utama()
	{
		$this->load->view('barang/laporan_rekap_data_pasien_utama');
	}


	public function form_rekap_laporan_data_pasien_online()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir') {
			$this->load->view('barang/form_laporan_rekap_data_pasien_online');
		}
	}

	public function rekap_laporan_tahun_data_pasien_online($tanggal)
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir') {
			$this->load->model('m_penjualan_master');
			$dt['penjualan'] 	= $this->m_penjualan_master->rekap_data_pasien_online_real($tanggal);
			$this->load->view('barang/laporan_rekap_data_pasien_online', $dt);
		}
	}

	public function lihat_transaksi_online($id_pasien, $tahun)
	{
		$level = $this->session->userdata('ap_level');
		$this->load->model('m_penjualan_master');
		if ($level == 'admin' or $level == 'kasir') {
			$dt['penjualan'] 	= $this->m_penjualan_master->rekap_data_pasien_online_satuan($id_pasien, $tahun);
			$dt['nama_pasien']    = $this->m_penjualan_master->data_pasien_online_satuan_nama_pelanggan($id_pasien)->row()->nama_pelanggan;
			$this->load->view('barang/data_rekap_transaksi_pasien_online', $dt);
		}
	}

	public function form_rekap_laporan_data_pasien_klinik_konsul()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir') {
			$this->load->view('barang/form_laporan_rekap_data_pasien_klinik_konsul');
		}
	}

	public function form_rekap_laporan_data_pasien_klinik()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir') {
			$this->load->view('barang/form_laporan_rekap_data_pasien_klinik');
		}
	}

	public function rekap_laporan_tahun_data_pasien_klinik($tanggal)
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir') {
			$this->load->model('m_penjualan_master');
			$dt['penjualan'] 	= $this->m_penjualan_master->rekap_data_pasien_klinik_real($tanggal);
			$dt['tahun'] 	= $tanggal;
			$this->load->view('barang/laporan_rekap_data_pasien_klinik', $dt);
		}
	}

	public function rekap_laporan_tahun_data_pasien_klinik_konsul($tanggal)
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir') {
			$this->load->model('m_penjualan_master');
			$dt['penjualan'] 	= $this->m_penjualan_master->rekap_data_pasien_klinik_real_konsul($tanggal);
			$dt['tahun'] 	= $tanggal;
			$this->load->view('barang/laporan_rekap_data_pasien_klinik_konsul', $dt);
		}
	}


	/*public function rekap_laporan_tahun_data_pasien_klinik_json($tanggal)
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');
        $tanggal2 = $tanggal;
		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->rekap_data_pasien_klinik_real_json($tanggal2,$requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['nrmp'];
			$nestedData[]	= $row['nama_pelanggan'];
			$nestedData[]	= $row['herbalis'];
			$nestedData[]	= $row['tgl_kembali'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/",'<br />', $row['keterangan']);
		
			if($level == 'admin' OR $level == 'kasir' OR $level == 'keuangan' OR $level == 'inventory')
			{
			    $nestedData[]	= "<a href='".site_url('penjualan/edit_transaksi
					/'.$row['id_penjualan_m'])."'><i class='fa fa-pencil-square-o'></i> Edit</a>";
			}

			$data[] = $nestedData;
		}

		$json_data = array(
			"draw"            => intval( $requestData['draw'] ),  
			"recordsTotal"    => intval( $totalData ),  
			"recordsFiltered" => intval( $totalFiltered ), 
			"data"            => $data
			);

		echo json_encode($json_data);
	}*/

	public function lihat_transaksi_klinik($id_pasien, $tahun)
	{
		$level = $this->session->userdata('ap_level');
		$this->load->model('m_penjualan_master');
		if ($level == 'admin' or $level == 'kasir') {
			$dt['penjualan'] 	= $this->m_penjualan_master->rekap_data_pasien_klinik_satuan($id_pasien, $tahun);
			$dt['nama_pasien']    = $this->m_penjualan_master->data_pasien_klinik_satuan_nama_pelanggan($id_pasien)->row()->nama_pelanggan;
			$this->load->view('barang/data_rekap_transaksi_pasien_klinik', $dt);
		}
	}

	public function jadwal_pasien_datang_kembali_utama()
	{
		$this->load->view('barang/jadwal_pasien_datang_kembali_utama');
	}

	public function form_jadwal_pasien_datang_kembali()
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->data_pasien_datang_kembali_klinik_hari_ini();
		$this->load->view('barang/form_jadwal_pasien_datang_kembali', $dt);
	}

	public function form_jadwal_pasien_datang_kembali_online()
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->data_pasien_datang_kembali_online_hari_ini();
		$this->load->view('barang/form_jadwal_pasien_datang_kembali_online', $dt);
	}

	public function data_pasien_datang_kembali_klinik($from)
	{
		$this->load->model('m_penjualan_master');
		$format		        = date('d F Y', strtotime($from));
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['penjualan'] 	= $this->m_penjualan_master->data_pasien_datang_kembali_klinik($format);
		$this->load->view('barang/data_pasien_datang_kembali_klinik', $dt);
	}

	public function data_pasien_datang_kembali_online($from)
	{
		$this->load->model('m_penjualan_master');
		$format		        = date('d F Y', strtotime($from));
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['penjualan'] 	= $this->m_penjualan_master->data_pasien_datang_kembali_online($format);
		$this->load->view('barang/data_pasien_datang_kembali_online', $dt);
	}

	public function jadwal_pasien_datang_kembali_plus_1D()
	{
		$this->load->view('barang/jadwal_pasien_datang_kembali_plus_1D');
	}

	public function jadwal_pasien_datang_kembali_plus_2D()
	{
		$this->load->view('barang/jadwal_pasien_datang_kembali_plus_2D');
	}

	public function jadwal_pasien_datang_kembali()
	{
		$this->load->view('barang/jadwal_pasien_datang_kembali');
	}

	public function list_pasien_datang_kembali_json()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;/*
		$get_qty_standar = $this->m_kategori_barang->get_pembelian_standar();
		    $get_qty_asli = $this->m_kategori_barang->get_pembelian_asli();*/

		$fetch			= $this->m_penjualan_master->fetch_data_datang_kembali($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];



		$data	= array();

		foreach ($query->result_array() as $row) {
			$nestedData = array();


			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['nrmp'];
			$nestedData[]	= $row['nama'];
			$nestedData[]	= $row['tgl_kembali2'];
			$nestedData[]	= $row['id_herbalis'];
			$nestedData[]	= $row['info_tambahan'];
			$nestedData[]	= $row['keterangan'];

			if ($level == 'admin') {
				$nestedData[]	= "<a type='button' class='btn btn-success' href='" . site_url('penjualan/pelanggan_edit_datang_kembali/' . $row['id_pelanggan']) . "' id='EditPelanggan'><i class='fa fa-pencil'></i> Edit</a>";
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

	public function list_pasien_datang_kembali_plus_1D_json()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;/*
		$get_qty_standar = $this->m_kategori_barang->get_pembelian_standar();
		    $get_qty_asli = $this->m_kategori_barang->get_pembelian_asli();*/

		$fetch			= $this->m_penjualan_master->fetch_data_datang_kembali_plus_1D($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];



		$data	= array();

		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['nrmp'];
			$nestedData[]	= $row['nama'];
			$nestedData[]	= $row['tgl_kembali2'];
			$nestedData[]	= $row['id_herbalis'];
			$nestedData[]	= $row['info_tambahan'];
			$nestedData[]	= $row['keterangan'];

			if ($level == 'admin') {
				$nestedData[]	= "<a type='button' class='btn btn-success' href='" . site_url('penjualan/pelanggan_edit_datang_kembali/' . $row['id_pelanggan']) . "' id='EditPelanggan'><i class='fa fa-pencil'></i> Edit</a>";
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

	public function list_pasien_datang_kembali_plus_2D_json()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;/*
		$get_qty_standar = $this->m_kategori_barang->get_pembelian_standar();
		    $get_qty_asli = $this->m_kategori_barang->get_pembelian_asli();*/

		$fetch			= $this->m_penjualan_master->fetch_data_datang_kembali_plus_2D($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];



		$data	= array();

		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['nrmp'];
			$nestedData[]	= $row['nama'];
			$nestedData[]	= $row['tgl_kembali2'];
			$nestedData[]	= $row['id_herbalis'];
			$nestedData[]	= $row['info_tambahan'];
			$nestedData[]	= $row['keterangan'];

			if ($level == 'admin') {
				$nestedData[]	= "<a type='button' class='btn btn-success' href='" . site_url('penjualan/pelanggan_edit_datang_kembali/' . $row['id_pelanggan']) . "' id='EditPelanggan'><i class='fa fa-pencil'></i> Edit</a>";
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

	public function transaksi_medan()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
			if ($_POST) {
				if (!empty($_POST['kode_barang'])) {
					$total = 0;
					foreach ($_POST['kode_barang'] as $k) {
						if (!empty($k)) {
							$total++;
						}
					}

					if ($total > 0) {
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nomor_nota', 'Nomor Nota', 'trim|required|max_length[40]|alpha_numeric|callback_cek_nota_asuransi[nomor_nota]');
						$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');

						$no = 0;
						foreach ($_POST['kode_barang'] as $d) {
							if (!empty($d)) {
								$this->form_validation->set_rules('jumlah_beli[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli[' . $no . ']]');
							}

							$no++;
						}

						$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nota_asuransi', '%s sudah ada');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nomor_nota 	= $this->input->post('nomor_nota');
							$tanggal		= $this->input->post('tanggal');
							$id_kasir		= $this->input->post('id_kasir');
							$catatan		= $this->clean_tag_input($this->input->post('catatan'));

							$this->load->model('m_penjualan_master');
							$master = $this->m_penjualan_master->insert_master_medan($nomor_nota, $tanggal, $id_kasir, $catatan);

							if ($master) {
								$id_master 	= $this->m_penjualan_master->get_id_medan($nomor_nota)->row()->id_medan_m;
								$inserted	= 0;

								$this->load->model('m_penjualan_detail');
								$this->load->model('m_barang');

								$no_array	= 0;
								foreach ($_POST['kode_barang'] as $k) {
									if (!empty($k)) {
										$kode_barang 	= $_POST['kode_barang'][$no_array];
										$jumlah_beli 	= $_POST['jumlah_beli'][$no_array];
										$satuan 	= $_POST['satuan'][$no_array];

										$id_barang		= $this->m_barang->get_id_medan($kode_barang)->row()->id_barang;

										$insert_detail	= $this->m_penjualan_detail->insert_detail_medan($id_master, $id_barang, $jumlah_beli, $satuan, $tanggal, $catatan);
										/*$this->m_barang->update_stok($id_barang, $jumlah_beli);*/
										if ($insert_detail) {
											$inserted++;
										}
									}

									$no_array++;
								}

								if ($inserted > 0) {
									echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
								} else {
									$this->query_error();
								}
							}
						} else {
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ", "</font><br />")));
						}
					} else {
						$this->query_error("Harap masukan minimal 1 kode barang !");
					}
				} else {
					$this->query_error("Harap masukan minimal 1 kode barang !");
				}
			} else {
				$this->load->model('m_user');
				$this->load->model('m_pelanggan');

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['pelanggan'] = $this->m_pelanggan->get_all();
				$dt['herbalis'] = $this->m_pelanggan->get_all_herbalis();
				/*	$this->output->cache(0.1);*/
				$this->load->view('penjualan/transaksi_medan', $dt);
			}
		}
	}

	public function transaksi_asuransi()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
			if ($_POST) {
				if (!empty($_POST['kode_barang'])) {
					$total = 0;
					foreach ($_POST['kode_barang'] as $k) {
						if (!empty($k)) {
							$total++;
						}
					}

					if ($total > 0) {
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nomor_nota', 'Nomor Nota', 'trim|required|max_length[40]|alpha_numeric|callback_cek_nota_asuransi[nomor_nota]');
						$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');
						$this->form_validation->set_rules('id_herbalis', 'Herbalis', 'trim|required');
						$this->form_validation->set_rules('id_pelanggan', 'Nama', 'trim|required');

						$no = 0;
						foreach ($_POST['kode_barang'] as $d) {
							if (!empty($d)) {
								$this->form_validation->set_rules('jumlah_beli[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli[' . $no . ']]');
							}

							$no++;
						}

						$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nota_asuransi', '%s sudah ada');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nomor_nota 	= $this->input->post('nomor_nota');
							$tanggal		= $this->input->post('tanggal');
							$id_kasir		= $this->input->post('id_kasir');
							$id_pelanggan	= $this->input->post('id_pelanggan');
							$id_herbalis	= $this->input->post('id_herbalis');
							$catatan		= $this->clean_tag_input($this->input->post('catatan'));

							$this->load->model('m_penjualan_master');
							$master = $this->m_penjualan_master->insert_master_asuransi($nomor_nota, $tanggal, $id_kasir, $id_pelanggan, $id_herbalis, $catatan);

							if ($master) {
								$id_master 	= $this->m_penjualan_master->get_id_asuransi($nomor_nota)->row()->id_asuransi_m;
								$inserted	= 0;

								$this->load->model('m_penjualan_detail');
								$this->load->model('m_barang');

								$no_array	= 0;
								foreach ($_POST['kode_barang'] as $k) {
									if (!empty($k)) {
										$kode_barang 	= $_POST['kode_barang'][$no_array];
										$jumlah_beli 	= $_POST['jumlah_beli'][$no_array];
										$satuan 	= $_POST['satuan'][$no_array];

										$id_barang		= $this->m_barang->get_id_asuransi($kode_barang)->row()->id_barang;

										$insert_detail	= $this->m_penjualan_detail->insert_detail_asuransi($id_master, $id_barang, $jumlah_beli, $satuan, $tanggal, $id_herbalis, $id_pelanggan, $catatan);/*
											$this->m_barang->update_stok($id_barang, $jumlah_beli);*/
										if ($insert_detail) {
											$inserted++;
										}
									}

									$no_array++;
								}

								if ($inserted > 0) {
									echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
								} else {
									$this->query_error();
								}
							}
						} else {
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ", "</font><br />")));
						}
					} else {
						$this->query_error("Harap masukan minimal 1 kode barang !");
					}
				} else {
					$this->query_error("Harap masukan minimal 1 kode barang !");
				}
			} else {
				$this->load->model('m_user');
				$this->load->model('m_pelanggan');

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['pelanggan'] = $this->m_pelanggan->get_all();
				$dt['herbalis'] = $this->m_pelanggan->get_all_herbalis();
				/*	$this->output->cache(0.1);*/
				$this->load->view('penjualan/transaksi_asuransi', $dt);
			}
		}
	}

	public function transaksi_rincian()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'resepsionis') {
			if ($_POST) {
				if (!empty($_POST['kode_barang'])) {
					$total = 0;
					foreach ($_POST['kode_barang'] as $k) {
						if (!empty($k)) {
							$total++;
						}
					}

					if ($total > 0) {
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nomor_nota', 'Nomor Nota', 'trim|required|max_length[40]|alpha_numeric|callback_cek_nota[nomor_nota]');
						$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');/*
						$this->form_validation->set_rules('sales_pam','Sales PAM','trim|required');*/

						$no = 0;
						foreach ($_POST['kode_barang'] as $d) {
							if (!empty($d)) {/*
								$this->form_validation->set_rules('kode_barang['.$no.']','Kode Barang #'.($no + 1), 'trim|required|max_length[40]|callback_cek_kode_barang[kode_barang['.$no.']]');*/
								$this->form_validation->set_rules('jumlah_beli[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli[' . $no . ']]');
							}

							$no++;
						}

						$this->form_validation->set_rules('cash', 'Total Bayar', 'trim|numeric|required|max_length[17]');
						$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nota', '%s sudah ada');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nomor_nota 	= $this->input->post('nomor_nota');
							$tanggal		= $this->input->post('tanggal');
							$id_kasir		= $this->input->post('id_kasir');
							$id_pelanggan	= $this->input->post('id_pelanggan');
							$id_herbalis	= $this->input->post('nama_herbalis');
							$bayar			= $this->input->post('cash');
							$grand_total	= $this->input->post('grand_total');
							$harga_discount = $this->input->post('total_discount');
							$total_awal     = $this->input->post('total_awal');
							$tanggal_kembali	= $this->input->post('tanggal_kembali');
							$catatan		= $this->clean_tag_input($this->input->post('catatan'));
							$sales_pam		= $this->input->post('sales_pam');

							if ($bayar < $grand_total) {
								$this->query_error("Cash Kurang");
							} else {
								$this->load->model('m_penjualan_master');
								if ($tanggal_kembali == '') {

									$master = $this->m_penjualan_master->insert_master_tanpatanggal($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $sales_pam);

									$master_rincian = $this->m_penjualan_master->insert_master_tanpatanggal_rincian($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $sales_pam);
								} else {

									$master = $this->m_penjualan_master->insert_master($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $tanggal_kembali, $sales_pam);

									$master_rincian = $this->m_penjualan_master->insert_master_rincian($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $tanggal_kembali, $sales_pam);
								}
								if ($master) {
									$id_master 	= $this->m_penjualan_master->get_id($nomor_nota)->row()->id_penjualan_m;
									$id_master_rincian 	= $this->m_penjualan_master->get_id_rincian($nomor_nota)->row()->id_rincian;

									$inserted	= 0;
									$inserted_2	= 0;

									$this->load->model('m_penjualan_detail');
									$this->load->model('m_barang');

									$no_array	= 0;
									$no_array_2	= 0;
									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$kode_barang 	= $_POST['kode_barang'][$no_array];
											$jumlah_dosis1 	= $_POST['jumlah_beli'][$no_array];
											$jumlah_dosis2 	= $_POST['jumlah_beli_2'][$no_array];
											$isi 	= $_POST['isi'][$no_array];
											$jumlah_kebutuhan 	= $_POST['kebutuhan'][$no_array];
											$harga_satuan 	= $_POST['harga_satuan'][$no_array];
											$discount 		= $_POST['discount'][$no_array];
											$discountnya 	= $_POST['discountnya'][$no_array];
											$sub_total 		= $_POST['sub_total_awal'][$no_array];
											$grand_total 	= $_POST['sub_total'][$no_array];
											$id_barang		= $this->m_barang->get_id($kode_barang)->row()->id_barang;
											$satuan		= $this->m_barang->get_id($kode_barang)->row()->satuan;

											$insert_detail_rincian	= $this->m_penjualan_detail->insert_detail2_rincian($id_master_rincian, $id_barang, $jumlah_dosis1, $jumlah_dosis2, $isi, $jumlah_kebutuhan, $harga_satuan, $discount, $discountnya, $sub_total, $grand_total, $tanggal, $id_herbalis, $id_pelanggan, $sales_pam);

											$insert_detail	= $this->m_penjualan_detail->insert_detail2($id_master, $id_barang, $jumlah_kebutuhan, $satuan, $harga_satuan, $discount, $discountnya, $sub_total, $grand_total, $tanggal, $id_herbalis, $id_pelanggan, $sales_pam);

											/*$this->m_barang->update_stok($id_barang, $jumlah_beli);*/

											if ($insert_detail_rincian and $insert_detail) {
												$inserted++;
											}
										}

										$no_array++;
									}

									if ($inserted > 0) {
										echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
									} else {
										echo json_encode(array('status' => 0, 'pesan' => "Transaksi Salah Tuh ! " . $id_master . $id_barang . $jumlah_kebutuhan . $satuan . $harga_satuan . $discount . $discountnya . $sub_total . $grand_total . $tanggal . $id_herbalis . $id_pelanggan . $sales_pam));
									}
								} else {
									$this->query_error();
								}
							}
						} else {
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ", "</font><br />")));
						}
					} else {
						$this->query_error("Harap masukan minimal 1 kode barang !");
					}
				} else {
					$this->query_error("Harap masukan minimal 1 kode barang !");
				}
			} else {
				$this->load->model('m_user');
				$this->load->model('m_pelanggan');

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['pelanggan'] = $this->m_pelanggan->get_all();
				$dt['herbalis'] = $this->m_pelanggan->get_all_herbalis();
				/*	$this->output->cache(0.1);*/
				$this->load->view('penjualan/transaksi_rincian', $dt);
			}
		}
	}

	public function hasil_transaksi()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'resepsionis') {
			if ($_POST) {
				if (!empty($_POST['kode_barang'])) {
					$total = 0;
					foreach ($_POST['kode_barang'] as $k) {
						if (!empty($k)) {
							$total++;
						}
					}

					if ($total > 0) {
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nomor_nota', 'Nomor Nota', 'trim|required|max_length[40]|alpha_numeric|callback_cek_nota[nomor_nota]');
						$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');/*
						$this->form_validation->set_rules('sales_pam','Sales PAM','trim|required');*/

						$no = 0;
						foreach ($_POST['kode_barang'] as $d) {
							if (!empty($d)) {/*
								$this->form_validation->set_rules('kode_barang['.$no.']','Kode Barang #'.($no + 1), 'trim|required|max_length[40]|callback_cek_kode_barang[kode_barang['.$no.']]');*/
								$this->form_validation->set_rules('jumlah_beli[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli[' . $no . ']]');
							}

							$no++;
						}

						$this->form_validation->set_rules('cash', 'Total Bayar', 'trim|numeric|required|max_length[17]');
						$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nota', '%s sudah ada');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nomor_nota 	= $this->input->post('nomor_nota');
							$tanggal		= $this->input->post('tanggal');
							$id_kasir		= $this->input->post('id_kasir');
							$id_pelanggan	= $this->input->post('id_pelanggan');
							$id_herbalis	= $this->input->post('nama_herbalis');
							$bayar			= $this->input->post('cash');
							$grand_total	= $this->input->post('grand_total');
							$harga_discount = $this->input->post('total_discount');
							$total_awal     = $this->input->post('total_awal');
							$tanggal_kembali	= $this->input->post('tanggal_kembali');
							$catatan		= $this->clean_tag_input($this->input->post('catatan'));
							$sales_pam		= $this->input->post('sales_pam');

							if ($bayar < $grand_total) {
								$this->query_error("Cash Kurang");
							} else {
								$this->load->model('m_penjualan_master');
								if ($tanggal_kembali == '') {
									$master = $this->m_penjualan_master->insert_master_tanpatanggal($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $sales_pam);
								} else {

									$master = $this->m_penjualan_master->insert_master($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $tanggal_kembali, $sales_pam);
								}
								if ($master) {
									$id_master 	= $this->m_penjualan_master->get_id($nomor_nota)->row()->id_penjualan_m;
									$inserted	= 0;

									$this->load->model('m_penjualan_detail');
									$this->load->model('m_barang');

									$no_array	= 0;
									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$kode_barang 	= $_POST['kode_barang'][$no_array];
											$jumlah_beli 	= $_POST['jumlah_beli'][$no_array];
											$harga_satuan 	= $_POST['harga_satuan'][$no_array];
											$satuan 		= $_POST['satuan'][$no_array];
											$discount 		= $_POST['discount'][$no_array];
											$discountnya 	= $_POST['discountnya'][$no_array];
											$sub_total 		= $_POST['sub_total_awal'][$no_array];
											$grand_total 	= $_POST['sub_total'][$no_array];
											$id_barang		= $this->m_barang->get_id($kode_barang)->row()->id_barang;

											$insert_detail	= $this->m_penjualan_detail->insert_detail2($id_master, $id_barang, $jumlah_beli, $satuan, $harga_satuan, $discount, $discountnya, $sub_total, $grand_total, $tanggal, $id_herbalis, $id_pelanggan, $sales_pam);/*
											$this->m_barang->update_stok($id_barang, $jumlah_beli);*/
											if ($insert_detail) {
												$this->m_penjualan_detail->update_pelanggan2($id_herbalis, $id_pelanggan, $tanggal_kembali);
												$inserted++;
											}
										}

										$no_array++;
									}

									if ($inserted > 0) {
										echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
									} else {
										$this->query_error();
									}
								} else {
									$this->query_error();
								}
							}
						} else {
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ", "</font><br />")));
						}
					} else {
						$this->query_error("Harap masukan minimal 1 kode barang !");
					}
				} else {
					$this->query_error("Harap masukan minimal 1 kode barang !");
				}
			} else {
				$this->load->model('m_user');
				$this->load->model('m_pelanggan');

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['pelanggan'] = $this->m_pelanggan->get_all();
				$dt['herbalis'] = $this->m_pelanggan->get_all_herbalis();
				/*	$this->output->cache(0.1);*/
				$this->load->view('penjualan/hasil_transaksi', $dt);
			}
		}
	}

	public function transaksi()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'resepsionis') {
			if ($_POST) {
				if (!empty($_POST['kode_barang'])) {
					$total = 0;
					foreach ($_POST['kode_barang'] as $k) {
						if (!empty($k)) {
							$total++;
						}
					}

					if ($total > 0) {
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nomor_nota', 'Nomor Nota', 'trim|required|max_length[40]|alpha_numeric|callback_cek_nota[nomor_nota]');
						$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');/*
						$this->form_validation->set_rules('sales_pam','Sales PAM','trim|required');*/

						$no = 0;
						foreach ($_POST['kode_barang'] as $d) {
							if (!empty($d)) {/*
								$this->form_validation->set_rules('kode_barang['.$no.']','Kode Barang #'.($no + 1), 'trim|required|max_length[40]|callback_cek_kode_barang[kode_barang['.$no.']]');*/
								$this->form_validation->set_rules('jumlah_beli[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli[' . $no . ']]');
							}

							$no++;
						}

						$this->form_validation->set_rules('cash', 'Total Bayar', 'trim|numeric|required|max_length[17]');
						$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nota', '%s sudah ada');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nomor_nota 	= $this->input->post('nomor_nota');
							$tanggal		= $this->input->post('tanggal');
							$id_kasir		= $this->input->post('id_kasir');
							$id_pelanggan	= $this->input->post('id_pelanggan');
							$id_herbalis	= $this->input->post('nama_herbalis');
							$bayar			= $this->input->post('cash');
							$grand_total	= $this->input->post('grand_total');
							$harga_discount = $this->input->post('total_discount');
							$total_awal     = $this->input->post('total_awal');
							$tanggal_kembali	= $this->input->post('tanggal_kembali');
							$catatan		= $this->clean_tag_input($this->input->post('catatan'));
							$sales_pam		= $this->input->post('sales_pam');

							if ($bayar < $grand_total) {
								$this->query_error("Cash Kurang");
							} else {
								$this->load->model('m_penjualan_master');
								if ($tanggal_kembali == '') {
									$master = $this->m_penjualan_master->insert_master_tanpatanggal($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $sales_pam);
								} else {

									$master = $this->m_penjualan_master->insert_master($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $tanggal_kembali, $sales_pam);
								}
								if ($master) {
									$id_master 	= $this->m_penjualan_master->get_id($nomor_nota)->row()->id_penjualan_m;
									$inserted	= 0;

									$this->load->model('m_penjualan_detail');
									$this->load->model('m_barang');

									$no_array	= 0;
									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$kode_barang 	= $_POST['kode_barang'][$no_array];
											$jumlah_beli 	= $_POST['jumlah_beli'][$no_array];
											$harga_satuan 	= $_POST['harga_satuan'][$no_array];
											$satuan 		= $_POST['satuan'][$no_array];
											$discount 		= $_POST['discount'][$no_array];
											$discountnya 	= $_POST['discountnya'][$no_array];
											$sub_total 		= $_POST['sub_total_awal'][$no_array];
											$grand_total 	= $_POST['sub_total'][$no_array];
											$id_barang		= $this->m_barang->get_id($kode_barang)->row()->id_barang;

											$insert_detail	= $this->m_penjualan_detail->insert_detail2($id_master, $id_barang, $jumlah_beli, $satuan, $harga_satuan, $discount, $discountnya, $sub_total, $grand_total, $tanggal, $id_herbalis, $id_pelanggan, $sales_pam);/*
											$this->m_barang->update_stok($id_barang, $jumlah_beli);*/
											if ($insert_detail) {
												$this->m_penjualan_detail->update_pelanggan2($id_herbalis, $id_pelanggan, $tanggal_kembali);
												$inserted++;
											}
										}

										$no_array++;
									}

									if ($inserted > 0) {
										echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
									} else {
										$this->query_error();
									}
								} else {
									$this->query_error();
								}
							}
						} else {
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ", "</font><br />")));
						}
					} else {
						$this->query_error("Harap masukan minimal 1 kode barang !");
					}
				} else {
					$this->query_error("Harap masukan minimal 1 kode barang !");
				}
			} else {
				$this->load->model('m_user');
				$this->load->model('m_pelanggan');

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['pelanggan'] = $this->m_pelanggan->get_all();
				$dt['herbalis'] = $this->m_pelanggan->get_all_herbalis();
				/*	$this->output->cache(0.1);*/
				$this->load->view('penjualan/transaksi', $dt);
				// $this->load->view('errors/eror');
			}
		}
	}

	public function transaksi2()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			if ($_POST) {
				if (!empty($_POST['kode_barang'])) {
					$total = 0;
					foreach ($_POST['kode_barang'] as $k) {
						if (!empty($k)) {
							$total++;
						}
					}

					if ($total > 0) {
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nomor_nota', 'Nomor Nota', 'trim|required|max_length[40]|alpha_numeric|callback_cek_nota[nomor_nota]');
						$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');

						$no = 0;
						foreach ($_POST['kode_barang'] as $d) {
							if (!empty($d)) {/*
								$this->form_validation->set_rules('kode_barang['.$no.']','Kode Barang #'.($no + 1), 'trim|required|max_length[40]|callback_cek_kode_barang[kode_barang['.$no.']]');*/
								$this->form_validation->set_rules('jumlah_beli[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli[' . $no . ']]');
							}

							$no++;
						}

						$this->form_validation->set_rules('cash', 'Total Bayar', 'trim|numeric|required|max_length[17]');
						$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nota', '%s sudah ada');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nomor_nota 	= $this->input->post('nomor_nota');
							$tanggal		= $this->input->post('tanggal');
							$id_kasir		= $this->input->post('id_kasir');
							$id_pelanggan	= $this->input->post('id_pelanggan');
							$id_herbalis_ori = $this->input->post('nama_herbalis_ori');
							$id_herbalis	= $this->input->post('nama_herbalis');
							$aty_kota		= $this->input->post('aty_kota');
							$bayar			= $this->input->post('cash');
							$grand_total	= $this->input->post('grand_total');
							$harga_discount = $this->input->post('total_discount');
							$total_awal     = $this->input->post('total_awal');
							$tanggal_kembali	= $this->input->post('tanggal_kembali');
							$catatan		= $this->clean_tag_input($this->input->post('catatan'));

							if ($bayar < $grand_total) {
								$this->query_error("Cash Kurang");
							} else {
								$this->load->model('m_penjualan_master');

								if ($tanggal_kembali == '') {
									$master = $this->m_penjualan_master->insert_master2_tanpatanggal($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis_ori, $id_herbalis, $aty_kota, $bayar, $grand_total, $catatan);
								} else {

									$master = $this->m_penjualan_master->insert_master2($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis_ori, $id_herbalis, $aty_kota, $bayar, $grand_total, $catatan, $tanggal_kembali);
								}

								if ($master) {
									$id_master 	= $this->m_penjualan_master->get_id($nomor_nota)->row()->id_penjualan_m;
									$inserted	= 0;

									$this->load->model('m_penjualan_detail');
									$this->load->model('m_barang');

									$no_array	= 0;
									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$kode_barang 	= $_POST['kode_barang'][$no_array];
											$jumlah_beli 	= $_POST['jumlah_beli'][$no_array];
											$harga_satuan 	= $_POST['harga_satuan'][$no_array];
											$satuan 		= $_POST['satuan'][$no_array];
											$discount 		= $_POST['discount'][$no_array];
											$discountnya 	= $_POST['discountnya'][$no_array];
											$sub_total 		= $_POST['sub_total_awal'][$no_array];
											$grand_total 	= $_POST['sub_total'][$no_array];

											$id_barang		= $this->m_barang->get_id_online($kode_barang)->row()->id_barang;

											$insert_detail	= $this->m_penjualan_detail->insert_detail($id_master, $id_barang, $kode_barang, $jumlah_beli, $satuan, $harga_satuan, $discount, $discountnya, $sub_total, $grand_total, $tanggal, $id_herbalis_ori, $id_herbalis, $aty_kota, $id_pelanggan);
											if ($insert_detail) {
												/*$this->m_barang->update_stok3($id_barang, $jumlah_beli);*/
												$this->m_penjualan_detail->update_pelanggan($id_herbalis, $tanggal_kembali, $id_pelanggan);
												$inserted++;
											}
										}

										$no_array++;
									}

									if ($inserted > 0) {
										echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
									} else {
										$this->query_error();
									}
								} else {
									$this->query_error();
								}
							}
						} else {
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ", "</font><br />")));
						}
					} else {
						$this->query_error("Harap masukan minimal 1 kode barang !");
					}
				} else {
					$this->query_error("Harap masukan minimal 1 kode barang !");
				}
			} else {
				$this->load->model('m_user');
				$this->load->model('m_pelanggan');

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['pelanggan'] = $this->m_pelanggan->get_all_online();
				$dt['sales'] = $this->m_pelanggan->get_all_sales();
				$dt['herbalis'] = $this->m_pelanggan->get_all_herbalis();
				/*$this->output->cache(0.1);*/
				$this->load->view('penjualan/transaksi2', $dt);
			}
		}
	}

	public function transaksi2_pending()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			if ($_POST) {
				if (!empty($_POST['kode_barang'])) {
					$total = 0;
					foreach ($_POST['kode_barang'] as $k) {
						if (!empty($k)) {
							$total++;
						}
					}

					if ($total > 0) {
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nomor_nota', 'Nomor Nota', 'trim|required|max_length[40]|alpha_numeric|callback_cek_nota[nomor_nota]');
						$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');

						$no = 0;
						foreach ($_POST['kode_barang'] as $d) {
							if (!empty($d)) {/*
								$this->form_validation->set_rules('kode_barang['.$no.']','Kode Barang #'.($no + 1), 'trim|required|max_length[40]|callback_cek_kode_barang[kode_barang['.$no.']]');*/
								$this->form_validation->set_rules('jumlah_beli[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli[' . $no . ']]');
							}

							$no++;
						}

						$this->form_validation->set_rules('cash', 'Total Bayar', 'trim|numeric|required|max_length[17]');
						$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nota', '%s sudah ada');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nomor_nota 	= $this->input->post('nomor_nota');
							$tanggal		= $this->input->post('tanggal');
							$id_kasir		= $this->input->post('id_kasir');
							$id_pelanggan	= $this->input->post('id_pelanggan');
							$id_herbalis_ori = $this->input->post('nama_herbalis_ori');
							$id_herbalis	= $this->input->post('nama_herbalis');
							$aty_kota		= $this->input->post('aty_kota');
							$bayar			= $this->input->post('cash');
							$grand_total	= $this->input->post('grand_total');
							$harga_discount = $this->input->post('total_discount');
							$total_awal     = $this->input->post('total_awal');
							$tanggal_kembali	= $this->input->post('tanggal_kembali');
							$catatan		= $this->clean_tag_input($this->input->post('catatan'));

							if ($bayar < $grand_total) {
								$this->query_error("Cash Kurang");
							} else {
								$this->load->model('m_penjualan_master');
								$master = $this->m_penjualan_master->insert_master2_pending($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis_ori, $id_herbalis, $aty_kota, $bayar, $grand_total, $catatan);
								if ($master) {
									$id_master 	= $this->m_penjualan_master->get_id($nomor_nota)->row()->id_penjualan_m;
									$inserted	= 0;

									$this->load->model('m_penjualan_detail');
									$this->load->model('m_barang');

									$no_array	= 0;
									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$kode_barang 	= $_POST['kode_barang'][$no_array];
											$jumlah_beli 	= $_POST['jumlah_beli'][$no_array];
											$harga_satuan 	= $_POST['harga_satuan'][$no_array];
											$satuan 		= $_POST['satuan'][$no_array];
											$discount 	    = $_POST['discount'][$no_array];
											$discountnya 	= $_POST['discountnya'][$no_array];
											$sub_total 		=
												$_POST['sub_total_awal'][$no_array];
											$grand_total 	=
												$_POST['sub_total'][$no_array];
											$id_barang		= $this->m_barang->get_id_online($kode_barang)->row()->id_barang;

											$insert_detail	= $this->m_penjualan_detail->insert_detail_pending($id_master, $id_barang, $jumlah_beli, $satuan, $harga_satuan, $discount, $discountnya, $sub_total, $grand_total, $tanggal, $id_herbalis_ori, $id_herbalis, $aty_kota, $id_pelanggan);
											if ($insert_detail) {
												/*$this->m_barang->update_stok3($id_barang, $jumlah_beli);*/
												$this->m_penjualan_detail->update_pelanggan($id_herbalis, $id_pelanggan);
												$inserted++;
											}
										}

										$no_array++;
									}

									if ($inserted > 0) {
										echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
									} else {
										$this->query_error();
									}
								} else {
									$this->query_error();
								}
							}
						} else {
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ", "</font><br />")));
						}
					} else {
						$this->query_error("Harap masukan minimal 1 kode barang !");
					}
				} else {
					$this->query_error("Harap masukan minimal 1 kode barang !");
				}
			} else {
				$this->load->model('m_user');
				$this->load->model('m_pelanggan');

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['pelanggan'] = $this->m_pelanggan->get_all_online();
				$dt['sales'] = $this->m_pelanggan->get_all_sales();
				$dt['herbalis'] = $this->m_pelanggan->get_all_herbalis();
				/*$this->output->cache(0.1);*/
				$this->load->view('penjualan/transaksi2', $dt);
			}
		}
	}

	public function transaksi_pending_utama()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			if ($_POST) {
				if (!empty($_POST['kode_barang'])) {
					$total = 0;
					foreach ($_POST['kode_barang'] as $k) {
						if (!empty($k)) {
							$total++;
						}
					}

					if ($total > 0) {
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nomor_nota', 'Nomor Nota', 'trim|required|max_length[40]|alpha_numeric|callback_cek_nota[nomor_nota]');
						$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');

						$no = 0;
						foreach ($_POST['kode_barang'] as $d) {
							if (!empty($d)) {/*
								$this->form_validation->set_rules('kode_barang['.$no.']','Kode Barang #'.($no + 1), 'trim|required|max_length[40]|callback_cek_kode_barang[kode_barang['.$no.']]');*/
								$this->form_validation->set_rules('jumlah_beli[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli[' . $no . ']]');
							}

							$no++;
						}

						$this->form_validation->set_rules('cash', 'Total Bayar', 'trim|numeric|required|max_length[17]');
						$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nota', '%s sudah ada');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nomor_nota 	= $this->input->post('nomor_nota');
							$tanggal		= $this->input->post('tanggal');
							$id_kasir		= $this->input->post('id_kasir');
							$id_pelanggan	= $this->input->post('id_pelanggan');
							$id_herbalis	= $this->input->post('nama_herbalis');
							$bayar			= $this->input->post('cash');
							$grand_total	= $this->input->post('grand_total');
							$harga_discount = $this->input->post('total_discount');
							$total_awal     = $this->input->post('total_awal');
							$tanggal_kembali	= $this->input->post('tanggal_kembali');
							$catatan		= $this->clean_tag_input($this->input->post('catatan'));
							$sales_pam		= $this->input->post('sales_pam');

							if ($bayar < $grand_total) {
								$this->query_error("Cash Kurang");
							} else {
								$this->load->model('m_penjualan_master');
								if ($tanggal_kembali == '') {
									$master = $this->m_penjualan_master->insert_master_pending_tanpatanggal($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $sales_pam);
								} else {

									$master = $this->m_penjualan_master->insert_master_pending($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $tanggal_kembali, $sales_pam);
								}
								if ($master) {
									$id_master 	= $this->m_penjualan_master->get_id($nomor_nota)->row()->id_penjualan_m;
									$inserted	= 0;

									$this->load->model('m_penjualan_detail');
									$this->load->model('m_barang');

									$no_array	= 0;
									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$kode_barang 	= $_POST['kode_barang'][$no_array];
											$jumlah_beli 	= $_POST['jumlah_beli'][$no_array];
											$harga_satuan 	= $_POST['harga_satuan'][$no_array];
											$satuan 		= $_POST['satuan'][$no_array];
											$discount 		= $_POST['discount'][$no_array];
											$discountnya 	= $_POST['discountnya'][$no_array];
											$sub_total 		= $_POST['sub_total_awal'][$no_array];
											$grand_total 	= $_POST['sub_total'][$no_array];
											$id_barang		= $this->m_barang->get_id($kode_barang)->row()->id_barang;

											$insert_detail	= $this->m_penjualan_detail->insert_detail2_pending($id_master, $id_barang, $jumlah_beli, $satuan, $harga_satuan, $discount, $discountnya, $sub_total, $grand_total, $tanggal, $id_herbalis, $id_pelanggan, $sales_pam);/*
											$this->m_barang->update_stok($id_barang, $jumlah_beli);*/
											if ($insert_detail) {
												$this->m_penjualan_detail->update_pelanggan2($id_herbalis, $id_pelanggan, $tanggal_kembali);
												$inserted++;
											}
										}

										$no_array++;
									}

									if ($inserted > 0) {
										echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
									} else {
										$this->query_error();
									}
								} else {
									$this->query_error();
								}
							}
						} else {
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ", "</font><br />")));
						}
					} else {
						$this->query_error("Harap masukan minimal 1 kode barang !");
					}
				} else {
					$this->query_error("Harap masukan minimal 1 kode barang !");
				}
			} else {
				$this->load->model('m_user');
				$this->load->model('m_pelanggan');

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['pelanggan'] = $this->m_pelanggan->get_all();
				$dt['herbalis'] = $this->m_pelanggan->get_all_herbalis();
				/*$this->output->cache(0.1);*/
				$this->load->view('penjualan/transaksi', $dt);
			}
		}
	}


	public function cek_nota($nota)
	{
		$this->load->model('m_penjualan_master');
		$cek = $this->m_penjualan_master->cek_nota_validasi($nota);

		if ($cek->num_rows() > 0) {
			return FALSE;
		}
		return TRUE;
	}

	public function cek_nota_asuransi($nota)
	{
		$this->load->model('m_penjualan_master');
		$cek = $this->m_penjualan_master->cek_nota_asuransi_validasi($nota);

		if ($cek->num_rows() > 0) {
			return FALSE;
		}
		return TRUE;
	}


	public function tr_cetak_rincian()
	{
		$nomor_nota 	= $this->input->get('nomor_nota');
		$tanggal		= $this->input->get('tanggal');
		$id_kasir		= $this->input->get('id_kasir');
		$id_pelanggan	= $this->input->get('id_pelanggan');
		$cash			= $this->input->get('cash');
		$satuan			= $this->input->get('satuan');
		$catatan		= $this->input->get('catatan');
		$grand_total	= $this->input->get('grand_total');
		$nama_herbalis	= $this->input->get('nama_herbalis');
		$sales_pam		= $this->input->get('sales_pam');
		$nrmp		= $this->input->get('nrmp');
		$tanggal_kembali	= $this->input->get('tanggal_kembali');
		$harga_discount = $this->input->get('total_discount');
		$total_awal     = $this->input->get('total_awal');
		$no = 0;
		$discount2	= $_GET['discount'][$no];


		$this->load->model('m_user');
		$kasir = $this->m_user->get_baris($id_kasir)->row()->nama;

		$this->load->model('m_pelanggan');
		$pelanggan = 'umum';
		if (!empty($id_pelanggan)) {
			$pelanggan = $this->m_pelanggan->get_baris($id_pelanggan)->row()->nama;
		}

		$this->load->library('cfpdf');
		$pdf = new FPDF('L', 'mm', 'A5');
		$pdf->SetMargins(5, 5, 5);
		$pdf->AddPage();

		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(200, 4, 'Rincian Obat ' . $pelanggan . '', 0, 1, 'C');

		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(170, 2, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(8, 4.5, 'No', 0, 0, 'L');
		$pdf->Cell(40, 4.5, 'Nama Obat', 0, 0, 'L');
		$pdf->Cell(15, 4.5, 'Dosis', 0, 0, 'L');
		$pdf->Cell(20, 4.5, 'Harga', 0, 0, 'L');
		$pdf->Cell(35, 4.5, 'Kebutuhan 1 Bulan', 0, 0, 'L');
		$pdf->Cell(25, 4.5, 'Subtotal', 0, 0, 'L');
		$pdf->Cell(12, 4.5, 'Disc', 0, 0, 'L');
		$pdf->Cell(21, 4.5, 'Discount', 0, 0, 'L');
		$pdf->Cell(25, 4.5, 'Grand Total', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(130, 3, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();

		$this->load->model('m_barang');
		$this->load->helper('text');

		$nomor = 0;
		$no = 0;
		foreach ($_GET['kode_barang'] as $kd) {
			$nomor = $nomor + 1;
			if (!empty($kd)) {
				$nama_barang = $this->m_barang->get_id($kd)->row()->nama_barang;
				$nama_jasa = $this->m_barang->get_id_jasa($kd)->row()->nama_jasa;
				$nama_barang = character_limiter($nama_barang, 20, '..');
				$nama_jasa = character_limiter($nama_jasa, 20, '..');
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(8, 4.5, $nomor, 0, 0, 'L');
				$pdf->Cell(40, 4.5, (!empty($nama_barang)) ? $nama_barang : $nama_jasa, 0, 0, 'L');
				$pdf->Cell(15, 4.5, '' . $_GET['jumlah_beli'][$no] . ' X ' . $_GET['jumlah_beli_2'][$no], 0, 0, 'L');
				$pdf->Cell(20, 4.5, str_replace(',', '.', 'Rp ' . number_format($_GET['harga_satuan'][$no])), 0, 0, 'L');
				$pdf->Cell(35, 4.5, $_GET['kebutuhan'][$no], 0, 0, 'C');
				$pdf->Cell(25, 4.5, str_replace(',', '.', 'Rp ' . number_format($_GET['sub_total_awal'][$no])), 0, 0, 'L');
				$pdf->Cell(12, 4.5, $_GET['discount'][$no] . ' %', 0, 0, 'L');
				$pdf->Cell(21, 4.5, str_replace(',', '.', 'Rp ' . number_format($_GET['discountnya'][$no])), 0, 0, 'L');
				$pdf->Cell(25, 4.5, str_replace(',', '.', 'Rp ' . number_format($_GET['sub_total'][$no])), 0, 0, 'L');
				$pdf->Ln();

				$no++;
			}
		}

		$pdf->Cell(130, 1, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(8, 5, '', 0, 0, 'L');

		$pdf->Cell(110, 7, 'Total Akhir', 0, 0, 'L');
		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(37, 7, 'Rp ' . str_replace(',', '.', number_format($total_awal)), 0, 0, 'L');
		$pdf->Cell(21, 7, 'Rp ' . str_replace(',', '.', number_format($harga_discount)), 0, 0, 'L');
		$pdf->Cell(25, 7, 'Rp ' . str_replace(',', '.', number_format($grand_total)), 0, 0, 'L');
		$pdf->Ln();

		$output = "Rincian Obat Pasien " . $pelanggan . ".pdf";
		$pdf->Output();
	}

	public function tr_cetak_rincian_all()
	{
		$nomor_nota 	= $this->input->get('nomor_nota');
		$tanggal		= $this->input->get('tanggal');
		$id_kasir		= $this->input->get('id_kasir');
		$id_pelanggan	= $this->input->get('id_pelanggan');
		$cash			= $this->input->get('cash');
		$satuan			= $this->input->get('satuan');
		$catatan		= $this->input->get('catatan');
		$grand_total	= $this->input->get('grand_total');
		$grand_total_m	= $this->input->get('grand_total_m');
		$nama_herbalis	= $this->input->get('nama_herbalis');
		$sales_pam		= $this->input->get('sales_pam');
		$nrmp		    = $this->input->get('nrmp');
		$tanggal_kembali	= $this->input->get('tanggal_kembali');
		$harga_discount     = $this->input->get('total_discount');
		$harga_discount_m   = $this->input->get('total_discount_m');
		$total_awal         = $this->input->get('total_awal');
		$total_awal_m       = $this->input->get('total_awal_m');
		$no = 0;
		$discount2	= $_GET['discount'][$no];


		$this->load->model('m_user');
		$kasir = $this->m_user->get_baris($id_kasir)->row()->nama;

		$this->load->model('m_pelanggan');
		$pelanggan = 'umum';
		if (!empty($id_pelanggan)) {
			$pelanggan = $this->m_pelanggan->get_baris($id_pelanggan)->row()->nama;
		}

		$this->load->library('cfpdf');
		$pdf = new FPDF('L', 'mm', 'A5');
		$pdf->SetMargins(5, 5, 5);
		$pdf->AddPage();

		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(200, 4, 'Rincian Obat 1 Bulan ' . $pelanggan . '', 0, 1, 'C');

		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(170, 2, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(8, 4.5, 'No', 0, 0, 'L');
		$pdf->Cell(40, 4.5, 'Nama Obat', 0, 0, 'L');
		$pdf->Cell(15, 4.5, 'Dosis', 0, 0, 'L');
		$pdf->Cell(20, 4.5, 'Harga', 0, 0, 'L');
		$pdf->Cell(35, 4.5, 'Kebutuhan 1 Bulan', 0, 0, 'L');
		$pdf->Cell(25, 4.5, 'Subtotal', 0, 0, 'L');
		$pdf->Cell(12, 4.5, 'Disc', 0, 0, 'L');
		$pdf->Cell(21, 4.5, 'Discount', 0, 0, 'L');
		$pdf->Cell(25, 4.5, 'Grand Total', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(130, 3, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();

		$this->load->model('m_barang');
		$this->load->helper('text');

		$nomor = 0;
		$no = 0;
		foreach ($_GET['kode_barang'] as $kd) {
			$nomor = $nomor + 1;
			if (!empty($kd)) {
				$nama_barang = $this->m_barang->get_id($kd)->row()->nama_barang;
				$nama_jasa = $this->m_barang->get_id_jasa($kd)->row()->nama_jasa;
				$nama_barang = character_limiter($nama_barang, 20, '..');
				$nama_jasa = character_limiter($nama_jasa, 20, '..');
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(8, 4.5, $nomor, 0, 0, 'L');
				$pdf->Cell(40, 4.5, (!empty($nama_barang)) ? $nama_barang : $nama_jasa, 0, 0, 'L');
				$pdf->Cell(15, 4.5, '' . $_GET['jumlah_beli'][$no] . ' X ' . $_GET['jumlah_beli_2'][$no], 0, 0, 'L');
				$pdf->Cell(20, 4.5, str_replace(',', '.', 'Rp ' . number_format($_GET['harga_satuan'][$no])), 0, 0, 'L');
				$pdf->Cell(35, 4.5, $_GET['kebutuhan'][$no], 0, 0, 'C');
				$pdf->Cell(25, 4.5, str_replace(',', '.', 'Rp ' . number_format($_GET['sub_total_awal'][$no])), 0, 0, 'L');
				$pdf->Cell(12, 4.5, $_GET['discount'][$no] . ' %', 0, 0, 'L');
				$pdf->Cell(21, 4.5, str_replace(',', '.', 'Rp ' . number_format($_GET['discountnya'][$no])), 0, 0, 'L');
				$pdf->Cell(25, 4.5, str_replace(',', '.', 'Rp ' . number_format($_GET['sub_total'][$no])), 0, 0, 'L');
				$pdf->Ln();

				$no++;
			}
		}

		$pdf->Cell(130, 1, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(8, 5, '', 0, 0, 'L');

		$pdf->Cell(110, 7, 'Total Akhir', 0, 0, 'L');
		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(37, 7, 'Rp ' . str_replace(',', '.', number_format($total_awal)), 0, 0, 'L');
		$pdf->Cell(21, 7, 'Rp ' . str_replace(',', '.', number_format($harga_discount)), 0, 0, 'L');
		$pdf->Cell(25, 7, 'Rp ' . str_replace(',', '.', number_format($grand_total)), 0, 0, 'L');
		$pdf->Ln();
		$pdf->Ln();
		$pdf->Ln();

		/*-----------------------------------------------*/

		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(200, 4, 'Rincian Obat 2 Minggu ' . $pelanggan . '', 0, 1, 'C');

		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(170, 2, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(8, 4.5, 'No', 0, 0, 'L');
		$pdf->Cell(40, 4.5, 'Nama Obat', 0, 0, 'L');
		$pdf->Cell(15, 4.5, 'Dosis', 0, 0, 'L');
		$pdf->Cell(20, 4.5, 'Harga', 0, 0, 'L');
		$pdf->Cell(35, 4.5, 'Kebutuhan 1 Minggu', 0, 0, 'L');
		$pdf->Cell(25, 4.5, 'Subtotal', 0, 0, 'L');
		$pdf->Cell(12, 4.5, 'Disc', 0, 0, 'L');
		$pdf->Cell(21, 4.5, 'Discount', 0, 0, 'L');
		$pdf->Cell(25, 4.5, 'Grand Total', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(130, 3, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();

		$this->load->model('m_barang');
		$this->load->helper('text');

		$nomor = 0;
		$no = 0;
		foreach ($_GET['kode_barang_m'] as $kd) {
			$nomor = $nomor + 1;
			if (!empty($kd)) {
				$nama_barang = $this->m_barang->get_id($kd)->row()->nama_barang;
				$nama_jasa = $this->m_barang->get_id_jasa($kd)->row()->nama_jasa;
				$nama_barang = character_limiter($nama_barang, 20, '..');
				$nama_jasa = character_limiter($nama_jasa, 20, '..');
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(8, 4.5, $nomor, 0, 0, 'L');
				$pdf->Cell(40, 4.5, (!empty($nama_barang)) ? $nama_barang : $nama_jasa, 0, 0, 'L');
				$pdf->Cell(15, 4.5, '' . $_GET['jumlah_beli_m'][$no] . ' X ' . $_GET['jumlah_beli_2_m'][$no], 0, 0, 'L');
				$pdf->Cell(20, 4.5, str_replace(',', '.', 'Rp ' . number_format($_GET['harga_satuan_m'][$no])), 0, 0, 'L');
				$pdf->Cell(35, 4.5, $_GET['kebutuhan_m'][$no], 0, 0, 'C');
				$pdf->Cell(25, 4.5, str_replace(',', '.', 'Rp ' . number_format($_GET['sub_total_awal_m'][$no])), 0, 0, 'L');
				$pdf->Cell(12, 4.5, $_GET['discount_m'][$no] . ' %', 0, 0, 'L');
				$pdf->Cell(21, 4.5, str_replace(',', '.', 'Rp ' . number_format($_GET['discountnya_m'][$no])), 0, 0, 'L');
				$pdf->Cell(25, 4.5, str_replace(',', '.', 'Rp ' . number_format($_GET['sub_total_m'][$no])), 0, 0, 'L');
				$pdf->Ln();

				$no++;
			}
		}

		$pdf->Cell(130, 1, '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetFont('Arial', '', 10);
		$pdf->Cell(8, 5, '', 0, 0, 'L');

		$pdf->Cell(110, 7, 'Total Akhir', 0, 0, 'L');
		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(37, 7, 'Rp ' . str_replace(',', '.', number_format($total_awal_m)), 0, 0, 'L');
		$pdf->Cell(21, 7, 'Rp ' . str_replace(',', '.', number_format($harga_discount_m)), 0, 0, 'L');
		$pdf->Cell(25, 7, 'Rp ' . str_replace(',', '.', number_format($grand_total_m)), 0, 0, 'L');
		$pdf->Ln();

		$output = "Rincian Obat Pasien " . $pelanggan . ".pdf";
		$pdf->Output();
	}

	public function transaksi_cetak()
	{
		$nomor_nota 	= $this->input->get('nomor_nota');
		$tanggal		= $this->input->get('tanggal');
		$id_kasir		= $this->input->get('id_kasir');
		$id_pelanggan	= $this->input->get('id_pelanggan');
		$cash			= $this->input->get('cash');
		$satuan			= $this->input->get('satuan');
		$catatan		= $this->input->get('catatan');
		$grand_total	= $this->input->get('grand_total');
		$nama_herbalis	= $this->input->get('nama_herbalis');
		$sales_pam		= $this->input->get('sales_pam');
		$nrmp		= $this->input->get('nrmp');
		$tanggal_kembali	= $this->input->get('tanggal_kembali');
		$harga_discount = $this->input->get('total_discount');
		$total_awal     = $this->input->get('total_awal');
		$no = 0;
		$discount2	= $_GET['discount'][$no];


		$this->load->model('m_user');
		$kasir = $this->m_user->get_baris($id_kasir)->row()->nama;

		$this->load->model('m_pelanggan');
		$pelanggan = 'umum';
		if (!empty($id_pelanggan)) {
			$pelanggan = $this->m_pelanggan->get_baris($id_pelanggan)->row()->nama;
		}

		$this->load->library('cfpdf');
		$pdf = new FPDF('L', 'mm', 'A5');
		$pdf->SetMargins(10, 5.50, 6.35);
		$pdf->AddPage();
		$pdf->SetFont('Arial', 'b', 14);

		$pdf->Cell(110, 0, 'KPRJ ALKINDI', 0, 0, 'L');

		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(30, 0, 'Kepada Yth :', 0, 1, 'R');

		$pdf->SetFont('Arial', '', 8, 5);
		$pdf->Cell(120, 7, 'JL.IR.JUANDA NO 13 BLOK 4C KEL.KEMIRI MUKA KEC.BEJI, DEPOK, 02177219559,', 0, 0, 'L');
		$pdf->SetFont('Arial', '', 8, 5);
		$pdf->Cell(60, 7, '' . $pelanggan . '', 0, 1, 'L');

		$pdf->Cell(120, 1, '', 0, 0, 'L');

		$pdf->Cell(60, -1, 'JADWAL DATANG KEMBALI : ' . $tanggal_kembali . '', 0, 1, 'L');

		$pdf->Cell(120, 0, '', 0, 0, 'L');
		$pdf->Cell(80, 7, 'HERBALIS : ' . $nama_herbalis . '', 0, 1, 'L');
		$pdf->Cell(120, 0, '', 0, 0, 'L');
		$pdf->Cell(80, -1, 'NRMP : ' . $nrmp . '', 0, 0, 'L');
		$pdf->Ln();
		/*$pdf->Cell(25, 4, 'Nota', 0, 0, 'L'); 
		$pdf->Cell(85, 4, $nomor_nota, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Tanggal', 0, 0, 'L'); 
		$pdf->Cell(85, 4, date('d-M-Y H:i:s', strtotime($tanggal)), 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Kasir', 0, 0, 'L'); 
		$pdf->Cell(85, 4, $kasir, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Pelanggan', 0, 0, 'L'); 
		$pdf->Cell(85, 4, $pelanggan, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Ln();*/

		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(187, 4, 'KWITANSI PEMBELIAN', 0, 1, 'C');

		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(85, 2, 'Tanggal : ' . date('d/m/Y - h:i:s a', strtotime($tanggal)) . '', 0, 0, 'L');
		$pdf->Cell(100, 2.5, 'Sales : ' . $sales_pam . '', 0, 1, 'L');

		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(170, 2, '----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(8, 1.5, 'No', 0, 0, 'L');
		$pdf->Cell(54, 1.5, 'Nama Produk', 0, 0, 'L');
		$pdf->Cell(22, 1.5, 'Qty', 0, 0, 'L');
		$pdf->Cell(23, 1.5, 'Harga', 0, 0, 'L');
		$pdf->Cell(25, 1.5, 'Subtotal', 0, 0, 'L');
		$pdf->Cell(12, 1.5, 'Disc', 0, 0, 'L');
		$pdf->Cell(21, 1.5, 'Discount', 0, 0, 'L');
		$pdf->Cell(25, 1.5, 'Grand Total', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(130, 3, '----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();

		$this->load->model('m_barang');
		$this->load->helper('text');

		$nomor = 0;
		$no = 0;
		foreach ($_GET['kode_barang'] as $kd) {
			$nomor = $nomor + 1;
			if (!empty($kd)) {
				$nama_barang = $this->m_barang->get_id($kd)->row()->nama_barang;
				$nama_jasa = $this->m_barang->get_id_jasa($kd)->row()->nama_jasa;
				$nama_barang = character_limiter($nama_barang, 20, '..');
				$nama_jasa = character_limiter($nama_jasa, 20, '..');
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(8, 3.5, $nomor, 0, 0, 'L');
				$pdf->Cell(54, 3.5, (!empty($nama_barang)) ? $nama_barang : $nama_jasa, 0, 0, 'L');
				$pdf->Cell(22, 3.5, '' . $_GET['jumlah_beli'][$no] . ' ' . $_GET['satuan'][$no], 0, 0, 'L');
				$pdf->Cell(23, 3.5, str_replace(',', '.', 'Rp ' . number_format($_GET['harga_satuan'][$no])), 0, 0, 'L');
				$pdf->Cell(25, 3.5, str_replace(',', '.', 'Rp ' . number_format($_GET['sub_total_awal'][$no])), 0, 0, 'L');
				$pdf->Cell(12, 3.5, $_GET['discount'][$no] . ' %', 0, 0, 'L');
				$pdf->Cell(21, 3.5, str_replace(',', '.', ($_GET['discountnya'][$no])), 0, 0, 'L');
				$pdf->Cell(25, 3.5, str_replace(',', '.', 'Rp ' . number_format($_GET['sub_total'][$no])), 0, 0, 'L');
				$pdf->Ln();

				$no++;
			}
		}

		$pdf->Cell(130, 1, '----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(10, 3, '', 0, 0, 'L');

		$pdf->Cell(30, 3, 'Diterima Oleh,', 0, 0, 'L');
		$pdf->Cell(5, 3, '', 0, 0, 'L');
		$pdf->Cell(30, 3, 'Hormat kami,', 0, 0, 'L');
		$pdf->Cell(6, 3, '', 0, 0, 'L');
		$pdf->Cell(30, 3, 'Gudang', 0, 0, 'L');
		$pdf->Cell(6, 3, '', 0, 0, 'L');
		$pdf->Cell(20, 3, 'Driver', 0, 0, 'L');
		$pdf->Ln();


		$pdf->Cell(41.3, 3, '', 0, 0, 'L');
		$pdf->Cell(20, 3, '', 0, 0, 'L');
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(103.5, -3, 'Sub Total :', 0, 0, 'R');
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(25, -3, 'Rp ' . str_replace(',', '.', number_format($total_awal)), 0, 0, 'L');
		$pdf->Ln();

		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(165, 10, 'Cash Disc :', 0, 0, 'R');
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(25, 10, 'Rp ' . ($harga_discount), 0, 0, 'L');
		$pdf->Ln();

		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(165, -3, 'Grand Total :', 0, 0, 'R');
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(25, -3, 'Rp ' . str_replace(',', '.', number_format($grand_total)), 0, 0, 'L');
		$pdf->Ln();

		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(165, 10, 'Bayar :', 0, 0, 'R');
		$pdf->Cell(25, 10, 'Rp ' . str_replace(',', '.', number_format($cash)), 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(165, -3, 'Kembali :', 0, 0, 'R');
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(25, -3, 'Rp ' . str_replace(',', '.', number_format(($cash - $grand_total))), 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(40, 5, '( ' . $pelanggan . ' )', 0, 0, 'C');
		$pdf->Cell(3.5, -2, '', 0, 0, 'L');
		$pdf->Cell(21, -2, '( KPRJ ALKINDI )', 0, 0, 'C');
		$pdf->Cell(5, -2, '', 0, 0, 'L');
		$pdf->Cell(35, -2, '  (                                  )', 0, 0, 'C');
		$pdf->Cell(2, -2, '', 0, 0, 'L');
		$pdf->Cell(35, -2, '(                                  )', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(130, 12.5, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(25, -9.5, 'Catatan : ', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(130, 14.5, '- maaf, barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(130, -8.5, '- Pemesanan Obat Pasien via online : 0811 1133 881', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(130, 14, (($catatan == '') ? '' : '- ' . $catatan), 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(130, -9.5, '--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');

		$pdf->Ln();
		$pdf->Cell(188, 14, "Terimakasih telah berobat Di klinik Alkindi Herbal", 0, 0, 'C');

		$output = "Kwitansi Pasien " . $pelanggan . ".pdf";
		$pdf->Output();
	}

	public function transaksi_cetak2()
	{
		$nomor_nota 	= $this->input->get('nomor_nota');
		$tanggal		= $this->input->get('tanggal');
		$id_kasir		= $this->input->get('id_kasir');
		$id_pelanggan	= $this->input->get('id_pelanggan');
		$cash			= $this->input->get('cash');
		$catatan		= $this->input->get('catatan');
		$grand_total	= $this->input->get('grand_total');
		$nama_herbalis	= $this->input->get('nama_herbalis');
		$nama_herbalis_ori	= $this->input->get('nama_herbalis_ori');
		$aty_kota		= $this->input->get('aty_kota');
		$NRMP	        = $this->input->get('nrmp');
		$tanggal_kembali = $this->input->get('tanggal_kembali');
		$harga_discount = $this->input->get('total_discount');
		$total_awal     = $this->input->get('total_awal');
		$no = 0;
		$discount2	= $_GET['discount'][$no];

		$this->load->model('m_user');
		$kasir = $this->m_user->get_baris($id_kasir)->row()->nama;

		$this->load->model('m_pelanggan');
		$pelanggan = 'umum';
		if (!empty($id_pelanggan)) {
			$pelanggan = $this->m_pelanggan->get_baris($id_pelanggan)->row()->nama;
		}

		$this->load->library('cfpdf');
		$pdf = new FPDF('L', 'mm', 'A5');
		$pdf->SetMargins(10, 6, 6.35);
		$pdf->AddPage();
		$pdf->SetFont('Arial', 'b', 14);

		$pdf->Cell(110, 0, 'PT ALKINDI', 0, 0, 'L');

		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(30, 0, 'Kepada Yth :', 0, 1, 'R');

		$pdf->SetFont('Arial', '', 8, 5);
		$pdf->Cell(120, 7, 'JL.IR.JUANDA NO 13 BLOK 4C KEL.KEMIRI MUKA KEC.BEJI, DEPOK, 02177219559,', 0, 0, 'L');

		$pdf->Cell(60, 7, '' . $pelanggan . '', 0, 1, 'L');

		$pdf->Cell(120, 1, '', 0, 0, 'L');

		$pdf->Cell(60, -1, 'NRMP  ' . ' : ' . ' ' . $NRMP . '   ' . 'HERBALIS  ' . '  : ' . ' ' . $nama_herbalis_ori . '', 0, 1, 'L');

		$pdf->Cell(120, 0, '', 0, 0, 'L');
		$pdf->Cell(60, 7, 'SALES  ' . ': ' . ' ' . $nama_herbalis . '', 0, 1, 'L');

		$pdf->Cell(120, 0, '', 0, 0, 'L');
		$pdf->Cell(60, -1, 'KOTA  ' . '  : ' . ' ' . $aty_kota . '', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Ln();
		/*$pdf->Cell(25, 4, 'Nota', 0, 0, 'L'); 
		$pdf->Cell(85, 4, $nomor_nota, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Tanggal', 0, 0, 'L'); 
		$pdf->Cell(85, 4, date('d-M-Y H:i:s', strtotime($tanggal)), 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Kasir', 0, 0, 'L'); 
		$pdf->Cell(85, 4, $kasir, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(25, 4, 'Pelanggan', 0, 0, 'L'); 
		$pdf->Cell(85, 4, $pelanggan, 0, 0, 'L');
		$pdf->Ln();
		$pdf->Ln();*/

		$pdf->SetFont('Arial', 'B', 12);
		$pdf->Cell(187, 4, 'KWITANSI PEMBELIAN', 0, 1, 'C');

		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(85, 1, 'Tanggal : ' . date('d/m/Y - h:i:s a', strtotime($tanggal)) . '', 0, 1, 'L');

		$pdf->SetFont('Arial', 'B', 9);
		$pdf->Cell(170, 3.5, '----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(10, 1, 'No', 0, 0, 'L');
		$pdf->Cell(50, 1, 'Nama Produk', 0, 0, 'L');
		$pdf->Cell(15, 1, 'Qty', 0, 0, 'L');
		$pdf->Cell(25, 1, 'Harga', 0, 0, 'L');
		$pdf->Cell(25, 1, 'Subtotal', 0, 0, 'L');
		$pdf->Cell(15, 1, 'Disc', 0, 0, 'L');
		$pdf->Cell(25, 1, 'Discount', 0, 0, 'L');
		$pdf->Cell(30, 1, 'Grand Total', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(130, 3, '----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();

		$this->load->model('m_barang');
		$this->load->helper('text');

		$nomor = 0;
		$no = 0;
		foreach ($_GET['kode_barang'] as $kd) {
			$nomor = $nomor + 1;
			if (!empty($kd)) {
				$nama_barang = $this->m_barang->get_id($kd)->row()->nama_barang;
				$nama_barang2 = $this->m_barang->get_id2($kd)->row()->nama_barang;
				$nama_jasa = $this->m_barang->get_id_jasa($kd)->row()->nama_jasa;
				$nama_barang = character_limiter($nama_barang, 20, '..');
				$nama_jasa = character_limiter($nama_jasa, 20, '..');
				$pdf->SetFont('Arial', '', 9);
				$pdf->Cell(10, 3.5, $nomor, 0, 0, 'L');
				$pdf->Cell(50, 3.5, (!empty($nama_barang)) ? $nama_barang : $nama_barang2, 0, 0, 'L');
				$pdf->Cell(15, 3.5, '' . $_GET['jumlah_beli'][$no] . ' ' . $_GET['satuan'][$no], 0, 0, 'L');
				$pdf->Cell(25, 3.5, str_replace(',', '.', 'Rp ' . number_format($_GET['harga_satuan'][$no])), 0, 0, 'L');
				$pdf->Cell(25, 3.5, str_replace(',', '.', 'Rp ' . number_format($_GET['sub_total_awal'][$no])), 0, 0, 'L');
				$pdf->Cell(15, 3.5, $_GET['discount'][$no], 0, 0, 'L');
				$pdf->Cell(25, 3.5, str_replace(',', '.', ($_GET['discountnya'][$no])), 0, 0, 'L');
				$pdf->Cell(25, 3.5, str_replace(',', '.', 'Rp ' . number_format($_GET['sub_total'][$no])), 0, 0, 'L');
				$pdf->Ln();

				$no++;
			}
		}

		$pdf->Cell(130, 1.5, '----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();


		$pdf->Cell(10, 3, '', 0, 0, 'L');

		$pdf->Cell(30, 3, 'Diterima Oleh,', 0, 0, 'L');
		$pdf->Cell(5, 3, '', 0, 0, 'L');
		$pdf->Cell(30, 3, 'Hormat kami,', 0, 0, 'L');
		$pdf->Cell(5, 3, '', 0, 0, 'L');
		$pdf->Cell(30, 3, 'Gudang', 0, 0, 'L');
		$pdf->Cell(8, 3, '', 0, 0, 'L');
		$pdf->Cell(20, 3, 'Driver', 0, 0, 'L');
		$pdf->Ln();


		$pdf->Cell(41.5, 3, '', 0, 0, 'L');
		$pdf->Cell(20, 5, '', 0, 0, 'L');
		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(103.5, -3, 'Sub Total :', 0, 0, 'R');
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(25, -3, 'Rp ' . str_replace(',', '.', number_format($total_awal)), 0, 0, 'L');
		$pdf->Ln();

		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(165, 10, 'Cash Disc :', 0, 0, 'R');
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(25, 10, 'Rp ' . ($harga_discount), 0, 0, 'L');
		$pdf->Ln();

		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(165, -3, 'Grand Total :', 0, 0, 'R');
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(25, -3, 'Rp ' . str_replace(',', '.', number_format($grand_total)), 0, 0, 'L');
		$pdf->Ln();

		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(165, 10, 'Bayar :', 0, 0, 'R');
		$pdf->Cell(25, 10, 'Rp ' . str_replace(',', '.', number_format($cash)), 0, 0, 'L');
		$pdf->Ln();

		$pdf->SetFont('Arial', 'B', 8);
		$pdf->Cell(165, -3, 'Kembali :', 0, 0, 'R');
		$pdf->SetFont('Arial', '', 8);
		$pdf->Cell(25, -3, 'Rp ' . str_replace(',', '.', number_format(($cash - $grand_total))), 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(40, 17, '( ' . $pelanggan . ' )', 0, 0, 'C');
		$pdf->Cell(5, 10, '', 0, 0, 'L');
		$pdf->Cell(20, 10, '( PT ALKINDI )', 0, 0, 'C');
		$pdf->Cell(5, 10, '', 0, 0, 'L');
		$pdf->Cell(35, 10, '  (                                  )', 0, 0, 'C');
		$pdf->Cell(2, 10, '', 0, 0, 'L');
		$pdf->Cell(35, 10, '(                                  )', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(130, 0.5, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(25, 3, 'Catatan : ', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(130, 3, '- maaf, barang yang sudah dibeli tidak dapat ditukar atau dikembalikan.', 0, 0, 'L');
		$pdf->Ln();
		$pdf->Cell(130, 3, (($catatan == '') ? '' : '- ' . $catatan), 0, 0, 'L');
		$pdf->Ln();

		$pdf->Cell(130, 1, '---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------', 0, 0, 'L');

		$pdf->Ln();
		$pdf->Ln();
		$pdf->Cell(188, 0, "Terimakasih telah berobat Di Klinik Alkindi Herbal", 0, 0, 'C');

		/*$output="Kwitansi Pasien ".$pelanggan.".pdf";*/
		$pdf->Output();/*$output,'D'*/
	}

	public function ajax_pelanggan()
	{
		if ($this->input->is_ajax_request()) {
			$id_pelanggan = $this->input->post('id_pelanggan');
			$this->load->model('m_pelanggan');
			$this->load->model('m_penjualan_master');

			$data = $this->m_pelanggan->get_baris2($id_pelanggan)->row();
			$json['telp']			= (!empty($data->telp)) ? $data->telp : "<small><i>Tidak ada</i></small>";
			$json['alamat']			= (!empty($data->alamat)) ? preg_replace("/\r\n|\r|\n/", '<br />', $data->alamat) : "<small><i>Tidak ada</i></small>";
			$json['info_tambahan']	= (!empty($data->info_tambahan)) ? preg_replace("/\r\n|\r|\n/", '<br />', $data->info_tambahan) : "<small><i>Tidak ada</i></small>";
			$json['herbalis']		= $data->id_herbalis;
			$json['nrmp']			= $data->nrmp;
			$json['tgl_kembali']	= $data->tgl_kembali;
			$json['nama']	= $data->nama;
			echo json_encode($json);
		}
	}

	public function ajax_pelanggan_jmo()
	{
		if ($this->input->is_ajax_request()) {
			$id_pelanggan = $this->input->post('id_pelanggan');
			$this->load->model('m_pelanggan');

			$data = $this->m_pelanggan->get_baris2_jmo($id_pelanggan)->row();
			$json['telp']			= (!empty($data->telp)) ? $data->telp : "<small><i>Tidak ada</i></small>";
			$json['alamat']			= (!empty($data->alamat)) ? preg_replace("/\r\n|\r|\n/", '<br />', $data->alamat) : "<small><i>Tidak ada</i></small>";
			$json['info_tambahan']	= (!empty($data->info_tambahan)) ? preg_replace("/\r\n|\r|\n/", '<br />', $data->info_tambahan) : "<small><i>Tidak ada</i></small>";
			$json['herbalis']		= $data->id_herbalis;
			$json['nrmp']			= $data->nrmp;
			$json['tgl_kembali']	= $data->tgl_kembali;
			$json['nama']	= $data->nama;
			echo json_encode($json);
		}
	}

	public function ajax_pelanggan2()
	{
		if ($this->input->is_ajax_request()) {
			$id_pelanggan = $this->input->post('id_pelanggan');
			$this->load->model('m_pelanggan');

			$data = $this->m_pelanggan->get_baris3($id_pelanggan)->row();
			$data2 = $this->m_pelanggan->get_baris_herbalis($id_pelanggan)->row();
			$json['telp']			= (!empty($data->telp)) ? $data->telp : "<small><i>Tidak ada</i></small>";
			$json['alamat']			= (!empty($data->alamat)) ? preg_replace("/\r\n|\r|\n/", '<br />', $data->alamat) : "<small><i>Tidak ada</i></small>";
			$json['info_tambahan']	= (!empty($data->info_tambahan)) ? preg_replace("/\r\n|\r|\n/", '<br />', $data->info_tambahan) : "<small><i>Tidak ada</i></small>";
			$json['herbalis']		= $data->sales;
			$json['herbalis_online']	= $data2->nama_herbalis;
			$json['nrmp']			= $data->nrmp;
			$json['tgl_kembali']	= $data->tgl_kembali;
			echo json_encode($json);
		}
	}


	public function ajax_kode_rincian()
	{
		if ($this->input->is_ajax_request()) {
			$keyword 	= $this->input->post('keyword');
			$registered	= $this->input->post('registered');

			$this->load->model('m_barang');

			$barang = $this->m_barang->cari_kode($keyword, $registered);
			/* $jasa = $this->m_barang->cari_kode_jasa($keyword, $registered); */

			if ($barang->num_rows() > 0) {
				$json['status'] 	= 1;
				$json['datanya'] 	= "<ul id='daftar-autocomplete' style='width:300px'>";
				foreach ($barang->result() as $b) {
					$json['datanya'] .= "
							<li> 
								
								<b>Tgl Masuk</b> : 
								<span id='tanggalnya'>" . $b->tanggal_masuk . "</span> <br />
								<b>Nama</b> : <br />
								<span id='barangnya'>" . $b->nama_barang . "</span>
								<span id='kodenya'>" . $b->kode_barang . "</span> <br/>
								<b>Harga</b> : <br />
								<span id='harganya' >" . $b->harga . "</span><br />
								
								<span id='isinya' style='display:none;'>" . $b->total_isi . "</span> 
								<span id='satuannya' style='display:none;'>" . $b->satuan . "</span>
							</li>
						";
				}

				$json['datanya'] .= "</ul>";
			}

			/*else if ($jasa->num_rows() > 0) {
				$json['status'] 	= 1;
				$json['datanya'] 	= "<ul id='daftar-autocomplete'>";
					foreach($jasa->result() as $b)
					{
						$json['datanya'] .= "
							<li>
								<b>Kode</b> : 
								<span id='kodenya'>".$b->kode_barang."</span> <br />
								<span id='barangnya'>".$b->nama_jasa."</span>
								<span id='harganya' style='display:none;'>".$b->harga."</span>
							</li>
						";
					}
				
				$json['datanya'] .= "</ul>";
				
			}*/ else {
				$json['status'] 	= 0;
			}

			echo json_encode($json);
		}
	}

	public function ajax_kode()
	{
		if ($this->input->is_ajax_request()) {
			$keyword 	= $this->input->post('keyword');
			$registered	= $this->input->post('registered');

			$this->load->model('m_barang');

			$barang = $this->m_barang->cari_kode($keyword, $registered);/*
			$jasa = $this->m_barang->cari_kode_jasa($keyword, $registered);*/

			if ($barang->num_rows() > 0) {
				$json['status'] 	= 1;
				$json['datanya'] 	= "<ul id='daftar-autocomplete' style='width:300px'>";
				foreach ($barang->result() as $b) {
					$json['datanya'] .= "
							<li> 
								
								<b>Tgl Masuk</b> : 
								<span id='tanggalnya'>" . $b->tanggal_masuk . "</span> <br />
								<b>Nama</b> : <br />
								<span id='barangnya'>" . $b->nama_barang . "</span>
								<span id='kodenya'>" . $b->kode_barang . "</span> <br/>
								<b>Stok</b> : <br />
								<span id='stoknya'>" . $b->total_stok . "</span> <br />
								<span id='satuannya' style='display:none;'>" . $b->satuan . "</span>
								<span id='harganya' style='display:none;'>" . $b->harga . "</span>
							</li>
						";
				}

				$json['datanya'] .= "</ul>";
			}

			/*else if ($jasa->num_rows() > 0) {
				$json['status'] 	= 1;
				$json['datanya'] 	= "<ul id='daftar-autocomplete'>";
					foreach($jasa->result() as $b)
					{
						$json['datanya'] .= "
							<li>
								<b>Kode</b> : 
								<span id='kodenya'>".$b->kode_barang."</span> <br />
								<span id='barangnya'>".$b->nama_jasa."</span>
								<span id='harganya' style='display:none;'>".$b->harga."</span>
							</li>
						";
					}
				
				$json['datanya'] .= "</ul>";
				
			}*/ else {
				$json['status'] 	= 0;
			}

			echo json_encode($json);
		}
	}

	public function ajax_kode2()
	{
		if ($this->input->is_ajax_request()) {
			$keyword 	= $this->input->post('keyword');
			$registered	= $this->input->post('registered');

			$this->load->model('m_barang');

			$barang = $this->m_barang->cari_kode2($keyword, $registered);
			/*$jasa = $this->m_barang->cari_kode_jasa($keyword, $registered);*/

			if ($barang->num_rows() > 0) {
				$json['status'] 	= 1;
				$json['datanya'] 	= "<ul id='daftar-autocomplete'>";
				foreach ($barang->result() as $b) {
					$json['datanya'] .= "
							<li>
								<b>Nama</b> :
								<span id='barangnya'>" . $b->nama_barang . "</span>
								<span id='kodenya'>" . $b->kode_barang . "</span> <br/>
								<b>Stok</b> :
								<span id='stoknya'>" . $b->total_stok . "</span> <br />
								<span id='satuannya' style='display:none;'>" . $b->satuan . "</span>
								<span id='harganya' style='display:none;'>" . $b->harga . "</span>
							</li>
						";
				}

				$json['datanya'] .= "</ul>";
			}

			/*else if ($jasa->num_rows() > 0) {
				$json['status'] 	= 1;
				$json['datanya'] 	= "<ul id='daftar-autocomplete'>";
					foreach($jasa->result() as $b)
					{
						$json['datanya'] .= "
							<li>
								<b>Kode</b> : 
								<span id='kodenya'>".$b->kode_barang."</span> <br />
								<span id='barangnya'>".$b->nama_jasa."</span>
								<span id='harganya' style='display:none;'>".$b->harga."</span>
							</li>
						";
					}
				
				$json['datanya'] .= "</ul>";
				
			}*/ else {
				$json['status'] 	= 0;
			}

			echo json_encode($json);
		}
	}

	public function cek_kode_barang($kode)
	{
		$this->load->model('m_barang');
		$cek_kode = $this->m_barang->cek_kode($kode);

		if ($cek_kode->num_rows() > 0) {
			return TRUE;
		}
		return FALSE;
	}

	public function cek_nol($qty)
	{
		if ($qty > 0) {
			return TRUE;
		}
		return FALSE;
	}

	public function history_medan_acc()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory' or $level == 'resepsionis') {
			/*$this->output->cache(0.1);*/
			$this->load->view('penjualan/transaksi_history_maudiacc_medan');
		}
	}

	public function history_asuransi_acc()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory' or $level == 'resepsionis') {
			/*$this->output->cache(0.1);*/
			$this->load->view('penjualan/transaksi_history_maudiacc_asuransi');
		}
	}

	public function history_acc_apotek()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory' or $level == 'resepsionis') {
			/*$this->output->cache(0.1);*/
			$this->load->view('penjualan/transaksi_history_maudiacc');
		}
	}

	public function history_acc_apotek_online()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory' or $level == 'resepsionis') {
			/*$this->output->cache(0.1);*/
			$this->load->view('penjualan/transaksi_history_maudiacc_online');
		}
	}

	public function history_PAM()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
			/*$this->output->cache(0.1);*/
			$this->load->view('penjualan/transaksi_history_PAM');
		}
	}

	public function history()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory' or $level == 'resepsionis') {
			/*$this->output->cache(0.1);*/
			$this->load->view('penjualan/transaksi_history');
		}
	}

	public function history_hapus_klinik()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin') {
			$this->load->view('penjualan/transaksi_history_hapus_klinik');
		}
	}

	public function history_hapus_online()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin') {
			$this->load->view('penjualan/transaksi_history_hapus_online');
		}
	}


	public function history_medan()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory' or $level == 'resepsionis') {
			/*$this->output->cache(0.1);*/
			$this->load->view('penjualan/transaksi_history_medan');
		}
	}

	public function history_asuransi()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory' or $level == 'resepsionis') {
			/*$this->output->cache(0.1);*/
			$this->load->view('penjualan/transaksi_history_asuransi');
		}
	}

	public function history_online()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory' or $level == 'resepsionis') {
			/* $this->output->cache(0.1);*/
			$this->load->view('penjualan/transaksi_history_online');
		}
	}

	public function transaksi_pending()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			/* $this->output->cache(0.1);*/
			$this->load->view('penjualan/transaksi_pending');
		}
	}

	public function transaksi_pending_klinik()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			/*$this->output->cache(0.1);*/
			$this->load->view('penjualan/transaksi_pending_klinik');
		}
	}

	public function history_json_pending()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->fetch_data_penjualan_pending($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='" . site_url('penjualan/detail-transaksi2/' . $row['id_penjualan_m']) . "' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> " . $row['nomor_nota'] . "</a>";
			$nestedData[]	= $row['grand_total'];
			$nestedData[]	= $row['nama_pelanggan'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			if ($level == 'admin' or $level == 'keuangan' or $level == 'kasir') {
				$nestedData[]	= "<a href='" . site_url('penjualan/edit_transaksi_pending_online
					/' . $row['id_penjualan_m']) . "'><i class='fa fa-pencil-square-o'></i> Edit</a>";

				$nestedData[]	= "<a href='" . site_url('penjualan/acc_transaksi2_pending/' . $row['id_penjualan_m']) . "' id='HapusTransaksi'><i class='fa fa-check'></i> ACC</a>";

				$nestedData[]	= "<a href='" . site_url('penjualan/hapus_transaksi_online/' . $row['id_penjualan_m']) . "' id='HapusTransaksi'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function history_json_pending_klinik()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->fetch_data_penjualan_pending_klinik($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='" . site_url('penjualan/detail-transaksi/' . $row['id_penjualan_m']) . "' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> " . $row['nomor_nota'] . "</a>";
			$nestedData[]	= $row['grand_total'];
			$nestedData[]	= $row['nama_pelanggan'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			if ($level == 'admin' or $level == 'keuangan' or $level == 'kasir') {
				$nestedData[]	= "<a href='" . site_url('penjualan/edit_transaksi_pending
					/' . $row['id_penjualan_m']) . "'><i class='fa fa-pencil-square-o'></i> Edit</a>";

				$nestedData[]	= "<a href='" . site_url('penjualan/acc_transaksi_pending/' . $row['id_penjualan_m']) . "' id='HapusTransaksi'><i class='fa fa-check'></i> ACC</a>";

				$nestedData[]	= "<a href='" . site_url('penjualan/hapus_transaksi/' . $row['id_penjualan_m']) . "' id='HapusTransaksi'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function history_json_medan()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->fetch_data_medan($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='" . site_url('penjualan/detail_transaksi_medan/' . $row['id_medan_m']) . "' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> " . $row['nomor_nota'] . "</a>";
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {/*
			    $nestedData[]	= "<a href='".site_url('penjualan/edit_transaksi
					/'.$row['id_asuransi_m'])."'><i class='fa fa-pencil-square-o'></i> Edit</a>";*/

				$nestedData[]	= "<a href='" . site_url('penjualan/hapus_transaksi_medan/' . $row['id_medan_m']) . "' id='HapusTransaksi'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function history_json_asuransi()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->fetch_data_asuransi($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='" . site_url('penjualan/detail_transaksi_asuransi/' . $row['id_asuransi_m']) . "' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> " . $row['nomor_nota'] . "</a>";
			$nestedData[]	= $row['nama_pelanggan'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {/*
			    $nestedData[]	= "<a href='".site_url('penjualan/edit_transaksi
					/'.$row['id_asuransi_m'])."'><i class='fa fa-pencil-square-o'></i> Edit</a>";*/

				$nestedData[]	= "<a href='" . site_url('penjualan/hapus_transaksi_asuransi/' . $row['id_asuransi_m']) . "' id='HapusTransaksi'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function history_json()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->fetch_data_penjualan($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='" . site_url('penjualan/detail_transaksi/' . $row['id_penjualan_m']) . "' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> " . $row['nomor_nota'] . "</a>";
			$nestedData[]	= $row['grand_total'];
			$nestedData[]	= $row['nama_pelanggan'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('penjualan/edit_transaksi
					/' . $row['id_penjualan_m']) . "'><i class='fa fa-pencil-square-o'></i> Edit</a>";

				$nestedData[]	= "<a href='" . site_url('penjualan/hapus_transaksi_sementara/' . $row['id_penjualan_m']) . "' id='HapusTransaksi'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function history_json_hapus_klinik()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->fetch_data_penjualan_hapus_klinik($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='" . site_url('penjualan/detail_transaksi/' . $row['id_penjualan_m']) . "' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> " . $row['nomor_nota'] . "</a>";
			$nestedData[]	= $row['grand_total'];
			$nestedData[]	= $row['nama_pelanggan'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir_hapus'];

			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('penjualan/hapus_transaksi/' . $row['id_penjualan_m']) . "' id='HapusTransaksi'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function history_json_hapus_online()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->fetch_data_penjualan_hapus_online($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='" . site_url('penjualan/detail_transaksi/' . $row['id_penjualan_m']) . "' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> " . $row['nomor_nota'] . "</a>";
			$nestedData[]	= $row['grand_total'];
			$nestedData[]	= $row['nama_pelanggan'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir_hapus'];

			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('penjualan/hapus_transaksi/' . $row['id_penjualan_m']) . "' id='HapusTransaksi'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function history_json_PAM()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->fetch_data_penjualan_PAM($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='" . site_url('penjualan/detail-transaksi/' . $row['id_penjualan_m']) . "' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> " . $row['nomor_nota'] . "</a>";
			$nestedData[]	= $row['grand_total'];
			$nestedData[]	= $row['nama_pelanggan'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('penjualan/edit_transaksi
					/' . $row['id_penjualan_m']) . "'><i class='fa fa-pencil-square-o'></i> Edit</a>";

				$nestedData[]	= "<a href='" . site_url('penjualan/hapus-transaksi/' . $row['id_penjualan_m']) . "' id='HapusTransaksi'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function edit_transaksi($id_penjualan)
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			if ($_POST) {
				if (!empty($_POST['kode_barang'])) {
					$total = 0;
					foreach ($_POST['kode_barang'] as $k) {
						if (!empty($k)) {
							$total++;
						}
					}

					if ($total > 0) {
						$this->load->library('form_validation');
						/*$this->form_validation->set_rules('nomor_nota','Nomor Nota','trim|required|max_length[40]|alpha_numeric|callback_cek_nota[nomor_nota]');*/
						$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');

						$no = 0;
						foreach ($_POST['kode_barang'] as $d) {
							if (!empty($d)) {/*
								$this->form_validation->set_rules('kode_barang['.$no.']','Kode Barang #'.($no + 1), 'trim|required|max_length[40]|callback_cek_kode_barang[kode_barang['.$no.']]');*/
								$this->form_validation->set_rules('jumlah_beli[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli[' . $no . ']]');
							}

							$no++;
						}

						$this->form_validation->set_rules('cash', 'Total Bayar', 'trim|numeric|required|max_length[17]');
						$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');/*
						$this->form_validation->set_message('cek_nota', '%s sudah ada');*/
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nomor_nota 	= $this->input->post('nomor_nota');
							$tanggal		= $this->input->post('tanggal');
							$id_kasir		= $this->input->post('id_kasir');
							$id_pelanggan	= $this->input->post('id_pelanggan');
							$id_herbalis	= $this->input->post('nama_herbalis');
							$bayar			= $this->input->post('cash');
							$grand_total	= $this->input->post('grand_total');
							$harga_discount = $this->input->post('total_discount');
							$total_awal     = $this->input->post('total_awal');
							$tanggal_kembali	= $this->input->post('tanggal_kembali');
							$catatan		= $this->clean_tag_input($this->input->post('catatan'));
							$sales_pam		= $this->input->post('sales_pam');

							if ($bayar < $grand_total) {
								$this->query_error("Cash Kurang");
							} else {
								$this->load->model('m_penjualan_master');
								if ($tanggal_kembali == '') {
									$master = $this->m_penjualan_master->update_master_tanpatanggal($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $sales_pam);
								} else {

									$master = $this->m_penjualan_master->update_master($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $tanggal_kembali, $sales_pam);
								}
								if ($master) {
									$id_master 	= $this->m_penjualan_master->get_id($nomor_nota)->row()->id_penjualan_m;
									$inserted	= 0;

									$this->load->model('m_penjualan_detail');
									$this->load->model('m_barang');

									$no_array	= 0;
									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$id_detail 	= $_POST['iddd'][$no_array];
											$kode_barang 	= $_POST['kode_barang'][$no_array];
											$jumlah_beli 	= $_POST['jumlah_beli'][$no_array];
											$harga_satuan 	= $_POST['harga_satuan'][$no_array];
											$satuan 		= $_POST['satuan'][$no_array];
											$discount 		= $_POST['discount'][$no_array];
											$discountnya 	= $_POST['discountnya'][$no_array];
											$sub_total 		= $_POST['sub_total_awal'][$no_array];
											$grand_total 	= $_POST['sub_total'][$no_array];
											$id_barang		= $this->m_barang->get_id($kode_barang)->row()->id_barang;

											$insert_detail	= $this->m_penjualan_detail->update_detail2($id_detail, $id_master, $id_barang, $jumlah_beli, $satuan, $harga_satuan, $discount, $discountnya, $sub_total, $grand_total, $tanggal, $id_herbalis, $id_pelanggan, $sales_pam);

											/*
											$this->m_barang->update_stok($id_barang, $jumlah_beli);*/
											if ($insert_detail) {
												$this->m_penjualan_detail->update_pelanggan2($id_herbalis, $id_pelanggan, $tanggal_kembali);
												$inserted++;
											}
										}

										$no_array++;
									}

									if ($inserted > 0) {
										echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
									} else {
										$this->query_error();
									}
								} else {
									$this->query_error();
								}
							}
						} else {
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ", "</font><br />")));
						}
					} else {
						$this->query_error("Harap masukan minimal 1 kode barang !");
					}
				} else {
					$this->query_error("Harap masukan minimal 1 kode barang !");
				}
			} else {
				$this->load->model('m_user');
				$this->load->model('m_pelanggan');

				$this->load->model('m_penjualan_detail');
				$this->load->model('m_penjualan_master');

				$dt['detail'] = $this->m_penjualan_detail->get_detail($id_penjualan);
				$dt['master'] = $this->m_penjualan_master->get_baris_edit($id_penjualan)->row();

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['pelanggan'] = $this->m_pelanggan->get_all();
				$dt['herbalis'] = $this->m_pelanggan->get_all_herbalis();

				$this->m_penjualan_master->hapus_transaksi2($id_penjualan);
				$this->output->cache(0.1);
				$this->load->view('penjualan/transaksi_edit', $dt);
			}
		}
	}


	public function edit_transaksi_rincian($id_penjualan)
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			if ($_POST) {
				if (!empty($_POST['kode_barang'])) {
					$total = 0;
					foreach ($_POST['kode_barang'] as $k) {
						if (!empty($k)) {
							$total++;
						}
					}

					if ($total > 0) {
						$this->load->library('form_validation');
						/*$this->form_validation->set_rules('nomor_nota','Nomor Nota','trim|required|max_length[40]|alpha_numeric|callback_cek_nota[nomor_nota]');*/
						$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');

						$no = 0;
						foreach ($_POST['kode_barang'] as $d) {
							if (!empty($d)) {/*
								$this->form_validation->set_rules('kode_barang['.$no.']','Kode Barang #'.($no + 1), 'trim|required|max_length[40]|callback_cek_kode_barang[kode_barang['.$no.']]');*/
								$this->form_validation->set_rules('jumlah_beli[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli[' . $no . ']]');
							}

							$no++;
						}

						$this->form_validation->set_rules('cash', 'Total Bayar', 'trim|numeric|required|max_length[17]');
						$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');/*
						$this->form_validation->set_message('cek_nota', '%s sudah ada');*/
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nomor_nota 	= $this->input->post('nomor_nota');
							$tanggal		= $this->input->post('tanggal');
							$id_kasir		= $this->input->post('id_kasir');
							$id_pelanggan	= $this->input->post('id_pelanggan');
							$id_herbalis	= $this->input->post('nama_herbalis');
							$bayar			= $this->input->post('cash');
							$grand_total	= $this->input->post('grand_total');
							$harga_discount = $this->input->post('total_discount');
							$total_awal     = $this->input->post('total_awal');
							$tanggal_kembali	= $this->input->post('tanggal_kembali');
							$catatan		= $this->clean_tag_input($this->input->post('catatan'));
							$sales_pam		= $this->input->post('sales_pam');

							if ($bayar < $grand_total) {
								$this->query_error("Cash Kurang");
							} else {
								$this->load->model('m_penjualan_master');
								if ($tanggal_kembali == '') {
									$master = $this->m_penjualan_master->update_master_tanpatanggal($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $sales_pam);
								} else {

									$master = $this->m_penjualan_master->update_master($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $tanggal_kembali, $sales_pam);
								}
								if ($master) {
									$id_master 	= $this->m_penjualan_master->get_id($nomor_nota)->row()->id_penjualan_m;
									$inserted	= 0;

									$this->load->model('m_penjualan_detail');
									$this->load->model('m_barang');

									$no_array	= 0;
									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$id_detail 	= $_POST['iddd'][$no_array];
											$kode_barang 	= $_POST['kode_barang'][$no_array];
											$jumlah_beli 	= $_POST['jumlah_beli'][$no_array];
											$harga_satuan 	= $_POST['harga_satuan'][$no_array];
											$satuan 		= $_POST['satuan'][$no_array];
											$discount 		= $_POST['discount'][$no_array];
											$discountnya 	= $_POST['discountnya'][$no_array];
											$sub_total 		= $_POST['sub_total_awal'][$no_array];
											$grand_total 	= $_POST['sub_total'][$no_array];
											$id_barang		= $this->m_barang->get_id($kode_barang)->row()->id_barang;

											$insert_detail	= $this->m_penjualan_detail->update_detail2($id_detail, $id_master, $id_barang, $jumlah_beli, $satuan, $harga_satuan, $discount, $discountnya, $sub_total, $grand_total, $tanggal, $id_herbalis, $id_pelanggan, $sales_pam);

											/*
											$this->m_barang->update_stok($id_barang, $jumlah_beli);*/
											if ($insert_detail) {
												$this->m_penjualan_detail->update_pelanggan2($id_herbalis, $id_pelanggan, $tanggal_kembali);
												$inserted++;
											}
										}

										$no_array++;
									}

									if ($inserted > 0) {
										echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
									} else {
										$this->query_error();
									}
								} else {
									$this->query_error();
								}
							}
						} else {
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ", "</font><br />")));
						}
					} else {
						$this->query_error("Harap masukan minimal 1 kode barang !");
					}
				} else {
					$this->query_error("Harap masukan minimal 1 kode barang !");
				}
			} else {
				$this->load->model('m_user');
				$this->load->model('m_pelanggan');

				$this->load->model('m_penjualan_detail');
				$this->load->model('m_penjualan_master');

				$dt['detail'] = $this->m_penjualan_detail->get_detail_rincian($id_penjualan);
				$dt['master'] = $this->m_penjualan_master->get_baris_edit_rincian($id_penjualan)->row();

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['pelanggan'] = $this->m_pelanggan->get_all();
				$dt['herbalis'] = $this->m_pelanggan->get_all_herbalis();

				$this->m_penjualan_master->hapus_transaksi2($id_penjualan);
				$this->output->cache(0.1);
				$this->load->view('penjualan/transaksi_edit_rincian', $dt);
			}
		}
	}

	public function edit_transaksi_pending($id_penjualan)
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			if ($_POST) {
				if (!empty($_POST['kode_barang'])) {
					$total = 0;
					foreach ($_POST['kode_barang'] as $k) {
						if (!empty($k)) {
							$total++;
						}
					}

					if ($total > 0) {
						$this->load->library('form_validation');
						/*$this->form_validation->set_rules('nomor_nota','Nomor Nota','trim|required|max_length[40]|alpha_numeric|callback_cek_nota[nomor_nota]');*/
						$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');

						$no = 0;
						foreach ($_POST['kode_barang'] as $d) {
							if (!empty($d)) {/*
								$this->form_validation->set_rules('kode_barang['.$no.']','Kode Barang #'.($no + 1), 'trim|required|max_length[40]|callback_cek_kode_barang[kode_barang['.$no.']]');*/
								$this->form_validation->set_rules('jumlah_beli[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli[' . $no . ']]');
							}

							$no++;
						}

						$this->form_validation->set_rules('cash', 'Total Bayar', 'trim|numeric|required|max_length[17]');
						$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');/*
						$this->form_validation->set_message('cek_nota', '%s sudah ada');*/
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nomor_nota 	= $this->input->post('nomor_nota');
							$tanggal		= $this->input->post('tanggal');
							$id_kasir		= $this->input->post('id_kasir');
							$id_pelanggan	= $this->input->post('id_pelanggan');
							$id_herbalis	= $this->input->post('nama_herbalis');
							$bayar			= $this->input->post('cash');
							$grand_total	= $this->input->post('grand_total');
							$harga_discount = $this->input->post('total_discount');
							$total_awal     = $this->input->post('total_awal');
							$tanggal_kembali	= $this->input->post('tanggal_kembali');
							$catatan		= $this->clean_tag_input($this->input->post('catatan'));
							$sales_pam		= $this->input->post('sales_pam');

							if ($bayar < $grand_total) {
								$this->query_error("Cash Kurang");
							} else {
								$this->load->model('m_penjualan_master');
								if ($tanggal_kembali == '') {
									$master = $this->m_penjualan_master->update_master_tanpatanggal($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $sales_pam);
								} else {

									$master = $this->m_penjualan_master->update_master($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis, $bayar, $grand_total, $catatan, $tanggal_kembali, $sales_pam);
								}
								if ($master) {
									$id_master 	= $this->m_penjualan_master->get_id($nomor_nota)->row()->id_penjualan_m;
									$inserted	= 0;

									$this->load->model('m_penjualan_detail');
									$this->load->model('m_barang');

									$no_array	= 0;
									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$id_detail 	= $_POST['iddd'][$no_array];
											$kode_barang 	= $_POST['kode_barang'][$no_array];
											$jumlah_beli 	= $_POST['jumlah_beli'][$no_array];
											$harga_satuan 	= $_POST['harga_satuan'][$no_array];
											$satuan 		= $_POST['satuan'][$no_array];
											$discount 		= $_POST['discount'][$no_array];
											$discountnya 	= $_POST['discountnya'][$no_array];
											$sub_total 		= $_POST['sub_total_awal'][$no_array];
											$grand_total 	= $_POST['sub_total'][$no_array];
											$id_barang		= $this->m_barang->get_id($kode_barang)->row()->id_barang;

											$insert_detail	= $this->m_penjualan_detail->update_detail2($id_detail, $id_master, $id_barang, $jumlah_beli, $satuan, $harga_satuan, $discount, $discountnya, $sub_total, $grand_total, $tanggal, $id_herbalis, $id_pelanggan, $sales_pam);

											/*
											$this->m_barang->update_stok($id_barang, $jumlah_beli);*/
											if ($insert_detail) {
												$this->m_penjualan_detail->update_pelanggan2($id_herbalis, $id_pelanggan, $tanggal_kembali);
												$inserted++;
											}
										}

										$no_array++;
									}

									if ($inserted > 0) {
										echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
									} else {
										$this->query_error();
									}
								} else {
									$this->query_error();
								}
							}
						} else {
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ", "</font><br />")));
						}
					} else {
						$this->query_error("Harap masukan minimal 1 kode barang !");
					}
				} else {
					$this->query_error("Harap masukan minimal 1 kode barang !");
				}
			} else {
				$this->load->model('m_user');
				$this->load->model('m_pelanggan');

				$this->load->model('m_penjualan_detail');
				$this->load->model('m_penjualan_master');

				$dt['detail'] = $this->m_penjualan_detail->get_detail($id_penjualan);
				$dt['master'] = $this->m_penjualan_master->get_baris_edit($id_penjualan)->row();

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['pelanggan'] = $this->m_pelanggan->get_all();
				$dt['herbalis'] = $this->m_pelanggan->get_all_herbalis();

				$this->m_penjualan_master->hapus_transaksi2($id_penjualan);
				$this->load->view('penjualan/transaksi_edit', $dt);
			}
		}
	}

	public function edit_transaksi_pending_online($id_penjualan)
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			if ($_POST) {
				if (!empty($_POST['kode_barang'])) {
					$total = 0;
					foreach ($_POST['kode_barang'] as $k) {
						if (!empty($k)) {
							$total++;
						}
					}

					if ($total > 0) {
						$this->load->library('form_validation');
						/*	$this->form_validation->set_rules('nomor_nota','Nomor Nota','trim|required|max_length[40]|alpha_numeric|callback_cek_nota[nomor_nota]');*/
						$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');

						$no = 0;
						foreach ($_POST['kode_barang'] as $d) {
							if (!empty($d)) {/*
								$this->form_validation->set_rules('kode_barang['.$no.']','Kode Barang #'.($no + 1), 'trim|required|max_length[40]|callback_cek_kode_barang[kode_barang['.$no.']]');*/
								$this->form_validation->set_rules('jumlah_beli[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli[' . $no . ']]');
							}

							$no++;
						}

						$this->form_validation->set_rules('cash', 'Total Bayar', 'trim|numeric|required|max_length[17]');
						$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nota', '%s sudah ada');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nomor_nota 	= $this->input->post('nomor_nota');
							$tanggal		= $this->input->post('tanggal');
							$id_kasir		= $this->input->post('id_kasir');
							$id_pelanggan	= $this->input->post('id_pelanggan');
							$id_herbalis_ori = $this->input->post('nama_herbalis_ori');
							$id_herbalis	= $this->input->post('nama_herbalis');
							$aty_kota		= $this->input->post('aty_kota');
							$bayar			= $this->input->post('cash');
							$grand_total	= $this->input->post('grand_total');
							$harga_discount = $this->input->post('total_discount');
							$total_awal     = $this->input->post('total_awal');
							$tanggal_kembali	= $this->input->post('tanggal_kembali');
							$catatan		= $this->clean_tag_input($this->input->post('catatan'));

							if ($bayar < $grand_total) {
								$this->query_error("Cash Kurang");
							} else {
								$this->load->model('m_penjualan_master');

								if ($tanggal_kembali == '') {
									$master = $this->m_penjualan_master->insert_master2_tanpatanggal($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis_ori, $id_herbalis, $aty_kota, $bayar, $grand_total, $catatan);
								} else {

									$master = $this->m_penjualan_master->insert_master2($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis_ori, $id_herbalis, $aty_kota, $bayar, $grand_total, $catatan, $tanggal_kembali);
								}

								if ($master) {
									$id_master 	= $this->m_penjualan_master->get_id($nomor_nota)->row()->id_penjualan_m;
									$inserted	= 0;

									$this->load->model('m_penjualan_detail');
									$this->load->model('m_barang');

									$no_array	= 0;
									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$kode_barang 	= $_POST['kode_barang'][$no_array];
											$jumlah_beli 	= $_POST['jumlah_beli'][$no_array];
											$harga_satuan 	= $_POST['harga_satuan'][$no_array];
											$satuan 		= $_POST['satuan'][$no_array];
											$discount 		= $_POST['discount'][$no_array];
											$discountnya 	= $_POST['discountnya'][$no_array];
											$sub_total 		= $_POST['sub_total_awal'][$no_array];
											$grand_total 	= $_POST['sub_total'][$no_array];
											$id_barang		= $this->m_barang->get_id_online($kode_barang)->row()->id_barang;

											$insert_detail	= $this->m_penjualan_detail->insert_detail($id_master, $id_barang, $jumlah_beli, $satuan, $harga_satuan, $discount, $discountnya, $sub_total, $grand_total, $tanggal, $id_herbalis_ori, $id_herbalis, $aty_kota, $id_pelanggan);
											if ($insert_detail) {
												/*$this->m_barang->update_stok3($id_barang, $jumlah_beli);*/
												$this->m_penjualan_detail->update_pelanggan($id_herbalis, $tanggal_kembali, $id_pelanggan);
												$inserted++;
											}
										}

										$no_array++;
									}

									if ($inserted > 0) {
										echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
									} else {
										$this->query_error();
									}
								} else {
									$this->query_error();
								}
							}
						} else {
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ", "</font><br />")));
						}
					} else {
						$this->query_error("Harap masukan minimal 1 kode barang !");
					}
				} else {
					$this->query_error("Harap masukan minimal 1 kode barang !");
				}
			} else {
				$this->load->model('m_user');
				$this->load->model('m_pelanggan');

				$this->load->model('m_penjualan_detail');
				$this->load->model('m_penjualan_master');

				$dt['detail'] = $this->m_penjualan_detail->get_detail($id_penjualan);
				$dt['master'] = $this->m_penjualan_master->get_baris($id_penjualan)->row();

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['pelanggan'] = $this->m_pelanggan->get_all_online();
				$dt['sales'] = $this->m_pelanggan->get_all_sales();
				$dt['herbalis'] = $this->m_pelanggan->get_all_herbalis();

				$this->m_penjualan_master->hapus_transaksi2($id_penjualan);
				$this->load->view('penjualan/transaksi_edit_online', $dt);
			}
		}
	}

	public function history_json_online()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->fetch_data_penjualan_online($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='" . site_url('penjualan/detail_transaksi2/' . $row['id_penjualan_m']) . "' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> " . $row['nomor_nota'] . "</a>";
			$nestedData[]	= $row['grand_total'];
			$nestedData[]	= $row['nama_pelanggan'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('penjualan/edit_transaksi_online
					/' . $row['id_penjualan_m']) . "'><i class='fa fa-pencil-square-o'></i> Edit</a>";

				$nestedData[]	= "<a href='" . site_url('penjualan/hapus_transaksi_sementara_online/' . $row['id_penjualan_m']) . "' id='HapusTransaksi'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function edit_transaksi_online($id_penjualan)
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			if ($_POST) {
				if (!empty($_POST['kode_barang'])) {
					$total = 0;
					foreach ($_POST['kode_barang'] as $k) {
						if (!empty($k)) {
							$total++;
						}
					}

					if ($total > 0) {
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nomor_nota', 'Nomor Nota', 'trim|required|max_length[40]|alpha_numeric|callback_cek_nota[nomor_nota]');
						$this->form_validation->set_rules('tanggal', 'Tanggal', 'trim|required');

						$no = 0;
						foreach ($_POST['kode_barang'] as $d) {
							if (!empty($d)) {/*
								$this->form_validation->set_rules('kode_barang['.$no.']','Kode Barang #'.($no + 1), 'trim|required|max_length[40]|callback_cek_kode_barang[kode_barang['.$no.']]');*/
								$this->form_validation->set_rules('jumlah_beli[' . $no . ']', 'Qty #' . ($no + 1), 'trim|numeric|required|callback_cek_nol[jumlah_beli[' . $no . ']]');
							}

							$no++;
						}

						$this->form_validation->set_rules('cash', 'Total Bayar', 'trim|numeric|required|max_length[17]');
						$this->form_validation->set_rules('catatan', 'Catatan', 'trim|max_length[1000]');

						$this->form_validation->set_message('required', '%s harus diisi');
						$this->form_validation->set_message('cek_kode_barang', '%s tidak ditemukan');
						$this->form_validation->set_message('cek_nota', '%s sudah ada');
						$this->form_validation->set_message('cek_nol', '%s tidak boleh nol');
						$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');

						if ($this->form_validation->run() == TRUE) {
							$nomor_nota 	= $this->input->post('nomor_nota');
							$tanggal		= $this->input->post('tanggal');
							$id_kasir		= $this->input->post('id_kasir');
							$id_pelanggan	= $this->input->post('id_pelanggan');
							$id_herbalis_ori = $this->input->post('nama_herbalis_ori');
							$id_herbalis	= $this->input->post('nama_herbalis');
							$aty_kota		= $this->input->post('aty_kota');
							$bayar			= $this->input->post('cash');
							$grand_total	= $this->input->post('grand_total');
							$harga_discount = $this->input->post('total_discount');
							$total_awal     = $this->input->post('total_awal');
							$tanggal_kembali	= $this->input->post('tanggal_kembali');
							$catatan		= $this->clean_tag_input($this->input->post('catatan'));

							if ($bayar < $grand_total) {
								$this->query_error("Cash Kurang");
							} else {
								$this->load->model('m_penjualan_master');

								if ($tanggal_kembali == '') {
									$master = $this->m_penjualan_master->insert_master2_tanpatanggal($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis_ori, $id_herbalis, $aty_kota, $bayar, $grand_total, $catatan);
								} else {

									$master = $this->m_penjualan_master->insert_master2($nomor_nota, $tanggal, $total_awal, $harga_discount, $id_kasir, $id_pelanggan, $id_herbalis_ori, $id_herbalis, $aty_kota, $bayar, $grand_total, $catatan, $tanggal_kembali);
								}

								if ($master) {
									$id_master 	= $this->m_penjualan_master->get_id($nomor_nota)->row()->id_penjualan_m;
									$inserted	= 0;

									$this->load->model('m_penjualan_detail');
									$this->load->model('m_barang');

									$no_array	= 0;
									foreach ($_POST['kode_barang'] as $k) {
										if (!empty($k)) {
											$kode_barang 	= $_POST['kode_barang'][$no_array];
											$jumlah_beli 	= $_POST['jumlah_beli'][$no_array];
											$harga_satuan 	= $_POST['harga_satuan'][$no_array];
											$satuan 		= $_POST['satuan'][$no_array];
											$discount 		= $_POST['discount'][$no_array];
											$discountnya 	= $_POST['discountnya'][$no_array];
											$sub_total 		= $_POST['sub_total_awal'][$no_array];
											$grand_total 	= $_POST['sub_total'][$no_array];
											$id_barang		= $this->m_barang->get_id_online($kode_barang)->row()->id_barang;

											$insert_detail	= $this->m_penjualan_detail->insert_detail($id_master, $id_barang, $jumlah_beli, $satuan, $harga_satuan, $discount, $discountnya, $sub_total, $grand_total, $tanggal, $id_herbalis_ori, $id_herbalis, $aty_kota, $id_pelanggan);
											if ($insert_detail) {
												/*$this->m_barang->update_stok3($id_barang, $jumlah_beli);*/
												$this->m_penjualan_detail->update_pelanggan($id_herbalis, $tanggal_kembali, $id_pelanggan);
												$inserted++;
											}
										}

										$no_array++;
									}

									if ($inserted > 0) {
										echo json_encode(array('status' => 1, 'pesan' => "Transaksi berhasil disimpan !"));
									} else {
										$this->query_error();
									}
								} else {
									$this->query_error();
								}
							}
						} else {
							echo json_encode(array('status' => 0, 'pesan' => validation_errors("<font color='red'>- ", "</font><br />")));
						}
					} else {
						$this->query_error("Harap masukan minimal 1 kode barang !");
					}
				} else {
					$this->query_error("Harap masukan minimal 1 kode barang !");
				}
			} else {
				$this->load->model('m_user');
				$this->load->model('m_pelanggan');

				$this->load->model('m_penjualan_detail');
				$this->load->model('m_penjualan_master');

				$dt['detail'] = $this->m_penjualan_detail->get_detail($id_penjualan);
				$dt['master'] = $this->m_penjualan_master->get_baris($id_penjualan)->row();

				$dt['kasirnya'] = $this->m_user->list_kasir();
				$dt['pelanggan'] = $this->m_pelanggan->get_all_online();
				$dt['sales'] = $this->m_pelanggan->get_all_sales();
				$dt['herbalis'] = $this->m_pelanggan->get_all_herbalis();

				$this->m_penjualan_master->hapus_transaksi2($id_penjualan);
				$this->output->cache(0.1);
				$this->load->view('penjualan/transaksi_edit_online', $dt);
			}
		}
	}

	public function history_json_apotek_medan()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->fetch_data_penjualan_apotek_medan($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='" . site_url('penjualan/detail_transaksi_medan/' . $row['id_medan_m']) . "' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> " . $row['nomor_nota'] . "</a>";
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('penjualan/acc_transaksi_medan/' . $row['id_medan_m']) . "' id='HapusTransaksi'><i class='fa fa-check'></i> ACC</a>";
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

	public function history_json_apotek_asuransi()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->fetch_data_penjualan_apotek_asuransi($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='" . site_url('penjualan/detail_transaksi_asuransi/' . $row['id_asuransi_m']) . "' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> " . $row['nomor_nota'] . "</a>";
			$nestedData[]	= $row['nama_pelanggan'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('penjualan/acc_transaksi_asuransi/' . $row['id_asuransi_m']) . "' id='HapusTransaksi'><i class='fa fa-check'></i> ACC</a>";
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

	public function history_json_apotek()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->fetch_data_penjualan_apotek($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='" . site_url('penjualan/detail-transaksi/' . $row['id_penjualan_m']) . "' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> " . $row['nomor_nota'] . "</a>";
			$nestedData[]	= $row['grand_total'];
			$nestedData[]	= $row['nama_pelanggan'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			if ($level == 'admin' or $level == 'inventory') {

				$nestedData[]	= "<a href='" . site_url('penjualan/acc_transaksi/' . $row['id_penjualan_m']) . "' id='HapusTransaksi'><i class='fa fa-check'></i> ACC</a>";
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

	public function history_json_apotek_online()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->fetch_data_penjualan_apotek_online($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='" . site_url('penjualan/detail-transaksi2/' . $row['id_penjualan_m']) . "' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> " . $row['nomor_nota'] . "</a>";
			$nestedData[]	= $row['grand_total'];
			$nestedData[]	= $row['nama_pelanggan'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('penjualan/acc_transaksi2/' . $row['id_penjualan_m']) . "' id='HapusTransaksi'><i class='fa fa-check'></i> ACC</a>";
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

	public function detail_transaksi_medan($id_medan_m)
	{
		if ($this->input->is_ajax_request()) {
			$this->load->model('m_penjualan_detail');
			$this->load->model('m_penjualan_master');

			$dt['detail'] = $this->m_penjualan_detail->get_detail_medan($id_medan_m);
			$dt['master'] = $this->m_penjualan_master->get_baris_medan($id_medan_m)->row();

			$this->output->cache(0.1);
			$this->load->view('penjualan/transaksi_history_detail_medan', $dt);
		}
	}

	public function detail_transaksi_asuransi($id_asuransi_m)
	{
		if ($this->input->is_ajax_request()) {
			$this->load->model('m_penjualan_detail');
			$this->load->model('m_penjualan_master');

			$dt['detail'] = $this->m_penjualan_detail->get_detail_asuransi($id_asuransi_m);
			$dt['master'] = $this->m_penjualan_master->get_baris_asuransi($id_asuransi_m)->row();

			$this->output->cache(0.1);
			$this->load->view('penjualan/transaksi_history_detail_asuransi', $dt);
		}
	}

	public function detail_transaksi($id_penjualan)
	{
		if ($this->input->is_ajax_request()) {
			$this->load->model('m_penjualan_detail');
			$this->load->model('m_penjualan_master');

			$dt['detail'] = $this->m_penjualan_detail->get_detail($id_penjualan);
			$dt['master'] = $this->m_penjualan_master->get_baris($id_penjualan)->row();
			// cekdb();
			$this->output->cache(0.1);
			$this->load->view('penjualan/transaksi_history_detail', $dt);
		}
	}

	public function detail_transaksi_rincian($id_penjualan)
	{
		if ($this->input->is_ajax_request()) {
			$this->load->model('m_penjualan_detail');
			$this->load->model('m_penjualan_master');

			$dt['detail'] = $this->m_penjualan_detail->get_detail_rincian($id_penjualan);
			$dt['master'] = $this->m_penjualan_master->get_baris_rincian($id_penjualan)->row();

			$this->output->cache(0.1);
			$this->load->view('penjualan/transaksi_history_detail_rincian', $dt);
		}
	}

	public function detail_transaksi2($id_penjualan)
	{
		if ($this->input->is_ajax_request()) {
			$this->load->model('m_penjualan_detail');
			$this->load->model('m_penjualan_master');

			$dt['detail'] = $this->m_penjualan_detail->get_detail($id_penjualan);
			$dt['master'] = $this->m_penjualan_master->get_baris($id_penjualan)->row();

			$this->load->view('penjualan/transaksi_history_detail_online', $dt);
		}
	}

	public function detail_transaksi2_zoom($id_penjualan)
	{
		if ($this->input->is_ajax_request()) {
			$this->load->model('m_penjualan_detail');
			$this->load->model('m_penjualan_master');

			$dt['detail'] = $this->m_penjualan_detail->get_detail($id_penjualan);
			$dt['master'] = $this->m_penjualan_master->get_baris($id_penjualan)->row();

			$this->output->cache(0.1);
			$this->load->view('penjualan/transaksi_history_detail_online_zoom', $dt);
		}
	}

	public function detail_transaksi2_zoom_klinik($id_penjualan)
	{
		if ($this->input->is_ajax_request()) {
			$this->load->model('m_penjualan_detail');
			$this->load->model('m_penjualan_master');

			$dt['detail'] = $this->m_penjualan_detail->get_detail($id_penjualan);
			$dt['master'] = $this->m_penjualan_master->get_baris($id_penjualan)->row();

			$this->output->cache(0.1);
			$this->load->view('penjualan/transaksi_history_detail_klinik_zoom', $dt);
		}
	}

	public function hapus_transaksi_medan($id_medan)
	{
		if ($this->input->is_ajax_request()) {
			$level 	= $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
				/*$reverse_stok = $this->input->post('reverse_stok');*/

				$this->load->model('m_penjualan_master');

				$nota 	= $this->m_penjualan_master->get_baris_medan($id_medan)->row()->nomor_nota;

				$hapus 	= $this->m_penjualan_master->hapus_transaksi_medan($id_medan /*$reverse_stok*/);

				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>" . $nota . "</b> berhasil dihapus !</font>
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

	public function hapus_transaksi_asuransi($id_asuransi)
	{
		if ($this->input->is_ajax_request()) {
			$level 	= $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
				/*$reverse_stok = $this->input->post('reverse_stok');*/

				$this->load->model('m_penjualan_master');

				$nota 	= $this->m_penjualan_master->get_baris_asuransi($id_asuransi)->row()->nomor_nota;

				$hapus 	= $this->m_penjualan_master->hapus_transaksi_asuransi($id_asuransi /*$reverse_stok*/);

				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>" . $nota . "</b> berhasil dihapus !</font>
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

	public function hapus_transaksi_online($id_penjualan)
	{
		if ($this->input->is_ajax_request()) {
			$level 	= $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
				/*$reverse_stok = $this->input->post('reverse_stok');*/

				$this->load->model('m_penjualan_master');

				$nota 	= $this->m_penjualan_master->get_baris($id_penjualan)->row()->nomor_nota;

				$hapus 	= $this->m_penjualan_master->hapus_transaksi_online($id_penjualan /*$reverse_stok*/);

				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>" . $nota . "</b> berhasil dihapus !</font>
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

	public function hapus_transaksi($id_penjualan)
	{
		if ($this->input->is_ajax_request()) {
			$level 	= $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
				/*$reverse_stok = $this->input->post('reverse_stok');*/

				$this->load->model('m_penjualan_master');

				$nota 	= $this->m_penjualan_master->get_baris($id_penjualan)->row()->nomor_nota;
				$hapus 	= $this->m_penjualan_master->hapus_transaksi($id_penjualan /*$reverse_stok*/);
				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>" . $nota . "</b> berhasil dihapus !</font>
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

	public function hapus_transaksi_sementara($id_penjualan)
	{
		if ($this->input->is_ajax_request()) {
			$level 	= $this->session->userdata('ap_level');
			$id_level = $this->session->userdata('ap_id_user');

			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
				/*$reverse_stok = $this->input->post('reverse_stok');*/

				$this->load->model('m_penjualan_master');

				$nota 	= $this->m_penjualan_master->get_baris($id_penjualan)->row()->nomor_nota;/*
				$id_user_hapus 	= $this->m_penjualan_master->get_baris($id_penjualan)->row()->id_kasir;*/
				$hapus 	= $this->m_penjualan_master->hapus_transaksi_sementara($id_penjualan, $id_level);
				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>" . $nota . "x" . $id_level . "</b> berhasil dihapus !</font>
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

	public function hapus_transaksi_sementara_online($id_penjualan)
	{
		if ($this->input->is_ajax_request()) {
			$level 	= $this->session->userdata('ap_level');
			$id_level = $this->session->userdata('ap_id_user');

			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
				/*$reverse_stok = $this->input->post('reverse_stok');*/

				$this->load->model('m_penjualan_master');

				$nota 	= $this->m_penjualan_master->get_baris($id_penjualan)->row()->nomor_nota;/*
				$id_user_hapus 	= $this->m_penjualan_master->get_baris($id_penjualan)->row()->id_kasir;*/
				$hapus 	= $this->m_penjualan_master->hapus_transaksi_sementara($id_penjualan, $id_level);
				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>" . $nota . "x" . $id_level . "</b> berhasil dihapus !</font>
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

	public function hapus_transaksi_rincian($id_penjualan)
	{
		if ($this->input->is_ajax_request()) {
			$level 	= $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
				/*$reverse_stok = $this->input->post('reverse_stok');*/

				$this->load->model('m_penjualan_master');

				$nota 	= $this->m_penjualan_master->get_baris_rincian($id_penjualan)->row()->nomor_nota;
				$hapus 	= $this->m_penjualan_master->hapus_transaksi_rincian($id_penjualan /*$reverse_stok*/);
				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>" . $nota . "</b> berhasil dihapus !</font>
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

	public function acc_transaksi_medan($id_medan)
	{
		if ($this->input->is_ajax_request()) {
			$level 	= $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {/*
				$reverse_stok = $this->input->post('reverse_stok');*/

				$this->load->model('m_penjualan_master');

				$nota 	= $this->m_penjualan_master->get_baris_medan($id_medan)->row()->nomor_nota;

				$hapus 	= $this->m_penjualan_master->acc_transaksi_medan($id_medan);
				/*
				$this->m_penjualan_master->update_namaherbalis($id_penjualan);*/
				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>" . $nota . "</b> berhasil di ACC !</font>
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

	public function acc_transaksi_asuransi($id_asuransi)
	{
		if ($this->input->is_ajax_request()) {
			$level 	= $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {/*
				$reverse_stok = $this->input->post('reverse_stok');*/

				$this->load->model('m_penjualan_master');

				$nota 	= $this->m_penjualan_master->get_baris_asuransi($id_asuransi)->row()->nomor_nota;

				$hapus 	= $this->m_penjualan_master->acc_transaksi_asuransi($id_asuransi);
				/*
				$this->m_penjualan_master->update_namaherbalis($id_penjualan);*/
				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>" . $nota . "</b> berhasil di ACC !</font>
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

	public function acc_transaksi($id_penjualan)
	{
		if ($this->input->is_ajax_request()) {
			$level 	= $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {/*
				$reverse_stok = $this->input->post('reverse_stok');*/

				$this->load->model('m_penjualan_master');

				$nota 	= $this->m_penjualan_master->get_baris($id_penjualan)->row()->nomor_nota;
				$hapus 	= $this->m_penjualan_master->acc_transaksi2($id_penjualan);/*
				$this->m_penjualan_master->update_namaherbalis($id_penjualan);*/
				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>" . $nota . "</b> berhasil di ACC !</font>
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

	public function acc_transaksi2($id_penjualan)
	{
		if ($this->input->is_ajax_request()) {
			$level 	= $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {/*
				$reverse_stok = $this->input->post('reverse_stok');*/

				$this->load->model('m_penjualan_master');

				$nota 	= $this->m_penjualan_master->get_baris($id_penjualan)->row()->nomor_nota;

				$hapus 	= $this->m_penjualan_master->acc_transaksi($id_penjualan);

				/*
				$this->m_penjualan_master->update_namaherbalis($id_penjualan);*/
				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>" . $nota . "</b> berhasil di ACC !</font>
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

	public function acc_transaksi_pending($id_penjualan)
	{
		if ($this->input->is_ajax_request()) {
			$level 	= $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {/*
				$reverse_stok = $this->input->post('reverse_stok');*/

				$this->load->model('m_penjualan_master');

				$nota 	= $this->m_penjualan_master->get_baris($id_penjualan)->row()->nomor_nota;
				$hapus 	= $this->m_penjualan_master->acc_transaksi2_pending($id_penjualan);/*
				$this->m_penjualan_master->update_namaherbalis($id_penjualan);*/
				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>" . $nota . "</b> berhasil di ACC !</font>
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

	public function acc_transaksi2_pending($id_penjualan)
	{
		if ($this->input->is_ajax_request()) {
			$level 	= $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {/*
				$reverse_stok = $this->input->post('reverse_stok');*/

				$this->load->model('m_penjualan_master');

				$nota 	= $this->m_penjualan_master->get_baris($id_penjualan)->row()->nomor_nota;

				$hapus 	= $this->m_penjualan_master->acc_transaksi_pending($id_penjualan);

				/*
				$this->m_penjualan_master->update_namaherbalis($id_penjualan);*/
				if ($hapus) {
					echo json_encode(array(
						"pesan" => "<font color='green'><i class='fa fa-check'></i> Transaksi <b>" . $nota . "</b> berhasil di ACC !</font>
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

	public function pelanggan_JMO()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
			$this->load->view('penjualan/pelanggan_data_JMO');
		}
	}

	public function rincian_pasien()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			/*$this->output->cache(0.1);*/
			$this->load->view('penjualan/pelanggan_data_rincian');
		}
	}

	public function pelanggan()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			/*$this->output->cache(0.1);*/
			$this->load->view('penjualan/pelanggan_data');
		}
	}

	public function pelanggan_Online()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			/*$this->output->cache(0.1);*/
			$this->load->view('penjualan/pelanggan_data_online');
		}
	}

	public function pelanggan_zoom()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			/*$this->output->cache(0.1);*/
			$this->load->view('penjualan/pelanggan_data_zoom');
		}
	}

	public function pelanggan_JMO_json()
	{
		$this->load->model('m_pelanggan');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_pelanggan->fetch_data_pelanggan_JMO($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['nrmp'];
			$nestedData[]	= $row['nama'];
			$nestedData[]	= $row['herbalis'];
			$nestedData[]	= $row['keterangan'];
			$nestedData[]	= $row['info_tambahan'];

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('penjualan/pelanggan_jmo_edit/' . $row['id_jmo']) . "' id='EditPelanggan'><i class='fa fa-pencil'></i> Edit</a>";
			}

			if ($level == 'admin' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('penjualan/pelanggan_jmo_hapus/' . $row['id_jmo']) . "' id='HapusPelanggan'><i class='fa fa-trash-o'></i> Hapus</a>";
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


	public function pelanggan_rincian_json()
	{
		$this->load->model('m_penjualan_master');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_penjualan_master->fetch_data_rincian_pasien($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['tanggal'];
			$nestedData[]	= "<a href='" . site_url('penjualan/detail_transaksi_rincian/' . $row['id_rincian']) . "' id='LihatDetailTransaksi'><i class='fa fa-file-text-o fa-fw'></i> " . $row['nomor_nota'] . "</a>";
			$nestedData[]	= $row['grand_total'];
			$nestedData[]	= $row['nama_pelanggan'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['keterangan']);
			$nestedData[]	= $row['kasir'];

			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan' or $level == 'inventory') {
				$nestedData[]	= "<a href='" . site_url('penjualan/edit_transaksi_rincian/' . $row['id_rincian']) . "'><i class='fa fa-pencil-square-o'></i> Edit</a>";

				$nestedData[]	= "<a href='" . site_url('penjualan/hapus_transaksi_rincian/' . $row['id_rincian']) . "' id='HapusTransaksi'><i class='fa fa-trash-o'></i> Hapus</a>";
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


	public function pelanggan_json()
	{
		$this->load->model('m_pelanggan');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_pelanggan->fetch_data_pelanggan($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['nrmp'];
			$nestedData[]	= $row['nama'];
			$nestedData[]	= $row['id_herbalis'];
			$nestedData[]	= $row['tgl_kembali'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['info_tambahan']);
			$nestedData[]	= $row['keterangan'];
			$nestedData[]	= $row['waktu_input'];

			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
				$nestedData[]	= "<a href='" . site_url('penjualan/pelanggan-edit/' . $row['id_pelanggan']) . "' id='EditPelanggan'><i class='fa fa-pencil'></i> Edit</a>";
			}

			if ($level == 'admin') {
				$nestedData[]	= "<a href='" . site_url('penjualan/pelanggan-hapus/' . $row['id_pelanggan']) . "' id='HapusPelanggan'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function pelanggan_json_online()
	{
		$this->load->model('m_pelanggan');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_pelanggan->fetch_data_pelanggan_online($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['nrmp'];
			$nestedData[]	= $row['nama'];
			$nestedData[]	= $row['tgl_kembali'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['alamat']);
			$nestedData[]	= $row['telp'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['info_tambahan']);
			$nestedData[]	= $row['keterangan'];
			$nestedData[]	= $row['waktu_input'];

			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
				$nestedData[]	= "<a href='" . site_url('penjualan/pelanggan-edit2/' . $row['id_pelanggan']) . "' id='EditPelanggan'><i class='fa fa-pencil'></i> Edit</a>";
			}

			if ($level == 'admin') {
				$nestedData[]	= "<a href='" . site_url('penjualan/pelanggan-hapus/' . $row['id_pelanggan']) . "' id='HapusPelanggan'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function pelanggan_json_ZOOM()
	{
		$this->load->model('m_pelanggan');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_pelanggan->fetch_data_pelanggan_zoom($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);

		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach ($query->result_array() as $row) {
			$nestedData = array();

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['nrmp'];
			$nestedData[]	= $row['nama'];
			$nestedData[]	= $row['id_herbalis'];
			$nestedData[]	= $row['tgl_kembali'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['alamat']);
			$nestedData[]	= $row['telp'];
			$nestedData[]	= preg_replace("/\r\n|\r|\n/", '<br />', $row['info_tambahan']);
			$nestedData[]	= $row['keterangan'];/*
			$nestedData[]	= $row['waktu_input'];*/

			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
				$nestedData[]	= "<a href='" . site_url('penjualan/pelanggan-edit2/' . $row['id_pelanggan']) . "' id='EditPelanggan'><i class='fa fa-pencil'></i> Edit</a>";
			}

			if ($level == 'admin') {
				$nestedData[]	= "<a href='" . site_url('penjualan/pelanggan-hapus/' . $row['id_pelanggan']) . "' id='HapusPelanggan'><i class='fa fa-trash-o'></i> Hapus</a>";
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

	public function tambah_pelanggan_jmo()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($_POST) {
				$this->load->model('m_pelanggan');
				$nrmp 		    = $this->input->post('nrmp');
				$id_pelanggan 	= $this->input->post('nama');
				$nama 		    = $this->input->post('nama_pasien');
				$herbalis 	    = $this->input->post('herbalis');
				$keterangan 	= $this->input->post('keterangan');
				$info_tambahan  = $this->clean_tag_input($this->input->post('info_tambahan'));

				$unique		= time() . $this->session->userdata('ap_id_user');

				$this->load->model('m_penjualan_master');
				$cek = $this->m_penjualan_master->cek_id_pelanggan_validasi($id_pelanggan)->row();

				if ($id_pelanggan == $cek->id_pelanggan) {
					echo json_encode(array(
						'status' => 1,
						'pesan' => "<div class='alert alert-danger'><i class='fa fa-check'></i> <b>" . $nama . "</b> sudah ada di data jmo.</div>",
						'nrmp' => $nrmp,
						'id_pelanggan' => $id_pelanggan,
						'nama' => $nama,
						'alamat' => preg_replace("/\r\n|\r|\n/", '<br />', $alamat),
						'telepon' => $telepon,
						'herbalis' => $herbalis,
						'tgl_kembali' => $tgl_kembali,
					));
				} else {

					$insert 	= $this->m_pelanggan->tambah_pelanggan_jmo($nrmp, $nama, $id_pelanggan, $herbalis, $keterangan, $info_tambahan);

					if ($insert) {
						$id_pelanggan = $this->m_pelanggan->get_dari_kode($unique)->row()->id_pelanggan;
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>" . $nama . "</b> berhasil ditambahkan sebagai pelanggan.</div>",
							'nrmp' => $nrmp,
							'id_pelanggan' => $id_pelanggan,
							'nama' => $nama,
							'alamat' => preg_replace("/\r\n|\r|\n/", '<br />', $alamat),
							'telepon' => $telepon,
							'herbalis' => $herbalis,
							'tgl_kembali' => $tgl_kembali,
						));
					} else {
						$this->query_error();
					}
				}
			} else {   /*
			    $cek_id = $this->m_penjualan_master->cek_id_pelanggan_validasi($id_pelanggan);*/

				$this->load->model('m_pelanggan');
				$this->output->cache(0.1);
				$dt['pelanggan'] = $this->m_pelanggan->get_all_jmo();
				$this->load->view('penjualan/tambah_pasien_jmo', $dt);
			}
		}
	}

	public function tambah_pelanggan()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			if ($_POST) {
				$this->load->library('form_validation');
				$this->form_validation->set_rules('nama', 'Nama', 'trim|required|alpha_spaces|max_length[40]');/*
				$this->form_validation->set_rules('alamat','Alamat','trim|required|max_length[1000]');
				$this->form_validation->set_rules('telepon','Telepon / Handphone','trim|required|numeric|max_length[40]');*/
				$this->form_validation->set_rules('info', 'Info Tambahan Lainnya', 'trim|max_length[1000]');

				$this->form_validation->set_message('alpha_spaces', '%s harus alphabet !');
				$this->form_validation->set_message('numeric', '%s harus angka !');
				$this->form_validation->set_message('required', '%s harus diisi !');
				if ($this->form_validation->run() == TRUE) {
					$this->load->model('m_pelanggan');
					$nrmp 		 = $this->input->post('nrmp');
					$nama 		 = $this->input->post('nama');
					$herbalis 	 = $this->input->post('herbalis');
					$tgl_kembali = $this->input->post('tgl_kembali');
					$alamat 	= $this->clean_tag_input($this->input->post('alamat'));
					$telepon 	= $this->input->post('telepon');
					$info 		= $this->clean_tag_input($this->input->post('info'));

					$unique		= time() . $this->session->userdata('ap_id_user');
					$insert 	= $this->m_pelanggan->tambah_pelanggan($nrmp, $nama, $alamat, $telepon, $info, $unique, $herbalis, $tgl_kembali);
					if ($insert) {
						$id_pelanggan = $this->m_pelanggan->get_dari_kode($unique)->row()->id_pelanggan;
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>" . $nama . "</b> berhasil ditambahkan sebagai pelanggan.</div>",
							'nrmp' => $nrmp,
							'id_pelanggan' => $id_pelanggan,
							'nama' => $nama,
							'alamat' => preg_replace("/\r\n|\r|\n/", '<br />', $alamat),
							'telepon' => $telepon,
							'herbalis' => $herbalis,
							'tgl_kembali' => $tgl_kembali,
						));
					} else {
						$this->query_error();
					}
				} else {
					$this->input_error();
				}
			} else {
				$this->output->cache(0.1);
				$this->load->view('penjualan/pelanggan_tambah');
			}
		}
	}

	public function tambah_pelanggan2()
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
			if ($_POST) {
				$this->load->library('form_validation');
				$this->form_validation->set_rules('nama', 'Nama', 'trim|required|alpha_spaces|max_length[40]');/*
				$this->form_validation->set_rules('alamat','Alamat','trim|required|max_length[1000]');
				$this->form_validation->set_rules('telepon','Telepon / Handphone','trim|required|numeric|max_length[40]');*/
				$this->form_validation->set_rules('info', 'Info Tambahan Lainnya', 'trim|max_length[1000]');

				$this->form_validation->set_message('alpha_spaces', '%s harus alphabet !');
				$this->form_validation->set_message('numeric', '%s harus angka !');
				$this->form_validation->set_message('required', '%s harus diisi !');
				if ($this->form_validation->run() == TRUE) {
					$this->load->model('m_pelanggan');
					$nrmp 		= $this->input->post('nrmp');
					$nama 		= $this->input->post('nama');
					$tgl_kembali = $this->input->post('tgl_kembali');
					$alamat 	= $this->clean_tag_input($this->input->post('alamat'));
					$telepon 	= $this->input->post('telepon');
					$info 		= $this->clean_tag_input($this->input->post('info'));

					$unique		= time() . $this->session->userdata('ap_id_user');
					$insert 	= $this->m_pelanggan->tambah_pelanggan_online($nrmp, $nama, $tgl_kembali, $alamat, $telepon, $info, $unique);
					if ($insert) {
						$id_pelanggan = $this->m_pelanggan->get_dari_kode($unique)->row()->id_pelanggan;
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>" . $nama . "</b> berhasil ditambahkan sebagai pelanggan.</div>",
							'nrmp' => $nrmp,
							'id_pelanggan' => $id_pelanggan,
							'nama' => $nama,
							'alamat' => preg_replace("/\r\n|\r|\n/", '<br />', $alamat),
							'telepon' => $telepon,
						));
					} else {
						$this->query_error();
					}
				} else {
					$this->input_error();
				}
			} else {
				$this->output->cache(0.1);
				$this->load->view('penjualan/pelanggan_tambah2');
			}
		}
	}

	public function pelanggan_edit_datang_kembali($id_pelanggan = NULL, $id_penjualan_m = NULL)
	{
		if (!empty($id_pelanggan)) {
			$level = $this->session->userdata('ap_level');
			if ($level == 'admin') {
				if ($this->input->is_ajax_request()) {
					$this->load->model('m_pelanggan');

					if ($_POST) {
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nama', 'Nama', 'trim|required|alpha_spaces|max_length[40]');
						$this->form_validation->set_rules('keterangan_pasien', 'Keterangan Pasien', 'required');/*
						$this->form_validation->set_rules('alamat','Alamat','trim|required|max_length[1000]');
						$this->form_validation->set_rules('telepon','Telepon / Handphone','trim|required|numeric|max_length[40]');*/
						$this->form_validation->set_rules('info', 'Info Tambahan Lainnya', 'trim|max_length[1000]');

						$this->form_validation->set_message('alpha_spaces', '%s harus alphabet !');
						$this->form_validation->set_message('numeric', '%s harus angka !');
						$this->form_validation->set_message('required', '%s harus diisi !');


						if ($this->form_validation->run() == TRUE) {
							$nrmp 		= $this->input->post('nrmp');
							$nama 		= $this->input->post('nama');
							$tgl_kembali = $this->input->post('tgl_kembali');
							$keterangan_pasien = $this->input->post('keterangan_pasien');
							$info 		= $this->clean_tag_input($this->input->post('info'));

							$update 	= $this->m_pelanggan->update_pelanggan_datang_kembali($id_pelanggan, $nrmp, $nama, $tgl_kembali, $info, $keterangan_pasien);

							$this->m_pelanggan->update_penjualanmaster_datang_kembali($id_penjualan_m, $tgl_kembali);

							if ($update) {
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
						$dt['pelanggan'] = $this->m_pelanggan->get_baris($id_pelanggan)->row();
						$dt['id_penjualan_m'] = $id_penjualan_m;
						$this->load->view('barang/pelanggan_edit_datang_kembali', $dt);
					}
				}
			}
		}
	}

	public function pelanggan_edit2($id_pelanggan = NULL)
	{
		if (!empty($id_pelanggan)) {
			$level = $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
				if ($this->input->is_ajax_request()) {
					$this->load->model('m_pelanggan');

					if ($_POST) {
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nama', 'Nama', 'trim|required|alpha_spaces|max_length[40]');/*
						$this->form_validation->set_rules('alamat','Alamat','trim|required|max_length[1000]');
						$this->form_validation->set_rules('telepon','Telepon / Handphone','trim|required|numeric|max_length[40]');*/
						$this->form_validation->set_rules('info', 'Info Tambahan Lainnya', 'trim|max_length[1000]');

						$this->form_validation->set_message('alpha_spaces', '%s harus alphabet !');
						$this->form_validation->set_message('numeric', '%s harus angka !');
						$this->form_validation->set_message('required', '%s harus diisi !');

						if ($this->form_validation->run() == TRUE) {
							$nrmp 		= $this->input->post('nrmp');
							$nama 		= $this->input->post('nama');
							$herbalis 	= $this->input->post('herbalis');
							$tgl_kembali = $this->input->post('tgl_kembali');
							$alamat 	= $this->clean_tag_input($this->input->post('alamat'));
							$telepon 	= $this->input->post('telepon');
							$info 		= $this->clean_tag_input($this->input->post('info'));

							$update 	= $this->m_pelanggan->update_pelanggan2($id_pelanggan, $nrmp, $nama, $tgl_kembali, $alamat, $telepon, $info);
							if ($update) {
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
						$dt['pelanggan'] = $this->m_pelanggan->get_baris($id_pelanggan)->row();
						$this->output->cache(0.1);
						$this->load->view('penjualan/pelanggan_edit2', $dt);
					}
				}
			}
		}
	}

	public function pelanggan_edit($id_pelanggan = NULL)
	{
		if (!empty($id_pelanggan)) {
			$level = $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'kasir' or $level == 'keuangan') {
				if ($this->input->is_ajax_request()) {
					$this->load->model('m_pelanggan');

					if ($_POST) {
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nama', 'Nama', 'trim|required|alpha_spaces|max_length[40]');/*
						$this->form_validation->set_rules('alamat','Alamat','trim|required|max_length[1000]');
						$this->form_validation->set_rules('telepon','Telepon / Handphone','trim|required|numeric|max_length[40]');*/
						$this->form_validation->set_rules('info', 'Info Tambahan Lainnya', 'trim|max_length[1000]');

						$this->form_validation->set_message('alpha_spaces', '%s harus alphabet !');
						$this->form_validation->set_message('numeric', '%s harus angka !');
						$this->form_validation->set_message('required', '%s harus diisi !');

						if ($this->form_validation->run() == TRUE) {
							$nrmp 		= $this->input->post('nrmp');
							$nama 		= $this->input->post('nama');
							$herbalis 	= $this->input->post('herbalis');
							$tgl_kembali = $this->input->post('tgl_kembali');
							$info 		= $this->clean_tag_input($this->input->post('info'));

							$update 	= $this->m_pelanggan->update_pelanggan($id_pelanggan, $nrmp, $nama, $herbalis, $tgl_kembali, $info);
							if ($update) {
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
						$dt['pelanggan'] = $this->m_pelanggan->get_baris($id_pelanggan)->row();
						$this->output->cache(0.1);
						$this->load->view('penjualan/pelanggan_edit', $dt);
					}
				}
			}
		}
	}

	public function pelanggan_jmo_edit($id_jmo = NULL)
	{
		if (!empty($id_jmo)) {
			$level = $this->session->userdata('ap_level');
			if ($level == 'admin' or $level == 'inventory') {
				if ($this->input->is_ajax_request()) {
					$this->load->model('m_pelanggan');

					if ($_POST) {
						$this->load->library('form_validation');
						$this->form_validation->set_rules('nama', 'Nama', 'trim|required|alpha_spaces|max_length[40]');/*
						$this->form_validation->set_rules('alamat','Alamat','trim|required|max_length[1000]');
						$this->form_validation->set_rules('telepon','Telepon / Handphone','trim|required|numeric|max_length[40]');*/

						$this->form_validation->set_message('alpha_spaces', '%s harus alphabet !');
						$this->form_validation->set_message('numeric', '%s harus angka !');
						$this->form_validation->set_message('required', '%s harus diisi !');

						if ($this->form_validation->run() == TRUE) {
							$nrmp 		    = $this->input->post('nrmp');
							$nama 		    = $this->input->post('nama');
							$herbalis 	    = $this->input->post('herbalis');
							$keterangan 	= $this->input->post('keterangan');
							$info_tambahan 	= $this->clean_tag_input($this->input->post('info_tambahan'));

							$update 	= $this->m_pelanggan->update_pelanggan_jmo($id_jmo, $nrmp, $nama, $herbalis, $keterangan, $info_tambahan);
							if ($update) {
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
						$dt['pelanggan'] = $this->m_pelanggan->get_baris_jmo($id_jmo)->row();
						$this->output->cache(0.1);
						$this->load->view('penjualan/pelanggan_JMO_edit', $dt);
					}
				}
			}
		}
	}

	public function pelanggan_hapus($id_pelanggan)
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin') {
			if ($this->input->is_ajax_request()) {
				$this->load->model('m_pelanggan');
				$hapus = $this->m_pelanggan->hapus_pelanggan($id_pelanggan);
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

	public function pelanggan_jmo_hapus($id_jmo)
	{
		$level = $this->session->userdata('ap_level');
		if ($level == 'admin' or $level == 'inventory') {
			if ($this->input->is_ajax_request()) {
				$this->load->model('m_pelanggan');
				$hapus = $this->m_pelanggan->hapus_pelanggan_jmo($id_jmo);
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
}
