{{-- we can have now access to avatar, as a property, we called like that dynamic value  :avatar --}}
{{-- <x-profile :avatar="$avatar" :username="$username" :id="$id" :currentlyFollowing="$currentlyFollowing" :postCount="$postCount"> --}}
<x-profile :sharedData="$sharedData">
    <div class="list-group">
     {{-- function comes from the followers function from user model --}}
      @foreach ($followers as $follow)
          <a href="/profile/{{$follow->UserDoingTheFollowing->id}}" class="list-group-item list-group-item-action">
              <img class="avatar-tiny" src="{{$follow->userDoingTheFollowing->avatar}}" />
              {{$follow->userDoingTheFollowing->username}}
          </a>   
      @endforeach
    </div>
    </x-profile>