<!--
	This page will be shown when access is denied.
	Explain to user how we handle their data.
-->
<p>
	<?php
	if (isset($fbError)) {
		echo $fbError;
	}
	?>
</p>
