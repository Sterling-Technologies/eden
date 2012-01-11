<ul>
<?php foreach($contents['folders'] as $folder): ?>
<?php if(strpos($folder, '.svn') !== false) { continue; } ?>
<li>
	<?php if(strpos($current, $root.'/'.$folder['last']) === 0): ?>
	<strong><?php echo $folder['last']; ?></strong>
	<?php echo front()->Front_Block_Menu()->setPath($current)->setRoot($root.'/'.$folder['last']); ?>
	<?php else: ?>
	<a href="/api<?php echo $root; ?>/<?php echo $folder['last']; ?>"><?php echo $folder['last']; ?></a>
	<?php endif; ?>
</li>
<?php endforeach; ?>
<?php foreach($contents['files'] as $file): ?>
<li>
	<?php if($current == $root.'/'.$file['last']): ?>
	<strong><?php echo $file['last']; ?></strong>
	<?php else: ?>
	<a href="/api<?php echo $root; ?>/<?php echo $file['last']; ?>"><?php echo $file['last']; ?></a>
	<?php endif; ?>
</li>
<?php endforeach; ?>
</ul>