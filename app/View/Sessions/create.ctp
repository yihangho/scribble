<h1>Login</h1>
<div class="text-center">
	<!-- TODO Implement CSRF token -->
	<?php $fb_redirect_url = Router::url(array('controller' => 'sessions', 'action' => 'fb_login'), true); ?>
	<?php $fb_login_url = 'https://www.facebook.com/dialog/oauth?client_id='.Configure::Read('FB_API').'&redirect_uri='.urlencode($fb_redirect_url).'&scope=email';?>
	<?php echo $this->Html->link('Login with Facebook', $fb_login_url, array('class' => 'zocial facebook'));?>

	<?php $google_plus_redirect_url = Router::url(array('controller' => 'sessions', 'action' => 'google_plus_login'), true); ?>
	<?php $google_plus_login_url = 'https://accounts.google.com/o/oauth2/auth?response_type=code&client_id='.urlencode(Configure::Read('GOOGLE_API')).'&redirect_uri='.urlencode($google_plus_redirect_url).'&scope=https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email';?>
	<?php echo $this->Html->link('Login with Google+', $google_plus_login_url, array('class' => 'zocial googleplus'));?>
</div>
