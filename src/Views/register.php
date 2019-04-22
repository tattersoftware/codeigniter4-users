<?= view($config->views['header']) ?>

	<div id="container" class="users-view users-register">
		<h1>Register</h1>
		<form name="register" action="<?= current_url() ?>" method="POST">
<?php
if (session('errors')):
?>
			<p class="users-error"><strong>ERROR:</strong> <?= implode(' ', session('errors')) ?></p>
<?php
endif;
?>
			<p>
				Username
				<br />
				<input name="username" class="<?= session('errors.username')? 'users-error' : '' ?>" type="text" value="<?= old('username') ?>" autocomplete="off" required autofocus />
			</p>
			<p>
				Email
				<br />
				<input name="email" class="<?= session('errors.email')? 'users-error' : '' ?>" type="text" value="<?= old('email') ?>" autocomplete="off" required />
			</p>
			<p>
				Password
				<br />
				<input name="password" class="<?= session('errors.password')? 'users-error' : '' ?>" type="password" required />
			</p>
<?php
$val1 = rand(1,5);
$val2 = rand(1,4);
session()->human = $val1 + $val2;
?>
			<p>
				Verify you are totally human by solving '<?=$val1 ?> + <?=$val2 ?>'
				<br />
				<input name="human" class="<?= session('errors.human')? 'users-error' : '' ?>" type="text" style="width:15px;" autocomplete="off" />
			</p>
		
			<p>
				<input name="users_register" type="hidden" value="1" />
				<input name="submit" type="submit" value="Submit" />
				<?=anchor('', "Cancel") ?>
			</p>
		</form>
	
		<hr />
	
		<p>Or, <?= anchor(session('returnTo'), "sign in now" ) ?> with an existing account.</p>
	</div>

<?= view($config->views['footer']) ?>
