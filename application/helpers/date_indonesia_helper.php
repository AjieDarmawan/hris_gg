<?php

function TanggalIndo($date)
{
	if($date == "")
	{
		return null;
	}

	if($date == "0000-00-00")
	{
		return null;
	}
	
	$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
 
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl   = substr($date, 8, 2);
 
	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;		
	return($result);
}

function BulanIndo($bln){
	$bulan = $bln;
	Switch ($bulan){
	 case 1 : $bulan="Januari";
	 Break;
	 case 2 : $bulan="Februari";
	 Break;
	 case 3 : $bulan="Maret";
	 Break;
	 case 4 : $bulan="April";
	 Break;
	 case 5 : $bulan="Mei";
	 Break;
	 case 6 : $bulan="Juni";
	 Break;
	 case 7 : $bulan="Juli";
	 Break;
	 case 8 : $bulan="Agustus";
	 Break;
	 case 9 : $bulan="September";
	 Break;
	 case 10 : $bulan="Oktober";
	 Break;
	 case 11 : $bulan="November";
	 Break;
	 case 12 : $bulan="Desember";
	 Break;
	 }
	return $bulan;
}

function DayIndonesia($tanggal)
{
	$day = date('N', $tanggal);	
	$dayList = array(
		'7' => 'Minggu',
		'1' => 'Senin',
		'2' => 'Selasa',
		'3' => 'Rabu',
		'4' => 'Kamis',
		'5' => 'Jumat',
		'6' => 'Sabtu'
	);
	return $dayList[$day];
}

function getRangeDate($bulan,$tahun)
{
	$list=array();
	for($d=1; $d<=31; $d++)
	{
		$time=mktime(12, 0, 0, $bulan, $d, $tahun);          
		if (date('m', $time)==$bulan)
		{
			$list[]=array(
				'date'=>date('Y-m-d', $time),
				'day'=>DayIndonesia($time),
				'weekday' => (date('N',$time) == 6 || date('N',$time) == 7 ? 0 : 1),
			);   
		}
	}
	return $list;
}
// docs : http://php.net/manual/en/function.date-diff.php
function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
    
    $interval = date_diff($datetime1, $datetime2);
    
    return $interval->format($differenceFormat);
    
}

