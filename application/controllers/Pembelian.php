<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Pembelian extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_barang', 'barang');
    }

    public function index()
    {
        $this->transaksi();
    }
    public function transaksi()
    {
        $level = $this->session->userdata('ap_level');
        // cekvar($level);
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
                            $nomor_nota     = $this->input->post('nomor_nota');
                            $tanggal        = $this->input->post('tanggal');
                            $id_kasir        = $this->input->post('id_kasir');
                            $id_pelanggan    = $this->input->post('id_pelanggan');
                            $id_herbalis    = $this->input->post('nama_herbalis');
                            $bayar            = $this->input->post('cash');
                            $grand_total    = $this->input->post('grand_total');
                            $harga_discount = $this->input->post('total_discount');
                            $total_awal     = $this->input->post('total_awal');
                            $tanggal_kembali    = $this->input->post('tanggal_kembali');
                            $catatan        = $this->clean_tag_input($this->input->post('catatan'));
                            $sales_pam        = $this->input->post('sales_pam');

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
                                    $id_master     = $this->m_penjualan_master->get_id($nomor_nota)->row()->id_penjualan_m;
                                    $inserted    = 0;

                                    $this->load->model('m_penjualan_detail');
                                    $this->load->model('m_barang');

                                    $no_array    = 0;
                                    foreach ($_POST['kode_barang'] as $k) {
                                        if (!empty($k)) {
                                            $kode_barang     = $_POST['kode_barang'][$no_array];
                                            $jumlah_beli     = $_POST['jumlah_beli'][$no_array];
                                            $harga_satuan     = $_POST['harga_satuan'][$no_array];
                                            $satuan         = $_POST['satuan'][$no_array];
                                            $discount         = $_POST['discount'][$no_array];
                                            $discountnya     = $_POST['discountnya'][$no_array];
                                            $sub_total         = $_POST['sub_total_awal'][$no_array];
                                            $grand_total     = $_POST['sub_total'][$no_array];
                                            $id_barang        = $this->m_barang->get_id($kode_barang)->row()->id_barang;

                                            $insert_detail    = $this->m_penjualan_detail->insert_detail2($id_master, $id_barang, $jumlah_beli, $satuan, $harga_satuan, $discount, $discountnya, $sub_total, $grand_total, $tanggal, $id_herbalis, $id_pelanggan, $sales_pam);/*
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
    public function datapo()
    {
        $this->load->view('barang/laporan_rekap_data_pasien_utama');
    }
    public function datasupplier()
    {
        // $level = $this->session->userdata('ap_level');
        // $tanggal = date('Y-m-d');
        // if ($level == 'admin' or $level == 'kasir') {
        //     $this->load->model('m_penjualan_master');
        //     $dt['penjualan']     = $this->m_penjualan_master->rekap_data_pasien_klinik_real($tanggal);
        //     $dt['tahun']     = $tanggal;
        //     $this->load->view('barang/laporan_rekap_data_pasien_klinik', $dt);
        // }
        $uri = $this->segmen->uri(3);
        cekvar($uri);
        $data['title'] = "Data Supplier / Pabrik ";
        $data['datasupplier'] = $this->barang->fetch_data('supplier');
        // cekvar($data);
        $this->load->model('m_user');
        $this->load->model('m_pelanggan');

        $dt['kasirnya'] = $this->m_user->list_kasir();
        $dt['pelanggan'] = $this->m_pelanggan->get_all();
        $dt['herbalis'] = $this->m_pelanggan->get_all_herbalis();
        $this->load->view('pembelian/datasupplier', $data);
    }
}
