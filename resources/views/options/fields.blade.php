
<div class="row form-divider">
    <div class="form-group col-md-12">  {{-- Corrected to col-md-12 for full width --}}
        <label>{{ trans('attributes.characteristics') }}:</label>
        <select class="form-select" aria-label="Default select example" id="characteristics_id">
            @foreach($characteristics as $characteristic)  {{-- Corrected variable name --}}
                <option value="{{ $characteristic['id'] }}">{{ $characteristic['name'] }}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-6">
        <label>{{ trans('attributes.name') }}:</label>
        @if(isset($options))
            <input type="text" class="form-control" value="{{ $options->name }}" name="name" id="name">
        @else
            <input type="text" class="form-control" name="name" id="name">
        @endif
    </div>
</div>


<div class="row form-divider">
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#characteristics_id').select2({
            placeholder: "Seleciona a caracteristica a qual a opção pertence",
            allowClear: true
        });
    });
</script>

