<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EarlyAccess;

class EarlyAccessController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:early_access_list,email',
        ]);

        EarlyAccess::create($validated);

        return response()->json(['message' => 'Thanks! We’ll let you know when we launch.']);
    }
}
