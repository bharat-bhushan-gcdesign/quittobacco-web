<!DOCTYPE html>
<html lang="en">
<head>
	<title>Thank You</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link type="text/css" rel="stylesheet" href="{{url('/')}}/css/paymentstyle.css" />
	 <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
      <style type="text/css">
/*.responsive {
  width: 100%;
  height: auto;
}
*/
      </style>
</head>
   <body style="height: 100%;margin: 0 auto;font-family: 'Roboto', sans-serif;background-color: #fff !important;display: block;
      width: 100%;">
      <table style="margin:50px auto;padding: 25px; border-radius: 0px;">
       <!--   <thead>
            <th style="text-align:center;">
               <h1 style="font-size: 40px;font-weight: 900;color: #fff;padding-top: 10px;text-transform: uppercase;"></h1>
            </th>
         </thead> -->
         <tbody style="">

           <tr>
        <td>
        <img src="{{url('/')}}/img/flogo.png"class="responsive" style="width: 40%;height: 35%;text-align: center;margin-left: 28%">
        </td>

        </tr>

<tr>
   <p>password: {{ $data1["v"] }}</p>

</tr>


  


         </tbody>
      </table>
      <br>
     <!--  <div style="text-align: center; color: #ddd;">
         <a href="" style="color: #ddd;">Click to view website</a>
      </div>
      <div style="text-align:center;">
         <p style="font-size: 16px;font-weight: bold;color: #ddd;">you received this email because you signup for Avi</p>
      </div> -->
   </body>

</html>