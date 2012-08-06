<?xml version="1.0" encoding="UTF-8"?>
<entry xmlns="http://www.w3.org/2005/Atom"
  xmlns:yt="http://gdata.youtube.com/schemas/2007">
  <?php if(!is_null($channel)): ?>
    <category scheme="http://gdata.youtube.com/schemas/2007/subscriptiontypes.cat"
      term="channel"/>
    <yt:username><?php echo $channel; ?></yt:username>
  <?php endif; ?>
  <?php if(!is_null($user)): ?>
    <category scheme="http://gdata.youtube.com/schemas/2007/subscriptiontypes.cat"
      term="user"/>
    <yt:username><?php echo $user; ?></yt:username>
  <?php endif; ?>
</entry>