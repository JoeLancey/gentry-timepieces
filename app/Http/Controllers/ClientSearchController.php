<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientSearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->get('query', '');
        
        $clients = Client::when($search, function ($q) use ($search) {
            $q->where('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%")
              ->orWhere('email', 'like', "%{$search}%")
              ->orWhere('phone', 'like', "%{$search}%");
        })
        ->limit(10)
        ->get(['id', 'first_name', 'last_name', 'email', 'phone'])
        ->map(function ($client) {
            return [
                'id' => $client->id,
                'name' => $client->full_name,
                'email' => $client->email,
                'phone' => $client->phone,
                'display' => "{$client->full_name}" . ($client->phone ? " ({$client->phone})" : ""),
            ];
        });

        return response()->json($clients);
    }
}
