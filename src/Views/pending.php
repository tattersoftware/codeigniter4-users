			<h1>Account pending</h1>
			<p>
				Your account has been created!
<?php
if ($verifyMethod == 'email'):
	echo 'Check the following email for a verification link:<br />' . PHP_EOL;
else:
	echo 'You will be notified at the following email once your account is approved:<br />' . PHP_EOL;
endif;
echo substr($_POST['email'], 0, 4) . '*******' . PHP_EOL;
?>
			</p>

			<p><?=anchor('', 'Back to home') ?></p>
