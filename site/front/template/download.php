<div class="two-column-layout column-layout clearfix">
	<div class="column-1 column"><?php include(dirname(__FILE__).'/_menu.php'); ?></div>
    <div class="column-2 column">
        <h3>Downloads</h3>
        <h4>Core Classes</h4>
        <p>For testing, developing frameworks or quick scripts. With a small finger print, you can still harness the power, style and flexability of Eden.</p>
        <h5>Select Packages:</h5>
        <form method="post">
			<div class="clearfix">
				<label><input type="checkbox" class="checkbox" name="package[]" value="utilities" /> Utilities</label>
				<label><input type="checkbox" class="checkbox" name="package[]" value="cache" /> Cache, MemCache, APC</label>
				<label><input type="checkbox" class="checkbox" name="package[]" value="mail" /> POP3, SMTP, IMAP</label>
				<label><input type="checkbox" class="checkbox" name="package[]" value="mysql" /> MySQL</label>
				<label><input type="checkbox" class="checkbox" name="package[]" value="postgre" /> PostGres</label>
				<label><input type="checkbox" class="checkbox" name="package[]" value="sqlite" /> Sqlite</label>
				<label><input type="checkbox" class="checkbox" name="package[]" value="amazon" /> Amazon</label>
				<label><input type="checkbox" class="checkbox" name="package[]" value="eventbrite" /> Eventbrite</label>
				<label><input type="checkbox" class="checkbox" name="package[]" value="facebook" /> Facebook</label>
				<label><input type="checkbox" class="checkbox" name="package[]" value="getsatisfaction" /> Get Satisfaction</label>
				<label><input type="checkbox" class="checkbox" name="package[]" value="jabber" /> Jabber</label>
				<label><input type="checkbox" class="checkbox" name="package[]" value="paypal" /> PayPal</label>
				<label><input type="checkbox" class="checkbox" name="package[]" value="authorizenet" /> Authorize.net</label>
				<label><input type="checkbox" class="checkbox" name="package[]" value="xend" /> Xend</label>
			</div>
			<input type="submit" class="submit" value="Download" />
        </form>
    </div>
</div>