<form method="post" action="">
    <label>Nýskrá</label>
        <div class="form-group">
        	<p for="username">Notendanafn:
			<?php if ($missing && in_array('username', $missing)) { ?>
			<span class="warning">Filla þarf út þennan reit</span>
			<?php } ?>
			</p>
           	<input type="text" name="username" placeholder="Notendanafn*" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$" title="Notendanafn, minnst fimm stafir" <?php if (($missing || $errors) && isset($username)) { echo 'value="' . htmlentities($username) . '"'; } ?>>
        </div>
        <div class="form-group">
           	<p for="password">Lykilorð:
			<?php if ($missing && in_array('password', $missing)) { ?>
			<span class="warning">Filla þarf út þennan reit</span>
			<?php } ?>
			</p>
        	<input type="password" name="password" placeholder="Lykilorð*" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$" title="Lykilorð" <?php if (($missing || $errors) && isset($password)) { echo 'value="' . htmlentities($password) . '"'; } ?>>
        </div>
        <div class="form-group">
        	<p for="email">Netfang:
			<?php if ($missing && in_array('email', $missing)) { ?>
			<span class="warning">Filla þarf út þennan reit</span>
			<?php } ?>
			</p>
        	<input type="email" name="email" placeholder="Netfang*" required title="Netfang" <?php if (($missing || $errors) && isset($email)) { echo 'value="' . htmlentities($email) . '"'; } ?>>
        </div>
        <div class="form-group">
        	<p for="name">Nafn:
			<?php if ($missing && in_array('name', $missing)) { ?>
			<span class="warning">Filla þarf út þennan reit</span>
			<?php } ?>
			</p>
        	<input type="text" name="name" placeholder="Fullt Nafn*" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{4,50}$" title="Fullt Nafn" <?php if (($missing || $errors) && isset($name)) { echo 'value="' . htmlentities($name) . '"'; } ?>>
        </div>
        <div class="form-group">
        	<label>Öryggisspurningar:</label>
        	<p>1
        	<?php if ($missing && (in_array('sq1', $missing) || in_array('sq1ans', $missing))) { ?>
			<span class="warning">Filla þarf út þennan reit</span>
			<?php } ?>
			</p>
        	<select name="sq1" required>
        		<option value="1" <?php if (($missing || $errors) && isset($sq1) && htmlentities($sq1) == '1') { echo 'selected="selected"'; } ?>>Hver var fyrsti kennarinn þinn?</option>
        		<option value="2" <?php if (($missing || $errors) && isset($sq1) && htmlentities($sq1) == '2') { echo 'selected="selected"'; } ?>>Hver er uppáhalds bókin þín?</option>
        		<option value="3" <?php if (($missing || $errors) && isset($sq1) && htmlentities($sq1) == '3') { echo 'selected="selected"'; } ?>>Hvar áttir þú heima sem barn?</option>
        	</select>
        	<input type="text" name="sq1ans" placeholder="...*" required title="Svaraðu öryggisspurningunni." <?php if (($missing || $errors) && isset($sq1ans)) { echo 'value="' . htmlentities($sq1ans) . '"'; } ?>>

        	<p>2
        	<?php if ($missing && (in_array('sq1', $missing) || in_array('sq1ans', $missing))) { ?>
			<span class="warning">Filla þarf út þennan reit</span>
			<?php } ?>
			</p>
        	<select name="sq2" required>
        		<option value="1" <?php if (($missing || $errors) && isset($sq2) && htmlentities($sq2) == '1') { echo 'selected="selected"'; } ?>>Hver var besti æskuvinur þinn?</option>
        		<option value="2" <?php if (($missing || $errors) && isset($sq2) && htmlentities($sq2) == '2') { echo 'selected="selected"'; } ?>>Uppáhalds skáldaða persónan þín?</option>
        		<option value="3" <?php if (($missing || $errors) && isset($sq2) && htmlentities($sq2) == '3') { echo 'selected="selected"'; } ?>>Hvað hét fyrsta gæludýrið þitt?</option>
        	</select>
        	<input type="text" name="sq2ans" placeholder="...*" required title="Svaraðu öryggisspurningunni." <?php if (($missing || $errors) && isset($sq2ans)) { echo 'value="' . htmlentities($sq2ans) . '"'; } ?>>
		</div>
	<?php if (($missing || $errors) && (in_array('g-recaptcha', $missing) || in_array('g-recaptcha', $errors))) { ?>
	<p class="warning">Sannaðu að þú sért ekki vélmenni.</p>
	<?php } ?>
	<div class="g-recaptcha" data-sitekey="6LdLtxcTAAAAAJrk7gzmEJmNJYoGyt9kpqBDm3_g"></div>
    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=is"></script>
    </script>
	<button name="sendregister" type="submit" class="pure-button pure-input-1 pure-button-primary register">Skrá inn</button>
	<p><i>*Fylla þarf út þessa reiti</i></p>
</form>
