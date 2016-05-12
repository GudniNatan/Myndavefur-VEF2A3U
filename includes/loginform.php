<form method="post" action="" class="updateImageDiv col-md-4 col-xs-10">
    <label>Innskrá</label>
        <div class="form-group">
        	<p for="login_username">Notendanafn:
			<?php if ($missing && in_array('login_username', $missing)) { ?>
			<span class="warning">Filla þarf út þennan reit</span>
			<?php } ?>
			</p>
           	<input type="text" class="form-control input-md" name="login_username" placeholder="Notendanafn*" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$" title="Notendanafn, minnst fimm stafir" <?php if (($missing || $errors) && isset($login_username)) { echo 'value="' . htmlentities($login_username) . '"'; } ?>>
        </div>
        <div class="form-group">
           	<p for="login_password">Lykilorð:
			<?php if ($missing && in_array('login_password', $missing)) { ?>
			<span class="warning">Filla þarf út þennan reit</span>
			<?php } ?>
			</p>
        	<input type="password" class="form-control input-md" name="login_password" placeholder="Lykilorð*" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$" title="Lykilorð" <?php if (($missing || $errors) && isset($login_password)) { echo 'value="' . htmlentities($login_password) . '"'; } ?>>
		</div>
	<button name="sendlogin" type="submit" class="btn btn-primary">Skrá inn</button>
	<p><i>*Fylla þarf út þessa reiti</i></p>
	<p><a href="forgotpassword.php" target="_blank">Ég gleymdi lykilorðinu mínu.</a></p>
</form>
