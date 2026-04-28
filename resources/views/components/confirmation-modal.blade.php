@props(['show' => false, 'title' => 'Confirm Action'])

<div id="confirmModal" style="display: {{ $show ? 'flex' : 'none' }}; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div class="card" style="max-width: 400px; padding: 2rem;">
        <h3 style="margin-bottom: 1rem;">{{ $title }}</h3>
        <p style="margin-bottom: 1.5rem; color: var(--gray-mid);">{{ $slot }}</p>
        <div style="display: flex; gap: 1rem;">
            <button onclick="document.getElementById('confirmModal').style.display='none'" class="btn btn-secondary" style="flex: 1; justify-content: center;">Cancel</button>
            <form method="POST" style="flex: 1;">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger" style="width: 100%; justify-content: center;">Delete</button>
            </form>
        </div>
    </div>
</div>
