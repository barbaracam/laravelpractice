<div class="list-group">                  
    @foreach ($following as $follow)
    {{-- the fuction comes from the follow model --}}
        <a href="/profile/{{$follow->userBeingFollowed->id}}" class="list-group-item list-group-item-action">
            <img class="avatar-tiny" src="{{$follow->userBeingFollowed->avatar}}" />
            {{$follow->userBeingFollowed->username}}
        </a>   
    @endforeach
  </div>