<ul class="nav nav-tabs">

<li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() === 'users.profile' ? 'active' : '' }}" 
           href="{{ route('users.profile') }}" 
           aria-current="{{ Route::currentRouteName() === 'users.profile' ? 'page' : '' }}">Perfil</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() === 'i_am.profile' ? 'active' : '' }}" 
           href="{{ route('i_am.profile') }}" 
           aria-current="{{ Route::currentRouteName() === 'i_am.profile' ? 'page' : '' }}">Minhas características</a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ Route::currentRouteName() === 'i_seek.profile' ? 'active' : '' }}" 
           href="{{ route('i_seek.profile') }}" 
           aria-current="{{ Route::currentRouteName() === 'i_seek.profile' ? 'page' : '' }}">O que procuro?</a>
    </li>
    
</ul>

