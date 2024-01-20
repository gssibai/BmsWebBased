@extends('layouts.user_type.auth')

@section('content')

  <section class="min-vh-100 mb-8">
    <div class="page-header align-items-start min-vh-50 pt-5 pb-11 mx-3 border-radius-lg" style="background-image: url('../assets/img/curved-images/curved14.jpg');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-5 text-center mx-auto">
            <h1 class="text-white mb-2 mt-5">Update Users</h1>
          </div>
        </div>
      </div>
    </div>
    <div class="container">
      <div class="row mt-lg-n10 mt-md-n11 mt-n10">
        <div class="col-xl-4 col-lg-5 col-md-7 mx-auto">
          <div class="card z-index-0">
           
            
            <div class="card-body">
              @if($users->isNotEmpty())
            <form action="{{ route('update.users.data') }}" method="POST"role="form text-left">
                @csrf
                @foreach($users as $user)
                <div class="mb-3">
                  <input type="text" class="form-control" placeholder="usersData[{{ $user->id }}][name]" name="usersData[{{ $user->id }}][name]" id="name" aria-label="Name" aria-describedby="name" value="{{ $user->name }}">
                  @error('name')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>
                <div class="mb-3">
                  <input type="email" class="form-control" placeholder="usersData[{{ $user->id }}][email]" name="usersData[{{ $user->id }}][email]" id="email" aria-label="Email" aria-describedby="email-addon" value="{{ $user->email }}">
                  @error('email')
                    <p class="text-danger text-xs mt-2">{{ $message }}</p>
                  @enderror
                </div>
                <hr>
                @endforeach
                <div class="text-center">
                    <button type="submit" class="btn bg-gradient-dark w-100 my-4 mb-2">Update users</button>
                </div>
            </form>
            @else
            <p>No users selected for update.</p>
            @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

