
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
<?php
if (session('errors.username'))
	echo "<span class='users-error'>" . session('errors.username') . "</span>";
?>
				<br />
				<input name="username" class="<?= session('errors.username')? 'users-error' : '' ?>" type="text" value="<?= old('username') ?>" autocomplete="off" required autofocus />
			</p>
			<p>
				Email
<?php
if (session('errors.email'))
	echo "<span class='users-error'>" . session('errors.email') . "</span>";
?>
				<br />
				<input name="email" class="<?= session('errors.email')? 'users-error' : '' ?>" type="text" value="<?= old('email') ?>" autocomplete="off" required />
			</p>
			<p>
				Password
<?php
if (session('errors.password'))
	echo "<span class='users-error'>" . session('errors.password') . "</span>";
?>
				<br />
				<input name="password" class="<?= session('errors.password')? 'users-error' : '' ?>" type="password" required />
			</p>
<?php
$val1 = rand(1,5);
$val2 = rand(1,4);
session()->robots = $val1+$val2;
?>
			<p>
				Verify you are totally human by solving '<?=$val1 ?> + <?=$val2 ?>'
<?php
if (session('errors.robots'))
	echo "<span class='users-error'>" . session('errors.robots') . "</span>";
?>
				<br />
				<input name="robots" class="<?= session('errors.robots')? 'users-error' : '' ?>" type="text" style="width:15px;" autocomplete="off" />
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
