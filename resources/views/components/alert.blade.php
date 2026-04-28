@props(['message', 'type' => 'info'])

@if ($message = session('success'))
    <div class="alert alert-success" role="alert">
        {{ $message }}
    </div>
@endif

@if ($message = session('error'))
    <div class="alert alert-danger" role="alert">
        {{ $message }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul style="margin: 0; padding-left: 1.25rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
