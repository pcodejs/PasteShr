@if(Auth::check())
@if(!empty($my_recent_pastes))
<div class="card mb-2">
  <div class="card-header"> {{ __('My Recent Pastes')}} </div>
  <ul class="list-group list-group-flush">
    @forelse($my_recent_pastes as $p)
    <li class="list-group-item"> <i class="fa fa-paste small"></i> <a href="{{$p->url}}">{{$p->title_f}}</a>
      <p><small class="text-muted">@if(isset($p->language)) {{$p->language->name}} @else{{$p->syntax}}@endif | {{$p->created_ago}}</small></p>
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
    <li class="list-group-item"> <i class="fa fa-paste small"></i> <a href="{{$p->url}}">{{$p->title_f}}</a>
      <p><small class="text-muted">@if(isset($p->language)) {{$p->language->name}} @else{{$p->syntax}}@endif | {{$p->created_ago}}</small></p>
    </li>
    @empty
    <li class="list-group-item text-center">{{ __('No results')}}</li>
    @endforelse
  </ul>
</div>
@endif