@if($isAdmin)
    <li><a href="{{ route('soon') }}"><span class="fa fa-lock"></span> Admin Only</a></li>
    <li class="divider"></li>
@endif
<li><a href="{{ route('soon') }}"><span class="fa fa-cog"></span> Settings</a></li>
<li><a href="{{ route('logout') }}"><span class="fa fa-sign-out"></span> Logout</a></li>
