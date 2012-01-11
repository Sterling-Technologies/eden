<p>
    <strong><?php echo $type; ?> <?php echo $level; ?></strong> from 
    <strong><?php echo $class; ?></strong> in 
    <strong><?php echo $file; ?></strong> on line 
    <strong><?php echo $line; ?></strong>
</p>
<p><strong>Eden Says:</strong> <?php echo $message; ?></p>
<table width="100%" border="1" cellspacing="0" cellpadding="5">
<?php foreach($history as $row): ?>
<tr>
    <td><?php echo $row[0]; ?></td>
    <td><?php echo $row[1]; ?>(<?php echo $row[2]; ?>)</td>
</tr>
<?php endforeach; ?>
</table>