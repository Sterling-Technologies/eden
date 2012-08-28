<form method="post" action="<?php echo $url;?>">
	<fieldset>
		<div>
			<label><?php echo $cardNumberLabel; ?></label>
			<input type="text" class="text" size="15" name="x_card_num" value="<?php echo $cardNumber; ?>" />
		</div>
		<div>
			<label><?php echo $expirationLabel; ?></label>
			<input type="text" class="text" size="4" name="x_exp_date" value="<?php echo $expiration; ?>" />
		</div>
		<div>
			<label><?php echo $cvvLabel; ?></label>
			<input type="text" class="text" size="4" name="x_card_code" value="<?php echo $cvv; ?>" />
		</div>
	</fieldset>
	<fieldset>
		<div>
			<label><?php echo $firstNameLabel; ?></label>
			<input type="text" class="text" size="15" name="x_first_name" value="<?php echo $firstName; ?>" />
		</div>
		<div>
			<label><?php echo $lastNameLabel; ?></label>
			<input type="text" class="text" size="14" name="x_last_name" value="<?php echo $lastName; ?>" />
		</div>
	</fieldset>
	<fieldset>
		<div>
			<label><?php echo $addressLabel; ?></label>
			<input type="text" class="text" size="26" name="x_address" value="<?php echo $address; ?>" />
		</div>
		<div>
			<label><?php echo $cityLabel; ?></label>
			<input type="text" class="text" size="15" name="x_city" value="<?php echo $city; ?>" />
		</div>
	</fieldset>
	<fieldset>
		<div>
			<label><?php echo $stateLabel; ?></label>
			<input type="text" class="text" size="4" name="x_state" value="<?php echo $state; ?>"/>
		</div>
		<div>
			<label><?php echo $zipLabel; ?></label>
			<input type="text" class="text" size="9" name="x_zip" value="<?php echo $zip; ?>"/>
		</div>
		<div>
			<label><?php echo $countryLabel; ?></label>
			<input type="text" class="text" size="22" name="x_country" value="<?php echo $country; ?>"/>
		</div>
	</fieldset>
	
	<?php foreach($fields as $name => $value): ?>
		<input type="hidden" name="<?php echo $name; ?>" value="<?php echo $value; ?>" />
	<?php endforeach; ?>
	
	<input type="submit" value="<?php echo $submitButton; ?>" class="submit buy">
</form>