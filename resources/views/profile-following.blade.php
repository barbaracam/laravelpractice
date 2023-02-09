{{-- we can have now access to avatar, as a property, we called like that dynamic value  :avatar --}}
{{-- <x-profile :avatar="$avatar" :username="$username" :id="$id" :currentlyFollowing="$currentlyFollowing" :postCount="$postCount"> --}}
    <x-profile :sharedData="$sharedData" doctitle="who {{$sharedData['username'] follows">  
    <div class="list-group">                  
      @foreach ($following as $follow)
      {{-- the fuction comes from the follow model --}}
          <a href="/profile/{{$follow->userBeingFollowed->id}}" class="list-group-item list-group-item-action">
              <img class="avatar-tiny" src="{{$follow->userBeingFollowed->avatar}}" />
              {{$follow->userBeingFollowed->username}}
          </a>   
      @endforeach
    </div>
    </x-profile>