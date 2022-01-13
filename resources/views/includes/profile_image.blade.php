@if (Auth::user()->image)
<div class="profile_image_container">
    <img class="profile_image" src="{{ route('user.image', ['filename'=>Auth::user()->image]) }}"/>
</div>
@endif