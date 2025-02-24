<input id="users-remaining" type="hidden" value="{{ $usersRemaining }}">
@foreach($users as $user)  

    <!-- nome -->
    <div class="tinder--card" data-id="{{ $user->id }}">
        <p class="name"> {{$user->name}} </p>

        <!-- foto -->
        <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}'s Photo">

        <!-- Caracteristica -->
        <div class='description'>
        <ul class="list-unstyled">
            <p>Detalhes</p>
            @forelse ($user->i_am_options as $option)
                <li>{{ $option->name }}</li>
            @empty
                <li>Nenhuma característica selecionada.</li>
            @endforelse
        </ul>
        <input class="id" type="hidden" value="{{$user->id}}"/>
        <input class="match" type="hidden" value="{{$user->like->like}}"/>
        <audio id="alarmSound" src="{{ Storage::url('public/audio/alarme.mp3') }}"></audio>
        </div>
    </div>

@endforeach