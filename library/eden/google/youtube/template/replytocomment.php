<?xml version="1.0" encoding="UTF-8"?>
<entry xmlns="http://www.w3.org/2005/Atom"
    xmlns:yt="http://gdata.youtube.com/schemas/2007">
  <link rel="http://gdata.youtube.com/schemas/2007#in-reply-to"
    type="application/atom+xml" 
    href="https://gdata.youtube.com/feeds/api/videos/<?php echo $videoId; ?>/comments/<?php echo $commentId; ?>"/>
  <content><?php echo $comment?></content>
</entry>