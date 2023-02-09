{{-- we can have now access to avatar, as a property, we called like that dynamic value  :avatar --}}
{{-- <x-profile :avatar="$avatar" :username="$username" :id="$id" :currentlyFollowing="$currentlyFollowing" :postCount="$postCount"> --}}
<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}}">
    @include('profile-followers-only')
</x-profile>