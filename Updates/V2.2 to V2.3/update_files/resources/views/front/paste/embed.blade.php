<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="{{csrf_token()}}" />
<title>@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}</title>
<link rel="shortcut icon" href="{{url('favicon.ico')}}" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="{{url('css/bootstrap.min.css')}}" rel="stylesheet">
<link href="{{url('css/mdb.min.css')}}" rel="stylesheet">
<link href="{{url('css/style.min.css')}}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{url('plugins/prismjs/prism.css')}}">
</head>
<body>
<div class="card" id="printarea">
  <div class="card-header"> {{$paste->title_f}} - <span class="badge badge-light">@if(!empty($paste->language)){{$paste->language->name}}@else{{strtoupper($paste->syntax)}}@endif</span> <small class="text-muted">{{$paste->content_size}} KB</small>
    <div class="pull-right"> 
        @if(config('settings.feature_copy') == 1)
            <a class="badge badge-grey" onclick="copyToClip(content)">{{ __('copy')}}</a>
        @endif      
        @if(config('settings.feature_raw') == 1 && empty($paste->password))<a href="{{url('raw/'.$paste->slug)}}" class="badge badge-default">{{ __('raw')}}</a> @endif 
        @if(config('settings.feature_download') == 1 && empty($paste->password))<a href="{{url('download/'.$paste->slug)}}" class="badge badge-primary">{{ __('download')}}</a> @endif
        @if(config('settings.feature_print') == 1)<a onclick="printDiv('printarea')" class="badge badge-info">{{ __('print')}}</a> @endif         
    </div>
  </div>
  <div class="card-body p-2">
    @if(!empty($paste->password))
       <form id="unlock_form">
        <div class="row justify-content-center">         
              <div class="form-group col-md-3  text-center">
                    <small class="text-muted">{{ __('To unlock this paste, please enter password.')}}</small>
                    <input type="password" class="form-control mb-1" id="password" placeholder="{{ __('Password')}}" autofocus tabindex="1">
                    <small id="password_response" class="pt-1"></small>
              </div>                 
              <div class="form-group col-md-12 text-center"> 
                  <button class="btn btn-sm btn-default m-0" type="submit" id="passwordBtn" tabindex="2">{{ __('Unlock')}}</button>
              </div>          
        </div>
      </form>
    @endif
    <pre class="line-numbers pre-editor @if(!empty($paste->password)) d-none @endif" id="pre">{{ __("Loading Please wait")}}...</pre>
    @if(config('settings.syntax_highlighter') == 'ace') <textarea id="editor" class="d-none"></textarea>@endif
    <p class="text-center p-0">{{ __('Paste Hosted With')}} <i class="fa fa-heart"></i> {{ __('By')}} <a href="{{url('/')}}" target="_blank">{{config('settings.site_name')}}</a></p>
  </div>
</div>
<script type="text/javascript">
var content = '';  
var txt_copied = '{{ __("Copied")}}';  
var txt_copy = '{{ __("Copy")}}';  
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
<script src="{{url('js/bootstrap.min.js')}}"></script> 
<script src="{{url('js/mdb.min.js')}}"></script> 

@if(config('settings.syntax_highlighter') == 'ace')
<!-- Ace -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.3/ace.js" type="text/javascript" charset="utf-8"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.3/ext-modelist.js"></script>
<script type="text/javascript">
  var type = 1;
  var syntax = "javascript";
  var syntax_extension = "{{$paste->extension}}";
  
</script>
@else
<script src="{{url('plugins/prismjs/prism.js')}}"></script> 
<script type="text/javascript">
(function(){

if (
    typeof self !== 'undefined' && !self.Prism ||
    typeof global !== 'undefined' && !global.Prism
) {
    return;
}

Prism.hooks.add('before-highlight', function(env) {
    var tokens = env.grammar;

    if (!tokens) return;

    tokens.tab = '';
    tokens.crlf = '';
    tokens.lf = '';
    tokens.cr = '';
    tokens.space = '';
});
})();  
</script>
@endif
<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}  
function copyToClip(str,response_field='') {
  function listener(e) {
    e.clipboardData.setData("text/html", str);
    e.clipboardData.setData("text/plain", str);
    e.preventDefault();
  }
  document.addEventListener("copy", listener);
  document.execCommand("copy");
  document.removeEventListener("copy", listener);
  if(response_field.length > 0) $('#'+response_field).html('{{ __("Copied")}}!');
}
</script>
@if(!empty($paste->password))
<script type="text/javascript">
$(document).ready(function($) {

  $('#unlock_form').on('submit', function(event) {
    event.preventDefault();
    $("#passwordBtn").prop('disabled','disabled');
    $("#password_response").html(' ');
    $.ajax({
      url: '{{route("paste.get")}}',
      type: 'POST',
      data: {slug: '{{$paste->slug}}',password: $('#password').val(), _token: '{{ csrf_token() }}'},
    })
    .done(function(data) {
      if(data.status == 'success')
      { 
          $("pre").removeClass('d-none');
          content = atob(data.content);
          content = decodeURIComponent(content.replace(/\+/g, '%20'));    

       @if(config('settings.syntax_highlighter') == 'ace')

        var editor = ace.edit("editor");
        editor.setTheme("ace/theme/{{config('settings.ace_editor_skin')}}");
        editor.$blockScrolling = Infinity;
        editor.setValue(content, -1);
        editor.setShowPrintMargin(false);
        editor.setReadOnly(true);
        editor.setHighlightActiveLine(false);

        editor.setOptions({
            autoScrollEditorIntoView: true,
            wrap: true,
            maxLines: Infinity
        });
        editor.renderer.$cursorLayer.element.style.display = "none"

        var tempPath = "file."+syntax_extension;
        var modelist = ace.require("ace/ext/modelist");
        var tempMode = modelist.getModeForPath(tempPath).mode;
        editor.session.setMode(tempMode);

        $(".pre-editor").addClass("d-none");

        @else


          var code = document.createElement('code');
          code.className = 'language-{{$paste->syntax}}';
          var pre = document.getElementById("pre");
          pre.textContent = '';

          code.textContent = content;
          pre.appendChild(code);

          Prism.highlightElement(code);
 
          @endif


          $("#unlock_form").remove();
      }
      else{
        $('#password').val('');
        $("#password_response").html(data.message);
      }
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
      $("#passwordBtn").removeAttr('disabled');
    });
    

  });

});
</script> 
@else 
<script type="text/javascript">

$(document).ready(function($) {

$.ajax({
url: '{{route("paste.get")}}',
type: 'POST',
data: {slug: '{{$paste->slug}}',password: $('#password').val(), _token: '{{ csrf_token() }}'},
})
.done(function(data) {
if(data.status == 'success')
{ 
content = atob(data.content);
content = decodeURIComponent(content.replace(/\+/g, '%20'));

@if(config('settings.syntax_highlighter') == 'ace')

    var editor = ace.edit("editor");
    editor.setTheme("ace/theme/{{config('settings.ace_editor_skin')}}");
    editor.$blockScrolling = Infinity;
    editor.setValue(content, -1);
    editor.setShowPrintMargin(false);
    editor.setReadOnly(true);
    editor.setHighlightActiveLine(false);

    editor.setOptions({
        autoScrollEditorIntoView: true,
        wrap: true,
        maxLines: Infinity
    });
    editor.renderer.$cursorLayer.element.style.display = "none"

    var tempPath = "file."+syntax_extension;
    var modelist = ace.require("ace/ext/modelist");
    var tempMode = modelist.getModeForPath(tempPath).mode;
    editor.session.setMode(tempMode);

    $(".pre-editor").addClass("d-none");

@else


var code = document.createElement('code');
code.className = 'language-{{$paste->syntax}}';
var pre = document.getElementById("pre");
pre.textContent = '';

code.textContent = content;
pre.appendChild(code);

Prism.highlightElement(code);

@endif

}
else{
$("#password_response").html(data.message);
}
})
.fail(function() {
  console.log("error");
})
.always(function() {
  console.log("complete");
  $("#passwordBtn").removeAttr('disabled');
});


});
</script> 
@endif
</body>
</html>