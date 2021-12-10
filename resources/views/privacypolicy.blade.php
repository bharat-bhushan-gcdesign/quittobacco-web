 <?php 
$privacyPolicy=App\Models\Content::where('id',17)->first();
?> 
<meta property="og:type" content="website" />
<meta property="og:title" content="Who privacy">

<meta property="fb:app_id" content="360981974964599">
<meta property="og:description" content="privacy policy">
<meta property="og:url" content="https://www.who.int/favicon.ico">
<meta property="og:image" content="https://whoapp.dci.in/uploads/userimage/who-LOGO.png">
<center><strong>{{$privacyPolicy->title}}</strong></center>
<script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<div class="container">
<?php

if($privacyPolicy->status==1) {
?>
  <strong>{!!base64_decode($privacyPolicy->description) !!}</strong>
 <?php
}
else
{ ?>
	<strong>Please Contact Admin</strong>
<?php }
?>
</div>



