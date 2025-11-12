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
use App\Services\DataTables\BaseDataTable;


class UserController extends Controller
{
    public function index()
    {
        $columns = ['id', 'name', 'email', 'created_at'];
        $renderComponents = true;
        $customActionsView = 'components.default-buttons-table'; // Reuse your generic component

        return view('admin.users.index', compact('columns', 'renderComponents', 'customActionsView'));
    }

    public function data(Request $request)
    {
        $query = User::query();
        $columns = ['id', 'name', 'email', 'created_at'];

        $service = new BaseDataTable($query, $columns, true, 'components.default-buttons-table');
        $service->setActionProps([
            'routeName' => 'admin.users',
        ]);
        return $service->make($request);
    }
    // Show create form
    public function create()
    {
        $packages = Package::all();
        return view('admin.users.create', compact('packages'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'nullable|string|min:6',
            'mobile' => 'nullable|string|max:20',
            'package_id' => 'nullable|exists:packages,id',
            'description' => 'nullable|string|max:1000',
            'files.*' => 'nullable|file|mimes:pdf,xlsx,xls|max:40480', // 40MB
            'workouts' => 'nullable|array',
            'workouts.*.link' => 'nullable|url',
            'workouts.*.title' => 'nullable|string|max:255',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password ?? 'Admin123'),
            'mobile' => $request->mobile,
            'package_id' => $request->package_id,
            'description' => $request->description,
        ]);

        // ✅ Handle multiple file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('user_files', 'public');
                UserFile::create([
                    'user_id' => $user->id,
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'description' => null, // optional: you can map an array for file descriptions if needed
                ]);
            }
        }

        // ✅ Add workouts
        if ($request->filled('workouts')) {
            foreach ($request->workouts as $workout) {
                if (!empty($workout['link'])) {
                    UserWorkout::create([
                        'user_id' => $user->id,
                        'title' => $workout['title'] ?? null,
                        'link' => $workout['link'],
                        'description' => $workout['description'] ?? null,
                        'package_id' => $workout['package_id'] ?? null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }


    public function edit($id)
    {
        $user = User::with(['package', 'workouts', 'files'])->findOrFail($id);
        $packages = Package::all();
        return view('admin.users.edit', compact('user', 'packages'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'mobile' => 'nullable|string|max:20',
            'package_id' => 'nullable|exists:packages,id',
            'description' => 'nullable|string|max:1000',
            'files.*' => 'nullable|file|mimes:pdf,xlsx,xls|max:40480', // 40MB
            'workouts' => 'nullable|array',
            'workouts.*.link' => 'nullable|url',
            'workouts.*.title' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'package_id' => $request->package_id,
            'description' => $request->description,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        // ✅ Handle multiple file uploads
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('user_files', 'public');
                UserFile::create([
                    'user_id' => $user->id,
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'description' => null,
                ]);
            }
        }

        // ✅ Update workouts: optional, you can delete old ones or add new ones
        if ($request->filled('workouts')) {
            foreach ($request->workouts as $workout) {
                if (!empty($workout['link'])) {
                    UserWorkout::updateOrCreate(
                        ['user_id' => $user->id, 'link' => $workout['link']], // unique key
                        [
                            'title' => $workout['title'] ?? null,
                            'description' => $workout['description'] ?? null,
                            'package_id' => $workout['package_id'] ?? null,
                        ]
                    );
                }
            }
        }

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function deleteWorkout($workoutId)
    {
        $workout = UserWorkout::findOrFail($workoutId);
        $workout->delete();

        return back()->with('success', 'Workout deleted successfully.');
    }
    public function deleteFile($fileId)
    {
        $file = UserFile::findOrFail($fileId);

        // Delete the physical file from storage
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        // Delete the database record
        $file->delete();

        return back()->with('success', 'File deleted successfully.');
    }

    // Delete user
    // public function destroy($id)
    // {
    //     $user = User::findOrFail($id);
    //     $user->delete();

    //     return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    // }

    // Upload PDF or Excel for a user

}
