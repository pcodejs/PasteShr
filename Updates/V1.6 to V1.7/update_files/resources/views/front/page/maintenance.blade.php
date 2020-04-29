<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
@include('front.includes.head')
<body>

<main>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h4 text-center">{{ __('Site Under Maintenance')}}</div>

                <div class="card-body">
                    {!! html_entity_decode(config('settings.maintenance_text')) !!}
                </div>
            </div>
        </div>
    </div>
</div>
</main>
@include('front.includes.foot')
</body>
</html>
