<ul>
<?php foreach($contents['folders'] as $folder): ?>
<li>
	<?php if(strpos($current, $root.'/'.$folder) === 0): ?>
	<strong><?php echo $folder; ?></strong>
	<?php echo front()->Front_Block_Menu()->setPath($current)->setRoot($root.'/'.$folder); ?>
	<?php else: ?>
	<a href="/api<?php echo $root; ?>/<?php echo $folder; ?>"><?php echo $folder; ?></a>
	<?php endif; ?>
</li>
<?php endforeach; ?>
<?php foreach($contents['files'] as $file): ?>
<li>
	<?php if($current == $root.'/'.$file): ?>
	<strong><?php echo $file; ?></strong>
	<?php else: ?>
	<a href="/api<?php echo $root; ?>/<?php echo $file; ?>"><?php echo $file; ?></a>
	<?php endif; ?>
</li>
<?php endforeach; ?>
</ul>