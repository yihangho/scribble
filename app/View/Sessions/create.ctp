<h1>Login</h1>
<div class="text-center">
	<!-- TODO Implement CSRF token -->
	<?php $fbRedirectUrl = Router::url(array('controller' => 'sessions', 'action' => 'fbLogin'), true); ?>
	<?php $fbLoginUrl = 'https://www.facebook.com/dialog/oauth?client_id=' . Configure::Read('FB_API') . '&redirect_uri=' . urlencode($fbRedirectUrl) . '&scope=email';?>
	<?php echo $this->Html->link('Login with Facebook', $fbLoginUrl, array('class' => 'zocial facebook'));?>

	<?php $googlePlusRedirectUrl = Router::url(array('controller' => 'sessions', 'action' => 'googlePlusLogin'), true); ?>
	<?php $googlePlusLoginUrl = 'https://accounts.google.com/o/oauth2/auth?response_type=code&client_id=' . urlencode(Configure::Read('GOOGLE_API')) . '&redirect_uri=' . urlencode($googlePlusRedirectUrl) . '&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email';?>
	<?php echo $this->Html->link('Login with Google+', $googlePlusLoginUrl, array('class' => 'zocial googleplus'));?>
</div>
