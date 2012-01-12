<div class="two-column-layout column-layout clearfix">
	<div class="column-1 column"><?php include(dirname(__FILE__).'/_menu.php'); ?></div>
    <div class="column-2 column">
        <h3>Downloads</h3>
        <h4>Core Classes</h4>
        <p>For testing, developing frameworks or quick scripts. With a small finger print, you can still harness the power, style and flexability of Eden.</p>
        <h5>Select Packages:</h5>
        <form method="post">
        <label><input type="checkbox" class="checkbox" name="package[]" value="utilities" /> Utilities</label>
        <label><input type="checkbox" class="checkbox" name="package[]" value="database" /> Database</label>
        <label><input type="checkbox" class="checkbox" name="package[]" value="cache" /> Cache</label>
        <br /><br /><br /><input type="submit" class="submit" value="Download" />
        </form>
    </div>
</div>