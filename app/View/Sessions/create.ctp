<h1>Login</h1>
<div class="text-center">
	<!-- TODO Implement CSRF token -->
	<?php $fb_redirect_url = Router::url(array('controller' => 'sessions', 'action' => 'fb_login'), true); ?>
	<?php $fb_login_url = 'https://www.facebook.com/dialog/oauth?client_id='.Configure::Read('FB_API').'&redirect_uri='.urlencode($fb_redirect_url).'&scope=email';?>
	<?php echo $this->Html->link('Login with Facebook', $fb_login_url, array('class' => 'zocial facebook'));?>
	<!-- <a href="#" class="zocial facebook">Login with Facebook</a> -->
</div>
