<?php
include "./nusoap/nusoap.php";
// print_r($_POST);
if($_POST['flag'] == 'buy'){
	$customer_nbr 	= $_POST['customer_nbr'];
	// $imtv_number 	= $_POST['imtv_number'];
	$imtv_number 	= '';
	$plan_code 		= $_POST['plan_code'];
	// $start_date 	= $_POST['start_date'];
	$start_date 	= '';
	// echo $customer_nbr.','.$imtv_number.','.$plan_code.','.$start_date;

	$wsdl ="http://139.0.22.190/ITB/webservice/server2.php?wsdl";
	$client = new nusoap_client($wsdl,true);
	$err = $client->getError();
	if ($err) {
		echo "<script>
				alert('".$err."');
				location.reload();
			</script>";
	}else{
		$param = array('customer_nbr'=>$customer_nbr,'imtv_number'=>$imtv_number,'plan_code'=>$plan_code,'start_date'=>$start_date,'creatorid'=>'PREPAID');
		$result = $client->call('send_sms', $param);
		
		if($result=='0'){
			echo "<script>
				alert('Maaf sedang maintenance.');
				location.reload();
			</script>";
		}else if($result=='1'){
			echo "<script>
				alert('Pembelian paket Anda sedang diproses. Jika paket belum aktif lebih dari 10 menit, hubungi Contact Center 0804 1 222 222.');
				location.reload();
			</script>";
		}
		// else if($result=='2'){
			// echo "<script>
				// alert('Saldo Anda tidak cukup.');
				// location.reload();
			// </script>";
		// }else if($result=='3'){
			// echo "<script>
				// alert('Kode Paket Tidak Ada.');
				// location.reload();
			// </script>";
		// }
	}
}else if($_POST['flag'] == 'aktivasi'){
	$customer_nbr 	= $_POST['customer_nbr'];
	$imtv_number 	= $_POST['kode_imtv'];
	$plan_code 		= $_POST['plan_code'];
	$first_name 	= $_POST['first_name'];
	$last_name	 	= $_POST['last_name'];
	$mobile_number	= $_POST['mobile_number'];

	$wsdl ="http://139.0.22.190/ITB/webservice/server2.php?wsdl";
	$client = new nusoap_client($wsdl,true);
	$err = $client->getError();
	if ($err) {
		echo "<script>
				alert('".$err."');
				location.reload();
			</script>";
	}else{
		$param = array('customer_nbr'=>$customer_nbr,'imtv_number'=>$imtv_number,'plan_code'=>$plan_code,'first_name'=>$first_name,'last_name'=>$last_name,'mobile_number'=>$mobile_number,'creatorid'=>'PREPAID');
		$result = $client->call('send_sms_aktivasi_dev', $param);
		if($result=='1'){
			echo "<script>
				alert('Aktivasi Anda sedang diproses. Jika belum aktif lebih dari 10 menit, hubungi Contact Center 0804 1 222 222.');
				location.reload();
			</script>";
		}else if($result=='0'){
			echo "<script>
				alert('Aktivasi Gagal.');
				location.reload();
			</script>";
		}else if($result=='NO_CUST'){
			echo "<script>
				alert('BIGTV ID yang Anda masukkan salah.');
				location.reload();
			</script>";
		}else if($result=='NO_IMTV'){
			echo "<script>
				alert('Kode IMTV yang Anda masukan salah.');
				location.reload();
			</script>";
		}
	}
}else if($_POST['flag'] == 'isi_voucher'){
	$customer_nbr 	= $_POST['customer_nbr'];
	$voucher_code 	= $_POST['voucher_code'];

	$wsdl ="http://139.0.22.190/ITB/webservice/server2.php?wsdl";
	$client = new nusoap_client($wsdl,true);
	$err = $client->getError();
	if ($err) {
		echo "<script>
				alert('".$err."');
				location.reload();
			</script>";
	}else{
		$param = array('customer_nbr'=>$customer_nbr,'voucher_code'=>$voucher_code,'creatorid'=>'PREPAID');
		$result = $client->call('send_sms_saldo', $param);
		if($result=='1'){
			echo "<script>
				alert('Isi saldo Anda sedang diproses.');
				location.reload();
			</script>";
		}else if($result=='0'){
			echo "<script>
				alert('Isi saldo Gagal.');
				location.reload();
			</script>";
		}
	}
}
?>