<div class="row">

    <!-- Name Field -->
    <div class="form-group col-md-6">
        <label>{{ trans('attributes.name') }}<span class="text-danger">*</span>:</label>
        @if(isset($user))
            <input type="text" class="form-control" value="{{ $user->name }}" name="name" id="name" required>
        @else
            <input type="text" class="form-control" name="name" id="name" required>
        @endif
    </div>

    <!-- email Field -->
    <div class="form-group col-md-6">
        <label>{{ trans('attributes.email') }}:</label>
        @if(isset($user))
            <input type="email" class="form-control" value="{{ $user->email }}" name="email" id="email">
        @else
            <input type="email" class="form-control" name="email" id="email">
        @endif
    </div>

    <!-- password Field -->
    <div class="form-group col-md-6">
        <label>{{ trans('attributes.password') }}:</label>
        <input type="password" class="form-control" name="password" id="password">
    </div>

    <!-- image Field -->
    {{-- Foto Field --}}
    <div class="form-group col-md-12">
        <label for="description">{{ trans('attributes.photo') }}:</label>

        <!-- If user has a photo, show the photo -->
        @if (isset($user))
            <!-- Div needed to restrict link to img -->
            <div style="width:10%">
                <a href="{{ Storage::url($user->photo) }}"> 
                    <img class="logo-edit" height="300" src="{{  isset ($user->photo)  ? Storage::url($user->photo) : asset('dist/images/sidebar/user_placeholder.jpg') }}" id="photo"/>
                </a>
            </div>
        @else
            <img src=""/>
        @endif
        <!-- Input to upload photo -->
        <br>
        <input type="file" name="photo" id="" onchange="previewPhoto(event)">
    </div> 
     
</div>

<script>
    function previewPhoto(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('photo');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }
</script>