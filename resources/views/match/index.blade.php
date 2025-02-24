<!-- Extende side bar -->
@extends('layouts.master')

@section('content')
  
  <!-- Conteúdo da tela -->
  <div class="tinder">

    <!-- Cria os cards -->
    <div class="tinder--cards" id="user-cards-container">
      @include('match.user_cards')
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
      z-index: 3;
      position: relative;
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

    $(document).ready(function () {

    // Criação das variáveis que selecionam os elementos do HTML
    var tinderContainer = document.querySelector('.tinder');
    var allCards = document.querySelectorAll('#user-cards-container .tinder--card');
    var nope = document.getElementById('nope');
    var love = document.getElementById('love');

    // Requisições para importação de mais cards
    const userCardsContainer = document.getElementById('user-cards-container');
    let currentPage = 1;
    let cardsPassed = 0;
    let usersRemaining = {{ $usersRemaining }};

    // Função que inicializa a visualização dos cards
    function initCards() {
        var newCards = document.querySelectorAll('#user-cards-container .tinder--card:not(.removed)');
        allCards = newCards;

        newCards.forEach(function (card, index) {
            card.style.zIndex = allCards.length - index;
            card.style.transform = 'scale(' + (20 - index) / 20 + ') translateY(-' + 30 * index + 'px)';
            card.style.opacity = (10 - index) / 10;
        });

        newCards.forEach(function (el) {
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

                event.target.style.transform =
                    'translate(' + event.deltaX + 'px, ' + event.deltaY + 'px) rotate(' + rotate + 'deg)';

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

                    event.target.style.transform =
                        'translate(' + toX + 'px, ' + (toY + event.deltaY) + 'px) rotate(' + rotate + 'deg)';

                    var card = event.target;
                    var avaliator_id = {{ Auth::user()->id }};
                    var avaliated_id = card.querySelector('.id').value;
                    var match = card.querySelector('.match').value;
                    var like = event.deltaX > 0;

                    function tocarAlarme() {
                        let som = document.getElementById("alarmSound");
                        som.play();
                    }

                    if (like && match == 1) {
                        tocarAlarme();
                        Swal.fire({
                            title: '🔥 Deu Match! 🔥',
                            text: 'Vocês dois se curtiram!',
                            imageUrl: 'https://images.emojiterra.com/google/noto-emoji/animated-emoji/1f525.gif',
                            imageWidth: 300,
                            imageHeight: 200,
                            imageAlt: 'Deu Match!',
                            background: '#ffe4e1',
                            color: '#d63384'
                        });
                    }

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
                        success: function (response) {
                            console.log('Avaliação enviada com sucesso:', response);
                        },
                        error: function (error) {
                            console.error('Erro ao enviar avaliação:', error);
                        }
                    });

                    if (cardsPassed % 30 === 0 && usersRemaining > 0) {
                        currentPage++;
                        fetch(`?page=${currentPage}`, {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        })
                            .then(response => response.text())
                            .then(html => {
                                const tempContainer = document.createElement('div');
                                tempContainer.innerHTML = html;

                                const newCards = tempContainer.querySelectorAll('.tinder--card');
                                userCardsContainer.append(...newCards);

                                const remainingData = tempContainer.querySelector('#users-remaining');
                                usersRemaining = remainingData ? parseInt(remainingData.value) : 0;

                            })
                            .catch(error => console.error('Erro:', error));
                    }
                    
                }
                // Incrementa o card quando o usuario clica em um dos botões
                cardsPassed++;
                initCards();
                
            });

        });

        tinderContainer.classList.add('loaded');
    }

    initCards();

    function createButtonListener(isLove) {
        return function (event) {
            var cards = document.querySelectorAll('.tinder--card:not(.removed)');
            var moveOutWidth = document.body.clientWidth * 1.5;

            if (!cards.length) return false;

            var card = cards[0];
            card.classList.add('removed');

            var avaliator_id = {{ Auth::user()->id }};
            var avaliated_id = card.querySelector('.id').value;
            var like = isLove;
            var match = card.querySelector('.match').value;

            function tocarAlarme() {
                let som = document.getElementById("alarmSound");
                som.play();
            }

            if (isLove) {
                card.style.transform = 'translate(' + moveOutWidth + 'px, -100px) rotate(-30deg)';

                if (match == 1) {
                    tocarAlarme();
                    Swal.fire({
                        title: '🔥 Deu Match! 🔥',
                        text: 'Vocês dois se curtiram!',
                        imageUrl: 'https://images.emojiterra.com/google/noto-emoji/animated-emoji/1f525.gif',
                        imageWidth: 300,
                        imageHeight: 200,
                        imageAlt: 'Deu Match!',
                        background: '#ffe4e1',
                        color: '#d63384'
                    });
                }
            } else {
                card.style.transform = 'translate(-' + moveOutWidth + 'px, -100px) rotate(30deg)';
            }

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
                success: function (response) {
                    console.log('Avaliação enviada com sucesso:', response);
                },
                error: function (error) {
                    console.error('Erro ao enviar avaliação:', error);
                }

                // Incrementa o card quando o usuario clica em um dos botões
                

            });
                cardsPassed++;
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
