<?php
function hexTo32Float($number){
    $binfinal    = sprintf("%032b", hexdec($number));
    $sign        = substr($binfinal, 0, 1);
    $exp         = substr($binfinal, 1, 8);
    $mantissa    = "1" . substr($binfinal, 9);
    $mantissa    = str_split($mantissa);
    $exp         = bindec($exp) - 127;
    $significand = 0;
    
    for ($i = 0; $i < 24; $i++) {
        $significand += (1 / pow(2, $i)) * $mantissa[$i];
    }
    return $significand * pow(2, $exp) * ($sign * -2 + 1);
}

function hitung_parsing(){
	
}

function parsing_rawpayload($rawpayload, $jmldata){
	//echo 'Jumlah Parsing : '.$jmldata.'<br>';
	//if ($gw==1){
		//echo 'Parsing KureyGeyo<br>';
	//}
	//else {
		$a = base64_decode($rawpayload);
		//echo 'Data RawPayloadnya : '.$a.'<br>';
		$x = '';
		foreach (str_split($a) as $c) {
			$b = sprintf("%08b", ord($c));
			//echo $b.' ';
			$x = $x .$b;
			//echo $x.'<br>';
		}
		$data = array();
		$x = substr($x,16);
		
		for ($i=0; $i < $jmldata; $i++){
			$x = substr($x,5);
			$data_i = substr($x,0,32);
			$hex_i   = '0x' . dechex(bindec($data_i));
			$hasil_i = round(hexTo32Float($hex_i),6);
			array_push($data,$hasil_i);
			
			$x = substr($x, 32);
			if ($i==0){
				$d_waktu  = date('Y-m-d H:i:s', $hasil_i);
				//array_push($data,$hasil_i);
				echo '<u>Data pada Waktu (Local +7) : '.$d_waktu.', EpochTime : ' .$hasil_i.'</u><br>'; 
			} 
			
		}
	//}
	
	
	return $data;
}

//echo 'ini hasil parsing';
//echo $_POST['start'].' s/d '.$_POST['end'].' => '.strtoupper($_POST['modem']).'<br>';
//echo 'gaetway'. $_POST['gw'].'<br>';
$gw = $_POST['gw'];
$jml_tu = $_POST['tu'];


$mulai = $_POST['start']; echo 'Ambil Data Mulai (+07:00) : '.$mulai;
$mulai_utc = date_create($mulai);
$mulai_utc->setTimeZone(new DateTimeZone('UTC'));
$start_utc = $mulai_utc->format('Y-m-d H:i:s');
echo ' || (+00:00) : '.$start_utc.'<br>';

$akhir = $_POST['end']; echo 'Ambil Data Sampai (+07:00) : '.$akhir;
$akhir_utc = date_create($akhir);
$akhir_utc->setTimeZone(new DateTimeZone('UTC'));
$end_utc = $akhir_utc->format('Y-m-d H:i:s');
echo ' || (+00:00) : '.$end_utc.'<br>';

$mobile_id = strtoupper($_POST['modem']);
$url1 = 'http://m2prime.aissat.com/RestMessages.svc/get_return_messages.xml/?access_id=150103286&password=ZRM3B9SSDI';
$url2 = 'http://isatdatapro.skywave.com/GLGW/GWServices_v1/RestMessages.svc/get_return_messages.xml/?access_id=70000214&password=STSATI2010';

//$link_url = $url.'&start_utc='.$start_utc.'&end_utc='.$end_utc.'&mobile_id='.$mobile_id;
//echo $url.'&start_utc='.$start_utc.'&end_utc='.$end_utc .'&mobile_id='.$mobile_id .'<br>';
echo '<hr>';

switch ($gw) {
    case 1 :  $link_url = $url1.'&start_utc='.$start_utc.'&end_utc='.$end_utc.'&mobile_id='.$mobile_id;
				xml_RawPayload($link_url,$jml_tu);
				break;
    case 2:  $link_url = $url2.'&start_utc='.$start_utc.'&end_utc='.$end_utc.'&mobile_id='.$mobile_id;
				xml_Payload($link_url,$jml_tu);
				break;
}

//url_parsing($link_url,$gw);
//xml_RawPayload($link_url);

//function url_parsing($url,$gw){
	////echo 'isi link di function url_parsing :'.$url.'<br>';
	//switch ($gw){
			//case 1 : //echo 'Gunakan parsing RawPayload';
					//xml_RawPayload($url);
					//break;
			//case 2 : echo 'Gunakan parsing Payload'; 
					//xml_Payload();
					//break;
	//}
//}

function xml_RawPayload($link,$jml_tu){
	//echo 'isi link di function xml Rawpayload :'.$link.'<br>';
	$filexml = simplexml_load_file($link);
	//print_r($filexml); 
	foreach ($filexml->Messages->ReturnMessage as $retmes){
		//echo '<pre>';
		//print_r($retmes);
		//echo '<pre>';
		if (($retmes->SIN[0])==128){
			//echo $retmes->RawPayload[0].'<br>';
			//echo '<pre>';
			//print_r($retmes->RawPayload[0]);
			//echo '<pre>';
			echo '<pre>';
			print_r(parsing_rawpayload($retmes->RawPayload[0],$jml_tu));
			echo '<pre>';
		}
	}
		
		//echo '<pre>';
		//print_r($retmes);
		//echo '<pre>';
		////$ddd = $retmes->MessageUTC[0];
		////echo '<br>Pesan pada Waktu (UTC) : '. $ddd.'<br>';
		////$waktu_sini = new DateTime($ddd,new DateTimeZone('UTC'));
		//////$waktu_sini = new DateTime($retmes->MessageUTC[0]);
		////$waktu_sini->setTimeZone(new DateTimeZone('Asia/Jakarta'));
		////echo 'Pesan pada Waktu (Local +7) : '.$waktu_sini->format('Y-m-d H:i:s').'<br>';
		//////echo 'Waktu Local Sini : '.$waktu_sini->format('Y-m-d H:i:s').'<br>';
		//////echo '//------------- //<br>';
		////if (($retmes->SIN[0])==128){
			////echo $retmes->RawPayload[0].'<br>';
			
			////$jml = 30;
			////echo '<pre>';
			////print_r(parsing_rawpayload($retmes->RawPayload[0],$jml));
			////echo '<pre>';
			//////echo '<br>';
			////echo '=====================================================================';
			////echo '<br>';
		////}
	//}
}

function xml_Payload(){
	echo 'under Constrction<br>';
	//return
}

?>

