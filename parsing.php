<?php
include	'asset/inc/config.php';
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


function parsing_payload($payload, $jmldata){
	//echo 'Jumlah Parsing : '.$jmldata.'<br>';
	//print_r($payload);
	$data = array();
	
	//$asd = hexTo32Float(dechex($payload[1]));
	//echo $asd.'<br>'; 
	
	for ($i=0; $i < $jmldata; $i++){
			//$x = substr($x,5);
			//$data_i = substr($x,0,32);
			$nilai = dechex($payload[$i]) ;
			$nilaix = (strlen($nilai) > 8) ? substr($nilai,8) : $nilai;
			//$hex_i   = '0x' . dechex($payload[$i]);
			$hasil = round(hexTo32Float($nilaix),6);
			array_push($data,$hasil);
			
			//$x = substr($x, 32);
			if ($i==0){
				$d_waktu  = date('Y-m-d H:i:s', $hasil);
				//array_push($data,$hasil_i);
				echo '<u>Data pada Waktu (Local +7) : '.$d_waktu.', EpochTime : ' .$hasil.'</u><br>'; 
			} 
//			if $(
			if ($i==2)	{
				echo "testing<br/>";
			}
		}
	//ECHO $tanggal.'<br>';
	
	return $data;
}

//echo 'ini hasil parsing';
//echo $_POST['start'].' s/d '.$_POST['end'].' => '.strtoupper($_POST['modem']).'<br>';
//echo 'gaetway'. $_POST['gw'].'<br>';
//$gw = $_POST['gw'];
$jml_tu = $_POST['tu'];

$mobile_id = strtoupper($_POST['modem']);

//$servername = "localhost";
//$username = "marine";
//$password = "monita2014";
//$dbname = "marine_1";
$modem = array();
try {
    //$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT gateway AS gw, CONCAT(g.url,'get_return_messages.xml/?access_id=',s.access_id,'&password=',s.password) as url FROM ship s, gateway g WHERE s.modem_id like '$mobile_id' AND s.gateway=g.id";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach($stmt->fetchAll() as $k=>$urlx) {
//        print_r($urlx); echo "<br/>";
//        array_push($modem, $v);
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$url = $urlx['url'];
$gw  = $urlx['gw'];
//print_r($url['url']); echo "<br/>";
//echo $v;
//echo "url: {$urlx['url']}<br/>";
//echo "gateway: {$url['gw']}";

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
    case 2 :  $link_url = $url.'&start_utc='.$start_utc.'&end_utc='.$end_utc.'&mobile_id='.$mobile_id;
				xml_RawPayload($link_url,$jml_tu);
				break;
    case 1:  $link_url = $url.'&start_utc='.$start_utc.'&end_utc='.$end_utc.'&mobile_id='.$mobile_id;
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
	echo '<a href="'.$link.'" target="_blank">'.$link.'</a><br>';
	
	$filexml = simplexml_load_file($link);
	//print_r($filexml); 
	foreach ($filexml->Messages->ReturnMessage as $retmes){
		$msg_kirim = $retmes->MessageUTC[0];
		echo '<br>Pesan dikirm pada (+00:00) : '. $msg_kirim;
		$waktu_sini = new DateTime($msg_kirim,new DateTimeZone('UTC'));
		$waktu_sini->setTimeZone(new DateTimeZone('Asia/Jakarta'));
		echo ' || (+07:00) : '.$waktu_sini->format('Y-m-d H:i:s').'<br>';//echo '<pre>';
		//print_r($retmes);
		//echo '<pre>';
		if (($retmes->SIN[0])==128){
			//echo $retmes->RawPayload[0].'<br>';
			//echo '<pre>';
			//print_r($retmes->RawPayload[0]);
			//echo '<pre>';
//			echo '<pre>';
//			print_r(parsing_rawpayload($retmes->RawPayload[0],$jml_tu));
//			echo '<pre>';

			$dt = parsing_rawpayload($retmes->RawPayload[0],$jml_tu);
			echo '<pre>';
			if (count($dt)>=3)
				echo "Lihat Peta : <a href='https://www.google.com/maps?q={$dt[1]},{$dt[2]}' target='_new'>Google Maps</a><br/>";
			print_r($dt);
			echo '</pre>';
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

function xml_Payload($link,$jml_tu){
	//echo 'under Constrction<br>';
	//return
	echo '<a href="'.$link.'" target="_blank">'.$link.'</a><br>';
	
	$filexml = simplexml_load_file($link);
	
	//foreach ($filexml->Messages->ReturnMessage->Payload as $retmes){
	foreach ($filexml->Messages->ReturnMessage as $retmes){
		$msg_kirim = $retmes->MessageUTC[0];
		echo '<br>Pesan dikirm pada (+00:00) : '. $msg_kirim;
		$waktu_sini = new DateTime($msg_kirim,new DateTimeZone('UTC'));
		$waktu_sini->setTimeZone(new DateTimeZone('Asia/Jakarta'));
		echo ' || (+07:00) : '.$waktu_sini->format('Y-m-d H:i:s').'<br>';//echo '<pre>';
		
		$payload = array();
		if ( isset($retmes->Payload['SIN'][0])==128 && isset($retmes->Payload['MIN'][0])==1){
			foreach ($retmes->Payload->Fields->Field as $data ){
				array_push($payload,$data['Value'][0]);
			}
		}
		
//		echo '<pre>';
//		print_r(parsing_payload($payload,$jml_tu));
//		echo '<pre>';

		$dt = parsing_payload($payload,$jml_tu);
		echo '<pre>';
		if (count($dt)>=3)
			echo "Lihat Peta : <a href='https://www.google.com/maps?q={$dt[1]},{$dt[2]}' target='_new'>Google Maps</a><br/>";
		print_r($dt);
		echo '</pre>';
		
	}
	
}

?>

