 <?php 
$privacyPolicy=App\Models\Content::where('id',14)->first();
?> 
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



