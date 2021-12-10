<h1>CCAvenue Payment Gateway Intgration</h1>
<div id="ccav-payment-form">
<form name="frmPayment" action="ccavRequestHandler.php" method="POST">
    <input type="hidden" name="merchant_id" value="<?php echo '222955'; ?>"> 
    <input type="hidden" name="language" value="EN"> 
    <input type="hidden" name="amount" value="1">
    <input type="hidden" name="currency" value="INR"> 
    <input type="hidden" name="redirect_url" value="http://avi.dci.in/api/ccavResponseHandler"> 
    <input type="hidden" name="cancel_url" value="http://avi.dci.in/api/ccavResponseHandler"> 
    
    <div>
    <input type="text" name="billing_name" value="" class="form-field" Placeholder="Billing Name"> 
    <input type="text" name="billing_address" value="" class="form-field" Placeholder="Billing Address">
    </div>
    <div>
    <input type="text" name="billing_state" value="" class="form-field" Placeholder="State"> 
    <input type="text" name="billing_zip" value="" class="form-field" Placeholder="Zipcode">
    </div>
    <div>
    <input type="text" name="billing_country" value="" class="form-field" Placeholder="Country">
    <input type="text" name="billing_tel" value="" class="form-field" Placeholder="Phone">
    </div> 
    <div>
    <input type="text" name="billing_email" value="" class="form-field" Placeholder="Email">
    </div>
    <div>
    <button class="btn-payment" type="submit">Pay Now</button>
    </div>
</form>
</div>