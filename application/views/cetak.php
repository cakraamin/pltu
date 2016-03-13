<html>
	<head>
		<title>Laporan Cetak Data Timbangan</title>
		<style type="text/css">
		table {
		    border-collapse: collapse;
		}
		table, th, td {
		    border: 1px solid black;
		}
		th{
			background: #EEE;
		}
		th,td{
			padding: 5px;
		}
		</style>
	</head>
	<body>
		<center><h1>Laporan Data Timbangan</h1></center>
		<table>
			<tr>
				<th>No Tiket</th>
				<th>No.Kend</th>
				<th>Jam Masuk</th>
				<th>Jenis Limbah</th>
				<th>Pemanfaat</th>
				<th>Transporter</th>
				<th>S.Jalan</th>
				<th>No.<br/>Manifest</th>
				<th>No.MGP</th>
				<th>Gross</th>
				<th>Tarra</th>
				<th>Netto</th>
				<th>Penimbang</th>
				<th>Pengemudi</th>
			</tr>
			<?php
			foreach($kueri as $dt_kueri)
			{
				?>
				<tr>
					<td><?php echo $dt_kueri->notrans; ?></td>
					<td><?php echo $dt_kueri->nopol; ?></td>
					<td><?php echo $dt_kueri->jamtb1; ?></td>
					<td><?php echo $dt_kueri->namabrg; ?></td>
					<td><?php echo $dt_kueri->namacust; ?></td>
					<td><?php echo $dt_kueri->namatrsp; ?></td>
					<?php                      
		                $do = isset($dt_kueri->nomorspk)?$dt_kueri->nomorspk:"//";
		                $pecahdo = explode("/", $do);
		                $jalan = (isset($pecahdo[0]) && $pecahdo[0] != "")?$pecahdo[0]:"";
		                $manifest = (isset($pecahdo[1]) && $pecahdo[1] != "")?$pecahdo[1]:"";
		                $mgp = (isset($pecahdo[2]) && $pecahdo[2] != "")?$pecahdo[2]:"";
		              ?>
					<td><?php echo $jalan; ?></td>
					<td><?php echo $manifest; ?></td>
					<td><?php echo $mgp; ?></td>
					<td><?php echo number_format($dt_kueri->timbang1,0,',','.'); ?></td>
					<td><?php echo number_format($dt_kueri->timbang2,0,',','.'); ?></td>
					<td><?php echo number_format($dt_kueri->netto,0,',','.'); ?></td>
					<td><?php echo $dt_kueri->user2; ?></td>
					<td><?php echo $dt_kueri->sopir; ?></td>
				</tr>
				<?php
			}
			?>
		</table>
	</body>
</html>