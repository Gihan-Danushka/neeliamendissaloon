<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle user registration for both web and API
     */
    public function register(Request $request)
    {
        try {
            // Validate input
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'phone_number' => 'required|string|max:20',
                'role' => 'required|string|in:admin,user',
                'password' => 'required|string|min:8|confirmed',
            ]);
            
            // Create the user
            $user = User::create([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone_number' => $request->input('phone_number'),
                'role' => $request->input('role'),
                'password' => Hash::make($request->input('password')),
            ]);

            // Generate API token
            // $token = Str::random(60);
            // $user->api_token = hash('sha256', $token);
            // $user->save();

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Registration successful',
                    //'token' => $token,
                    'user' => $user,
                ], 201);
            }

            return redirect()->route('login')->with('success', 'Registration successful');
        } catch (Exception $e) {
            return $this->handleException($e, $request);
        }
    }

    /**
     * Handle login for both web and API
     * 
        */
  public function login(Request $request)
    {
        try {
            // Validate incoming request
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            // Attempt to authenticate the user
            $credentials = $request->only('email', 'password');

            if (Auth::attempt($credentials)) {
                /** @var \App\Models\User $user */
                $user = Auth::user();

                
                if ($user->status !== 'active') {
                    Auth::logout(); // destroy session

                    if ($request->wantsJson()) {
                        return response()->json([
                            'message' => 'Your account does not exist.',
                        ], 403);
                    }

                    return back()
                        ->withErrors(['email' => 'Your account does not exist.'])
                        ->withInput($request->only('email'));
                }

                if ($request->wantsJson()) {
                    $token = $user->createToken($request->userAgent() ?? 'device')->plainTextToken;

                    return response()->json([
                        'message' => 'Login successful',
                        'user' => $user,
                        'access_token' => $token,
                        'token_type' => 'Bearer',
                    ], 200);
                }

                if ($user->role === 'admin') {
                    return redirect()->route('dashboard')->with('success', 'Welcome back, Admin!');
                }

                return redirect()->route('bookings.create')->with('success', 'Welcome back!');
            }

            // Handle failed login
            return $this->handleAuthFailure($request);

        } catch (Exception $e) {
            return $this->handleException($e, $request);
        }
    }
    /**
     * Display user profile for both web and API
     */
    public function profileView(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return $this->handleNotFound('User not found', $request);
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'User profile retrieved successfully.',
                    'user' => $user,
                ], 200);
            }

            return view('user.profile', ['user' => $user]);
        } catch (Exception $e) {
            return $this->handleException($e, $request);
        }
    }

    /**
     * Update user profile for both web and API
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return $this->handleNotFound('User not found', $request);
            }

            $request->validate([
                'first_name' => 'sometimes|string|max:255',
                'last_name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
                'phone_number' => 'sometimes|string|max:20',
                'role' => 'sometimes|string|in:admin,user',
                'password' => 'sometimes|string|min:8|confirmed',
            ]);

            $user->update($request->only(['first_name', 'last_name', 'email', 'phone_number', 'role']));
            
            if ($request->filled('password')) {
                $user->password = Hash::make($request->input('password'));
                $user->save();
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'User updated successfully!',
                    'user' => $user,
                ], 200);
            }

            return redirect()->route('profile', ['id' => $id])->with('success', 'Profile updated successfully');
        } catch (Exception $e) {
            return $this->handleException($e, $request);
        }
    }

    /**
     * Delete user by ID for both web and API
     */
    public function destroy($id, Request $request)
    {
        try {
            $user = User::find($id);
            
            if (!$user) {
                return $this->handleNotFound('User not found', $request);
            }

            //Make user inactive instead of deleting
            $user->status = 'inactive';
            $user->save();
            $user->tokens()->delete();//revoke API tokens too (Sanctum)

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Account Deletion successfully.',
                ], 200);
            }

            return redirect()->route('users.index')->with('success', 'Account Deletion successfully');
        } catch (Exception $e) {
            return $this->handleException($e, $request);
        }
    }


    /**
     * Retrieve all users for both web and API
     */
    public function allUsers(Request $request)
    {
        try {
            $users = User::all();

            if ($users->isEmpty()) {
                return $this->handleNotFound('No users found', $request);
            }

            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Users retrieved successfully.',
                    'users' => $users,
                ], 200);
            }

            return view('user.index', ['users' => $users]);
        } catch (Exception $e) {
            return $this->handleException($e, $request);
        }
    }

    /**
     * Handle failed authentication
     */
    protected function handleAuthFailure(Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }

        return back()->withErrors(['login' => 'Invalid credentials']);
    }

    /**
     * Handle not found cases
     */
    protected function handleNotFound($message, Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => $message,
            ], 404);
        }

        return redirect()->back()->with('error', $message);
    }

    /**
     * Handle exception and return response
     */
    protected function handleException(Exception $e, Request $request)
    {
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'An error occurred.',
                'error' => $e->getMessage(),
            ], 500);
        }

        return back()->with('error', $e->getMessage());
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerate();

        if($request->wantsJson()){
            $user=$request->user();
            if ($user) {
            $user->api_token = null;
            $user->save();
        }

        return response()->json(['message' => 'Logged out successfully'], 200);

        }
       return redirect()->route('login')->with('success', 'Logged out successfully');
    }
}
