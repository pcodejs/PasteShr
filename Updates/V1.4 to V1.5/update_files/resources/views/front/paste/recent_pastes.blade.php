@if(Auth::check())
@if(!empty($my_recent_pastes))
<div class="card mb-2 mt-2 paste_list">
  <div class="card-header"> {{ __('My Recent Pastes')}} </div>
  <ul class="list-group list-group-flush">
    @forelse($my_recent_pastes as $p)
    <li class="list-group-item"> <i class="fa fa-paste blue-grey-text small"></i> @if(!empty($p->password))<i class="fa fa-lock pink-text small"></i>@endif @if(!empty($p->expire_time))<i class="fa fa-clock-o text-warning small"></i> @endif <a href="{{$p->url}}">{{$p->title_f}}</a>
      <p><small class="text-muted">@if(isset($p->language)) <a href="{{$p->language->url}}">{{$p->language->name}}</a> @else{{$p->syntax}}@endif | <i class="fa fa-eye blue-grey-text"></i> {{$p->views_f}} | {{$p->created_ago}}</small></p>
    </li>
    @empty
    <li class="list-group-item text-center">{{ __('No results')}}</li>
    @endforelse
  </ul>
</div>
@endif
@endif

@if(config('settings.recent_pastes_limit') > 0)
<div class="card paste_list">
  <div class="card-header"> {{ __('Recent Pastes')}} </div>
  <ul class="list-group list-group-flush">
    @forelse($recent_pastes as $p)
    <li class="list-group-item"> <i class="fa fa-paste blue-grey-text small"></i> @if(!empty($p->password))<i class="fa fa-lock pink-text small"></i>@endif @if(!empty($p->expire_time))<i class="fa fa-clock-o text-warning small"></i> @endif <a href="{{$p->url}}">{{$p->title_f}}</a>
      <p><small class="text-muted">@if(isset($p->language)) <a href="{{$p->language->url}}">{{$p->language->name}}</a> @else{{$p->syntax}}@endif | <i class="fa fa-eye blue-grey-text"></i> {{$p->views_f}} | {{$p->created_ago}}</small></p>
    </li>
    @empty
    <li class="list-group-item text-center">{{ __('No results')}}</li>
    @endforelse
  </ul>
</div>
@endif