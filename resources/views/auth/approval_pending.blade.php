<x-app-layout header="Account Pending Approval">
    <div class="card">
        <h2 style="margin-bottom:0.5rem;">Account Pending Approval</h2>
        <p>Your account is awaiting approval by an administrator. You will be notified once approved.</p>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-secondary" type="submit" style="margin-top:1rem;">Sign Out</button>
        </form>
    </div>
</x-app-layout>
