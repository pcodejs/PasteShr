@if(Auth::check())
@if(!empty($my_recent_pastes))
<div class="card mb-2">
  <div class="card-header"> {{ __('My Recent Pastes')}} </div>
  <ul class="list-group list-group-flush">
    @forelse($my_recent_pastes as $p)
    <li class="list-group-item"> <i class="fa fa-paste small"></i> @if(!empty($p->password))<i class="fa fa-lock small"></i>@endif @if(!empty($p->expire_time))<i class="fa fa-clock-o small"></i> @endif <a href="{{$p->url}}">{{$p->title_f}}</a>
      <p><small class="text-muted">@if(isset($p->language)) <a href="{{$p->language->url}}">{{$p->language->name}}</a> @else{{$p->syntax}}@endif | {{$p->created_ago}}</small></p>
    </li>
    @empty
    <li class="list-group-item text-center">{{ __('No results')}}</li>
    @endforelse
  </ul>
</div>
@endif
@endif

@if(config('settings.recent_pastes_limit') > 0)
<div class="card">
  <div class="card-header"> {{ __('Recent Pastes')}} </div>
  <ul class="list-group list-group-flush">
    @forelse($recent_pastes as $p)
    <li class="list-group-item"> <i class="fa fa-paste small"></i> @if(!empty($p->password))<i class="fa fa-lock small"></i>@endif @if(!empty($p->expire_time))<i class="fa fa-clock-o small"></i> @endif <a href="{{$p->url}}">{{$p->title_f}}</a>
      <p><small class="text-muted">@if(isset($p->language)) <a href="{{$p->language->url}}">{{$p->language->name}}</a> @else{{$p->syntax}}@endif | {{$p->created_ago}}</small></p>
    </li>
    @empty
    <li class="list-group-item text-center">{{ __('No results')}}</li>
    @endforelse
  </ul>
</div>
@endif