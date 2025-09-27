<?php

namespace App\Http\Controllers\API\Wordpress;

use App\Http\Controllers\Controller;
use App\Http\Resources\WPUserResource;
use App\Repositories\Contracts\Wordpress\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserRepositoryInterface $users;

    public function __construct(UserRepositoryInterface $users)
    {
        $this->users = $users;
    }

    public function index(Request $request)
    {
        $rpp = $request->input("rpp", 10);
        $users = $this->users->getUsers($rpp);
        return WPUserResource::collection($users);
    }

    public function show(int|string $id)
    {
        $user = $this->users->findByID($id);
        if (!$user) return response()->json(['message' => 'User Not Found!'], 404);

        return new WPUserResource($user);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string',
            'email' => 'required|email',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'website' => 'nullable|url',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ]);

        if ($this->users->isUsernameTaken($request->username)) {
            return response()->json(['message' => 'Username already exists'], 422);
        }
        if ($this->users->isEmailTaken($request->email)) {
            return response()->json(['message' => 'Email already exists'], 422);
        }

        $user = $this->users->create($validated);
        return response()->json([
            'message' => 'User created successfully',
            'user' => new WPUserResource($user),
        ], 201);
    }

    public function update(Request $request, int|string $id)
    {
        $validated = $request->validate([
            'username' => "required|string",
            'email' => "required|email",
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'website' => 'nullable|url',
            'password' => 'nullable|string|min:8',
            'role' => 'required|string',
        ]);

        if ($this->users->isUsernameTaken($request->username, $id)) {
            return response()->json(['message' => 'Username already exists'], 422);
        }
        if ($this->users->isEmailTaken($request->email, $id)) {
            return response()->json(['message' => 'Email already exists'], 422);
        }

        $exist = $this->users->findByID($id);
        if (!$exist) {
            return response()->json(['message' => 'User not found!'], 404);
        }

        $user = $this->users->update($id, $validated);
        return response()->json([
            'message' => 'User updated successfully',
            'user' => new WPUserResource($user),
        ]);
    }

    public function destroy(int|string $id)
    {
        $exist = $this->users->findByID($id);
        if (!$exist) {
            return response()->json(['message' => 'User not found!'], 404);
        }

        $this->users->delete($id);
        return response()->json(['message' => 'User deleted successfully']);
    }
}
