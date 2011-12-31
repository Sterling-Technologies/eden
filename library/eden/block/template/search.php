<form class="<?php echo $class; ?>" 
	method="get" 
	action="<?php echo $url; ?>?<?php echo http_build_query($query); ?>">
	<?php if($label): ?>
	<span class="title"><?php echo $label; ?></span>
	<?php endif; ?>
	<input class="text" type="text" name="<?php echo $name; ?>" value="<?php echo $keyword; ?>" />
	<input class="submit" type="submit" value="Search"/>
</form>