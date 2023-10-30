<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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

class Jasa extends MY_Controller 
{
	public function index()
	{
		$this->load->view('jasa/jasa_data');
	}

	public function jasa_json()
	{
		$this->load->model('m_barang');
		$level 			= $this->session->userdata('ap_level');

		$requestData	= $_REQUEST;
		$fetch			= $this->m_barang->fetch_data_jasa($requestData['search']['value'], $requestData['order'][0]['column'], $requestData['order'][0]['dir'], $requestData['start'], $requestData['length']);
		
		$totalData		= $fetch['totalData'];
		$totalFiltered	= $fetch['totalFiltered'];
		$query			= $fetch['query'];

		$data	= array();
		foreach($query->result_array() as $row)
		{ 
			$nestedData = array(); 

			$nestedData[]	= $row['nomor'];
			$nestedData[]	= $row['kode_barang'];
			$nestedData[]	= $row['nama_barang'];
			$nestedData[]	= $row['harga'];

			if($level == 'admin' OR $level == 'inventory')
			{
				$nestedData[]	= "<a href='".site_url('barang/edit/'.$row['id_barang'])."' id='EditBarang'><i class='fa fa-pencil'></i> Edit</a>";
				$nestedData[]	= "<a href='".site_url('barang/hapus/'.$row['id_barang'])."' id='HapusBarang'><i class='fa fa-trash-o'></i> Hapus</a>";
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
	}

    public function tambah_jasa()
{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory')
		{
			if($_POST)
			{
				$this->load->library('form_validation');
				$this->form_validation->set_rules('nama','Nama','trim|required|max_length[40]');

				$this->form_validation->set_message('alpha_spaces','%s harus alphabet !');
				$this->form_validation->set_message('numeric','%s harus angka !');
				$this->form_validation->set_message('required','%s harus diisi !');

				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('m_barang');
					$kode 		 = $this->input->post('kode');
					$nama 		 = $this->input->post('nama');
					$harga 	 	 = $this->input->post('harga');

					$insert 	= $this->m_barang->tambah_jasa($kode, $nama, $harga);

					if($insert)
					{
						$id_barang = $this->m_barang->get_dari_kode($kode)->row()->id_barang;
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<div class='alert alert-success'><i class='fa fa-check'></i> <b>".$nama."</b> berhasil ditambahkan sebagai pelanggan.</div>",
							'kode' => $kode,
							'id_barang' => $id_barang,
							'nama' => $nama,
							'harga' => $harga
						));
					}
					else
					{
						$this->query_error();
					}
				}
				else
				{
					$this->input_error();
				}
			}
			else
			{
			    $this->output->cache(0.1);
				$this->load->view('jasa/tambah_jasa');
			}
		}
	}

	public function tambah_jasa2()
	{
		$level = $this->session->userdata('ap_level');
		if($level == 'admin' OR $level == 'inventory')
		{
			if($_POST)
			{
				$this->load->library('form_validation');

				$no = 0;
				foreach($_POST['kode'] as $kode)
				{/*
					$this->form_validation->set_rules('kode['.$no.']','Kode Barang #'.($no + 1),'trim|required|alpha_numeric|max_length[40]|callback_exist_kode[kode['.$no.']]');*/
					$this->form_validation->set_rules('nama['.$no.']','Nama Barang #'.($no + 1),'trim|required|max_length[60]|alpha_numeric_spaces');
					$this->form_validation->set_rules('id_kategori_barang['.$no.']','Kategori #'.($no + 1),'trim|required');
					$this->form_validation->set_rules('stok['.$no.']','Stok #'.($no + 1),'trim|required|numeric|max_length[10]|callback_cek_titik[stok['.$no.']]');
					$this->form_validation->set_rules('harga['.$no.']','Harga #'.($no + 1),'trim|required|numeric|min_length[4]|max_length[10]|callback_cek_titik[harga['.$no.']]');
					$this->form_validation->set_rules('keterangan['.$no.']','Keterangan #'.($no + 1),'trim|max_length[2000]');
					$no++;
				}
				
				$this->form_validation->set_message('required','%s harus diisi !');
				$this->form_validation->set_message('numeric','%s harus angka !');
				$this->form_validation->set_message('exist_kode','%s sudah ada di database, pilih kode lain yang unik !');
				$this->form_validation->set_message('cek_titik','%s harus angka, tidak boleh ada titik !');
				$this->form_validation->set_message('alpha_numeric_spaces', '%s Harus huruf / angka !');
				$this->form_validation->set_message('alpha_numeric', '%s Harus huruf / angka !');
				if($this->form_validation->run() == TRUE)
				{
					$this->load->model('m_barang');

					$id_obat ='';
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
        			}

			        $kd_barang ='';
			        $data['kd_barang2'] = $this->m_barang->ambilkodeobat3();
			        if(empty($data['kd_barang2'])){
			            $kd_barang='b00005';
			        }
			        else{
			            $kd_akhir='';
			            foreach ($data['kd_barang2'] as $kode) {
			                $kd_akhir = $kode->kd_barang;
			            }
			            $urutan = substr($kd_akhir,4);
			            $int = (int)$urutan;
			            $next = $int+1;
			            $strlen = strlen($next);
			            $nol='';
			            for ($i=1; $i <= 5 - $strlen; $i++) { 
			                $nol=$nol.'0';
			            }
			            $kd_barang ='b'.$nol.$next;
			        }

					$no_array = 0;
					$inserted = 0;
					foreach($_POST['kode'] as $k)
					{
						$kode 				= $_POST['kode'][$no_array];
						$kd_barang2 		= $kd_barang;
						$nama 				= $_POST['nama'][$no_array];/*
						$kode_barang2		= $id_obat;*/
						$id_kategori_barang	= $_POST['id_kategori_barang'][$no_array];
						$satuan 			= $_POST['satuan'][$no_array];
						$stok 				= $_POST['stok'][$no_array];
						$harga 				= $_POST['harga'][$no_array];
						$keterangan 		= $this->clean_tag_input($_POST['keterangan'][$no_array]);

						$insert2 = $this->m_barang->barangonline($kode)->row();

						if($kode == $insert2->kode_barang)
						{	
							$insert = $this->m_barang->tambah_baru_online2($kode ,$kd_barang2 ,$nama, $id_kategori_barang, $satuan, $stok, $harga, $keterangan);
							$this->m_barang->update_stok_online($kode, $stok);

							if($insert){
							$inserted++;
							}
							$no_array++;
						}
						else
						{
							$insert = $this->m_barang->tambah_baru_online($kode ,$kd_barang2 ,$nama, $id_kategori_barang, $satuan, $stok, $harga, $keterangan);
							$insert = $this->m_barang->tambah_baru_online2($kode ,$kd_barang2 ,$nama, $id_kategori_barang, $satuan, $stok, $harga, $keterangan);

							if($insert){
							$inserted++;
							}
							$no_array++;
						}

						
					}

					if($inserted > 0)
					{
						echo json_encode(array(
							'status' => 1,
							'pesan' => "<i class='fa fa-check' style='color:green;'></i> Data barang berhasil dismpan."
						));
					}
					else
					{
						$this->query_error("Oops, terjadi kesalahan, coba lagi !");
					}
				}
				else
				{
					$this->input_error();
				}
			}
			else
			{	
				$this->load->view('jasa/tambah_jasa');
			}
		}
		else
		{
			exit();
		}
	}
}