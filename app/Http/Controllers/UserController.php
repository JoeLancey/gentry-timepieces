<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function index() { 
        $this->authorize('viewAny', User::class);
        $users = User::when(request('role'), fn($q) => $q->where('role', request('role')))
            ->latest()
            ->paginate(15);
        return view('users.index', compact('users')); 
    }
    public function create() { 
        $this->authorize('create', User::class);
        return view('users.create'); 
    }
    public function store(StoreUserRequest $request) {
        $this->authorize('create', User::class);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        return redirect()->route('users.index')->with('success','User created.');
    }
    public function show(User $user) { 
        $this->authorize('view', $user);
        return view('users.show', compact('user')); 
    }
    public function edit(User $user) { 
        $this->authorize('update', $user);
        return view('users.edit', compact('user')); 
    }
    public function update(UpdateUserRequest $request, User $user) {
        $this->authorize('update', $user);
        $data = ['name' => $request->name, 'email' => $request->email, 'role' => $request->role];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return redirect()->route('users.index')->with('success','User updated.');
    }
    public function destroy(User $user) { 
        $this->authorize('delete', $user);
        $user->delete(); 
        return redirect()->route('users.index')->with('success','User deleted.'); 
    }
}