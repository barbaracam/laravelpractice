<x-layout :doctitle="$doctitle">
    <div class="container py-md-5 container--narrow">
        <h2>
        <img class="avatar-small" src="{{$sharedData['avatar']}}" /> {{$sharedData['username']}}
        {{-- from the profile, user controller --}}
        @auth
        {{-- if currently is not being follow or it is not you --}}
            @if(!$sharedData['currentlyFollowing'] AND auth()->user()->id !=$sharedData['id'])
            <form class="ml-2 d-inline" action="/create-follow/{{$sharedData['id']}}" method="POST">
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
            @if($sharedData['currentlyFollowing'])
            <form class="ml-2 d-inline" action="/remove-follow/{{$sharedData['id']}}" method="POST">
            {{-- if i decided to use username, instead of id in create follow we use {{username}} --}}
            @csrf                
                <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button>
            </form>
            @endif 

            @if(auth()->user()->username == $sharedData['username'])
            <a href='/manage-avatar' class="btn btn-secondary btn-sm">Manage Avatar</a>
            @endif            
        @endauth          
        </h2>

        <div class="profile-nav nav nav-tabs pt-2 mb-4">
            {{-- we will use a ternary operator between brackets, we will mark the 3 segment ==(means if) if return nothing, it have be active if not nothing return --}}
        <a href="/profile/{{$sharedData['id']}}" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "" ? "active" : ""}}">Posts: {{$sharedData['postCount']}}</a>
        <a href="/profile/{{$sharedData['id']}}/followers" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "followers" ? "active" : ""}}">Followers: {{$sharedData['followerCount']}}</a>
        <a href="/profile/{{$sharedData['id']}}/following" class="profile-nav-link nav-item nav-link {{Request::segment(3) == "following" ? "active" : ""}}">Following: {{$sharedData['followingCount']}}</a>
        </div>

        <div class="profile-slot-content">
            {{$slot}}
        </div>

        
    </div>
</x-layout>