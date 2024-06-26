<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Gender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['login', 'processLogin']);
    }
    
    // LOG IN

    public function login(){
        return view('login.index');
    }

    public function processLogin(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('username', $validated['username'])->first();

        if ($user && Hash::check($validated['password'], $user->password)) {
            Auth::login($user);

            if ($user->isAdmin()) {
                return redirect()->route('dashboard'); 
            } elseif ($user->isUser()) {
                return redirect()->route('store.index'); 
            }
        }

        throw ValidationException::withMessages([
            'password' => 'The username or password is incorrect.',
        ]);
    }


    public function processLogout(Request $request)
    {
        auth()->logout();
    
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    
        return redirect('/')
            ->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Sat, 01 Jan 2000 00:00:00 GMT',
            ]);
    }
    

    // INDEX
    public function index(Request $request)
    {
        $searchTerm = $request->input('searchTerm');

        $users = User::query();

        if ($searchTerm) {
            $users->where(function ($query) use ($searchTerm) {
                $query->where('first_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('user_id', 'like', '%' . $searchTerm . '%')
                    ->orWhere('middle_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('last_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('suffix_name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('username', 'like', '%' . $searchTerm . '%');
            })
                ->orWhereHas('gender', function ($query) use ($searchTerm) {
                    $query->where('gender', 'like', ucfirst($searchTerm));
                });
        }

        $users->orderBy('first_name')
            ->orderBy('middle_name')
            ->orderBy('last_name')
            ->orderBy('suffix_name')
            ->orderBy('username');

        $users = $users->paginate(9)->appends(['searchTerm' => $searchTerm]);

        return view('user.index', compact('users', 'searchTerm'));
    }

    // SHOW
    public function show($id)
    {
        $user = User::with('gender')->findOrFail($id);
        return view('user.show', compact('user'));
    }

    // CREATE
    public function create()
    {
        $genders = Gender::all();
        return view('user.create', compact('genders'));
    }

    // STORE
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required'],
            'middle_name' => ['required'],
            'last_name' => ['required'],
            'suffix_name' => ['nullable'],
            'birth_date' => ['required', 'date'],
            'gender_id' => ['required', 'integer'],
            'address' => ['required'],
            'contact_number' => ['required'],
            'email_address' => ['required', 'email'],
            'username' => ['required'],
            'password' => ['required'],
            'user_image' => ['nullable', 'mimes:jpg,png,jpeg,biff,bmp'],
            'role' => ['required', Rule::in(['admin', 'user'])],
        ]);

        $validated['first_name'] = Str::title($validated['first_name']);
        $validated['middle_name'] = Str::title($validated['middle_name']);
        $validated['last_name'] = Str::title($validated['last_name']);
        $validated['suffix_name'] = Str::title($validated['suffix_name']);
        $validated['address'] = Str::title($validated['address']);

        // Hash the password
        $validated['password'] = Hash::make($validated['password']);

        if ($request->hasFile('user_image')) {
            $filenameWithExtension = $request->file('user_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('user_image')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('user_image')->storeAs('public/img/user', $filenameToStore);
            $validated['user_image'] = $filenameToStore;
        }

        User::create($validated);

        return redirect('/user/list')->with('message_success', 'User successfully saved.');
    }

    // EDIT
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $genders = Gender::all();
        return view('user.edit', compact('user', 'genders'));
    }

    // UPDATE
    public function update(Request $request, User $user)
    {
        $request->validate([
            'first_name' => ['required'],
            'middle_name' => ['required'],
            'last_name' => ['required'],
            'suffix_name' => ['nullable'],
            'birth_date' => ['required', 'date'],
            'gender_id' => ['required', 'integer'],
            'address' => ['required'],
            'contact_number' => ['required'],
            'email_address' => ['required', 'email'],
            'username' => ['required'],
            'user_image' => ['nullable', 'mimes:jpg,png,jpeg,biff,bmp'],
        ]);

        $userData = [
            'first_name' => Str::title($request->input('first_name')),
            'middle_name' => Str::title($request->input('middle_name')),
            'last_name' => Str::title($request->input('last_name')),
            'suffix_name' => Str::title($request->input('suffix_name')),
            'birth_date' => $request->input('birth_date'),
            'gender_id' => $request->input('gender_id'),
            'address' => Str::title($request->input('address')),
            'contact_number' => $request->input('contact_number'),
            'email_address' => $request->input('email_address'),
            'username' => $request->input('username'),
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->input('password'));
        }

        if ($request->hasFile('user_image')) {
            $filenameWithExtension = $request->file('user_image')->getClientOriginalName();
            $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
            $extension = $request->file('user_image')->getClientOriginalExtension();
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            $request->file('user_image')->storeAs('public/img/user', $filenameToStore);
            $userData['user_image'] = $filenameToStore;

            if ($user->user_image && Storage::exists('public/img/user/' . $user->user_image)) {
                Storage::delete('public/img/user/' . $user->user_image);
                $userData['user_image'] = $filenameToStore;
            }
        }

        $user->update($userData);

        return redirect('/user/list')->with('message_success', 'User updated successfully');
    }

    // DELETE
    public function delete($id)
    {
        $user = User::find($id);

        return view('user.delete', compact('user'));
    }

    public function destroy(Request $request, User $user)
    {
        if ($user->user_image && Storage::exists('public/img/user/' . $user->user_image)) {
            Storage::delete('public/img/user/' . $user->user_image);
        }
        $user->delete();

        return redirect('/user/list')->with('message_success', 'User successfully deleted.');
    }

    // Dashboard for Admin
    public function dashboard()
    {
        // Logic for admin dashboard
        return view('dashboard');
    }

    // Store List for Regular User
    public function storeList()
    {
        // Logic for regular user's store listing view
        return view('store.list');
    }
}
