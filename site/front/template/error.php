<p>
	<strong><?php echo $type; ?> <?php echo $level; ?></strong> from 
	<strong><?php echo $class; ?></strong> in 
	<strong><?php echo $file; ?></strong> on line 
	<strong><?php echo $line; ?></strong>
</p>
<p><strong>Eden Says:</strong> <?php echo $message; ?></p>
<table width="100%%" border="1" cellspacing="0" cellpadding="5">
<?php foreach($trace as $line): ?>
<tr><td><?php echo $line[0]; ?></td><td><?php echo $line[1]; ?>(<?php echo $line[2]; ?>)</td></tr>
<?php endforeach; ?>
</table>