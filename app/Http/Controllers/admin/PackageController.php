<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; //
use App\Models\Package;
use Illuminate\Http\Request;
use App\Services\DataTables\BaseDataTable;


class PackageController extends Controller
{
    // Show all packages
 
      public function index()
    {
        $columns = ['id',   'name',
        'description',
        'price',
        'duration'];
        $renderComponents = true; // or false based on your condition
        $customActionsView = 'components.default-buttons-table'; // full view path

        return view('admin.packages.index', compact('columns', 'renderComponents', 'customActionsView'));
    }

  
    public function data(Request $request)
    {
        $query = Package::query();
 $columns = ['id',   'name',
        'description',
        'price',
        'duration'];
        $service = new BaseDataTable($query, $columns, true, 'components.default-buttons-table');
        // Optional: send extra props to the view (e.g. routeName)
        $service->setActionProps([
            'routeName' => 'admin.packages',
        ]);
        return $service->make($request);
    }

    // Show create form
    public function create()
    {
        return view('admin.packages.create');
    }

    // Store new package
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'duration'    => 'nullable|integer|min:1',
        ]);

        Package::create($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package created successfully.');
    }

    // Show edit form
    public function edit($id)
    {
        $package = Package::findOrFail($id);
        return view('admin.packages.edit', compact('package'));
    }

    // Update package
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'price'       => 'required|numeric|min:0',
            'duration'    => 'nullable|integer|min:1',
        ]);

        $package = Package::findOrFail($id);
        $package->update($validated);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package updated successfully.');
    }

    // Delete package
    public function destroy($id)
    {
        $package = Package::findOrFail($id);
        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package deleted successfully.');
    }
}
