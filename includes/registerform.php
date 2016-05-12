<form method="post" action="" class="updateImageDiv col-md-4 col-xs-10">
    <label>Nýskrá</label>
        <div class="form-group">
        	<p for="username">Notendanafn:
			<?php if ($missing && in_array('username', $missing)) { ?>
			<span class="warning">Filla þarf út þennan reit</span>
			<?php } ?>
			</p>
           	<input type="text" class="form-control input-md" name="username" placeholder="Notendanafn*" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$" title="Notendanafn, minnst fimm stafir" <?php if (($missing || $errors) && isset($username)) { echo 'value="' . htmlentities($username) . '"'; } ?>>
        </div>
        <div class="form-group">
           	<p for="password">Lykilorð:
			<?php if ($missing && in_array('password', $missing)) { ?>
			<span class="warning">Filla þarf út þennan reit</span>
			<?php } ?>
			</p>
        	<input type="password" class="form-control input-md" name="password" placeholder="Lykilorð*" required pattern="^[a-zA-Z][a-zA-Z0-9-_\.]{4,20}$" title="Lykilorð" <?php if (($missing || $errors) && isset($password)) { echo 'value="' . htmlentities($password) . '"'; } ?>>
        </div>
        <div class="form-group">
        	<p for="email">Netfang:
			<?php if ($missing && in_array('email', $missing)) { ?>
			<span class="warning">Filla þarf út þennan reit</span>
			<?php } ?>
			</p>
        	<input type="email" class="form-control input-md" name="email" placeholder="Netfang*" required title="Netfang" <?php if (($missing || $errors) && isset($email)) { echo 'value="' . htmlentities($email) . '"'; } ?>>
        </div>
        <div class="form-group">
            <p for="firstname">Fyrra nafn:
            <?php if ($missing && in_array('name', $missing)) { ?>
            <span class="warning">Filla þarf út þennan reit</span>
            <?php } ?>
            </p>
            <input type="text" class="form-control input-md" name="firstname" placeholder="Fyrra Nafn*" required pattern="^[a-zA-Z][a-zA-Z0-9-_ ðÐþÞáÁéÉæÆúÚóÓÖöýÝ\.]{4,50}$" title="Fyrra Nafn" <?php if (($missing || $errors) && isset($firstname)) { echo 'value="' . htmlentities($firstname) . '"'; } ?>>
        </div>
        <div class="form-group">
            <p for="lastname">Seinna nafn:
            <?php if ($missing && in_array('name', $missing)) { ?>
            <span class="warning">Filla þarf út þennan reit</span>
            <?php } ?>
            </p>
            <input type="text" class="form-control input-md" name="lastname" placeholder="Seinna Nafn*" required pattern="^[a-zA-Z][a-zA-Z0-9-_ ðÐþÞáÁéÉæÆúÚóÓÖöýÝ\.]{4,50}$" title="Seinna Nafn" <?php if (($missing || $errors) && isset($lastname)) { echo 'value="' . htmlentities($lastname) . '"'; } ?>>
        </div>
        <div class="form-group">
            <?php 
            require_once './includes/dbcon.php';
            require_once'./includes/Users/Users.php';  

            $dbUsers = new Users($conn);
            $questionList = $dbUsers->questionList();

            ?>
        	<label>Öryggisspurningar:</label>
        	<p>1
        	<?php if ($missing && (in_array('sq1', $missing) || in_array('sq1ans', $missing))) { ?>
			<span class="warning">Filla þarf út þennan reit</span>
			<?php } ?>
			</p>
        	<select name="sq1" required class="form-control">
                <?php foreach ($questionList as $key => $value): ?>
                    <?php if ($value[2] == 1): ?>
                        <option value="<?php echo $value[0]; ?>" <?php if (($missing || $errors) && isset($sq1) && htmlentities($sq1) == '1') { echo 'selected="selected"'; } ?>><?php echo $value[1]; ?></option>
                    <?php endif ?>
                <?php endforeach ?>
        	</select>
        	<input type="text" class="form-control input-md" name="sq1ans" placeholder="...*" required title="Svaraðu öryggisspurningunni." <?php if (($missing || $errors) && isset($sq1ans)) { echo 'value="' . htmlentities($sq1ans) . '"'; } ?>>

        	<p>2
        	<?php if ($missing && (in_array('sq1', $missing) || in_array('sq1ans', $missing))) { ?>
			<span class="warning">Filla þarf út þennan reit</span>
			<?php } ?>
			</p>
        	<select name="sq2" required class="form-control">
                <?php foreach ($questionList as $key => $value): ?>
                    <?php if ($value[2] == 2): ?>
                        <option value="<?php echo $value[0]; ?>" <?php if (($missing || $errors) && isset($sq1) && htmlentities($sq1) == '1') { echo 'selected="selected"'; } ?>><?php echo $value[1]; ?></option>
                    <?php endif ?>
                <?php endforeach ?>
        	</select>
        	<input type="text" class="form-control input-md" name="sq2ans" placeholder="...*" required title="Svaraðu öryggisspurningunni." <?php if (($missing || $errors) && isset($sq2ans)) { echo 'value="' . htmlentities($sq2ans) . '"'; } ?>>
		</div>
	<?php if (($missing || $errors) && (in_array('g-recaptcha', $missing) || in_array('g-recaptcha', $errors))) { ?>
	<p class="warning">Sannaðu að þú sért ekki vélmenni.</p>
	<?php } ?>
	<div class="g-recaptcha" data-sitekey="6LdLtxcTAAAAAJrk7gzmEJmNJYoGyt9kpqBDm3_g"></div>
    <script type="text/javascript" src="https://www.google.com/recaptcha/api.js?hl=is"></script>
    </script>
	<button name="sendregister" type="submit" class="btn btn-primary">Nýskrá</button>
	<p><i>*Fylla þarf út þessa reiti</i></p>
</form>
