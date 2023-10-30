<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * ------------------------------------------------------------------------
 * CLASS NAME : Laporan
 * ------------------------------------------------------------------------
 *
 * @author     Muhammad Akbar <muslim.politekniktelkom@gmail.com>
 * @copyright  2016
 * @license    http://aplikasiphp.net
 *
 */

class Laporan extends MY_Controller 
{
	function __construct()
	{
		parent::__construct();
		$level 		= $this->session->userdata('ap_level');
		$allowed	= array('admin', 'keuangan', 'kasir', 'inventory');

		if( ! in_array($level, $allowed))
		{
			redirect();
		}
	}

	public function index()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporan');
	}
	
	public function laporan_zoom_klinik()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporan_zoom_klinik');
	}
	
	public function penjualan_zoom_klinik($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualan_zoom_klinik($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualan_zoom_klinik', $dt);
	}
	
		public function laporan_pasien_zoom_perproduk_klinik()
	{	/*
		$this->load->model('m_pelanggan');
		$dt['sales']= $this->m_pelanggan->get_all_sales();*/
		$this->output->cache(0.1);
		$this->load->view('laporan/form_laporan_zoom_perproduk_klinik', $dt);
	}
	
	public function penjualan_pasien_zoom_perproduk_klinik($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualan_pasien_zoom_perproduk_klinik($from, $to, $herbalis);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));/*
		$dt['herbalis']		= $herbalis;*/
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualan_pasien_zoom_perproduk_klinik', $dt);
	}
	
	public function laporan_zoom()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporan_zoom');
	}
	
	public function penjualan_zoom($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualan_zoom($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualan_zoom', $dt);
	}
	
	public function laporan_pasien_zoom_perproduk()
	{	/*
		$this->load->model('m_pelanggan');
		$dt['sales']= $this->m_pelanggan->get_all_sales();*/
		$this->output->cache(0.1);
		$this->load->view('laporan/form_laporan_zoom_perproduk', $dt);
	}
	
	public function penjualan_pasien_zoom_perproduk($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualan_pasien_zoom_perproduk($from, $to, $herbalis);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));/*
		$dt['herbalis']		= $herbalis;*/
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualan_pasien_zoom_perproduk', $dt);
	}

	public function penjualan($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualan($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualan', $dt);
	}

	public function laporan_peritem()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporan_peritem');
	}

	public function penjualan_peritem_online($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualan_online($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualan_online', $dt);
	}

	public function laporan_sales()
	{	
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporansales');
	}

	public function laporan_sales_baru()
	{	
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporansales_baru');
	}

	public function laporan_sales_ATY()
	{	
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporansales_ATY');
	}
	
	public function laporan_sales_ATY_semua_kota()
	{	
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporansales_ATY_semua_kota');
	}
	
	public function laporan_sales_pam()
	{	
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporansales_pam');
	}
	
		public function laporan_obat_sales_pam()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporan_obat_PAM');
	}
	
	public function penjualan_obat_PAM($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualanobat_klinik_PAM($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_penjualan_obat_PAM', $dt);
	}


	public function penjualan_sales($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualansales($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualansales', $dt);
	}


	public function penjualan_sales_baru($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualansales_baru($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualansales_baru', $dt);
	}

	public function penjualan_sales_ATY($from, $to, $aty)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualansales_ATY($from, $to, $aty);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$dt['aty']			= $aty;
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualansales_ATY', $dt);
	}
	
	public function penjualan_sales_ATY_semua_kota($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualansales_ATY_semua_kota($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualansales_ATY_semua_kota', $dt);
	}
	
	public function penjualan_sales_pam($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualansales_pam($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualansales_pam', $dt);
	}

	public function laporan_sales_perproduk()
	{	
		$this->load->model('m_pelanggan');
		$dt['sales']= $this->m_pelanggan->get_all_sales();
		$this->output->cache(0.1);
		$this->load->view('laporan/form_laporansales_perproduk', $dt);
	}

	public function laporan_sales_perproduk_ATY()
	{	
		$this->load->model('m_pelanggan');
		$dt['sales']= $this->m_pelanggan->get_all_sales();
		$this->output->cache(0.1);
		$this->load->view('laporan/form_laporansales_perproduk_ATY', $dt);
	}

	public function penjualan_sales_perproduk($from, $to, $sales)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualansales_perproduk($from, $to, $sales);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$dt['sales']		= $sales;
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualansales_perproduk', $dt);
	}

	public function penjualan_sales_perproduk_ATY($from, $to, $sales, $aty)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualansales_perproduk_ATY($from, $to, $sales, $aty);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$dt['sales']		= $sales;
		$dt['aty']		= $aty;
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualansales_perproduk_ATY', $dt);
	}

	public function laporan_pasien()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporanpasien');
	}
	
	public function laporan_pasien_asuransi()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporanpasien_asuransi');
	}

	public function laporan_pasien_ATY()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporanpasien_ATY');
	}
	
	public function laporan_pasien_ATY_semua_kota()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporanpasien_ATY_semua_kota');
	}

	public function penjualan_pasien($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualanpasien($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualanpasien', $dt);
	}
	
	public function penjualan_pasien_asuransi($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualanpasien_asuransi($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualanpasien_asuransi', $dt);
	}

	public function penjualan_pasien_ATY($from, $to, $aty)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualanpasien_ATY($from, $to, $aty);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$dt['aty']			= $aty;
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualanpasien_ATY', $dt);
	}
	
	public function penjualan_pasien_ATY_semua_kota($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualanpasien_ATY_semua_kota($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$dt['aty']			= $aty;
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualanpasien_ATY_semua_kota', $dt);
	}
	
	public function laporan_pasienklinik_khusus()
	{
		$this->load->view('laporan/form_laporanpasien_klinik_khusus');
	}
	
	public function penjualan_pasienklinik_khusus($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualanpasien_klinik_khusus($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_penjualanpasien_klinik', $dt);
	}

	public function laporan_pasienklinik()
	{
		$this->load->view('laporan/form_laporanpasien_klinik');
	}

	public function penjualan_pasienklinik($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualanpasien_klinik($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualanpasien_klinik', $dt);
	}
	
	public function laporan_obat_zoom()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporan_obat_zoom');
	}
	
	public function laporan_obat_zoom_klinik()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporan_obat_zoom_klinik');
	}
	
	public function penjualan_obat_pasien_zoom($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualan_obat_zoom($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_penjualan_obat_zoom', $dt);
	}
	
	public function penjualan_obat_pasien_zoom_klinik($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualan_obat_zoom_klinik($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_penjualan_obat_zoom_klinik', $dt);
	}
	
	public function laporan_obat_kimia()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporanobat_kimia');
	}
	
	public function penjualan_obat_kimia($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualanobat_kimia($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualanobat_kimia', $dt);
	}

	public function laporan_obatklinik()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporanobat_klinik');
	}

	public function penjualan_obatklinik($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualanobat_klinik($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualanobat_klinik', $dt);
	}

	public function laporan_obat()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporanobat');
	}
	
	public function laporan_obat_asuransi()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporanobat_asuransi');
	}

	public function laporan_obat_ATY()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporanobat_ATY_semua_kota');
	}
	
	public function laporan_obat_ATY_semua_kota()
	{
	    $this->output->cache(0.1);
		$this->load->view('laporan/form_laporanobat_ATY');
	}

	public function penjualan_obat($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualanobat($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_penjualanobat', $dt);
	}
	
	public function penjualan_obat_asuransi($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualanobat_asuransi($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_penjualanobat_asuransi', $dt);
	}

	public function penjualan_obat_ATY($from, $to, $aty)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualanobat_ATY($from, $to, $aty);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$dt['Aty']			= $aty;
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualanobat_ATY', $dt);
	}
	
	public function penjualan_obat_ATY_semua_kota($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualanobat_ATY_semua_kota($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$dt['Aty']			= $aty;
		$this->output->cache(0.1);
		$this->load->view('laporan/laporan_penjualanobat_ATY_semua_kota', $dt);
	}

	public function laporan_herbalis()
	{
	    
		$this->load->view('laporan/form_laporanherbalis');
	}
	
	public function laporan_produk_perherbalis()
	{
	    
		$this->load->view('laporan/form_laporan_produk_perherbalis');
	}

	public function penjualan_herbalis($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualanherbalis($from, $to);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_penjualanherbalis', $dt);
	}
	
	public function penjualan_herbalis_perproduk($from, $to, $kde_herbalis)
	{
		$this->load->model('m_penjualan_master');
		$dt['penjualan'] 	= $this->m_penjualan_master->laporan_penjualanherbalis_perproduk($from, $to, $kde_herbalis);
		$dt['from']			= date('d F Y', strtotime($from));
		$dt['to']			= date('d F Y', strtotime($to));
		$this->load->view('laporan/laporan_penjualanherbalis_perproduk', $dt);
	}

	public function excel($from, $to)
	{
		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualan($from, $to);
		if($penjualan->num_rows() > 0)
		{
			$filename = 'Laporan_Penjualan_'.$from.'_'.$to;
			header("Content-type: application/x-msdownload");
			header("Content-Disposition: attachment; filename=".$filename.".xls");

			echo "
				<h4>Laporan Penjualan Tanggal ".date('d/m/Y', strtotime($from))." - ".date('d/m/Y', strtotime($to))."</h4>
				<table border='1' width='100%'>
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							<th>Total Penjualan</th>
						</tr>
					</thead>
					<tbody>
			";

			$no = 1;
			$total_penjualan = 0;
			foreach($penjualan->result() as $p)
			{
				echo "
					<tr>
						<td>".$no."</td>
						<td>".date('d F Y', strtotime($p->tanggal))."</td>
						<td>Rp. ".str_replace(",", ".", number_format($p->total_penjualan))."</td>
					</tr>
				";

				$total_penjualan = $total_penjualan + $p->total_penjualan;
				$no++;
			}

			echo "
				<tr>
					<td colspan='2'><b>Total Seluruh Penjualan</b></td>
					<td><b>Rp. ".str_replace(",", ".", number_format($total_penjualan))."</b></td>
				</tr>
			</tbody>
			</table>
			";
		}
	}
	
	public function pdf_rekap_data_pasien_klinik($tahun)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Data Pasien Klinik", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".$tahun, 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(8, 7, 'No', 1, 0, 'C'); /*
		$pdf->Cell(40, 7, 'Tanggal Transaksi', 1, 0, 'C');*/
		$pdf->Cell(20, 7, 'NRMP', 1, 0, 'C');
		$pdf->Cell(78, 7, 'Nama Pasien', 1, 0, 'C');
		$pdf->Cell(26, 7, 'Herbalis', 1, 0, 'C'); 
		$pdf->Cell(45, 7, 'No Telepon', 1, 0, 'C'); 
		$pdf->Cell(15, 7, 'Y / N', 1, 0, 'C');
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_rekap_pasien_klinik($tahun);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{	
			$pdf->SetFont('Arial','',9);
			$pdf->Cell(8, 7, $no, 1, 0, 'L'); /*
			$pdf->Cell(40, 7, $p->tanggal, 1, 0, 'L');*/
			$pdf->Cell(20, 7, $p->nrmp, 1, 0, 'L');
			$pdf->Cell(78, 7, $p->nama_pelanggan, 1, 0, 'L');
			$pdf->Cell(26, 7, $p->herbalis, 1, 0, 'L');
			$pdf->Cell(45, 7, '', 1, 0, 'L');
			$pdf->Cell(15, 7, '', 1, 0, 'L');
			$pdf->Ln();

			$total_penjualan = $total_penjualan + $p->total_penjualan;
			$no++;
		}
/*
		$pdf->Cell(130, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(55, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');*/
		$pdf->Ln();

		$pdf->Output();
	}

	public function pdf($from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage('L');
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Item Klinik", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(10, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(35, 7, 'Nomor Nota', 1, 0, 'C');
		$pdf->Cell(20, 7, 'Tanggal', 1, 0, 'C');
		$pdf->Cell(85, 7, 'Nama Pasien', 1, 0, 'C'); 
		$pdf->Cell(50, 7, 'Nama Produk', 1, 0, 'C'); 
		$pdf->Cell(10, 7, 'QTY', 1, 0, 'C'); 
		$pdf->Cell(30, 7, 'Harga Satuan', 1, 0, 'C');
		$pdf->Cell(35, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualan($from, $to);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{	
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(10, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(35, 7, $p->nomor_nota, 1, 0, 'L');
			$pdf->Cell(20, 7, $p->tanggal, 1, 0, 'L');
			$pdf->Cell(85, 7, $p->nrmp.' - '.$p->nama_pasien, 1, 0, 'L'); 
			$pdf->Cell(50, 7, $p->nama_barang, 1, 0, 'L');
			$pdf->Cell(10, 7, $p->jumlah_beli, 1, 0, 'C');
			$pdf->Cell(30, 7, "Rp. ".str_replace(",", ".", number_format($p->harga_satuan)), 1, 0, 'L');
			$pdf->Cell(35, 7, "Rp. ".str_replace(",", ".", number_format($p->total)), 1, 0, 'L');
			$pdf->Ln();

			$total_penjualan = $total_penjualan + $p->total;
			$no++;
		}
			$pdf->SetFont('Arial','B',11);
		$pdf->Cell(240, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(35, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}

	public function pdf_online($from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage('L');
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Item Online", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(10, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(35, 7, 'Nomor Nota', 1, 0, 'C');
		$pdf->Cell(20, 7, 'Tanggal', 1, 0, 'C');
		$pdf->Cell(85, 7, 'Nama Pasien', 1, 0, 'C'); 
		$pdf->Cell(50, 7, 'Nama Produk', 1, 0, 'C'); 
		$pdf->Cell(10, 7, 'QTY', 1, 0, 'C'); 
		$pdf->Cell(30, 7, 'Harga Satuan', 1, 0, 'C');
		$pdf->Cell(35, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualan_online($from, $to);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{	
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(10, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(35, 7, $p->nomor_nota, 1, 0, 'L');
			$pdf->Cell(20, 7, $p->tanggal, 1, 0, 'L');
			$pdf->Cell(85, 7, $p->nrmp.' - '.$p->nama_pasien, 1, 0, 'L'); 
			$pdf->Cell(50, 7, $p->nama_barang, 1, 0, 'L');
			$pdf->Cell(10, 7, $p->jumlah_beli, 1, 0, 'C');
			$pdf->Cell(30, 7, "Rp. ".str_replace(",", ".", number_format($p->harga_satuan)), 1, 0, 'L');
			$pdf->Cell(35, 7, "Rp. ".str_replace(",", ".", number_format($p->total)), 1, 0, 'L');
			$pdf->Ln();

			$total_penjualan = $total_penjualan + $p->total;
			$no++;
		}
			$pdf->SetFont('Arial','B',11);
		$pdf->Cell(240, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(35, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}

	public function pdf_perpasien_online($from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Pasien Online", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(15, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(35, 7, 'NRMP', 1, 0, 'C');
		$pdf->Cell(80, 7, 'Nama Pasien', 1, 0, 'C');
		$pdf->Cell(55, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualanpasien($from, $to);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{	
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(15, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(35, 7, $p->nrmp, 1, 0, 'L');
			$pdf->Cell(80, 7, $p->nama_pasien, 1, 0, 'L');
			$pdf->Cell(55, 7, "Rp. ".str_replace(",", ".", number_format($p->total_penjualan)), 1, 0, 'L');
			$pdf->Ln();

			$total_penjualan = $total_penjualan + $p->total_penjualan;
			$no++;
		}

		$pdf->Cell(130, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(55, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}
	
	public function pdf_perpasien_online_ATY($from, $to, $aty)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Pasien Online ".$aty."", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(15, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(35, 7, 'NRMP', 1, 0, 'C');
		$pdf->Cell(80, 7, 'Nama Pasien', 1, 0, 'C');
		$pdf->Cell(55, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualanpasien_ATY($from, $to, $aty);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{	
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(15, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(35, 7, $p->nrmp, 1, 0, 'L');
			$pdf->Cell(80, 7, $p->nama_pasien, 1, 0, 'L');
			$pdf->Cell(55, 7, "Rp. ".str_replace(",", ".", number_format($p->total_penjualan)), 1, 0, 'L');
			$pdf->Ln();

			$total_penjualan = $total_penjualan + $p->total_penjualan;
			$no++;
		}
        $pdf->SetFont('Arial','B',10);
		$pdf->Cell(130, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(55, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}
	
	public function pdf_perpasien_online_aty_semua($from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Pasien Online ATY Semua Kota", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11); 
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln(); 

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(10, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(30, 7, 'NRMP', 1, 0, 'C');
		$pdf->Cell(80, 7, 'Nama Pasien', 1, 0, 'C');
		$pdf->Cell(30, 7, 'Kota ATY', 1, 0, 'C');
		$pdf->Cell(40, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualanpasien_ATY_semua_kota($from, $to);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{	
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(10, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(30, 7, $p->nrmp, 1, 0, 'L');
			$pdf->Cell(80, 7, $p->nama_pasien, 1, 0, 'L');
			$pdf->Cell(30, 7, $p->ATY_kota, 1, 0, 'L');
			$pdf->Cell(40, 7, "Rp. ".str_replace(",", ".", number_format($p->total_penjualan)), 1, 0, 'L');
			$pdf->Ln();

			$total_penjualan = $total_penjualan + $p->total_penjualan;
			$no++;
		}
        $pdf->SetFont('Arial','B',10);
		$pdf->Cell(150, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(40, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}

	public function pdf_perpasien_klinik($from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Pasien Klinik", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(15, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(35, 7, 'NRMP', 1, 0, 'C');
		$pdf->Cell(80, 7, 'Nama Pasien', 1, 0, 'C');
		$pdf->Cell(55, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualanpasien_klinik($from, $to);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{	
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(15, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(35, 7, $p->nrmp, 1, 0, 'L');
			$pdf->Cell(80, 7, $p->nama_pasien, 1, 0, 'L');
			$pdf->Cell(55, 7, "Rp. ".str_replace(",", ".", number_format($p->total_penjualan)), 1, 0, 'L');
			$pdf->Ln();

			$total_penjualan = $total_penjualan + $p->total_penjualan;
			$no++;
		}

		$pdf->Cell(130, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(55, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}

	public function pdf_persales($from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Sales", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(10, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(50, 7, 'Nama Sales', 1, 0, 'C');
		$pdf->Cell(40, 7, 'Total Obat', 1, 0, 'C');
		$pdf->Cell(90, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualansales($from, $to);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(10, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(50, 7, $p->nama_sales, 1, 0, 'L'); 
			$pdf->Cell(40, 7, $p->total_Obat, 1, 0, 'C'); 
			$pdf->Cell(90, 7, "Rp. ".str_replace(",", ".", number_format($p->total_penjualan)), 1, 0, 'L');
			$pdf->Ln();

			$total_obat = $total_obat + $p->total_Obat;
			$total_penjualan = $total_penjualan + $p->total_penjualan;
			$no++;
		}
        $pdf->SetFont('Arial','B',10);
		$pdf->Cell(60, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(40, 7, $total_obat, 1, 0, 'C'); 
		$pdf->Cell(90, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}
	
	public function pdf_persales_ATY($from, $to, $Aty)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Sales ATY (".$Aty.")", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(10, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(50, 7, 'Nama Sales', 1, 0, 'C');
		$pdf->Cell(40, 7, 'Total Obat', 1, 0, 'C');
		$pdf->Cell(90, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualansales_ATY($from, $to, $Aty);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(10, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(50, 7, $p->nama_sales, 1, 0, 'L'); 
			$pdf->Cell(40, 7, $p->total_Obat, 1, 0, 'C'); 
			$pdf->Cell(90, 7, "Rp. ".str_replace(",", ".", number_format($p->total_penjualan)), 1, 0, 'L');
			$pdf->Ln();

			$total_obat = $total_obat + $p->total_Obat;
			$total_penjualan = $total_penjualan + $p->total_penjualan;
			$no++;
		}
        $pdf->SetFont('Arial','B',10);
		$pdf->Cell(60, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(40, 7, $total_obat, 1, 0, 'C'); 
		$pdf->Cell(90, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}
	
	public function pdf_persales_ATY_semua_kota($from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Sales ATY ( Semua Kota )", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(10, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(50, 7, 'Nama Sales', 1, 0, 'C');
		$pdf->Cell(40, 7, 'Total Obat', 1, 0, 'C');
		$pdf->Cell(90, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualansales_ATY_semua_kota($from, $to);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(10, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(50, 7, $p->nama_sales, 1, 0, 'L'); 
			$pdf->Cell(40, 7, $p->total_Obat, 1, 0, 'C'); 
			$pdf->Cell(90, 7, "Rp. ".str_replace(",", ".", number_format($p->total_penjualan)), 1, 0, 'L');
			$pdf->Ln();

			$total_obat = $total_obat + $p->total_Obat;
			$total_penjualan = $total_penjualan + $p->total_penjualan;
			$no++;
		}
        $pdf->SetFont('Arial','B',10);
		$pdf->Cell(60, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(40, 7, $total_obat, 1, 0, 'C'); 
		$pdf->Cell(90, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}
	
		public function pdf_perproduk($from, $to, $sales)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Produk", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(10, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(40, 7, 'Nama Sales', 1, 0, 'C');
		$pdf->Cell(30, 7, 'Total Obat', 1, 0, 'C');
		$pdf->Cell(70, 7, 'Nama Obat', 1, 0, 'C');
		$pdf->Cell(50, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualansales_perproduk($from, $to, $sales);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(10, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(40, 7, $p->nama_sales, 1, 0, 'L'); 
			$pdf->Cell(30, 7, $p->jumlah_beli, 1, 0, 'C');  
			$pdf->Cell(70, 7, $p->nama_barang, 1, 0, 'L');
			$pdf->Cell(50, 7, "Rp. ".str_replace(",", ".", number_format($p->total)), 1, 0, 'L');
			$pdf->Ln();

			$total_obat = $total_obat + $p->jumlah_beli;
			$total_penjualan = $total_penjualan + $p->total;
			$no++;
		}
        $pdf->SetFont('Arial','B',10);
		$pdf->Cell(50, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(30, 7, $total_obat, 1, 0, 'C'); 
		$pdf->Cell(70, 7,'', 1, 0, 'C'); 
		$pdf->Cell(50, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}
	
		public function pdf_perproduk_aty($from, $to, $sales, $aty_kota)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Produk ATY (" .$aty_kota. ")", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(10, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(40, 7, 'Nama Sales', 1, 0, 'C');
		$pdf->Cell(30, 7, 'Total Obat', 1, 0, 'C');
		$pdf->Cell(40, 7, 'Nama Obat', 1, 0, 'C');
		$pdf->Cell(70, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualansales_perproduk_ATY($from, $to, $sales, $aty_kota);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(10, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(40, 7, $p->nama_sales, 1, 0, 'L'); 
			$pdf->Cell(30, 7, $p->jumlah_beli, 1, 0, 'C');  
			$pdf->Cell(40, 7, $p->nama_barang, 1, 0, 'L');
			$pdf->Cell(70, 7, "Rp. ".str_replace(",", ".", number_format($p->total)), 1, 0, 'L');
			$pdf->Ln();

			$total_obat = $total_obat + $p->jumlah_beli;
			$total_penjualan = $total_penjualan + $p->total;
			$no++;
		}
        $pdf->SetFont('Arial','B',10);
		$pdf->Cell(50, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(30, 7, $total_obat, 1, 0, 'C'); 
		$pdf->Cell(40, 7,'', 1, 0, 'C'); 
		$pdf->Cell(70, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}

	public function pdf_perherbalis($from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Herbalis", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(15, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(45, 7, 'Nama Sales', 1, 0, 'C');
		$pdf->Cell(35, 7, 'Total Obat', 1, 0, 'C');
		$pdf->Cell(85, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualanherbalis($from, $to);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(15, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(45, 7, $p->nama_herbalis, 1, 0, 'L'); 
			$pdf->Cell(35, 7, $p->total_Obat, 1, 0, 'L'); 
			$pdf->Cell(85, 7, "Rp. ".str_replace(",", ".", number_format($p->total_penjualan)), 1, 0, 'L');
			$pdf->Ln();

			$total_obat = $total_obat + $p->total_Obat;
			$total_penjualan = $total_penjualan + $p->total_penjualan;
			$no++;
		}

		$pdf->Cell(60, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(35, 7, $total_obat, 1, 0, 'L'); 
		$pdf->Cell(85, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}

	public function pdf_obat_online($from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Obat Online", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(15, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(45, 7, 'Nama Obat', 1, 0, 'C');
		$pdf->Cell(35, 7, 'Satuan', 1, 0, 'C');
		$pdf->Cell(10, 7, 'QTY', 1, 0, 'C');
		$pdf->Cell(40, 7, 'Harga Jual', 1, 0, 'C'); 
		$pdf->Cell(45, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualanobat($from, $to);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(15, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(45, 7, $p->nama_obat, 1, 0, 'L'); 
			$pdf->Cell(35, 7, $p->satuan, 1, 0, 'L'); 
			$pdf->Cell(10, 7, $p->total_Obat, 1, 0, 'L');
			$pdf->Cell(40, 7, "Rp. ".str_replace(",", ".", number_format($p->harga_satuan)), 1, 0, 'L');
			$pdf->Cell(45, 7, "Rp. ".str_replace(",", ".", number_format($p->total_penjualan)), 1, 0, 'L');
			$pdf->Ln();

			$total_obat = $total_obat + $p->total_Obat;
			$total_penjualan = $total_penjualan + $p->total_penjualan;
			$no++;
		}

		$pdf->Cell(95, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(10, 7, $total_obat, 1, 0, 'L'); 
		$pdf->Cell(40, 7,'', 1, 0, 'L'); 
		$pdf->Cell(45, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}
	
	public function pdf_obat_online_ATY($from, $to, $aty)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Obat Online ".$aty."", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(15, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(45, 7, 'Nama Obat', 1, 0, 'C');
		$pdf->Cell(35, 7, 'Satuan', 1, 0, 'C');
		$pdf->Cell(10, 7, 'QTY', 1, 0, 'C');
		$pdf->Cell(40, 7, 'Harga Jual', 1, 0, 'C'); 
		$pdf->Cell(45, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualanobat_ATY($from, $to, $aty);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(15, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(45, 7, $p->nama_obat, 1, 0, 'L'); 
			$pdf->Cell(35, 7, $p->satuan, 1, 0, 'L'); 
			$pdf->Cell(10, 7, $p->total_Obat, 1, 0, 'L');
			$pdf->Cell(40, 7, "Rp. ".str_replace(",", ".", number_format($p->harga_satuan)), 1, 0, 'L');
			$pdf->Cell(45, 7, "Rp. ".str_replace(",", ".", number_format($p->total_penjualan)), 1, 0, 'L');
			$pdf->Ln();

			$total_obat = $total_obat + $p->total_Obat;
			$total_penjualan = $total_penjualan + $p->total_penjualan;
			$no++;
		}
	    $pdf->SetFont('Arial','B',10);
		$pdf->Cell(95, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(10, 7, $total_obat, 1, 0, 'L'); 
		$pdf->Cell(40, 7,'', 1, 0, 'L'); 
		$pdf->Cell(45, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}
	
	public function pdf_obat_online_ATY_semua_kota($from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Obat Online ATY SEMUA KOTA ", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(15, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(45, 7, 'Nama Obat', 1, 0, 'C');
		$pdf->Cell(35, 7, 'Satuan', 1, 0, 'C');
		$pdf->Cell(10, 7, 'QTY', 1, 0, 'C');
		$pdf->Cell(40, 7, 'Harga Jual', 1, 0, 'C'); 
		$pdf->Cell(45, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualanobat_ATY_semua_kota($from, $to);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(15, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(45, 7, $p->nama_obat, 1, 0, 'L'); 
			$pdf->Cell(35, 7, $p->satuan, 1, 0, 'L'); 
			$pdf->Cell(10, 7, $p->total_Obat, 1, 0, 'L');
			$pdf->Cell(40, 7, "Rp. ".str_replace(",", ".", number_format($p->harga_satuan)), 1, 0, 'L');
			$pdf->Cell(45, 7, "Rp. ".str_replace(",", ".", number_format($p->total_penjualan)), 1, 0, 'L');
			$pdf->Ln();

			$total_obat = $total_obat + $p->total_Obat;
			$total_penjualan = $total_penjualan + $p->total_penjualan;
			$no++;
		}
	    $pdf->SetFont('Arial','B',10);
		$pdf->Cell(95, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(10, 7, $total_obat, 1, 0, 'L'); 
		$pdf->Cell(40, 7,'', 1, 0, 'L'); 
		$pdf->Cell(45, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}

	public function pdf_obat_klinik($from, $to)
	{
		$this->load->library('cfpdf');
					
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',10);

		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(0, 5, "Laporan Rekap Penjualan Per Obat klinik", 0, 1, 'C');
		$pdf->SetFont('Arial','B',11);
		$pdf->Cell(0, 5, "Periode ".date('d F Y', strtotime($from))." - ".date('d F Y', strtotime($to)), 0, 1, 'C'); 
		$pdf->SetFont('Arial','',11);
		$pdf->Cell(0, 5, "(Dalam Rupiah)", 0, 1, 'C'); 
		$pdf->Ln();

		$pdf->SetFont('Arial','B',10);
		$pdf->Cell(15, 7, 'No', 1, 0, 'C'); 
		$pdf->Cell(45, 7, 'Nama Obat', 1, 0, 'C');
		$pdf->Cell(35, 7, 'Satuan', 1, 0, 'C');
		$pdf->Cell(10, 7, 'QTY', 1, 0, 'C');
		$pdf->Cell(40, 7, 'Harga Jual', 1, 0, 'C'); 
		$pdf->Cell(45, 7, 'Total Penjualan', 1, 0, 'C'); 
		$pdf->Ln();

		$this->load->model('m_penjualan_master');
		$penjualan 	= $this->m_penjualan_master->laporan_penjualanobat_klinik($from, $to);

		$no = 1;
		$total_penjualan = 0;
		foreach($penjualan->result() as $p)
		{
			$pdf->SetFont('Arial','',10);
			$pdf->Cell(15, 7, $no, 1, 0, 'L'); 
			$pdf->Cell(45, 7, $p->nama_obat, 1, 0, 'L'); 
			$pdf->Cell(35, 7, $p->satuan, 1, 0, 'L'); 
			$pdf->Cell(10, 7, $p->total_Obat, 1, 0, 'L');
			$pdf->Cell(40, 7, "Rp. ".str_replace(",", ".", number_format($p->harga_satuan)), 1, 0, 'L');
			$pdf->Cell(45, 7, "Rp. ".str_replace(",", ".", number_format($p->total_penjualan)), 1, 0, 'L');
			$pdf->Ln();

			$total_obat = $total_obat + $p->total_Obat;
			$total_penjualan = $total_penjualan + $p->total_penjualan;
			$no++;
		}

		$pdf->Cell(95, 7, 'Total Seluruh Penjualan', 1, 0, 'C'); 
		$pdf->Cell(10, 7, $total_obat, 1, 0, 'L'); 
		$pdf->Cell(40, 7,'', 1, 0, 'L'); 
		$pdf->Cell(45, 7, "Rp. ".str_replace(",", ".", number_format($total_penjualan)), 1, 0, 'L');
		$pdf->Ln();

		$pdf->Output();
	}
}