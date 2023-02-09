<x-layout>
    <div class="container py-md-5 container--narrow">
        <h2>
          <img class="avatar-small" src="{{$avatar}}" /> {{$username}}
          {{-- from the profile, user controller --}}
          @auth
          {{-- if currently is not being follow or it is not you --}}
            @if(!$currentlyFollowing AND auth()->user()->id !=$username)
            <form class="ml-2 d-inline" action="/create-follow/{{$id}}" method="POST">
              {{-- if i decided to use username, instead of id in create follow we use {{username}} --}}
              @csrf
                <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>                
                {{-- we delete so we dont repeat
                @if(auth()->user()->username == $username)
                <a href='/manage-avatar' class="btn btn-secondary btn-sm">Manage Avatar</a> 
                @endif --}}
              </form>
            @endif
            {{-- DELETE if it is following lets delete --}}
            @if($currentlyFollowing)
            <form class="ml-2 d-inline" action="/remove-follow/{{$id}}" method="POST">
              {{-- if i decided to use username, instead of id in create follow we use {{username}} --}}
              @csrf                
                <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button>
            </form>
            @endif 

            @if(auth()->user()->username == $username)
              <a href='/manage-avatar' class="btn btn-secondary btn-sm">Manage Avatar</a>
            @endif            
          @endauth          
        </h2>
  
        <div class="profile-nav nav nav-tabs pt-2 mb-4">
          <a href="#" class="profile-nav-link nav-item nav-link active">Posts: {{$postCount}}</a>
          <a href="#" class="profile-nav-link nav-item nav-link">Followers: 3</a>
          <a href="#" class="profile-nav-link nav-item nav-link">Following: 2</a>
        </div>
  
        <div class="list-group">                  
          @foreach ($posts as $post)
             <a href="/post/{{$post->id}}" class="list-group-item list-group-item-action">
                <img class="avatar-tiny" src="{{$post->user->avatar}}" />
                <strong>{{$post->title}}</strong> on {{$post->created_at->format('n/j/Y')}}
            </a>   
          @endforeach
        </div>
      </div>


</x-layout>