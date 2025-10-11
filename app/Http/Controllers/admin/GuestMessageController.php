<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuestMessage;
use App\Models\User;
use Illuminate\Support\Str;

class GuestMessageController extends Controller
{
    // Store a guest message
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'mobile' => 'nullable|string|max:20',
            'message' => 'required|string|max:2000',
        ]);

        $guestMessage = GuestMessage::create($request->only('name','email','mobile','message'));

        return response()->json([
            'message' => 'Message sent successfully',
            'guestMessage' => $guestMessage,
        ]);
    }

    // List all messages (for admin)
    public function index()
    {
        $messages = GuestMessage::latest()->get();
        return response()->json($messages);
    }

    // Delete a message
    public function destroy($id)
    {
        $message = GuestMessage::findOrFail($id);
        $message->delete();

        return response()->json(['message' => 'Message deleted successfully']);
    }
    public function convertGuestToUser($guestId)
{
    $guest = GuestMessage::findOrFail($guestId);

    // If email exists, link to existing user
    $user = User::firstOrCreate(
        ['email' => $guest->email],
        [
            'name' => $guest->name ?? 'Guest',
            'password' => bcrypt(Str::random(10)), // random password
            'mobile' => $guest->mobile,
        ]
    );

    // Link guest message to this user
    $guest->user_id = $user->id;
    $guest->save();

    return response()->json([
        'message' => 'Guest converted to user successfully',
        'user' => $user,
        'guestMessage' => $guest
    ]);
}
}
