<form name="client-post-form" method="post" action="<?php echo $url; ?>">
    <?php foreach($query as $key => $value): ?>
    	<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $value; ?>">    	
    <?php endforeach; ?>
    <input type="submit" name="submit">
</form>
