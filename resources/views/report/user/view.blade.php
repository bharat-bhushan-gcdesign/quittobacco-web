
<style type="text/css">
.successmsg {
   color: #fff !important;
   background-color: green !important;
   width: 30% !important;
   font-size: 15px !important;
   border-radius: 25px !important;
}
.errmsg {
  color: #fff !important;
   background-color: #ff8086 !important;
   width: 30% !important;
   font-size: 15px !important;
   border-radius: 25px !important;
}
.successmsg1 {
   color: #fff !important;
   background-color: green !important;
   width: 30% !important;
   font-size: 15px !important;
   border-radius: 25px !important;
   display:none;
}
table{
  width:100%;
}
table, th, td {
  padding-top: 25px;
  font-size:12px;
  border: 1px solid black; 
  border-collapse: collapse;
}
.footer {
    position: fixed;
      bottom: 0px;
      left: 0px;
      right: 0px;
    height:30px;
    padding:10px;
    width:100%;
    text-align:center;
}
</style>
<div class="row footer">
  <p style="margin-bottom:5px;">Report generated by</p>
 <img src="{{url('/')}}/img/donationapp.png" alt="logo" width="40" style="display:inline-block;margin-bottom:8px;" />
</div>
<div class="row">
<center><h1>User Report</h1></center>
<table style="width:100%;">
  <thead>
    <tr>
      <th>S.no</th>
      <th>Name</th>
      <th>Email</th>
      <th>Mobile</th>
      <th>Status</th>
      <th>Created Date</th>                                          
    </tr>
  </thead>
  <tbody>
    @foreach($userlist as $index => $list)
                                        <tr>
                                          <td>{{$index +1}}</td>
                                          <td>{{$list->Name}}</td>
                                          <td>{{$list->email}}</td>
                                          <td>{{$list->mobile}}</td>
                                          @if($list->status =='0')
                                           {
                                             <td>Inactive</td>
                                           }
                                           @endif
                                           @if($list->status =='1')
                                           {
                                             <td>Active</td>
                                           }
                                           @endif
                                           @if($list->status =='2'){
                                             <td>Delete</td>
                                           }
                                           @endif
                                           <td>{{date('d-m-Y', strtotime($list->created_at))}}</td>
                                        </tr>
        @endforeach                                                                      
  </tbody>
</table>
</div>

   



    


