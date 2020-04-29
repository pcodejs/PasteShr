@extends('admin.layouts.default')

@section('after_styles')
	@if(config('settings.paste_editor') == 'ace')
		<link rel="stylesheet" href="{{url('plugins/ace/css/ace.min.css')}}" />
  	@elseif(config('settings.paste_editor') == 'codemirror')
	    <link rel="stylesheet" href="{{url('plugins/codemirror-5.52.0/lib/codemirror.min.css')}}" />
	    <style>.CodeMirror{ border:1px solid lightgray; }</style>
  	@endif
@stop

@section('after_scripts')
	@if(config('settings.paste_editor') == 'ace')
		<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.3/ace.js" type="text/javascript" charset="utf-8"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.3/ext-modelist.js"></script>
		<script>
            var mode = "text";
            var syntax = "Text";
            var syntax_extension = "txt";
            var type = 1;
            var editor = ace.edit("editor");
            editor.$blockScrolling = Infinity;
            editor.setShowPrintMargin(false);
            editor.setOptions({
                autoScrollEditorIntoView: true,
                wrap: true,
		        minLines: paste_editor_height,
		        maxLines: paste_editor_height,
				@if(config('settings.syntax_highlighter_line_numbers') == 0)
                showLineNumbers: false,
                showGutter: false
				@endif
            });
            editor.focus();

            $('button[type="submit"]').on('click', function (event) {
                $('input[name="content"]').val(editor.getValue());
            });

            $("select[name='syntax']").on("change", function () {

                var ext = $(this).find('option:selected').data('ext');
                var tempPath = "file." + ext;
                var modelist = ace.require("ace/ext/modelist");
                var tempMode = modelist.getModeForPath(tempPath).mode;
                editor.session.setMode(tempMode);

            });
		</script>
@elseif(config('settings.paste_editor') == 'codemirror')
<script src="{{url('plugins/codemirror-5.52.0/lib/codemirror.min.js')}}"></script>
<script src="{{url('plugins/codemirror-5.52.0/addon/mode/loadmode.js')}}"></script>
<script src="{{url('plugins/codemirror-5.52.0/addon/edit/matchbrackets.js')}}"></script>
<script src="{{url('plugins/codemirror-5.52.0/addon/fold/foldcode.js')}}"></script>
<script src="{{url('plugins/codemirror-5.52.0/addon/fold/foldgutter.js')}}"></script>
<script src="{{url('plugins/codemirror-5.52.0/mode/meta.js')}}"></script>
<script>
CodeMirror.modeURL = '{{url("plugins/codemirror-5.52.0")}}/mode/%N/%N.js';  
var syntax_extension = $("select[name='syntax']").find('option:selected').data('ext');
var editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
  lineNumbers: true,
  lineWrapping: true,
  matchBrackets: true,
  styleActiveLine: true,
  mode: "text"
});

changeMode(syntax_extension);

function changeMode(ext)
{
	var info = CodeMirror.findModeByExtension(ext);	
	if (typeof info === 'undefined') {
		mime = 'text/plain';
		mode = null;
	}
	else{
		mime = info.mime;
		mode = info.mode
	}
 	editor.setOption("mode", mime);
    CodeMirror.autoLoadMode(editor, mode);
}


$("select[name='syntax']").on("change", function () {
  var ext = $(this).find('option:selected').data('ext');
  changeMode(ext);
});

$('button[type="submit"]').on('click', function (event) {
    $('input[name="content"]').val(editor.getValue());
});

</script> 
@endif
@stop

@section('content')
	<!--Main layout-->
	<main class="pt-5 mx-lg-5">
		<div class="container mt-5">
			<!-- Heading -->
			<div class="card mb-4 ">
				<!--Card content-->
				<div class="card-body d-sm-flex justify-content-between">
					<h4 class="mb-2 mb-sm-0 pt-1">
						<a href="{{url('admin/dashboard')}}">Admin </a> <span>/ </span>
						<a href="{{url('admin/pastes')}}">{{$page_title}}
						</a> <span>/ </span> <a href="{{$paste->url}}" target="_blank">{{$paste->title_f}}
						</a> <span>/ </span> <span>Edit </span>
					</h4>
				</div>
			</div>
			<!-- Heading -->
			<!--Grid row-->
			<div class="row ">
				<!--Grid column-->
				<div class="col-md-12 mb-4"> @include('admin.includes.messages')
				<!--Card-->
					<div class="card mb-4">
						<!-- Card header -->
						<div class="card-header"> {{$page_title}} Edit
						</div>
						<!--Card content-->
						<div class="card-body">
							<input id="paste_file" type="file" onchange="handleFileSelect(this);" style="display: none;" />
							<form method="post" action="">
								@csrf
								<div class="form-group">
									<label class="font-weight-bold d-flex justify-content-between">
										<span>{{ __('Edit Paste')}} </span>
										<small><a id="load_file">{{ __('Browse') }}</a></small>
									</label>
									@if(config('settings.paste_editor') == 'ace')
										<textarea id="editor" class="hide">{{old('content',$paste->content_f)}}</textarea>
										<input type="hidden" name="content">
									@elseif(config('settings.paste_editor') == 'codemirror')
										<textarea id="editor">{{old('content',$paste->content_f)}}</textarea>
										<input name="content" type="hidden">
									@else
										<textarea name="content" class="form-control" rows="15" autofocus>{{old('content',$paste->content_f)}}</textarea>
									@endif
								</div>
								<h5>Paste Settings
								</h5>
								<hr class="extra-margin" />
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Syntax Highlighting : <small class="text-muted">[Optional] </small>
											</label>
											@php $selected = old('syntax',$paste->syntax); @endphp
											<select class="form-control select2" name="syntax">
												<option value="none">Select
												</option>
												<optgroup label="Popular Languages">
													@foreach($popular_syntaxes as $syntax)
														<option value="{{$syntax->slug}}" data-ext="{{(!empty($syntax->extension))?$syntax->extension:'txt'}}" @if($selected == $syntax->slug) selected @endif>{{$syntax->name}}
														</option>
													@endforeach
												</optgroup>
												<optgroup label="All Languages">
													@foreach($syntaxes as $syntax)
														<option value="{{$syntax->slug}}" data-ext="{{(!empty($syntax->extension))?$syntax->extension:'txt'}}" @if($selected == $syntax->slug) selected @endif>{{$syntax->name}}
														</option>
													@endforeach
												</optgroup>
											</select>
										</div>
										<div class="form-group">
											<label>Paste Title :
												<small class="text-muted">@if(config('settings.paste_title_required') == 0) [{{ __('Optional')}}] @endif
												</small> </label>
											<input type="text" name="title" class="form-control" placeholder="Paste Title" value="{{old('title',$paste->title)}}">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Paste Status : <small class="text-muted">[Optional] </small> </label>
											@php $selected = old('status',$paste->status); @endphp
											<select class="form-control" name="status">
												<option value="1" @if($selected == 1) selected @endif>Public
												</option>
												<option value="2" @if($selected == 2) selected @endif>Unlisted
												</option>
												<option value="3" @if(!Auth::check()) disabled @else  @if($selected == 3) selected @endif @endif>
													Private (members only)
												</option>
											</select>
										</div>
										<div class="form-group">
											<label>Password : <small class="text-muted">[Optional] </small> </label>
											<input type="text" name="password" class="form-control" placeholder="Password">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<div class="custom-control custom-checkbox">
												<input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="encrypted" @if(old('encrypted',$paste->encrypted) == 1) checked @endif>
												<label class="custom-control-label" for="defaultUnchecked">Encrypt Paste </label>
												<span>(<small class="cp" title="{{ __('Protect your text by Encrypting and Decrypting any given text with a key that no one knows')}}">?</small>)</span>
											</div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<button type="submit" class="btn btn-success">Save
											</button>
											<a href="{{url('admin/pastes')}}" class="btn btn-default">Cancel </a>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<!--/.Card-->
				</div>
				<!--Grid column-->
			</div>
			<!--Grid row-->
		</div>
	</main>
	<!--Main layout-->

@stop