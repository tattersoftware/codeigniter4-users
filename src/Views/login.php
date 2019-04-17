
	<div id="container" class="users-view users-login">
		<h1>Login</h1>
		<form name="login" action="<?= route_to('login') ?>" method="post">
<?php
				if (session('errors')):
?>
			<p class="users-error"><strong>ERROR:</strong> <?=implode(' ', session('errors')) ?></p>
<?php
				endif;
?>
			<p>
				Username or email<br />
				<input name="login" class="<?= session('errors.login')? 'users-error' : '' ?>" type="text" autocomplete="off" required autofocus />
			</p>
			<p>
				Password <span style="margin-left:20px; font-size:12px;"><?= anchor(route_to('forgot'), 'Forgot?') ?></span>
				<br />
				<input name="password" class="<?= session('errors.password')? 'users-error' : '' ?>" type="password" required />
			</p>
			<p>
				<label>
					<input name="remember" type="checkbox" value="1" <?= (old('remember') || get_cookie('tatter.users'))? 'checked' : '' ?> />
					Remember me
				</label>
			</p>

			<p>
				<input name="users_login" type="hidden" value="1" />
				<input name="submit" type="submit" value="Submit" />
				<?=anchor('', 'Cancel') ?>
			</p>
		</form>

		<hr />

		<p>Or, <?=anchor(route_to('register'), 'sign up now' ) ?> for an account.</p>
	</div>
