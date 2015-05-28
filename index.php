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
	<title>Laras || Parsing Satelit</title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<meta name="generator" content="Geany 1.23.1" />
	<link rel="stylesheet" media="all" type="text/css" href="http://code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css" />
	<link rel="stylesheet" media="all" type="text/css" href="asset/js/jquery-ui-timepicker-addon.css" />
	<style>
		.ui-datepicker{ font-size: 85%; }
	</style>
</head>

<body>
	<h1>Parsing Skywave v 0.0</h1>
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
				<td><input type="text" id="start" name="start" value="<?php $saiki = new DateTime(); echo $saiki->format('Y-m-d H:i:s');?>" required></td>
			</tr>
			<tr>
				<td>End Ambil Data</td>
				<td>:</td>
				<td><input type="text" id="end" name="end" value="<?php $saiki = new DateTime(); echo $saiki->format('Y-m-d H:i:s');?>" required></td> 
			</tr>
			<tr>
				<td>Modem</td>
				<td>:</td>
				<td><input type="text" id="modem" name="modem" maxlength="15" minlength="15" style="text-transform:uppercase" required></td>
			</tr>
			<tr>
				<td>Gateway</td>
				<td>:</td>
				<td>
					<select id="gw" name="gw" required>
						<option value='2'>isatdatapro.skywave.com</option> 
						<option value='1' selected="selected" >m2prime.aissat.com</option>
						
					</select>
				</td>
			</tr>
			<tr>
				<td>Jumlah Titik Ukur</td>
				<td>:</td>
				<td><input type="number" max="26" id="tu" name="tu" value="20" required></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
<!--
				<td><button id="tb_submit">Submit</button> </td>
-->
				<td><input type="submit" id="tb_submit" value="S U B M I T"> </td>
			</tr>
		</table>
	</form>
	<hr>
	<div id="hasil_pars">
	
	</div>
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
	<script type="text/javascript" src="asset/js/jquery-ui-timepicker-addon.js"></script>
	
	<script type="text/javascript">
			$(function(){
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
				
				$('#form1').submit(function(){
						//console.log($('#form1').serializeArray());
						//console.log($('#form1').serialize());
						
						//var isidata = $('#form1').serializeArray();
						var val_modem = $('#modem').val();
						
						var isidata = $('#form1').serialize();
						//console.log('isi data ke satu : '+isidata[0].value);
						console.log(val_modem);
						var url = 'parsing.php';
						alert ('data yang dikirim '+isidata);
						$.post(
							url,isidata,
							function (data){
								alert ('sip sip');
								$('#hasil_pars').html(data);
								}
						);
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
