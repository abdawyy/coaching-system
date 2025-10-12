<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserFile;
use App\Models\UserWorkout;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // Show user dashboard (profile + workouts + files)
    public function profile()
    {
        $user = Auth::user()->load(['package', 'workouts', 'files']);
        return view('user.dashboard', compact('user'));
    }

    // Update profile info (name, mobile, password)
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'     => 'required|string|max:255',
            'mobile'   => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->mobile = $request->mobile ?? $user->mobile;

        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // Upload PDF or Excel file
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,xlsx,xls|max:10240',
            'description' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();
        $file = $request->file('file');
        $path = $file->store('user_files', 'public');

        UserFile::create([
            'user_id' => $user->id,
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully!');
    }

    // Show list of uploaded files
    public function myFiles()
    {
        $files = Auth::user()->files;
        return view('user.files', compact('files'));
    }

    // Show user workouts
    public function myWorkouts()
    {
        $workouts = Auth::user()->workouts()->with('package')->get();
        return view('user.workouts', compact('workouts'));
    }

    // Delete uploaded file
    public function deleteFile($fileId)
    {
        $file = UserFile::where('id', $fileId)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return redirect()->back()->with('success', 'File deleted successfully!');
    }
}
