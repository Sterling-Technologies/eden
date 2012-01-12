<div class="three-column-layout column-layout clearfix">
	<div class="column-1 column">
		<h3>Navigation</h3>
		<?php echo front()->Front_Block_Menu()->setPath($path); ?>
	</div>
	<div class="column-2 column">
		<div class="crumbs"><?php echo front()->Front_Block_Crumbs()->setPath($path); ?></div>
		<?php if(empty($notes)): ?>
		<div class="folder">
		<h3>Folder: <?php echo $path; ?></h3>
		<?php echo front()->Front_Block_Menu()->setRoot($path)->setPath($path); ?>
		</div>
		<?php elseif(!$source): ?>
		<a href="?source=1">View Source</a>
		<?php foreach($notes as $class => $class_note): ?>
		<?php if(!isset($class_note['meta'])) { continue; } ?>
		<div class="class">
			<h3>
				<?php if($class_note['meta']['abstract']): ?>
				abstract
				<?php endif; ?>
				class <?php echo $class; ?>
			</h3>
			<p><?php echo implode(' ', $class_note['description']); ?></p>
			
			<?php if($class_note['meta']['extends'] || $class_note['meta']['implements']): ?>
			<ul>
				<?php if($class_note['meta']['extends']): ?>
				<li>Extends: <a href="/api/<?php echo front()
						->Eden_Type_String($class_note['meta']['extends'])
						->trim()
						->str_replace('_', '/')
						->strtolower(); ?>.php"
					><?php echo trim($class_note['meta']['extends']); ?></a>
				</li>
				<?php endif ?>
				<?php if($class_note['meta']['implements']): ?>
				<li>Implements: <?php echo implode(', ', $class_note['meta']['implements']); ?></li>
				<?php endif ?>
			</ul>
			<?php endif; ?>
			
			<?php if(isset($class_note['Constants']) && !empty($class_note['Constants'])): ?>
			<h4>Constants</h4>
			<ul>
				<?php foreach($class_note['Constants'] as $key => $value): ?>
				<li><?php echo $key; ?>: <?php echo $value; ?></li>
				<?php endforeach; ?>
			</ul>
			<?php endif; ?>
			
			<?php if(isset($class_note['Public Methods']) && !empty($class_note['Public Methods'])): ?>
			<h4>Public Methods</h4>
			<?php foreach($class_note['Public Methods'] as $i => $method_note): ?>
			<div class="method<?php echo $i%2==0?' method-zebra':NULL; ?>">
				<h5><?php echo $method_note['code']; ?></h5>
				<p><?php echo implode(' ', $method_note['description']); ?></p>
				<?php if(isset($method_note['attributes']['param']) 
				&& is_string($method_note['attributes']['param']) 
				&& trim($method_note['attributes']['param'])): ?>
				<h6>Arguments</h6>
				<ol><li><?php echo $method_note['attributes']['param']; ?></li></ol>
				
				<?php elseif(isset($method_note['attributes']['param']) 
				&& is_array($method_note['attributes']['param']) 
				&& !empty($method_note['attributes']['param'])): ?>
				
				<h6>Arguments</h6>
				<ol>
					<?php foreach($method_note['attributes']['param'] as $argument): ?>
					<li><?php echo $argument; ?></li>
					<?php endforeach; ?>
				</ol>
				<?php endif; ?>
				
				<?php if(isset($method_note['attributes']['return']) 
				&& trim($method_note['attributes']['return'])): ?>
				<h6>Returns <?php echo $method_note['attributes']['return']; ?></h6>
				<?php endif; ?>
			</div>
			<?php endforeach; ?>
			<?php endif; ?>
		</div>
		<?php endforeach; ?>
            
        
		<?php elseif($source == 2): ?>
		<?php //$code = str_replace(array('<?php //-->', "\n"), '', $code); ?>
		<code><?php echo $minify; ?></code>
		<?php else: ?>
		<a href="?source=0">View Notes</a>
		<div class="source">
			<h3>Source</h3>
			<script type="text/javascript" src="/assets/brushes/shCore.js"></script>
			<script type="text/javascript" src="/assets/brushes/shBrushPhp.js"></script>
			<link type="text/css" rel="stylesheet" href="/assets/brushes/shCoreDefault.css"/>
			<script type="text/javascript">SyntaxHighlighter.all();</script>
			<pre class="brush: php;"><?php echo $code; ?></pre>
		</div>
		<?php endif; ?>
	</div>
	<div class="column-3 column">
		<h3>Revision History</h3>
		<?php echo front()->Front_Block_Log()->setPath($path); ?>
	</div>
</div>