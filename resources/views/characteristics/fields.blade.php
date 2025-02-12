
<div class="row form-divider">

    <div class="form-group col-md-6">
        <label>{{ trans('attributes.name') }}:</label>
        @if(isset($characteristics))
            <input type="text" class="form-control" value="{{ $characteristics->name }}" name="name" id="name">
        @else
            <input type="text" class="form-control" name="name" id="name">
        @endif
    </div>


</div>

