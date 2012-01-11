<?php //-->
include '../eden.php';
include '../eden/loader.php';

$loader = Eden_Loader::i()->load('Eden_Unit');
$unit 	= $loader->Eden_Unit();

include 'unit/class.php';
include 'unit/cookie.php';
include 'unit/session.php';
//include 'unit/file.php';
include 'unit/folder.php';
include 'unit/string.php';
include 'unit/model.php';

?>
<br /><br />
<table width="100%" cellpadding="5" cellspacing="0" border="1">
<?php foreach($unit->getReport() as $package => $tests): ?>
	<?php $p = $unit->getPassFail($package); ?>
	<tr>
		<td colspan="3">
			<h3><?php echo $package; ?> <?php echo floor($p[0] / $unit->getTotalTests($package) * 100); ?>%</h3>
			<em>
				PASS: <?php echo $p[0]; ?>,
				FAIL: <?php echo $p[1]; ?>,
				TOTAL TESTS: <?php echo $unit->getTotalTests($package); ?>
			</em>
		</td>
	</tr>
	<?php foreach($tests as $test => $results): ?>
	<tr style="background-color: #EFEFEF;">
		<td width="500"><?php echo $results['message']; ?></td>
		<td><?php echo $results['end'] - $results['start']; ?>ms</td>
		
		<?php if($results['pass']): ?>
		<td bgcolor="#CAFFA0">PASS</td>
		<?php else: ?>
		<td bgcolor="#FEB7A8">FAIL</td>
		<?php endif; ?>
	</tr>
	
	<?php endforeach; ?>
<?php endforeach; ?>
</table>