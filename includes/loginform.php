<form method="post" action="login.php">
    <label>Innskrá</label>
        <fieldset>
           	<input type="text" name="username" placeholder="Notendanafn" required pattern="{5}" title="Notendanafn, minnst fimm stafir">
        	<input type="password" name="password" placeholder="Lykilorð" required title="Lykilorð">
		</fieldset>
	<button type="submit" class="pure-button pure-input-1 pure-button-primary">Skrá inn</button>
</form>