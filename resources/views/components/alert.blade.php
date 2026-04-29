@props(['type' => 'info'])

@if(session('success'))
    <div class="alert alert-success animate-fade-in" role="alert">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger animate-fade-in" role="alert">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger animate-fade-in" role="alert">
        <ul class="mt-2 pl-4 list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
