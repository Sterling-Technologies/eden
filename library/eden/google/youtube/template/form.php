<form action="<?php echo $postUrl; ?>?nexturl=<?php echo $redirectUrl; ?>" method="post" enctype="multipart/form-data"> 
        <input name="file" type="file"/>
        <input name="token" type="hidden" value="<?php echo $uploadToken; ?>"/>
        <input value="Upload Video File" type="submit" />
</form>