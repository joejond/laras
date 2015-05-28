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
	<title>untitled</title>
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
	<form>
		<table>
			<tr>
				<td>Start Ambil Data</td>
				<td>:</td>
				<td><input type="text" id="start" name="start" value="<?php $saiki = new DateTime(); echo $saiki->format('Y-m-d H:i:s');?>"></td>
			</tr>
			<tr>
				<td>End Ambil Data</td>
				<td>:</td>
				<td><input type="text" id="end" name="end" value="<?php $saiki = new DateTime(); echo $saiki->format('Y-m-d H:i:s');?>"></td> 
			</tr>
			<tr>
				<td>Modem</td>
				<td>:</td>
				<td><input type="text" id="modem" name="modem" maxlength="15" style="text-transform:uppercase"></td>
			</tr>
			<tr>
				<td>Gateway</td>
				<td>:</td>
				<td>
					<select>
						<option value='2'>isatdatapro.skywave.com</option> 
						<option value='1' selected="selected" >m2prime.aissat.com</option>
						
					</select>
				</td>
			</tr>
			<tr>
				<td>Jumlah Titik Ukur</td>
				<td>:</td>
				<td><input type="number" max="26" id="tu" name="tu" value="20"></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td><button>Submit</button> </td>
			</tr>
		</table>
	</form>
	
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
	<script type="text/javascript" src="http://code.jquery.com/ui/1.11.0/jquery-ui.min.js"></script>
	<script type="text/javascript" src="asset/js/jquery-ui-timepicker-addon.js"></script>
	
	<script type="text/javascript">
			$(function(){
				$('#start').datetimepicker({
						dateFormat: 'yy-mm-dd', 
						timeFormat: 'HH:mm:ss',
						//stepMinute: 
						//addSliderAccess: true,
						//sliderAccessArgs: { touchonly: true }
				});
				$('#end').datetimepicker({
						dateFormat: 'yy-mm-dd', 
						timeFormat: 'HH:mm:ss',
						//stepMinute: 
				});
			});
		
			
	</script>
</body>

</html>
