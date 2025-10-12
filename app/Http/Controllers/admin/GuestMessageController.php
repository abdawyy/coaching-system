<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuestMessage;
use App\Models\User;
use Illuminate\Support\Str;

class GuestMessageController extends Controller
{
    // Show all guest messages in admin dashboard
    public function index()
    {
        $messages = GuestMessage::latest()->paginate(10);
        return view('admin.guest_messages.index', compact('messages'));
    }

    // Show form to create a guest message (optional)
    public function create()
    {
        return view('admin.guest_messages.create');
    }

    // Store a new guest message (can be from frontend or admin)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:20',
            'message' => 'required|string|max:2000',
        ]);

        GuestMessage::create($request->only('name', 'email', 'mobile', 'message'));

        return redirect()->route('admin.guest_messages.index')
                         ->with('success', 'Message sent successfully!');
    }

    // Delete a message
    public function destroy($id)
    {
        $message = GuestMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.guest_messages.index')
                         ->with('success', 'Message deleted successfully.');
    }

    // Convert guest message to user
    public function convertGuestToUser($guestId)
    {
        $guest = GuestMessage::findOrFail($guestId);

        $user = User::firstOrCreate(
            ['email' => $guest->email],
            [
                'name' => $guest->name ?? 'Guest',
                'password' => bcrypt(Str::random(10)),
                'mobile' => $guest->mobile,
            ]
        );

        $guest->user_id = $user->id;
        $guest->save();

        return redirect()->route('admin.guest_messages.index')
                         ->with('success', 'Guest converted to user successfully!');
    }
}
