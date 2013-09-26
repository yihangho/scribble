<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Scribble 2.0');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->css("bootstrap.min");
		echo $this->Html->css('zocial');
		echo $this->Html->css('style');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');

		echo $this->Html->script("//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js");
		echo $this->Html->scriptStart();
		echo "if (!window.jQuery) document.write('<script src=\"js/jquery-1.10.2.min.js\"><\/script>');";
		echo $this->Html->scriptEnd();
		echo $this->Html->script("bootstrap.min");
		echo $this->Html->script("script");
	?>
</head>
<body>
	<div class="container">
		<nav class="navbar navbar-default" role="navigation">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
			    <a class="navbar-brand" href="<?php echo $this->Html->url(array('controller' => 'Scribbles', 'action' => 'add'));?>"><?php echo $cakeDescription;?></a>
			</div>

			<div class="collapse navbar-collapse navbar-ex1-collapse">
				<ul class="nav navbar-nav navbar-right">
					<?php if ($loggedIn):?>
					<li <?php if (isset($minePage) && $minePage):?>class="active"<?php endif;?>><a href="<?php echo $this->Html->url(array('controller' => 'Users', 'action' => 'listScribbles'));?>">Mine</a></li>
					<li><a href="<?php echo $this->Html->url(array('controller' => 'sessions', 'action' => 'destroy'));?>">Logout</a></li>
					<?php else:?>
					<li <?php if (isset($loginPage) && $loginPage):?>class="active"<?php endif;?>><a href="<?php echo $this->Html->url(array('controller' => 'sessions', 'action' => 'create'));?>">Login</a></li>
					<?php endif;?>
					<li <?php if (isset($tutorialPage) && $tutorialPage):?>class="active"<?php endif;?>><a href="<?php echo $this->Html->url(array('controller' => 'pages', 'action' => 'tutorial'));?>">Tutorial</a></li>
					<li <?php if (isset($aboutPage) && $aboutPage):?>class="active"<?php endif;?>><a href="<?php echo $this->Html->url(array('controller' => 'pages', 'action' => 'about'));?>">About Scribble</a></li>
				</ul>
			</div>
		</nav>

		<div id="content">
			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
	</div>
	<?php echo $this->Js->writeBuffer(); ?>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
