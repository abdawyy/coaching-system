<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserFile;
use App\Models\UserWorkout;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Show user dashboard with profile, workouts, and files
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
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully!');
    }

    // Upload one or multiple files
    public function uploadFiles(Request $request)
    {
        $request->validate([
            'files.*' => 'required|file|mimes:pdf,xlsx,xls|max:20480', // up to 20MB per file
            'descriptions.*' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $index => $file) {
                $path = $file->store('user_files', 'public');

                UserFile::create([
                    'user_id' => $user->id,
                    'file_path' => $path,
                    'file_type' => $file->getClientOriginalExtension(),
                    'description' => $request->descriptions[$index] ?? null,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Files uploaded successfully!');
    }

    // Show list of uploaded files
    public function myFiles()
    {
        $files = Auth::user()->files;
        return view('user.files', compact('files'));
    }

    // Download a file
    public function downloadFile($fileId)
    {
        $file = UserFile::where('id', $fileId)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        if (!Storage::disk('public')->exists($file->file_path)) {
            return redirect()->back()->with('error', 'File not found!');
        }

        return Storage::disk('public')->download($file->file_path);
    }

    // Delete uploaded file
    public function deleteFile($fileId)
    {
        $file = UserFile::where('id', $fileId)
                        ->where('user_id', Auth::id())
                        ->firstOrFail();

        // Delete physical file if exists
        if (Storage::disk('public')->exists($file->file_path)) {
            Storage::disk('public')->delete($file->file_path);
        }

        $file->delete();

        return redirect()->back()->with('success', 'File deleted successfully!');
    }

    // Show user workouts
    public function myWorkouts()
    {
        $workouts = Auth::user()->workouts()->with('package')->get();
        return view('user.workouts', compact('workouts'));
    }
}
