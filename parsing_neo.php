<?php



$rawpayload = 'gAFydeBBM5Ex6AAYAOPczMzXH8AAADkUuqaZx2hgGG7AzOgbchauNEOQmbMzWADkLGAAAA==';


// strbin($rawpayload);

$rawtostr = strbin($rawpayload);

$hasil = parsebin($rawtostr);
// echo '<pre>';
// print_r($hasil);
// echo '</pre>';

foreach ($hasil as $val){
    // echo $val.'</br>';
    echo bin2nilai($val).'</br>';
}


function strbin($rawpl){
    $hexb64 = base64_decode($rawpl);

    //hex to string biner
    $x = '';
    foreach (str_split($hexb64) as $c) {
        $b = sprintf("%08b", ord($c));
        // echo $b.' </br>';
        $x = $x .$b;
        // echo $x.'<br>';
    }
    
    // String biner dipotong depannya (SIN = 128, MIN = 1)
    
    $x = substr($x,16);
    
    return $x;

}

function parsebin($strbin){
    $arr = array();
    $len = strlen($strbin);

    $temp1 = $strbin;
    $temp2 = '';
    // echo $temp1.'<br>';
    // $cek = substr($temp1,0,5);
    // echo $cek.'<br>';
    
    for ($i=0; $i<$len; $i++)
    {
        // echo substr($temp1,0,37).'</br>';
        $a =  substr($temp1,0,5);
        if(strcmp($a,'01110')==0)
        {
            // echo '0xOE </br>';
            $temp2 = substr($temp1,0,37);
            $temp1 = substr($temp1,37);
        }    

        elseif(strcmp($a,'01101')==0)
        {
            // echo '0xOD </br>';
            $temp2 = substr($temp1,0,21);
            $temp1 = substr($temp1,21);
        }
        elseif(strcmp($a,'01100')==0)
        {
            // echo '0xOC </br>';
            $temp2 = substr($temp1,0,13);
            $temp1 = substr($temp1,13);
        }

        // array_push($arr,$temp2);
        array_push($arr,substr($temp2,5));  //sudah biner datanya yang di ambil

        if (strlen($temp1) < 13) break;
    }

    return $arr;
}


function bin2nilai($binary)
{
    $hex = '0x' . dechex(bindec($binary));
	$hasil = round(hexTo32Float($hex),6);
    return $hasil;
}

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

?>