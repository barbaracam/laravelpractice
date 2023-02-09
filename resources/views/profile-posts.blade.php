{{-- we can have now access to avatar, as a property, we called like that dynamic value  :avatar --}}
{{-- i wont need the colon because im using a dinamyc with doublke bracketsx --}}
<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}}'s Profile" >
  @include('profile-posts-only')
  </x-profile>