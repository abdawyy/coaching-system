<?php
namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Models\GuestMessage;
use App\Http\Controllers\Controller; // ✅ Make sure this line exists


class GuestMessageController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|max:150',
            'mobile'  => 'required|string|max:20',
            'message' => 'required|string|max:2000',
        ]);

        GuestMessage::create($validated);

        return back()->with('success', __('Your message has been sent successfully!'));
    }
}
