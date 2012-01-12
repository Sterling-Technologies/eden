<!DOCTYPE html>
<html class="<?php print $class; ?>">
	
<head>
	<title><?php print $title; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<?php if(isset($meta) && is_array($meta)): ?>
    <?php foreach($meta as $name => $content): ?>
    <meta name="<?php print $name; ?>" content="<?php print $content; ?>" />
    <?php endforeach; ?>
    <?php endif; ?>
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/reset.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="/assets/main.css" />
</head>

<body>
	<div class="page">
		<div class="head"><?php print $head; ?></div>
        <div class="body"><?php print $body; ?></div>
        <div class="foot"><?php print $foot; ?></div>
    </div>
    
</body>

</html>
