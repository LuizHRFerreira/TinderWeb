<aside class="main-sidebar sidebar-dark-primary elevation-4" style="height: calc(100vh - 50px); overflow-y: auto;">

<style>

  aside.main-sidebar {
      height: 100vh; /* Or 100% if the parent is already sized correctly */
      /* Other sidebar styles if needed */
  }

  .matches{
    background-color:rgb(39, 39, 39);
    border-radius: 10px;
    width:100%;
    height:80px;
    display:flex;
  }

  .match-photo{
    height:80px;
    border-radius: 50%;
    padding:10px;
    align:left;
  }

  h3{
    color:white;
    margin-left:10px;
    font-size:18px;
    padding-top:29px;
  }

</style>

  <!-- Logo e nome da empresa -->
  <a href="{{ route('match.index') }}" class="brand-link" style="padding-left: 30px;">
    <i class="fas fa-fire nav-icon"></i>
    <span class="brand-text font-weight-light">Tinder Web</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" >
        
        <!-- Opção do Usuario logado -->
        <li class="nav-item user-panel">
          <a href="{{ route('users.profile') }}" class="nav-link">
           
            @if(\Auth::user()->photo)
            <!-- Se o usuario tiver foto ele importa -->
            <img class="logo-edit" src="{{ Storage::url(Auth::user()->photo) }}" style="border-radius: 50%" />
            @else
              <!-- Se não tiver foto, mostra o place holder -->
              <img class="logo-edit" src="{{ asset('dist/images/sidebar/user_placeholder.jpg') }}"
                style="border-radius: 50%" />
            @endif
              <!-- Nome do usuário -->
             
            <p>
              {{ \Auth::user()->name }}
            </p>

          </a>

        </li>

        @if(\Auth::user()->hasRole('admin'))

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

          <li class="nav-item">
            <a href="{{ route('dashboard.index') }}" class="nav-link">
              <i class="fas fa-chart-line nav-icon"></i>
              <p>{{ trans('text.dashboard') }}</p>
            </a>
          </li>
        @endif
      </ul>
    </nav>


  <!-- Botão de sair -->
    <div class="nav-link">
      <form action="{{ url('logout ') }}" method="post">
        @csrf
        <button type="submit" class="btn btn-danger btn-block btn-sm"><i
            class="fas fa-sign-out-alt nav-icon"></i>{{ trans('text.exit') }}</button>
      </form>
    </div>
    <h2 class="brand-link"></h2>
    <h2 class="brand-link" style="align:center"> Matches 🔥 </h2>

      @foreach ($matches as $match)
        <li class="matches">
            <img src="{{ Storage::url($match->photo) }}" class="match-photo" />
            <h3>{{ $match->name }}</h3>
        </li>   
        <br>
      @endforeach
</aside>