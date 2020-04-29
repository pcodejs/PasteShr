@auth
    @include('comments::_form')
@else
<div class="card mt-2 mb-2">
  <div class="card-body">
    <h2>{{ __('Comments')}}</h2>
    <h5 class="card-title">{{ __('Authentication required')}}</h5>
    <p class="card-text">{{ __('You must log in to post a comment')}}.</p>
    <a href="{{ route('login') }}" class="btn btn-primary">{{ __('Log in')}}</a> </div>
</div>
@endauth
<div class="card mb-2">
  <div class="card-body">
    <ul class="list-unstyled">
      @forelse($model->comments->where('parent', null) as $comment)
      @include('comments::_comment')
      @empty
        <div class="alert alert-warning">{{ __('There are no comments yet')}}.</div>
      @endforelse
    </ul>
  </div>
</div>
