@if(Session::has('flash_notification.message') || count($errors) > 0)
<div class="flash-message">
    <div class="alert alert-{{Session::get('flash_notification.level', 'danger')}} @if(Session::get('flash_notification.level', 'danger') != 'danger') alert-disappear @endif">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
        <h4>{{Session::get('flash_notification.message', 'Form validation failed')}}</h4>
        @include('common.flash_validation')
    </div>
</div>
@endif
