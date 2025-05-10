@if(\App\Helpers\CommonHelper::hasPermission(['audit-log-list', 'audit-log-show']))
    <li class="@if($module_name == 'activity') active @endif">
        <a href="{{ route('activity.index') }}">
            <i class="fa fa-book"></i>
            <span class="link-title">Audit logs</span>
        </a>
    </li>
@endif
