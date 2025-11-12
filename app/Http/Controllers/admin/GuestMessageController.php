<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\GuestMessage;
use App\Models\User;
use Illuminate\Support\Str;
use App\Services\DataTables\BaseDataTable;
use Illuminate\Support\Facades\Hash;



class GuestMessageController extends Controller
{
    // Show all guest messages in admin dashboard

    public function index()
    {
        $columns = [
            'id',
            'name',
            'email',
            'mobile',
            'message'
        ];
        $renderComponents = true; // or false based on your condition
        $customActionsView = 'components.default-buttons-table'; // full view path

        return view('admin.guest.index', compact('columns', 'renderComponents', 'customActionsView'));
    }


    public function data(Request $request)
    {
        $query = GuestMessage::query();
        $columns = [
            'id',
            'name',
            'email',
            'mobile',
            'message'
        ];
        $service = new BaseDataTable($query, $columns, true, 'components.default-buttons-table');
        // Optional: send extra props to the view (e.g. routeName)
        $service->setActionProps([
            'routeName' => 'admin.guest',
        ]);
        return $service->make($request);
    }



    // Convert guest message to user
    public function convertGuestToUser($guestId)
    {
        $guest = GuestMessage::findOrFail($guestId);

        $user = User::firstOrCreate(
            ['email' => $guest->email],
            [
                'name' => $guest->name ?? 'Guest',
                'password' => Hash::make('Admin123'),
                'mobile' => $guest->mobile,
            ]
        );

        $guest->user_id = $user->id;
        $guest->save();

        return redirect()->route('admin.guests.index')
            ->with('success', 'Guest converted to user successfully!');
    }
}
