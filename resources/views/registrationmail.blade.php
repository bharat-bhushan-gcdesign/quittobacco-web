<!DOCTYPE html>
<html lang="en-US" class="no-js no-svg">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900" rel="stylesheet">
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
   </head>
   <body style="height: 100%;margin: 0 auto;font-family: 'Roboto', sans-serif;background:#f8f9fa;display: block;width: 100%; background-color: #fff !important;">

      <table style="margin:50px auto; width:50%;background-color: #ed7626;border-radius: 0px;">
         <thead>
            <th >
               <h1 style="font-size: 40px;font-weight: bold;color:#fff;text-transform: uppercase;">avi</h1>
            </th>


         </thead>
         <tbody style="display: block;background-color:#ed7626;">

        <tr>
        <td>
        <img src="{{url('/')}}/img/Email_img1.jpg" style="width: 50%; padding-left: 150px;">
        </td>

        </tr>


            <tr style="text-align: center;display: block;">
               <td style="width: 100%;float: left;">
                  <h2 style=" font-family: proxima-nova, sans-serif;font-weight: bold; color:#fff;position: relative;
    top: 15px;">Activate Your Account</h2>
               </td>
            </tr>
            <tr style="text-align: center;display:inline-block;width: 100%">
               <td style="color:#000; text-align: center; font-size: 15px; font-weight: normal;padding: 7px 70px;
                  font-family: proxima-nova, sans-serif; font-style: normal;font-weight: normal;color:#ffffffbf;">
                  Thank you for registering with us. We are happy to have you as a member.
               </td>
            </tr>
            <tr style="text-align: center;display: block; ">
               <td style="width: 100%;float: left; 	 margin: 10px auto 30px;">
                  <h4 style="border: 1px solid #ddd; display: inline-block;  padding: 10px 30px; border-radius: 30px; color: #fff;"> Email : {{$email}}</h4>
                  <h4 style="border: 1px solid #ddd; display: inline-block;  padding: 10px 30px; border-radius: 30px; 
                    color: #fff;">Password : {{$password}}</h4>
               </td>
            </tr>
            <tr   style="text-align: center;display: block; margin-left:40%;" >
            <td >
            	 <a href="{{url('/')}}" style="color: #d0d0d0;">Click to view website</a>
            </td>
            </tr>

            <tr style="text-align: center;display: block;margin-left:20% ">
            <td >
         	<p style="font-size: 16px;font-weight: bold;color: #fff;">You received this email because you signed up for AVI.</p>
            </td>
            </tr>
         </tbody>
      </table>
      <br>
   </body>
</html>