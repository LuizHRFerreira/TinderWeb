<style>
    .select2-container--default .select2-selection--single {
        height: 100% !important; 
    }
    
</style>





<div class="row form-divider">
    <div class="form-group col-md-12">
        <label>{{ trans('attributes.characteristics') }}:</label>
        <select class="form-select" aria-label="Default select example" id="characteristics_id" name="characteristics_id" value="{option->nome}">
            
            @foreach($characteristics as $characteristic)
                <option value="{{ $characteristic['id'] }}">{{ $characteristic['name'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-6">
        <label>{{ trans('attributes.name') }}:</label>
        @if(isset($options))
            <input type="text" class="form-control" value="{{ $options->name }}" name="name" id="name">
        @else
            <input type="text" class="form-control" name="name" id="name" placeholder="{{$option->name}}" Value="{{$option->name}}">
        @endif

        
    </div>
</div>


<div class="row form-divider">
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#characteristics_id').select2({
            height:'50px',
        });
    });
</script>