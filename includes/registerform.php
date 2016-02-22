<?php  
if (!empty($_POST["g-recaptcha-response"])){
	$response = $_POST["g-recaptcha-response"];
	$secret = "6LdLtxcTAAAAAPl7aQ1Oa7Sm7vAVAj5k8FKO2Rqg";
	$remoteip = $_SERVER['REMOTE_ADDR'];
	echo $response;
}
?>

<form method="post" action="">
	<?php if ($missing || $errors) { ?>
	<p class="warning">Lagaðu eftirfarandi villur.</p>
	<?php } ?>
	<label for="name">Name:
	<?php if ($missing && in_array('name', $missing)) { ?>
	<span class="warning">Please enter your name</span>
	<?php } ?>
	</label>
    <label>Nýskrá</label>
        <fieldset>
           	<input type="text" name="username" placeholder="Notendanafn" required pattern="{5}" title="Notendanafn, minnst fimm stafir">
        	<input type="password" name="password" placeholder="Lykilorð" required title="Lykilorð">
        </fieldset>
        <fieldset>
        	<input type="email" name="email" placeholder="Netfang" required title="Netfang">
        	<input type="text" name="name" placeholder="Fullt Nafn" required title="Fullt Nafn">
        </fieldset>
        <fieldset>
        	<label>Öryggisspurningar:</label>
        	<p>1</p>
        	<select name="sq1" required>
        		<option value="1">Hver var fyrsti kennarinn þinn?</option>
        		<option value="2">Hver er uppáhalds bókin þín?</option>
        		<option value="3">Hvar áttir þú heima sem barn?</option>
        	</select>
        	<input type="text" name="sq1ans" placeholder="..." required title="Svaraðu öryggisspurningunni.">

        	<p>2</p>
        	<select name="sq1" required>
        		<option value="1">Hver var besti æskuvinur þinn?</option>
        		<option value="2">Hver er uppáhalds skáldaða persónan þín?</option>
        		<option value="3">Hvað vildir þú vinna við sem barn?</option>
        	</select>
        	<input type="text" name="sq2ans" placeholder="..." required title="Svaraðu öryggisspurningunni.">
		</fieldset>
	<div class="g-recaptcha" data-sitekey="6LdLtxcTAAAAAJrk7gzmEJmNJYoGyt9kpqBDm3_g"></div>
	<button name="send" type="submit" class="pure-button pure-input-1 pure-button-primary">Skrá inn</button>
</form>
