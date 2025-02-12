    @foreach($characteristics as $characteristic)  
<div class="invoice p-3 mb-3">
    <!-- Characteristic Field -->
    <div class="row">
        <p class="h1">{{$characteristic->name}}</p>
        <hr class="bg-dark">
    </div>

    <!-- options Field -->
    <ul class="list-inline">
        @foreach($options->where('characteristics_id', $characteristic->id) as $option)  
        <li class="list-inline-item"> 
            <input type="checkbox" name={{$option->name}} id={{$option->name}}> 
            <label for={{$option->name}}> {{$option->name}} </label>
        </li>
        @endforeach
    </div>
    @endforeach
</div>
