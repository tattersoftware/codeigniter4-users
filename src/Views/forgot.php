
	<h1>Forgot password</h2>
	<p>
		Enter your email address or username to receive an email with instructions on how
		to reset your password and regain access to your account.<br />
		If you don't remember your email or username please contact an admin for help.
	</p>

	<form name="forgot" action="<?= route_to('forgot') ?>" method="post">
<?php
				if (! empty($messages) ):
?>
		<p class="users-<?=$status ?>"><strong><?=strtoupper($status) ?>:</strong> <?=implode(' ', $messages) ?></p>
<?php
				endif;
?>
		<p>
			Username or email
			<br />
			<input name="login" type="text" value="" autocomplete="off" required autofocus />
		</p>

		<p>
			<input name="users_forgot" type="hidden" value="1" />
			<input name="submit" type="submit" value="Submit" />
			<?=anchor('', "Cancel") ?>
		</p>
	</form>
