<form method="post" action="<?php echo $action; ?>">
	<input type="hidden" name="x_login" value="<?php echo $login; ?>" />
	<input type="hidden" name="x_fp_hash" value="<?php echo $fingerprint; ?>" />
	<input type="hidden" name="x_amount" value="<?php echo $amount; ?>" />
	<input type="hidden" name="x_fp_timestamp" value="<?php echo $time; ?>" />
	<input type="hidden" name="x_description" value="<?php echo $description; ?>" />
	<input type="hidden" name="x_fp_sequence" value="<?php echo $sequence; ?>" />
	<input type="hidden" name="x_version" value="<?php echo $version; ?>">
	<input type="hidden" name="x_show_form" value="payment_form">
	<input type="hidden" name="x_test_request" value="<?php echo $test; ?>" />
	<input type="hidden" name="x_method" value="cc">
	<input type="submit" value ="<?php echo $submit; ?>">
</form>