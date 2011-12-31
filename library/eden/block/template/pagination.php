<?php if($pages > 1): ?>
<div class="pagination">
<?php if($label): ?>
<span class="label"><?php echo $label; ?></span>
<?php endif; ?>
<?php for($i = $min; $i <= $max; $i++): ?>
<?php if($i == $page): ?>
<strong><?php echo $i; ?></strong>
<?php else: ?>
<a class="<?php echo $class; ?>" 
	href="<?php echo $url; ?>?<?php echo front()->getQuery($query, 'page', $i); ?>"
	><?php echo $i; ?></a>
<?php endif; ?>
<?php endfor; ?>
</div>
<?php endif; ?>