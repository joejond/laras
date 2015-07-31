<?php
/*
 * index.php
 * 
 * Copyright 2015 jono <jono@jonodbe>
 * 
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 * 
 * 
 */

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>LARAS || Parsing Satelit</title>
	
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.23.1" />
	<link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" media="all" type="text/css" href="asset/js/jquery-ui-timepicker-addon.css" />
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
	
	<style>
		.ui-datepicker{ font-size: 85%; }
	</style>
</head>

<body>
	<h1>LARAS (tooLs pARsing A Satelite) v0.0</h1>

<?php 
$servername = "localhost";
$username = "marine";
$password = "monita2014";
$dbname = "marine_1";
$modem = array();
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT CONCAT(s.modem_id,' - ',s.name) AS nama, s.modem_id FROM ship s ORDER BY s.name ASC"); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
    foreach($stmt->fetchAll() as $k=>$v) {
//        print_r($v); echo "<br/>";
	array_push($modem, $v);
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
//print_r($modem);
?>

	<form id="form1" action="" method="POST">
		<table>
			<tr>
				<td>Waktu Sekarang</td>
				<td>:</td>
				<td><?php
					$skr = new DateTime();
					echo '(+07.00)-> '.$skr->format('Y-m-d H:i:s');
					$skr_utc = $skr;
					$skr_utc->setTimeZone(new DateTimeZone('UTC'));
					echo ' || (+00.00)-> '.$skr_utc->format('Y-m-d H:i:s').'<br>';
				
				?></td>
			</tr>
			<tr>
				<td>Start Ambil Data</td>
				<td>:</td>
				<td><input type="text" id="start" name="start" value="<?php $saiki = new DateTime(); $saiki->modify('-1 hour'); echo $saiki->format('Y-m-d H:i:s');?>" required></td>
			</tr>
			<tr>
				<td>End Ambil Data</td>
				<td>:</td>
				<td><input type="text" id="end" name="end" value="<?php $saiki = new DateTime(); echo $saiki->format('Y-m-d H:i:s');?>" required></td> 
			</tr>
<?php 
?>
			<tr>
				<td>Modem</td>
				<td>:</td>
				<td><!--input type="text" id="modem" name="modem" maxlength="15" minlength="15" style="text-transform:uppercase" required-->
					<select id="modem" name="modem" required>
<!--
						<option  selected>-- Pilih Modem --</option>
-->
					<?php
						foreach($modem as $m)	{
							echo "<option value='{$m['modem_id']}'>{$m['nama']}</option>";
						}
					?>
					</select>
				</td>
			</tr>
			<!--tr>
				<td>Gateway</td>
				<td>:</td>
				<td>
					<select id="gw" name="gw" required>
						<option value='2'>isatdatapro.skywave.com</option> 
						<option value='1' selected="selected" >m2prime.aissat.com</option>
						
					</select>
				</td>
			</tr-->
			<tr>
				<td>Jumlah Titik Ukur</td>
				<td>:</td>
				<td><input type="number" max="40" id="tu" name="tu" value="20" required></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
<!--
				<td><button id="tb_submit">Submit</button> </td>
-->
				<td><input type="submit" id="tb_submit" value="S U B M I T"> </td>
			</tr>
<!--
			<tr>
				<td>Status Modem GPRS</td>
				<td>:</td>
				<td><input type="text" id="md_gprs" name="md_gprs" disabled></td>
			</tr>

			<tr>
				<td>Aktifasi Modem GPRS</td>
				<td>:</td>

				<td><button id="tb_add">Daftar Modem</button> <button id="tb_dell">Delete Modem</button> <button id="tb_list">List Modem</button></td>

			</tr>
-->


		</table>
	</form>
<!--
	<table>
		<tr>
			<td>Aktifasi Modem GPRS</td>
			<td>:</td>
			<td><button id="tb_add">Daftar Modem</button> <button id="tb_dell">Delete Modem</button> <button id="tb_list">List Modem</button></td>

		</tr>
	</table>
-->

	<div id="tabs">
	  <ul>
		<li><a href="#tabs-1">Modem Satelit</a></li>
		<li><a href="#tabs-2">Modem GPRS</a></li>
<!--
		<li><a href="#tabs-3">Aenean lacinia</a></li>
-->
	  </ul>
	  <div id="tabs-1">
		<p>Menunggu Satelit Status</p>
	  </div>
	  <div id="tabs-2">
		<p>Modem GPRS Status</p>
		<table>
			<tr>
				<td>Aktifasi Modem GPRS</td>
				<td>:</td>
				<td><button id="tb_add">Aktivasi Modem</button> <button id="tb_dell">Deaktivasi Modem</button> <button id="tb_list">List Modem</button></td>

			</tr>
		</table>
		<div id="tab_gprs"></div>
	  </div>
<!--
	  <div id="tabs-3">
		<p>Mauris eleifend est et turpis. Duis id erat. Suspendisse potenti. Aliquam vulputate, pede vel vehicula accumsan, mi neque rutrum erat, eu congue orci lorem eget lorem. Vestibulum non ante. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Fusce sodales. Quisque eu urna vel enim commodo pellentesque. Praesent eu risus hendrerit ligula tempus pretium. Curabitur lorem enim, pretium nec, feugiat nec, luctus a, lacus.</p>
		<p>Duis cursus. Maecenas ligula eros, blandit nec, pharetra at, semper at, magna. Nullam ac lacus. Nulla facilisi. Praesent viverra justo vitae neque. Praesent blandit adipiscing velit. Suspendisse potenti. Donec mattis, pede vel pharetra blandit, magna ligula faucibus eros, id euismod lacus dolor eget odio. Nam scelerisque. Donec non libero sed nulla mattis commodo. Ut sagittis. Donec nisi lectus, feugiat porttitor, tempor ac, tempor vitae, pede. Aenean vehicula velit eu tellus interdum rutrum. Maecenas commodo. Pellentesque nec elit. Fusce in lacus. Vivamus a libero vitae lectus hendrerit hendrerit.</p>
	  </div>
-->
	</div>
	
	<div id="hasil_pars">
	
	</div>
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
	<script type="text/javascript" src="asset/js/jquery-ui-timepicker-addon.js"></script>
	
	<script type="text/javascript">
			//$( document ).ready(function(){
			$(function(){
				$( "#tabs" ).tabs();
				$('#start').datetimepicker({
						dateFormat: 'yy-mm-dd', 
						timeFormat: 'HH:mm:ss'
						//stepMinute: 
						//addSliderAccess: true,
						//sliderAccessArgs: { touchonly: true }
				});
				$('#end').datetimepicker({
						dateFormat: 'yy-mm-dd', 
						timeFormat: 'HH:mm:ss'
						//stepMinute: 
				});
				
				$('#modem').on('change',function(){
					//console.log(sbl);
					var hsl = $("#modem").val();
					
					//kk = (hsl === '')? sbl : hsl ;
					
					//console.log(hsl);
				
				});
								
				$('#form1').submit(function(){
				//$('#tb_submit').submit(function(){
						//console.log($('#form1').serializeArray());
						//console.log($('#form1').serialize());
						
						//var isidata = $('#form1').serializeArray();
						//var val_modem = $('#modem').val();
						
						var isidata = $('#form1').serialize();
						//console.log('isi data ke satu : '+isidata[0].value);
						//console.log(val_modem);
						var url = 'parsing.php';
						alert ('Tunggu Mas ya....  Datanya lagi di Prosess ');
						$.post(
							url,isidata,
							function (data){
								alert ('Sip .... Sukses Parsingnya ');
								//$('#hasil_pars').html(data);
								$('#tabs-1').html(data);
								}
						);
						return false;
				});
				
				$('#tb_add').click(function(e){
						//var isidata1 = $('#form1').serialize();
						var mdm = $("#modem").val();
						//console.log(isidata1);
						//console.log(mdm);
						//e.preventDefault();
						var r = confirm("Yakin akan aktifkan GPRS Modem "+ mdm+" ?? ");
						
						if (r == true) {
							//var urlsn = '../gprs/daftar.php?act=add&sn='+mdm;
							var urlsn = '../daftar.php?act=add&sn='+mdm;
							//console.log(urlsn);
							
							$.post(
								urlsn,'',
								function (data){
									alert ('modem SN = '+mdm+', sukses ditambahkan');
									$('#tab_gprs').html(data);
									}
							);
							
							//alert('modem SN = '+mdm+', anda menambah modem gprs '); 
						}
						else 
							alert('Yee..... Malah Ga Jadi ... '); 
						
						return false;
						
				});
				$('#tb_dell').click(function(e){
						//var isidata1 = $('#form1').serialize();
						var mdm = $("#modem").val();
						//console.log(isidata1);
						//console.log(mdm);
						//e.preventDefault();
						var r = confirm("Yakin akan Non-Aktifkan GPRS Modem "+ mdm+" ?? ");
						
						if (r == true) {
							//daftar.php?act=add&sn
							//var urlsn = '../gprs/daftar.php?act=dell&sn='+mdm;
							var urlsn = '../daftar.php?act=dell&sn='+mdm;
							//console.log(urlsn);
							
							$.post(
								urlsn,'',
								function (data){
									alert ('modem SN = '+mdm+', sukses dinonaktifkan');
									$('#tab_gprs').html(data);
									}
							);
							
							//alert('modem SN = '+mdm+', anda menambah modem gprs '); 
						}
						else 
							alert('Yee..... Malah Ga Jadi ... '); 
						
						return false;
						
				});
				$('#tb_list').click(function(e){
						//var isidata1 = $('#form1').serialize();
						//var mdm = $("#modem").val();
						//console.log(isidata1);
						//console.log(mdm);
						//e.preventDefault();
						var r = confirm("Cek List Modem yang telah terdaftar ?? ");
						
						if (r == true) {
							//daftar.php?act=add&sn
							//var urllist = '../gprs/daftar.php?act=list';
							var urllist = '../daftar.php?act=list';
							//console.log(urllist);
							
							$.post(
								urllist,'',
								function (data){
									//alert ('modem SN = '+mdm+', sukses ditambahkan');
									//$('#hasil_pars').html(data);
									$('#tab_gprs').html(data);
									}
							);
							
							//alert('modem SN = '+mdm+', anda menambah modem gprs '); 
						}
						else 
							alert('Yee..... Malah Ga Jadi ... '); 
						
						return false;
						
				});
			});
			
			//$("#form_grafik1").submit(function(){
				//$("#loading1").show();
				//var data1 = $("#form_grafik1").serialize();
				//var url1 = $('#form_grafik1').attr('action');
				////alert ('tekan tekan kamu datane ' + data1 +'=> '+url1);
				////return true;
				//$.post( 
                  //url1,data1,
                  //function(data) {
                     //$("#loading1").hide();
                     //$('#hasil_grafik1').html(data);
                     
                     ////alert('wes wess');
                  //}
                 //);
                 //return false
			//});
		
		//$( "form" ).submit(function( event ) {
  //console.log( $( this ).serializeArray() );
  //event.preventDefault();
//});
			
	</script>
</body>

</html>
