@php
    $user = \Auth::user();
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    
    <!-- Logo e nome da empresa -->
    <a href="{{ route('match.index') }}"  class="brand-link" style="padding-left: 30px;">
      <i class="fas fa-fire nav-icon"></i>
      <span class="brand-text font-weight-light">Tinder Web</span>
    </a>


    <!-- Sidebar -->
    <div class="sidebar">
      
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                  <!-- Opção do Usuario logado -->
            <li class="nav-item user-panel">
            <a href="#" class="nav-link">
            @if($user->photo)
                    <!-- If user has photo show the photo -->
                    <img class="logo-edit" src="{{ Storage::url($user->photo) }}" style="border-radius: 50%"/>
                    @else
                    <!-- If user hasn't photo show show place holder -->
                    <img class="logo-edit" src="{{ asset('dist/images/sidebar/user_placeholder.jpg') }}" style="border-radius: 50%"/>
                    @endif
                    <p>
                    {{ \Auth::user()->name }}
                    <i class="right fas fa-angle-left"></i>
                    </p>
                </a>

                <!-- Editar cadastro do usuário -->
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                    <a href="{{ route('users.profile') }}" class="nav-link">
                        <i class="fas fa-user-edit nav-icon"></i>
                        <p>{{ trans('text.profile') }}</p>
                    </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link">
                        <form action="{{ url('logout ') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-block btn-sm"><i class="fas fa-sign-out-alt nav-icon"></i>{{ trans('text.exit') }}</button>
                        </form>
                    </a>
                    </li>
                </ul>
            </li>
          
                    <!-- Opção de Dashboard -->
          <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link">
                <i class="fas fa-user nav-icon"></i>
                  <p>{{ trans('text.users') }}</p>
                </a>
          </li>
            
          <!-- Opção de caracteristicas -->
          <li class="nav-item">
            <a href="{{ route('characteristics.index') }}" class="nav-link">
              <i class="fas fa-id-badge nav-icon"></i>
              <p>{{ trans('text.characteristics') }}</p>
            </a>
          </li>

          <!-- Opção de opções -->
          <li class="nav-item">
            <a href="{{ route('options.index') }}" class="nav-link">
              <i class="fas fa-list nav-icon"></i>
              <p>{{ trans('text.options') }}</p>
            </a>
          </li>

           <!-- Opção I am -->
           <li class="nav-item">
            <a href="{{ route('i_am.profile') }}" class="nav-link">
              <i class="fas fa-id-badge nav-icon"></i>
              <p>{{ trans('text.i_am') }}</p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>