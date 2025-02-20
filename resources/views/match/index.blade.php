<!-- Extende side bar -->
@extends('layouts.master')

@section('content')
  
  <!-- Conteúdo da tela -->
  <div class="tinder">

    <!-- Cria os ícons de X e coração -->
    <div class="tinder--status">
      <i class="fa fa-remove"></i>
      <i class="fa fa-heart"></i>
    </div>    

    <!-- Cria os cards -->
    <div class="tinder--cards">

    
    

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

      <!-- Ultimo card -->
      <div class="tinder--card">
        <p class="ultimo_card">Sem novas pessoas para conhecer? 🔄 Atualize seus interesses e descubra novas conexões!</p>
      </div>
    </div>

    <!-- Botões de like e deslike -->
    <div class="tinder--buttons">
      <button id="nope"><i class="fa fa-remove"></i></button>
      <button id="love"><i class="fa fa-heart"></i></button>
    </div>

  </div>
@endsection

<!-- Script dos cards -->
@section('scripts')

  <!-- Estilização dos cards -->
  <style>
      *,
      *:before,
      *:after {
      box-sizing: border-box;
      padding: 0;
      margin: 0;
      }

      body {
      background: #CCFBFE;
      overflow: hidden;
      font-family: sans-serif;
      }

      .tinder {
      width: 90vw;
      height: 90vh;
      overflow: hidden;
      display: flex;
      flex-direction: column;
      position: relative;
      opacity: 0;
      transition: opacity 0.1s ease-in-out;
      }

      .loaded.tinder {
      opacity: 1;
      }

      .tinder--status {
      position: absolute;
      top: 50%;
      margin-top: -30px;
      z-index: 2;
      width: 100%;
      text-align: center;
      pointer-events: none;
      }

      .tinder--status i {
      font-size: 100px;
      opacity: 0;
      transform: scale(0.3);
      transition: all 0.2s ease-in-out;
      position: absolute;
      width: 100px;
      margin-left: -50px;
      }

      .tinder_love .fa-heart {
      opacity: 0.7;
      transform: scale(1);
      }

      .tinder_nope .fa-remove {
      opacity: 0.7;
      transform: scale(1);
      }

      .tinder--cards {
      flex-grow: 1;
      padding-top: 40px;
      text-align: center;
      display: flex;
      justify-content: center;
      align-items: flex-end;
      z-index: 1;
      background-color: #f0e5c9;
      }

      .tinder--card {
      display: inline-block;
      width: 90vw;
      max-width: 400px;
      height: 70vh;
      background: black;
      padding-bottom: 40px;
      border-radius: 8px;
      overflow: hidden;
      position: absolute;
      will-change: transform;
      transition: all 0.3s ease-in-out;
      cursor: -webkit-grab;
      cursor: -moz-grab;
      cursor: grab;
      height: 560px;
      overflow-y: auto;
      }

      .moving.tinder--card {
      transition: none;
      cursor: -webkit-grabbing;
      cursor: -moz-grabbing;
      cursor: grabbing;
      }

      .tinder--card img {
      max-width: 100%;
      pointer-events: none;
      }

      .tinder--card h3 {
      margin-top: 32px;
      font-size: 32px;
      padding: 0 16px;
      pointer-events: none;
      }

      .tinder--card p {
      margin-top: 24px;
      font-size: 20px;
      padding: 0 16px;
      pointer-events: none;
      }

      .tinder--buttons {
      flex: 0 0 100px;
      text-align: center;
      padding-top: 20px;
      background: #f0e5c9;
      }

      .tinder--buttons button {
      border-radius: 50%;
      line-height: 60px;
      width: 60px;
      border: 0;
      background: #FFFFFF;
      display: inline-block;
      margin: 0 8px;
      }

      .tinder--buttons button:focus {
      outline: 0;
      }

      .tinder--buttons i {
      font-size: 32px;
      vertical-align: middle;
      }

      .fa-heart {
      color: rgb(252, 77, 77);
      }

      .fa-remove {
      color: rgb(0, 0, 0);
      }

      .name {
      font-size: 50px;
      color: white;
      text-align: left;
      }

      .description{
        background-color:rgb(65, 48, 34);
        margin: 10px;
        border-radius: 10px;
        color:white;
        text-align: left;
      }

      .ultimo_card{
      font-size: 50px;
      color: white;
      display: flex;
      justify-content: center; 
      align-items: center; 
      width: 100%;
      height: 92%;
      }

  </style>
  
  <!-- importa o script do hammer.js que deixa arrastar os cards -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>

  <!-- importando o js do sweetbutton -->
  <script src="{{ asset('js/sweetalert.js') }}"></script>
  
  <script>

    $(document).ready(function (){

      // Criação das variaveis que seleciona os elementos do html
      var tinderContainer = document.querySelector('.tinder');
      var allCards = document.querySelectorAll('.tinder--card');
      var nope = document.getElementById('nope');
      var love = document.getElementById('love');
    

      // Função que Inicializa a visualização dos cards
      function initCards(card, index) {

      // Seleciona todos os cards que não foram removidos
      var newCards = document.querySelectorAll('.tinder--card:not(.removed)');

      // Para cada card que não foi removido, faz a animação de ir deixando o card transparente e aumentando o tamanho
      newCards.forEach(function (card, index) {

        // Animação que deixa o card em cima dos outros
        card.style.zIndex = allCards.length - index;

        // Animação que aumenta o tamanho do card
        card.style.transform = 'scale(' + (20 - index) / 20 + ') translateY(-' + 30 * index + 'px)';

        // Animação que deixa o card transparente
        card.style.opacity = (10 - index) / 10;
      });

    
      tinderContainer.classList.add('loaded');
      }

      initCards();

      allCards.forEach(function (el) 
      {
        var hammertime = new Hammer(el);

        hammertime.on('pan', function (event) {
          el.classList.add('moving');
        });

        hammertime.on('pan', function (event) {
          if (event.deltaX === 0) return;
          if (event.center.x === 0 && event.center.y === 0) return;

          tinderContainer.classList.toggle('tinder_love', event.deltaX > 0);
          tinderContainer.classList.toggle('tinder_nope', event.deltaX < 0);

          var xMulti = event.deltaX * 0.03;
          var yMulti = event.deltaY / 80;
          var rotate = xMulti * yMulti;

          event.target.style.transform = 'translate(' + event.deltaX + 'px, ' + event.deltaY + 'px) rotate(' + rotate + 'deg)';
        });

        hammertime.on('panend', function (event) {
        el.classList.remove('moving');
        tinderContainer.classList.remove('tinder_love');
        tinderContainer.classList.remove('tinder_nope');

        var moveOutWidth = document.body.clientWidth;
        var keep = Math.abs(event.deltaX) < 80 || Math.abs(event.velocityX) < 0.5;

        event.target.classList.toggle('removed', !keep);

        if (keep) {
          event.target.style.transform = '';
        } else {
          var endX = Math.max(Math.abs(event.velocityX) * moveOutWidth, moveOutWidth);
          var toX = event.deltaX > 0 ? endX : -endX;
          var endY = Math.abs(event.velocityY) * moveOutWidth;
          var toY = event.deltaY > 0 ? endY : -endY;
          var xMulti = event.deltaX * 0.03;
          var yMulti = event.deltaY / 80;
          var rotate = xMulti * yMulti;
          var like = event.deltaX > 0;

          event.target.style.transform = 'translate(' + toX + 'px, ' + (toY + event.deltaY) + 'px) rotate(' + rotate + 'deg)';
          
          var card = event.target;
          // Pega o id do user logado
          var avaliator_id = {{ Auth::user()->id }};
          // Pega o id do user do card
          var id = card.querySelector('.id').value;
          // Vai pegar o id da pessoa se ela deu like
          var match = card.querySelector('.match').value;

          function tocarAlarme() {
          let som = document.getElementById("alarmSound");
          som.play();
          }
          

          var avaliated_id = card.querySelector('.id').value;
          var like = event.deltaX > 0;

          // Verificando a direção do movimento para determinar se foi like ou deslike
          if (event.deltaX > 0) {
            if(match == 1)
          {
              
            tocarAlarme()

              Swal.fire({
                title: '🔥 Deu Match! 🔥',
                  text: 'Vocês dois se curtiram!',
                  imageUrl: 'https://images.emojiterra.com/google/noto-emoji/animated-emoji/1f525.gif',
                  imageWidth: 300,
                  imageHeight: 200,
                  imageAlt: 'Deu Match!',
                  background: '#ffe4e1',
                  color: '#d63384'
              })

          }
          else{}

          } else {
          }

            // Requisição AJAX dentro do listener
            $.ajax({
            url: '/match',
            type: 'POST',
            data: {
                avaliator_id: avaliator_id,
                avaliated_id: avaliated_id,
                like: like,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('Avaliação enviada com sucesso:', response);
                initCards();
            },
            error: function(error) {
                console.error('Erro ao enviar avaliação:', error);
                initCards();
            }
        });
        }
      });

      });

      function createButtonListener(isLove) {
      return function (event) {
        var cards = document.querySelectorAll('.tinder--card:not(.removed)');
        var moveOutWidth = document.body.clientWidth * 1.5;

        if (!cards.length) return false;

        var card = cards[0];

        // Ação quando clica no coração
        card.classList.add('removed');

        //Pega o id do user logado
        var avaliator_id = {{ Auth::user()->id }};
        //Pega o id do user do card
        var avaliated_id = card.querySelector('.id').value;
        var like = isLove;

      // Vai pegar o id da pessoa se ela deu like
      var match = card.querySelector('.match').value;

      function tocarAlarme() {
          let som = document.getElementById("alarmSound");
          som.play();
          }

        // Se clicar no coração
        if (isLove) {

          //Animação do card
          card.style.transform = 'translate(' + moveOutWidth + 'px, -100px) rotate(-30deg)';
          if(match == 1)
            {
              Swal.fire({
                title: '🔥 Deu Match! 🔥',
                  text: 'Vocês dois se curtiram!',
                  imageUrl: 'https://images.emojiterra.com/google/noto-emoji/animated-emoji/1f525.gif',
                  imageWidth: 300,
                  imageHeight: 200,
                  imageAlt: 'Deu Match!',
                  background: '#ffe4e1',
                  color: '#d63384'
              })

              tocarAlarme()
            };

        } else {

        //Animação do card
        card.style.transform = 'translate(-' + moveOutWidth + 'px, -100px) rotate(30deg)';}


    //==========================================================================================
        
        // Requisição AJAX dentro do listener
        $.ajax({
            url: '/match',
            type: 'POST',
            data: {
                avaliator_id: avaliator_id,
                avaliated_id: avaliated_id,
                like: isLove,
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log('Avaliação enviada com sucesso:', response);
            },
            error: function(error) {
                console.error('Erro ao enviar avaliação:', error);
            }
        });
        initCards();
      };
    }

      var nopeListener = createButtonListener(false);
      var loveListener = createButtonListener(true);

      nope.addEventListener('click', nopeListener);
      love.addEventListener('click', loveListener);
    });
    
  </script>
  
@endsection
