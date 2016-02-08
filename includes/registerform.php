<?php  
if (!empty($_POST["g-recaptcha-response"])){
	$response = $_POST["g-recaptcha-response"];
	$secret = "6LdLtxcTAAAAAPl7aQ1Oa7Sm7vAVAj5k8FKO2Rqg";
	$remoteip = $_SERVER['REMOTE_ADDR'];
	echo $response;
}
?>

<form method="post" action="login.php">
    <label>Nýskrá</label>
        <fieldset>
           	<input type="text" name="username" placeholder="Notendanafn" required pattern="{5}" title="Notendanafn, minnst fimm stafir">
        	<input type="password" name="password" placeholder="Lykilorð" required title="Lykilorð">
		</fieldset>
	<div class="g-recaptcha" data-sitekey="6LdLtxcTAAAAAJrk7gzmEJmNJYoGyt9kpqBDm3_g"></div>
	<button type="submit" class="pure-button pure-input-1 pure-button-primary">Skrá inn</button>
</form>
