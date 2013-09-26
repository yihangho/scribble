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
<hr>
<h2>Why login?</h2>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Keep track of all your Scribbles</h3>
	</div>
	<div class="panel-body">
		Logging in allows you to easily keep track of all the Scribbles that you have created, together with the date and time when your Scribbles were created and last modified.
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Access control <span class="label label-info">Coming soon</span></h3>
	</div>
	<div class="panel-body">
		Logging in allows you to control who can view and who can edit your Scribbles.
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">Early access to new features</h3>
	</div>
	<div class="panel-body">
		Scribble is still under active development. We will let logged in users try out our newest, latest and awesomest features before other users.
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">It's free!</h3>
	</div>
	<div class="panel-body">
		And will always be. :)
	</div>
</div>
<hr>
<h2>Wait, what do you collect?</h2>
<p>
	We understand that your concern when asking you to hand over your private information to other people. In face, we are happy that you have such awareness. Well, Scribble record <em>ONLY</em> your email address when you log in. When you login either via Facebook and Google+, Facebook and Google+ allow Scribble to access all the information that you've made public, and also your email address. We will record only your email address for identification purpose. In other words, we recognize our users by email address - you can choose to login with Facebook and Google+, as long as you registered both with the same email address, you will be recognized as the same user. What about spam? Glad that you asked. To date, we have not sent any email to any of our users. 'Nuff said. :D So, go ahead and login make your Scribble experience even more amazing!
</p>
