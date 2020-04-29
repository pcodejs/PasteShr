@extends('front.layouts.default')

@section('meta')
<meta name="description" content="{!!$paste->description!!}">
<meta name="keywords" content="{!!config('settings.meta_keywords')!!}">
<meta name="author" content="{{config('settings.site_name')}}">
<meta property="og:title" content="@if(isset($page_title)){{$page_title.' - '}}@endif{{config('settings.site_name')}}" />
<meta property="og:type" content="article" />
<meta property="og:url" content="{{Request::url()}}" />
@if(!empty(config('settings.site_image')))
<meta property="og:image" content="{{url(config('settings.site_image'))}}" />
@endif
<meta property="og:site_name" content="{{config('settings.site_name')}}" />
<link rel="canonical" href="{{Request::url()}}" />
@stop

@section('after_styles')
	@if(config('settings.syntax_highlighter') == 'ace')
		<link rel="stylesheet" href="{{url('plugins/ace/css/ace.min.css')}}" />
	  @elseif(config('settings.syntax_highlighter') == 'codemirror')
	    <link rel="stylesheet" href="{{url('plugins/codemirror-5.52.0/lib/codemirror.min.css')}}" />
	    <link rel="stylesheet" href="{{url('plugins/codemirror-5.52.0/theme/'.config('settings.codemirror_skin').'.css')}}" />
	    <style>.CodeMirror{ border:1px solid lightgray;max-height:{{ config('settings.paste_editor_height') * 20 . 'px' }}; }
				
			.CodeMirror-lines{ padding:0 !important;}
	    	.cm-s-monokai .CodeMirror-linenumber{ !important;text-align: center; }
		</style>
	  @else
		<!--PrismJs-->
		<link rel="stylesheet" type="text/css" href="{{url('plugins/prismjs/prism-'.config('settings.syntax_highlighting_style').'.css')}}">
		<style>
			pre{ max-height:{{ config('settings.paste_editor_height') * 22 . 'px' }}; }
		</style>
	@endif
@stop

@section('after_scripts')
	<script type="text/javascript">
        var content = '';
        var txt_copied = '{{ __("Copied")}}';
        var txt_copy = '{{ __("Copy")}}';
	</script>
	<script>
        $('body').on('click', '.url-link', function (event) {
            event.preventDefault();
            window.open($(this).attr('href'), '_blank')
        });
	</script>

	@if(config('settings.syntax_highlighter') == 'ace')
		<!-- Ace -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.3/ace.js" type="text/javascript" charset="utf-8"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.3/ext-modelist.js"></script>
		<script type="text/javascript">
            var type = 1;
            var syntax = "javascript";
            var syntax_extension = "{{$paste->extension}}";
		</script>
	@elseif(config('settings.syntax_highlighter') == 'codemirror')
<script src="{{url('plugins/codemirror-5.52.0/lib/codemirror.min.js')}}"></script>
<script src="{{url('plugins/codemirror-5.52.0/addon/mode/loadmode.js')}}"></script>
<script src="{{url('plugins/codemirror-5.52.0/addon/edit/matchbrackets.js')}}"></script>
<script src="{{url('plugins/codemirror-5.52.0/addon/fold/foldcode.js')}}"></script>
<script src="{{url('plugins/codemirror-5.52.0/addon/fold/foldgutter.js')}}"></script>
<script src="{{url('plugins/codemirror-5.52.0/mode/meta.js')}}"></script>
<script>
var syntax_extension = "{{$paste->extension}}";	
var theme = "{{config('settings.codemirror_skin')}}";	
CodeMirror.modeURL = '{{url("plugins/codemirror-5.52.0")}}/mode/%N/%N.js'; 
function changeMode(editor,ext)
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

</script>
	@else

		<!-- PrismJs -->
		<script src="{{url('plugins/prismjs/prism.js')}}"></script>
		<script type="text/javascript">
            (function () {

                if (
                    typeof self !== 'undefined' && !self.Prism ||
                    typeof global !== 'undefined' && !global.Prism
                ) {
                    return;
                }

                Prism.hooks.add('before-highlight', function (env) {
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

	@if(!empty($paste->password))
		<script type="text/javascript">
            $(document).ready(function ($) {

                $('#passwordModal').modal('toggle');

                $('#unlock_form').on('submit', function (event) {
                    event.preventDefault();
                    $("#passwordBtn").prop('disabled', 'disabled');
                    $("#password_response").html(' ');
                    $.ajax({
                        url: '{{route("paste.get")}}',
                        type: 'POST',
                        data: {slug: '{{$paste->slug}}', password: $('#password').val(), _token: '{{ csrf_token() }}'},
                    })
                        .done(function (data) {
                            if (data.status == 'success') {
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
                                    maxLines: 50,
									@if(config('settings.syntax_highlighter_line_numbers') == 0)
                                    showLineNumbers: false,
                                    showGutter: false
									@endif

                                });
                                editor.renderer.$cursorLayer.element.style.display = "none"

                                var tempPath = "file." + syntax_extension;
                                var modelist = ace.require("ace/ext/modelist");
                                var tempMode = modelist.getModeForPath(tempPath).mode;
                                editor.session.setMode(tempMode);

                                $(".pre-editor").addClass("d-none");

							@elseif(config('settings.syntax_highlighter') == 'codemirror')

									var editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
									@if(config('settings.syntax_highlighter_line_numbers') == 1)		
										lineNumbers: true,
									@endif
									  lineWrapping: true,
									  matchBrackets: true,
									  styleActiveLine: true,
							  		  readOnly: true,									  
									  theme: theme,
									  mode: "text"
									});
									editor.setValue(content, -1);
									changeMode(editor,syntax_extension);
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

                                //$("#raw_content").val(content);
                                $("#passwordModal").modal('toggle');
                                $("#unlock_link").remove();
                            } else {
                                $("#password_response").html(data.message);
                            }
                        })
                        .fail(function () {
                            console.log("error");
                        })
                        .always(function () {
                            console.log("complete");
                            $("#passwordBtn").removeAttr('disabled');
                        });

                });

            });
		</script>
	@else
		<script type="text/javascript">
            $(document).ready(function ($) {

                $.ajax({
                    url: '{{route("paste.get")}}',
                    type: 'POST',
                    data: {slug: '{{$paste->slug}}', password: $('#password').val(), _token: '{{ csrf_token() }}'},
                })
                    .done(function (data) {
                        if (data.status == 'success') {
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
                                maxLines: 50,
								@if(config('settings.syntax_highlighter_line_numbers') == 0)
                                showLineNumbers: false,
                                showGutter: false
								@endif
                            });
                            editor.renderer.$cursorLayer.element.style.display = "none"

                            var tempPath = "file." + syntax_extension;
                            var modelist = ace.require("ace/ext/modelist");
                            var tempMode = modelist.getModeForPath(tempPath).mode;
                            editor.session.setMode(tempMode);

                            $(".pre-editor").addClass("d-none");

						@elseif(config('settings.syntax_highlighter') == 'codemirror')

							var editor = CodeMirror.fromTextArea(document.getElementById("editor"), {
							@if(config('settings.syntax_highlighter_line_numbers') == 1)		
							  lineNumbers: true,
							@endif
							  lineWrapping: true,
							  matchBrackets: true,
							  styleActiveLine: true,
							  readOnly: true,
							  theme: theme,
							  mode: "text"
							});
							editor.setValue(content, -1);

							changeMode(editor,syntax_extension);
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

                            $("#raw_content").val(content);
                        } else {
                            $("#password_response").html(data.message);
                        }
                    })
                    .fail(function () {
                        console.log("error");
                    })
                    .always(function () {
                        console.log("complete");
                        $("#passwordBtn").removeAttr('disabled');
                    });

            });
		</script>
	@endif
@stop

@section('content')
	<main>
		<!--Main layout-->
		<div class="container">
			<!--First row-->
			<div class="row ">
				<div class="@if(config('settings.site_layout') == 1) col-md-9 @else col-md-12 @endif">
					@if(config('settings.ad') == 1 && !empty(config('settings.ad1')))
						<div class="col-md-12 m-2 text-center">{!! html_entity_decode(config('settings.ad1')) !!}</div>
					@endif
					@include('front.includes.messages')
					<div class="card" id="printarea">
						<div class="card-body">
							<div class="media"> @if(isset($paste->user))
									<img class="mr-3 mb-3 rounded-circle img-fluid" src="{{$paste->user->avatar}}" alt="avatar" style="height: 60px"> @else
									<img class="mr-3 mb-3 rounded-circle img-fluid" src="{{url('img/default-avatar.png')}}" alt="avatar" style="height: 60px"> @endif
								<div class="media-body">
									<h5 class="mt-0">
										<i class="fa fa-paste blue-grey-text small"></i> @if(!empty($paste->password))
											<i class="fa fa-lock pink-text small"></i>@endif @if(!empty($paste->expire_time))
											<i class="fa fa-clock-o text-warning small"></i> @endif {{$paste->title_f}}
									</h5>
									<p class="text-muted small"><i class="fa fa-user"></i> @if(isset($paste->user))
											<a href="{{$paste->user->url}}"> {{$paste->user->name}} </a> @else {{ __('Guest')}}  @endif
										<i class="fa fa-eye ml-2"></i> {{$paste->views_f}}
										<i class="fa fa-calendar ml-2"> {{$paste->created_at->format('jS M, Y')}}</i> @if($paste->status == 2)
											<span class="badge badge-warning">{{ __('Unlisted')}}</span> @elseif($paste->status == 3)
											<span class="badge badge-danger">{{ __('Private')}}</span> @endif</p>
								</div>
								@if(Auth::check())
									@if($paste->user_id == Auth::user()->id)
										<a href="{{route('paste.edit',[$paste->slug])}}" class="badge badge-info mr-2"><i class="fa fa-edit"></i> {{ __('Edit')}}
										</a>
										<a href="{{route('paste.delete',[$paste->slug])}}" class="badge badge-danger"><i class="fa fa-trash"></i> {{ __('Delete')}}
										</a> @else
										@if(Auth::user()->role == 1)
											<a href="{{route('pastes.edit',[$paste->id])}}" class="badge badge-info mr-2"><i class="fa fa-edit"></i> {{ __('Edit')}}
											</a>
											<a href="{{route('pastes.delete',[$paste->id])}}" class="badge badge-danger"><i class="fa fa-trash"></i> {{ __('Delete')}}
											</a> @endif
									@endif
								@endif </div>
							@if(Auth::check()) @if($paste->user_id == Auth::user()->id)
								<p class="text-muted text-center"><small>{{ __('This is one of your paste')}}</small>
								</p>
							@endif @endif
							@if(!empty($paste->password))
								<div class="text-center" id="unlock_link">
									<a class="btn btn-warning btn-sm" data-toggle="modal" data-target="#passwordModal">{{ __('Unlock')}}</a>
								</div>
							@endif
							<div class="card">
								<div class="card-header d-print-none">
									<span class="badge badge-light">@if(!empty($paste->language)){{$paste->language->name}}@else{{strtoupper($paste->syntax)}}@endif</span>
									<small class="text-muted">{{$paste->content_size}} {{ __('KB')}}</small>
									<div class="pull-right">
										@if(config('settings.feature_copy') == 1)
											<a class="badge badge-grey" onclick="copyToClip(content)">{{ __('copy')}}</a>
										@endif
										@if(config('settings.feature_share') == 1)
											<a class="badge badge-warning" data-toggle="modal" data-target="#shareModal">{{ __('share')}}</a> @endif
										@if(config('settings.feature_raw') == 1 && empty($paste->password))
											<a href="{{route('raw',[$paste->slug])}}" class="badge badge-default">{{ __('raw')}}</a> @endif
										@if(config('settings.feature_download') == 1 && empty($paste->password))
											<a href="{{route('download',[$paste->slug])}}" class="badge badge-primary">{{ __('download')}}</a> @endif
										@if(config('settings.feature_clone') == 1 && empty($paste->password))
											<a href="{{route('clone',[$paste->slug])}}" class="badge badge-secondary">{{ __('clone')}}</a> @endif
										@if(config('settings.feature_embed') == 1)
											<a class="badge badge-success" data-toggle="modal" data-target="#embedModal">{{ __('embed')}}</a> @endif
										@if(config('settings.feature_report') == 1)
											<a class="badge badge-danger" @if(\Auth::check()) data-toggle="modal" data-target="#reportModal" @else href="{{url('login')}}" @endif>{{ __('report')}}</a> @endif
										@if(config('settings.feature_print') == 1)
											<a onclick="printDiv('printarea')" class="badge badge-info">{{ __('print')}}</a> @endif
									</div>
								</div>
								<div class="card-body">
									<pre class="@if(config('settings.syntax_highlighter_line_numbers') == 1) line-numbers @endif pre-editor" id="pre">{{ __("Loading Please wait")}}...</pre>
									@if(config('settings.syntax_highlighter') == 'ace' || config('settings.syntax_highlighter') == 'codemirror')
										<textarea id="editor" class="d-none"></textarea>
									@endif
								</div>
							</div>
							@if(config('settings.feature_copy') == 1)
								<div class="form-group mt-3 mb-3 d-print-none">
									<small class="text-muted">{{ __('To share this paste please copy this url and send to your friends')}}</small>
									<div class="input-group">
										<div class="input-group-prepend">
											<button class="btn btn-md btn-blue-grey m-0 px-3" type="button" onclick="copyToClip('{{$paste->url}}','copy_link_response')">{{ __('Copy')}}</button>
										</div>
										<input type="text" class="form-control" value="{{$paste->url}}" disabled>
									</div>
									<small class="text-success" id="copy_link_response"></small>
								</div>
							@endif

							@if(config('settings.feature_raw') == 1 && empty($paste->password))
								<div class="card mt-3 d-print-none">
									<div class="card-header"> {{ __('RAW Paste Data')}} </div>
									<div class="card-body">
										<textarea class="form-control" rows="10" id="raw_content">{{ __("Loading Please wait")}}...</textarea>
									</div>
								</div>
							@endif
						</div>
					</div>
					@if(config('settings.ad') == 1 && !empty(config('settings.ad2')))
						<div class="col-md-12 m-2 text-center">{!! html_entity_decode(config('settings.ad2')) !!}</div>
					@endif

					@if(config('settings.disqus') == 1){!!html_entity_decode(config('settings.disqus_code'))!!}@endif

					@if(config('settings.custom_comments') == 1)
						<div class="row ">
							<div class="col-md-12"> @comments(['model' => $paste]) @endcomments</div>
						</div>
					@endif </div>
				@include('front.paste.recent_pastes') </div>
			<!--/.First row-->
		</div>
		<!--/.Main layout-->
	</main>

	<!-- The Modal -->
	<div class="modal" id="embedModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">{{ __('Embed Code')}}</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<textarea class="form-control" id="embed_code">
						<iframe src="{{url('embed/'.$paste->slug)}}" style="border:none;width:100%;min-height:400px;"></iframe>
					</textarea> <span id="embed_response" class="text-success"></span></div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button class="btn btn-success btn-sm" onclick="copyToClip(document.getElementById('embed_code').value,'embed_response');">{{ __('Copy')}}</button>
					<button class="btn btn-danger btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
				</div>
			</div>
		</div>
	</div>

	<!-- The Modal -->
	<div class="modal" id="reportModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">{{ __('Report Issue')}}</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<form method="post" action="{{route('paste.report')}}">
					<!-- Modal body -->
					<div class="modal-body"> @csrf
						<input type="hidden" name="id" value="{{$paste->id}}"> <label>{{ __('Reason')}}</label>
						<textarea class="form-control" name="reason" placeholder="{{ __('Write your reason')}}.."></textarea>
					</div>
					<!-- Modal footer -->
					<div class="modal-footer">
						<button type="submit" class="btn btn-warning btn-sm">{{ __('Report')}}</button>
						<button class="btn btn-danger btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	@if(config('settings.feature_share') == 1)
		<!-- The Modal -->
		<div class="modal" id="shareModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">{{ __('Share')}}</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<!-- Modal body -->
					<div class="modal-body text-center"> @if(config('settings.qr_code_share') == 1)
							<div class="mb-2">
								<img src="https://www.qrcoder.co.uk/api/v1/?size=4&text={{urlencode($paste->url)}}">
							</div>
						@endif
						<a href="#" onclick="MyWindow=window.open('https://www.facebook.com/dialog/share?app_id={{config('settings.facebook_app_id')}}&amp;display=popup&amp;href={{$paste->url}}','Facebook share','width=600,height=300'); return false;" class="btn btn-primary btn-sm waves-effect waves-light"><i class="fa fa-facebook"></i></a>
						<a href="#" onclick="MyWindow=window.open('https://twitter.com/share?url={{$paste->url}}','Twitt this','width=600,height=300'); return false;" class="btn btn-info btn-sm waves-effect waves-light"><i class="fa fa-twitter"></i></a>
						<a href="#" onclick="MyWindow=window.open('https://plus.google.com/share?url={{$paste->url}}','Google Plus share','width=600,height=300'); return false;" class="btn btn-pink btn-sm waves-effect waves-light"><i class="fa fa-google-plus"></i></a> @if(config('settings.feature_copy') == 1)
							<div class="form-group mt-3 mb-3">
								<small class="text-muted">{{ __('To share this paste please copy this url and send to your friends')}}</small>
								<div class="input-group">
									<div class="input-group-prepend">
										<button class="btn btn-md btn-blue-grey m-0 px-3" type="button" onclick="copyToClip('{{$paste->url}}','copy_share_link')">{{ __('Copy')}}</button>
									</div>
									<input type="text" class="form-control" value="{{$paste->url}}" disabled>
								</div>
								<small class="green-text" id="copy_share_link"></small>
							</div>
						@endif </div>
					<!-- Modal footer -->
					<div class="modal-footer">
						<button class="btn btn-danger btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
					</div>
				</div>
			</div>
		</div>
	@endif


	@if(!empty($paste->password))
		<!-- The Modal -->
		<div class="modal" id="passwordModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<!-- Modal Header -->
					<div class="modal-header">
						<h4 class="modal-title">{{ __('Password')}}</h4>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
					</div>
					<form id="unlock_form">
						<!-- Modal body -->
						<div class="modal-body text-center">
							<div class="form-group">
								<small class="text-muted">{{ __('To unlock this paste, please enter password')}}</small>
								<input type="password" class="form-control" id="password" placeholder="{{ __('Password')}}" autofocus>
							</div>
							<div id="password_response"></div>
						</div>
						<!-- Modal footer -->
						<div class="modal-footer">
							<button class="btn btn-sm btn-default" type="submit" id="passwordBtn">{{ __('Unlock')}}</button>
							<button class="btn btn-danger btn-sm" data-dismiss="modal">{{ __('Close')}}</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	@endif

@stop 