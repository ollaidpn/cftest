@if(session('error'))
    <div class="alert alert-danger">
        {{session('error')}}
    </div>
@endif

  <!-- Success message -->
  @if(session('success'))
  <div class="alert alert-success" style="color: black !important">
      {{session('success')}}
  </div>
  @endif


  @if ($errors->any())
  <div class="alert alert-danger">
      <ul>
          @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
          @endforeach
      </ul>
  </div>
@endif
