<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UpdateController extends Controller
{
    public function __invoke(UpdateRequest $request)
    {
        $userId = Auth::id();
        $user = User::findOrFail($userId);
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $data['updated_at'] = time();
        unset($data['password_confirmation']);
        $user->update($data);
        return $user;
    }
}
