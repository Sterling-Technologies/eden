<?xml version="1.0"?>
<entry xmlns="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/" xmlns:yt="http://gdata.youtube.com/schemas/2007">
  <media:group>
    <media:title type="plain"><?php echo $title; ?></media:title>
    <media:description type="plain">
    	<?php echo $description; ?>
    </media:description>
    <media:category scheme="http://gdata.youtube.com/schemas/2007/categories.cat">
		<?php echo $category; ?>
    </media:category>
    <media:keywords><?php $keyword; ?></media:keywords>
  </media:group>
</entry>