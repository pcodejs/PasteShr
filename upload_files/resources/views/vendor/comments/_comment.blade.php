@inject('markdown', 'Parsedown')

@if(isset($reply) && $reply === true)
<div id="comment-{{ $comment->id }}" class="media"> @else
  <li id="comment-{{ $comment->id }}" class="media"> @endif <img class="mr-3 rounded-circle img-fluid" src="{{$comment->commenter->avatar}}" alt="{{ $comment->commenter->name }} Avatar" style="height:60px !important;">
    <div class="media-body">
      <h5 class="mt-0 mb-1">{{ $comment->commenter->name }} <small class="text-muted">- {{ $comment->created_at->diffForHumans() }}</small></h5>
      <div style="white-space: pre-wrap;">{!! $markdown->line($comment->comment) !!}</div>
      <p class="mb-0"> @can('reply-to-comment', $comment)
        <button data-toggle="modal" data-target="#reply-modal-{{ $comment->id }}" class="btn btn-sm btn-link text-uppercase"><i class="fa fa-reply"></i> {{ __('Reply')}}</button>
        @endcan
        @can('edit-comment', $comment)
        <button data-toggle="modal" data-target="#comment-modal-{{ $comment->id }}" class="btn btn-sm btn-link text-uppercase"><i class="fa fa-edit"></i> {{ __('Edit')}}</button>
        @endcan
        @can('delete-comment', $comment) <a href="{{ url('comments/' . $comment->id) }}" onclick="event.preventDefault();document.getElementById('comment-delete-form-{{ $comment->id }}').submit();" class="btn btn-sm btn-link text-danger text-uppercase"><i class="fa fa-trash"></i> {{ __('Delete')}}</a>
      <form id="comment-delete-form-{{ $comment->id }}" action="{{ url('comments/' . $comment->id) }}" method="POST" style="display: none;">
        @method('DELETE')
        @csrf
      </form>
      @endcan
      </p>
      @can('edit-comment', $comment)
      <div class="modal fade" id="comment-modal-{{ $comment->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form method="POST" action="{{ url('comments/' . $comment->id) }}">
              @method('PUT')
              @csrf
              <div class="modal-header">
                <h5 class="modal-title">{{ __('Edit Comment')}}</h5>
                <button type="button" class="close" data-dismiss="modal"> <span>&times;</span> </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="message">{{ __('Update your message here')}}:</label>
                  <textarea required class="form-control" name="message" rows="3">{{ $comment->comment }}</textarea>
                  <small class="form-text text-muted"><a target="_blank" href="https://help.github.com/articles/basic-writing-and-formatting-syntax">Markdown</a> cheatsheet.</small> </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-primary text-uppercase" data-dismiss="modal">{{ __('Cancel')}}</button>
                <button type="submit" class="btn btn-sm btn-outline-success text-uppercase">{{ __('Update')}}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @endcan
      
      @can('reply-to-comment', $comment)
      <div class="modal fade" id="reply-modal-{{ $comment->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <form method="POST" action="{{ url('comments/' . $comment->id) }}">
              @csrf
              <div class="modal-header">
                <h5 class="modal-title">{{ __('Reply to Comment')}}</h5>
                <button type="button" class="close" data-dismiss="modal"> <span>&times;</span> </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="message">{{ __('Enter your message here')}}:</label>
                  <textarea required class="form-control" name="message" rows="3"></textarea>
                  <small class="form-text text-muted"><a target="_blank" href="https://help.github.com/articles/basic-writing-and-formatting-syntax">Markdown</a> cheatsheet.</small> </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-outline-primary text-uppercase" data-dismiss="modal">{{ __('Cancel')}}</button>
                <button type="submit" class="btn btn-sm btn-outline-success text-uppercase">{{ __('Reply')}}</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      @endcan <br />
      {{-- Margin bottom --}}
      
      @foreach($comment->children as $child)
      @include('comments::_comment', [
      'comment' => $child,
      'reply' => true
      ])
      @endforeach </div>
    @if(isset($reply) && $reply === true) 
</div>
@else
</li>
@endif