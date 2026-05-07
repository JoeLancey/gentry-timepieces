<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\ActivityLog;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

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
            'role' => $request->role ?? 'staff',
        ]);
        
        // Log user creation
        ActivityLog::log(
            'created',
            'User',
            $user->id,
            null,
            "User account created: {$user->name} ({$user->email})"
        );
        
        return redirect()->route('users.index')->with('success','User created successfully.');
    }
    
    public function show(User $user) { 
        $this->authorize('view', $user);
        
        $transactions = $user->transactions()->latest()->paginate(10);
        $activityLogs = ActivityLog::where('user_id', $user->id)->latest()->paginate(10);
        $userActivityBy = ActivityLog::where('model_type', 'User')->where('model_id', $user->id)->latest()->paginate(5);
        
        return view('users.show', compact('user', 'transactions', 'activityLogs', 'userActivityBy')); 
    }
    
    public function edit(User $user) { 
        $this->authorize('update', $user);
        return view('users.edit', compact('user')); 
    }
    
    public function update(UpdateUserRequest $request, User $user) {
        $this->authorize('update', $user);
        
        $oldRole = $user->role;
        $data = ['name' => $request->name, 'email' => $request->email, 'role' => $request->role];
        
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        
        $user->update($data);
        
        // Log role change if applicable
        if ($oldRole !== $request->role) {
            ActivityLog::log(
                'updated',
                'User',
                $user->id,
                ['role' => ['from' => $oldRole, 'to' => $request->role]],
                "User role changed from {$oldRole} to {$request->role}"
            );
        } else {
            ActivityLog::log(
                'updated',
                'User',
                $user->id,
                null,
                "User information updated"
            );
        }
        
        return redirect()->route('users.show', $user)->with('success','User updated successfully.');
    }
    
    public function destroy(User $user) { 
        $this->authorize('delete', $user);
        
        $userName = $user->name;
        $userEmail = $user->email;
        
        $user->delete();
        
        // Log user deletion
        ActivityLog::log(
            'deleted',
            'User',
            $user->id,
            null,
            "User account deleted: {$userName} ({$userEmail})"
        );
        
        return redirect()->route('users.index')->with('success','User deleted successfully.'); 
    }

    public function recordLogin(User $user)
    {
        $user->update(['last_login_at' => now()]);
        ActivityLog::log('login', 'User', $user->id, null, 'User logged in');
    }
}
