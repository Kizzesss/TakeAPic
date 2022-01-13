<?php
    $array = array(Auth::user()->category_id, Auth::user()->last_category_seen);
?>
@if(in_array($image->category_id, $array))                          
            <div class="card pub_image">
                <div class="card-header">
                    @if ($image->user->image)
                    <div class="profile_image_container">
                        <img class="profile_image" src="{{ route('user.image', ['filename'=>$image->user->image]) }}"/>
                    </div>
                    @endif
                    <div class="data-user">
                        <a href="{{ route('user.profile', ['id' => $image->user->id])}}">
                            {{ '@'.$image->user->nick.' | '}}
                            <span class="category">
                                {{$image->category->name }}
                            </span>
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="image-container">
                        <img src="{{ route('image.file', ['filename'=>$image->image_path]) }}" class="image_pub"/>
                    </div>
                    
                    <div class="description">
                        <span class="nickname">{{ '@'.$image->user->nick }}</span>
                        <span class="nickname-date"> {{ ' | '.\FormatTime::LongTimeFilter($image->created_at) }} </span>
                        <p>{{ $image->description }}</p>
                    </div>
                    <div class="likes">
                        <!--Comprobar si el usuario le dio like a la imagen-->
                        <?php $user_like = false; ?>
                        @foreach ($image->like as $like)
                            @if ($like->user->id == Auth::user()->id)
                                <?php $user_like = true; ?>
                            @endif
                        @endforeach

                        @if ($user_like)
                            <img src="{{ asset('software/heart_red.png') }}" data-id="{{ $image->id }}"" class="btn-dislike"/>  
                        @else
                            <img src="{{ asset('software/heart.png') }}" data-id="{{ $image->id }}" class="btn-like"/>
                        @endif
                       
                    </div>
                    <div class="comments">
                        <a href="{{ route('image.detail', ['id' => $image->id])}}" class="btn btn-outline-info btn-comments">
                            Comentarios ({{ count($image->comment) }}) 
                        </a>  
                    </div>
                </div>
            </div>      
@endif