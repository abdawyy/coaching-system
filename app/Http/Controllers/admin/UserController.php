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

class UserController extends Controller
{
    // Show all users
    public function index()
    {
        $users = User::with(['package', 'workouts', 'files'])->latest()->get();
        return response()->json($users);
    }

    // Create user form
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
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'package_id' => $request->package_id,
        ]);

        return response()->json(['message' => 'User created successfully', 'user' => $user]);
    }

    // Update user info
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'mobile'   => 'nullable|string|max:20',
            'package_id' => 'nullable|exists:packages,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile ?? $user->mobile,
            'package_id' => $request->package_id ?? $user->package_id,
            'password' => !empty($request->password) ? Hash::make($request->password) : $user->password,
        ]);

        return response()->json(['message' => 'User updated successfully', 'user' => $user]);
    }

    // Delete user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }

    // Upload PDF or Excel file for a user
    public function uploadFile(Request $request, $userId)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,xlsx,xls|max:10240',
            'description' => 'nullable|string|max:500',
        ]);

        $user = User::findOrFail($userId);
        $file = $request->file('file');

        $path = $file->store('user_files', 'public');

        $userFile = UserFile::create([
            'user_id' => $user->id,
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
            'description' => $request->description,
        ]);

        return response()->json([
            'message' => 'File uploaded successfully',
            'file' => $userFile,
        ]);
    }

    // Add multiple workout links for a user
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
        $created = [];

        foreach ($request->workouts as $data) {
            $created[] = UserWorkout::create([
                'user_id' => $user->id,
                'title' => $data['title'] ?? null,
                'link' => $data['link'],
                'description' => $data['description'] ?? null,
                'package_id' => $data['package_id'] ?? null,
            ]);
        }

        return response()->json([
            'message' => 'Workouts added successfully',
            'workouts' => $created,
        ]);
    }

    // Get all workouts for a user
    public function getWorkouts($userId)
    {
        $user = User::with(['workouts.package'])->findOrFail($userId);
        return response()->json($user->workouts);
    }

    // Delete a workout
    public function deleteWorkout($workoutId)
    {
        $workout = UserWorkout::findOrFail($workoutId);
        $workout->delete();

        return response()->json(['message' => 'Workout deleted successfully']);
    }
}
