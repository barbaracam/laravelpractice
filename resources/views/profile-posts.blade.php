{{-- we can have now access to avatar, as a property, we called like that dynamic value  :avatar --}}
{{-- i wont need the colon because im using a dinamyc with doublke bracketsx --}}
<x-profile :sharedData="$sharedData" doctitle="{{$sharedData['username']}}'s Profile" >
  <div class="list-group">                  
    @foreach ($posts as $post)
      <x-post :post="$post" hideAuthor="true" />  
    @endforeach
  </div>
  </x-profile>