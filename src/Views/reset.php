
		<h1>Password reset</h1>
		<p>Enter a new password for your account:</p>

		<form name="reset" action="<?= route_to('reset') ?>" method="POST">
<?php
			if (session('messages')):
?>
		<p class="messages-<?= $status ?>"><strong><?=strtoupper(session('status')) ?>:</strong> <?=implode(' ', session('messages')) ?></p>
<?php
			endif;
?>
			<p>
				New password<br />
				<input name="password" type="password" required />
			</p>
			<p>
				Confirm new password<br />
				<input name="confirm" type="password" required />
			</p>
			
			<p>
				<input name="users_reset" type="hidden" value="<?= $_GET['users_reset'] ?>" />
				<input name="submit" type="submit" value="Submit" />
				<?=anchor('', "Cancel") ?>
			</p>
</form>