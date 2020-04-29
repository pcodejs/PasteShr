<div class="card mt-3">
  <div class="card-body">
    <h2>{{ __('Comments')}}</h2>
    <form method="POST" action="{{ url('comments') }}">
      @csrf
      <input type="hidden" name="commentable_type" value="\{{ get_class($model) }}" />
      <input type="hidden" name="commentable_id" value="{{ $model->id }}" />
      <div class="form-group">
        <label for="message">{{ __('Enter your message here')}}:</label>
        <textarea class="form-control @if($errors->has('message')) is-invalid @endif" name="message" rows="3"></textarea>
        <div class="invalid-feedback"> {{ __('Your message is required')}}. </div>
        <small class="form-text text-muted"><a target="_blank" href="https://help.github.com/articles/basic-writing-and-formatting-syntax">Markdown</a> cheatsheet.</small> </div>
      <button type="submit" class="btn btn-sm btn-outline-blue-grey text-uppercase">{{ __('Submit')}}</button>
    </form>
  </div>
</div>
<br />
