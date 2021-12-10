@include('header')
@include('sidebar')

<!-- /#left -->
  <style>
.error {
      color: red;
      
   }
</style>
        <div id="content" class="bg-container">
            <header class="head">
                <div class="main-bar">
                   <div class="row no-gutters">
                       <div class="col-sm-5 col-lg-6 skin_txt">
                           <h4 class="nav_top_align">
                               <i class="fa fa-plus"></i>
                                 @if($pid=="")
                               Add Morning smoke time
                               @else
                               Edit Morning smoke time
                               @endif
                           </h4>
                       </div>
                       <div class="col-sm-7 col-lg-6">
                           <ol class="breadcrumb float-right nav_breadcrumb_top_align">
                               <li class="breadcrumb-item">
                                   <a href="{{url('/')}}">
                                       <i class="fa fa-home" data-pack="default" data-tags=""></i>
                                       Dashboard
                                   </a>
                               </li>
                               <li class="breadcrumb-item">
                                   <a href="{{url('/firstSmoke')}}">Morning smoke time</a>
                               </li>
                             
                           </ol> 
                       </div>
                   </div>
                </div>
            </header>
            <div class="outer">
                <div class="inner bg-container forms">
                    <form method="POST" action="{{url('firstSmoke/save')}}" id="adforms" name="edit_country" class="form-horizontal">
                    <div class="row">
                        <div class="col">
                            <div class="card">

                                          {{ csrf_field() }}
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-3 input_field_sections">
                                            <h5>Time</h5>
                                        </div>    
                                       <div class="col-sm-9 input_field_sections">                                       
                                           <input type="text" class="form-control" name="name" id="name" value="{{ ( isset($morningFirstSmoke->time) ? $morningFirstSmoke->time : null) }}" placeholder="Enter Time here.." minlength="1" maxlength="50" onkeypress="return lettersOnly(event)"/>  
                                             
                                         </div>
                                      </div>
                                    <div class="row"> 
                                       <div class="col-sm-3 input_field_sections">
                                          <h5>Status</h5>
                                        </div>
                                        <div class="col-sm-9 input_field_sections">
                                             <select class="form-control status" style="width: 100%;" name="status" id="status"  >
                                             <option value="1">Active</option>
                                             <option value="0" {{ (isset($morningFirstSmoke->status) && $morningFirstSmoke->status==0)  ? 'selected': '' }}>InActive</option>
                                             </select>
                                        </div>
                                    </div>  

                                                           
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- /.row -->
                    <div class=" m-t-35">

                        <div class="form-actions form-group row">
                            <div class="col-xl-12 text-center">
                              <input type="hidden" name="pid" value="{{$pid}}">
                               <input type="submit" class="btn btn-primary" value="Submit">
                                 <input type="button" class="btn btn-default" value="Cancel" id="cancelform">
                            </div>
                        </div>
                    </div>
                   </form>
                   
                </div>
                <!-- /.outer -->
            </div>
        </div>
        <!-- /#content -->
    </div>
<!-- startsec End -->

<script src="https://cdn.ckeditor.com/4.11.1/standard/ckeditor.js"></script>
   @include('footer')

<script>
  CKEDITOR.editorConfig = function (config) {
    config.language = 'es';
    config.uiColor = '#F7B42C';
    config.height = 300;
    config.toolbarCanCollapse = true;

  };
  CKEDITOR.replace( 'description');
</script>  
 

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>


<script type="text/javascript">


jQuery.validator.addMethod("lettersonly", function(value, element) {
  return this.optional(element) || /^[a-zA-Z0-9\s& ]+$/i.test(value);
}, "<span class='testing' style='color:red'>  Please enter only letters</span>");

 $.validator.addMethod("nowhitespace", function(value, element) {
      return this.optional(element) || value.trim()!="";
      }, "No white space please");

/*$('input, text').blur(function() {
        var value = $.trim( $(this).val() );
        $(this).val( value );
    });*/
$(function() {
  
   $( "#adforms" ).validate({
      ignore: [],
      rules: {    
        name: {
            required: true,
            minlength:3,
            maxlength:50,
            remote: {
                    url: "/firstSmoke/check-Title",
                    type: "post",
                    data: {
                        name: function() {
                            return $( "#name" ).val();
                        },
                        id: function() {
                            return $( "#id" ).val();
                        },
                        _token: function() {
                            return "{{csrf_token()}}"
                        }
                    }
                }
              },
        description:{
           ckeditor_required:true
          }
        },
       messages: {
             
        name: {
            required: "Please Enter Time",
            lettersonly: "only allowed alphabets.",
            nowhitespace:"Name Field is invalid",
            remote:"Time Already exists",

                 }     
              },

    /* use below section if required to place the error*/
                errorPlacement: function(error, element) 
                {
                    if (element.attr("name") == "description") 
                   {
                    error.insertBefore("textarea#description");
                    } else {
                    error.insertBefore(element);
                    }
                },

    submitHandler: function(form){
      $('form input[type=submit]').prop('disabled', true);
      form.submit();
    },
   });  

   //Extention method for check CKEditor Control   
// jQuery.validator.addMethod("customfunctionanme",validationfunction,validationmessage);  
  
        jQuery.validator.addMethod("ckeditor_required", function (value, element) {  
            var idname = $(element).attr('id');  
            var editor = CKEDITOR.instances[idname];  
            var ckValue = GetTextFromHtml(editor.getData()).replace(/<[^>]*>/gi, '').trim();  
            if (ckValue.length === 0) {  
//if empty or trimmed value then remove extra spacing to current control  
                $(element).val(ckValue);  
            } else {  
//If not empty then leave the value as it is  
                $(element).val(editor.getData());  
            }  
            return $(element).val().length > 0;  
        }, "This field is required");
function GetTextFromHtml(html) {  
            var dv = document.createElement("DIV");  
            dv.innerHTML = html;  
            return dv.textContent || dv.innerText || "";  
        }
});
$("#cancelform").click(function() {
   window.location.href = "{{url('/firstSmoke')}}";
});
function lettersOnly() 
{
            var charCode = event.keyCode;

            if ((charCode > 48 && charCode < 57) || (charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 8 || charCode == 32)

                return true;
            else
                return false;
}
</script>