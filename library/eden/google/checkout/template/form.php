<form method="POST" action="<?php echo $url; ?>">
	<input type="hidden" name="item_name_1" value="<?php echo $itemName; ?>"/>
	<input type="hidden" name="item_description_1" value="<?php echo $itemDescription; ?>"/>
	<input type="hidden" name="item_price_1" value="<?php echo $itemPrice; ?>"/>
	<input type="hidden" name="item_currency_1" value="<?php echo $itemCurrency; ?>"/>
	<input type="hidden" name="item_quantity_1" value="<?php echo $itemQuantity; ?>"/>
	<input type="hidden" name="item_merchant_id_1" value="<?php echo $merchantId; ?>"/>
    <input type="image" name="Google Checkout" alt="Fast checkout through Google"
        src="http://sandbox.google.com/checkout/buttons/checkout.gif?merchant_id=418817113687135
              &w=180&h=46&style=white&variant=text&loc=en_US" height="46" width="180">
</form> 