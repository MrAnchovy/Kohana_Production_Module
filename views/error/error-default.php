<div class="container error">
<?php if ($debug) : ?>
	<h1>Error <?php echo $code ?> <?php echo $status ?></h1>
	<p>Message [<?php echo $message ?>]</p>

	<p>Extended [<?php echo $extended ?>]</p>
<?php else : ?>
	<h1>Technical fault <span>:(</span></h1>
	<p>Sorry, something has gone wrong. We have logged the error and will try to fix it so it doesn't happen in future, but we appreciate that is not much help to you now.</p>
	<p>You could:</p>
	<ul>
		<li><a href="<?php echo $_SERVER['REQUEST_URI'] ?>">Try again</a></li>
		<li>Go to our <a href="<?php echo URL::base() ?>">home page</a></li>
		<li>Contact the server administrator at <?php echo $_SERVER['SERVER_ADMIN'] ?></li>
	</ul>
<?php endif; ?>
</div>
