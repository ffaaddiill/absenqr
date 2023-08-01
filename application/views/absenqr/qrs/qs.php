<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta HTTP-EQUIV="Expires" CONTENT="-1">
	<title>qr</title>
	<script type="text/javascript">
	    var token_name = '<?=$this->security->get_csrf_token_name()?>';
	    var token_key = '<?=$this->security->get_csrf_hash()?>';
	</script>
</head>
<body>
		<form id="qrbulkform">
			<input type="hidden" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">
			<textarea id="qr" name="qr" rows="10" cols="10" <?=($disable_input)?'disabled="disabled"':''?> autofocus></textarea>
		</form>
		<button id="qrsave" type="submit">Simpan</button>

		<div class="qr_output"></div>
	
	<script type="text/javascript">
		document.querySelector('#qrsave').addEventListener('click', function() {
			alert(document.getElementById('qr').value);
		});

		var count = 1;
		document.querySelector('#qr').addEventListener('keypress', (evt) => {
			if(evt.key === 'Enter' || evt.code === 13) {
				//let qrvalues = document.querySelector('#qr').value;

				let qrdata = new FormData(document.getElementById('qrbulkform'));
				console.log(Array.from(qrdata));

				//document.querySelector('.qr_output').innerHTML = qrvalues;

				const urlpost = '<?=base_url()?>qrs/submit';
	 
	            /*fetch(urlpost, {
				    method: 'POST',
				    body: qrdata
				}).then(function (response) {
					if (response.ok) {
						return response.json();
					}
					return Promise.reject(response);
				}).then(function (data) {
					console.log(data);
				}).catch(function (error) {
					console.warn(error);
				});*/

			    let xhttp = new XMLHttpRequest();
			    xhttp.open('POST', urlpost, true);
			    //xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			    xhttp.onload = function() {
			        if (this.status >= 200 && this.status < 400) {
			             console.log(decodeURIComponent(this.response));
			        } else {
			             // Error
			        }
			    };
			    xhttp.send(qrdata);
				
			} else {
				//console.log('key event: ' + evt.key);
			}
		});
	</script>
</body>
</html>