<div class="list-group">
    {{-- function comes from the followers function from user model --}}
     @foreach ($followers as $follow)
         <a href="/profile/{{$follow->UserDoingTheFollowing->id}}" class="list-group-item list-group-item-action">
             <img class="avatar-tiny" src="{{$follow->userDoingTheFollowing->avatar}}" />
             {{$follow->userDoingTheFollowing->username}}
         </a>   
     @endforeach
   </div>