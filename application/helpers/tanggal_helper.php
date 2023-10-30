<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('tanggal')) {
	function tgl_system($tgl)
	{
		$tgl = date('Y-m-d', strtotime($tgl));
		return $tgl;
	}

	function tgl_tampil($tgl)
	{
		$tgl = date('d-m-Y', strtotime($tgl));
		return $tgl;
	}


	function tglJam_system($tgl)
	{
		$tgl = date('Y-m-d H:i:s', strtotime($tgl));
		return $tgl;
	}

	function tglJam_tampil($tgl)
	{
		$tgl = date('d-m-Y H:i:s', strtotime($tgl));
		return $tgl;
	}

	function limit_words2($string, $word_limit)
	{
		$words = explode(" ", $string);
		return implode(" ", array_splice($words, 0, $word_limit));
	}

	function tgl_batas($tgl)
	{
		$tgl = date('Y-m-d', strtotime('-1 day', strtotime($tgl)));
		return $tgl;
	}

	function selisihTampilJam($dari, $sampai)
	{
		$selisih = (strtotime($sampai) - strtotime($dari));
		$day = floor($selisih / (3600 * 24));
		$jam = floor(($selisih - ($day * (3600 * 24))) / (60 * 60));
		return $day . " Hari " . $jam . " Jam";
	}

	function selisihJam($dari, $sampai)
	{
		$selisih = (strtotime($sampai) - strtotime($dari));
		$day = floor($selisih / (3600 * 24));
		$jam = floor(($selisih - ($day * (3600 * 24))) / (60 * 60));
		if ($dari == $sampai) {
			$timeused = 0;
		} else {
			if ($jam <= 6) {
				$timeused = $day + 0.5;
			} else {
				$timeused = $day + 1;
			}
		}
		return $timeused;
	}

	function selisihTanggal($dari, $sampai)
	{
		$awal = date_create($dari);
		$akhir = date_create($sampai);
		//menghitung selisih dengan hasil detik
		$diff  = date_diff($awal, $akhir);
		return $diff->m . " bulan " . $diff->d . " hari " . $diff->h . " jam";
	}

	function pembulatan($uang)
	{
		$uang = number_format($uang, 0, ".", "");
		$ratusan = substr($uang, -2);
		if ($ratusan < 50) {
			$akhir = $uang + (50 - $ratusan);
		} else {
			$akhir = $uang + (100 - $ratusan);
		}
		return number_format($akhir, 2, '.', '');;
	}


	function saveRupiah($uang)
	{
		$uang1 = str_replace(".", "", $uang);
		$uang2 = str_replace(",", ".", $uang1);


		return $uang2;
	}

	function waktu()
	{
		date_default_timezone_set("Asia/Jakarta");
		$jam = date('H:i');
		// cekvar($jam);
		if ($jam >= '05:30' && $jam < '10:00') {
			$salam = 'Salam Pagi';
		} elseif ($jam >= '10:00' && $jam < '15:00') {
			$salam = 'Salam Siang';
		} elseif ($jam <= '18:00' && $jam > '15:00') {
			$salam = 'Salam Sore';
		} else if ($jam >= '03:00'  && $jam <= '05:30') {
			$salam = 'Salam Subuh';
		} else {
			$salam = 'Salam Malam';
		}
		return $salam;
	}
}

function format_indo($date)
{
	date_default_timezone_set('Asia/Jakarta');
	// array hari dan bulan
	$Hari = array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu");
	$Bulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

	// pemisahan tahun, bulan, hari, dan waktu
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl = substr($date, 8, 2);
	$waktu = substr($date, 11, 5);
	$hari = date("w", strtotime($date));
	$result = $Hari[$hari] . ", " . $tgl . " " . $Bulan[(int)$bulan - 1] . " " . $tahun . " " . $waktu;

	return $result;
}
function daySql($tgl)
{
	$tgl = date('l', strtotime($tgl));
	$day = intval($tgl) - 1;
	return $day;
}
