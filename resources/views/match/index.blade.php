@extends('layouts.master')
@section('content')

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

  </style>

  <div class="tinder">

    <!-- Cria os ícons de X e coração -->
    <div class="tinder--status">
      <i class="fa fa-remove"></i>
      <i class="fa fa-heart"></i>
    </div>

    <!-- Cria os cards -->
    <div class="tinder--cards">

    <!-- Para cada usuario cadastrado, cria um card -->
    @foreach($users as $user)  

    <!-- criação do card -->
    <div class="tinder--card">

      <!-- nome da pessoa no card -->
      <p class="name"> {{$user->name}} </p>

      <!-- foto da pessoa no card -->
      <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}'s Photo">

      <!-- Cria lista com as caracteristicas da pessoa no card -->
      <div class="description">
        <ul class="list-unstyled">

          <p>Sobre mim:</p>

              @php
                  // Busca na tabela CharacteristicsOptionsUsers a linha que contém o id do usuário logado e armaena na variável $he_is
                  $userCharacteristics = $CharacteristicsOptionsUsers->where('users_id',$user->id)->first();

                  // Armazena na variavel selectedOptions as opções selecionadas pelo usuário ou se estiver nulo, um array vazio
                  $selectedOptions = $userCharacteristics && $userCharacteristics->i_am ? json_decode($userCharacteristics->i_am, true) : [];
              @endphp

              <!-- se no array tiver opções-->
              @if ($selectedOptions)

                  <!-- vai fazer em looping a consulta do nome do id na tabela options-->
                  @foreach ($selectedOptions as $optionId)
                      <ul><li>{{ \App\Models\Option::find($optionId)->name}}</li></ul>
                  @endforeach

              <!-- se o array estiver vazio -->
              @else
                  <ul><li>Sem caracterísitcas informadas</li></ul>
              @endif
              <br>
                        
              <!-- Importa do banco o id do usuario para ser puxado pelo script -->
              <div class="id" style="font-size: 0px;"> {{$user->id}} </div>
          </ul>
        </div>
      </div>
      @endforeach
    </div>

    <!-- Botões de like e deslike -->
    <div class="tinder--buttons">
      <button id="nope"><i class="fa fa-remove"></i></button>
      <button id="love"><i class="fa fa-heart"></i></button>
    </div>

  </div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js"></script>
  
  <script>

    function myDoubleClickFunction(event) {
    let card = event.currentTarget;
    let question = card.querySelector('[id^=question]');
    let answer = card.querySelector('[id^=answer]');

    if (question && answer) {
      question.style.display = question.style.display === 'none' ? 'block' : 'none';
      answer.style.display = answer.style.display === 'none' ? 'block' : 'none';
    }
    }

    'use strict';

    var tinderContainer = document.querySelector('.tinder');
    var allCards = document.querySelectorAll('.tinder--card');
    var nope = document.getElementById('nope');
    var love = document.getElementById('love');

    function writeLoveToServer() {
    //Execute cgi to update positive record
    //document.getElementById("question2").innerHTML = "whatever";
    }

    function writeNopeToServer() {
    //Execute cgi to update negative
    }

    function initCards(card, index) {
    var newCards = document.querySelectorAll('.tinder--card:not(.removed)');

    newCards.forEach(function (card, index) {
      card.style.zIndex = allCards.length - index;
      card.style.transform = 'scale(' + (20 - index) / 20 + ') translateY(-' + 30 * index + 'px)';
      card.style.opacity = (10 - index) / 10;
    });

    tinderContainer.classList.add('loaded');
    }

    initCards();

    allCards.forEach(function (el) {
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



      // Ação ao arrastar o card
      event.target.style.transform = 'translate(' + toX + 'px, ' + (toY + event.deltaY) + 'px) rotate(' + rotate + 'deg)';
      
      //Se puxar para a direita
      if (event.deltaX > 0) {
            alert("Você deu like em " + el.querySelector('.id').innerHTML);
        } 
      
        //Se puxar para a esquerda
      else {
            alert("Você não deu like em " + el.querySelector('.id').innerHTML);
            writeNopeToServer();
        }
        
      
      initCards();
      }
    });
    });

    function createButtonListener(love) {
    return function (event) {
      var cards = document.querySelectorAll('.tinder--card:not(.removed)');
      var moveOutWidth = document.body.clientWidth * 1.5;

      if (!cards.length) return false;

      var card = cards[0];


      
      // Ação quando clica no coração
      card.classList.add('removed');

      // Se clicar no coração
      if (love) {

      //Animação do card
      card.style.transform = 'translate(' + moveOutWidth + 'px, -100px) rotate(-30deg)';

      //envia para o banco
      alert("Você deu like em " + card.querySelector('.id').innerHTML);
      writeLoveToServer();

      //Se clicar no X
      } else {

      //Animação do card
      card.style.transform = 'translate(-' + moveOutWidth + 'px, -100px) rotate(30deg)';

      //envia para o banco
      alert("Você não deu like em " + card.querySelector('.id').innerHTML);
      }

      initCards();

      event.preventDefault();
    };
    }

    var nopeListener = createButtonListener(false);
    var loveListener = createButtonListener(true);

    nope.addEventListener('click', nopeListener);
    love.addEventListener('click', loveListener);
  </script>


@endsection