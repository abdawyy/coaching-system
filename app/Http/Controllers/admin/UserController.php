<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Package;
use App\Models\UserWorkout;
use App\Models\UserFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\DataTableService;


class UserController extends Controller
{
    // List all users
    public function index()
    {
        $users = User::with(['package', 'workouts', 'files'])->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Show create form
    public function create()
    {
        $packages = Package::all();
        return view('admin.users.create', compact('packages'));
    }

    // Store user
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'mobile'   => 'nullable|string|max:20',
            'package_id' => 'nullable|exists:packages,id',
            'description' => 'nullable|string|max:1000',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'package_id' => $request->package_id,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    // Edit form
    public function edit($id)
    {
        $user = User::with(['package', 'workouts', 'files'])->findOrFail($id);
        $packages = Package::all();
        return view('admin.users.edit', compact('user', 'packages'));
    }

    // Update user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'mobile'   => 'nullable|string|max:20',
            'package_id' => 'nullable|exists:packages,id',
            'description' => 'nullable|string|max:1000',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'package_id' => $request->package_id,
            'description' => $request->description,
            'password' => !empty($request->password) ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    // Upload PDF or Excel for a user
    public function uploadFile(Request $request, $userId)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,xlsx,xls|max:10240',
            'description' => 'nullable|string|max:500',
        ]);

        $user = User::findOrFail($userId);
        $file = $request->file('file');
        $path = $file->store('user_files', 'public');

        UserFile::create([
            'user_id' => $user->id,
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
            'description' => $request->description,
        ]);

        return back()->with('success', 'File uploaded successfully.');
    }

    // Add workouts (multiple)
    public function addWorkouts(Request $request, $userId)
    {
        $request->validate([
            'workouts' => 'required|array|min:1',
            'workouts.*.title' => 'nullable|string|max:255',
            'workouts.*.link' => 'required|url|max:500',
            'workouts.*.description' => 'nullable|string|max:1000',
            'workouts.*.package_id' => 'nullable|exists:packages,id',
        ]);

        $user = User::findOrFail($userId);

        foreach ($request->workouts as $data) {
            UserWorkout::create([
                'user_id' => $user->id,
                'title' => $data['title'] ?? null,
                'link' => $data['link'],
                'description' => $data['description'] ?? null,
                'package_id' => $data['package_id'] ?? null,
            ]);
        }

        return back()->with('success', 'Workouts added successfully.');
    }

    // Delete a workout
    public function deleteWorkout($workoutId)
    {
        $workout = UserWorkout::findOrFail($workoutId);
        $workout->delete();

        return back()->with('success', 'Workout deleted successfully.');
    }
}
