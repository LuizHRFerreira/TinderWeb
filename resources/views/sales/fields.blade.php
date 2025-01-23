
<div class="row form-divider">


    <div class="form-group col-md-12">
        <label>{{ trans('attributes.product') }}:</label>        
        <select class="form-control" name="product_id" id="product_id">
        @foreach($products as $product)
                <option value="{{ $product->id }}">{{ $product->name }}</option>
            @endforeach
        </select>
    </div>    

    <div class="form-group col-md-6">
        <label>{{ trans('attributes.amount') }}:</label>
        @if(isset($sale))
            <input type="number" class="form-control" value="{{ $sale->name }}" name="amount" id="amount">
        @else
            <input type="number" class="form-control" name="amount" id="amount">
        @endif
    </div>

    <div class="form-group col-md-6">
        <label>{{ trans('attributes.is_paid') }}:</label>     
        <select class="form-control" name="is_paid" id="is_paid">
            <option value="1">{{ trans('text.yes') }}</option>
            <option value="0">{{ trans('text.no') }}</option>
        </select>
    </div>

    <div class="form-group col-md-12">
        <label>{{ trans('attributes.description') }}:</label>
        @if(isset($sale))
            <textarea type="text" class="form-control" value="{{ $sale->name }}" name="description" id="description"></textarea>
        @else
            <textarea type="text" class="form-control" name="description" id="name"></textarea>
        @endif
    </div>

</div>

