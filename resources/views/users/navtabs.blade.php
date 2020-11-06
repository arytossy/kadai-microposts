<ul class="nav nav-tabs nav-justified mb-3">
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('users.show') ? 'active' : '' }}" href="{{ route('users.show', ['user' => $user->id]) }}">
            TimeLine
            <span class="badge badge-secondary">{{ $user->microposts_count }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('users.followings') ? 'active' : '' }}" href="{{ route('users.followings', ['id' => $user->id]) }}">
            Followings
            <span class="badge badge-secondary">{{ $user->followings_count }}</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('users.followers') ? 'active' : '' }}" href="{{ route('users.followers', ['id' => $user->id]) }}">
            Followers
            <span class="badge badge-secondary">{{ $user->followers_count }}</span>
        </a>
    </li>
</ul>