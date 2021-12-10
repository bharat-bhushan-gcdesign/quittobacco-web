@if ($errors->any())
    <ul class="alert alert-danger" style="width: auto">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>

@endif
@if(Session::has('success_message'))
    <div id="success_message" class="alert alert-success" style="width: auto; align-self: right">
        <span class="glyphicon glyphicon-ok"></span>
        {!! session('success_message') !!}

        <button type="button" class="close" data-dismiss="alert" aria-label="close">
            <span aria-hidden="true">&times;</span>
        </button>

    </div>
@endif
<script type="text/javascript">
    function success(){
        $('#success_message').hide();    
    }
    setTimeout(success,5000);
</script>