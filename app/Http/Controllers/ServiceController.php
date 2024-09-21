<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Exception;

class ServiceController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = Service::select(['id', 'service_name', 'sort_desc', 'image', 'status']);
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $editUrl = route('service-edit', ['id' => $row->id]);
                    $viewUrl = route('service-view', ['id' => $row->id]);

                    return '<div class="d-inline-block text-nowrap">
                                <a href="' . $viewUrl . '" class="btn btn-sm btn-icon btn-text-secondary waves-effect rounded-pill text-body me-1 view-button">
                                    <i class="ri-eye-line ri-22px"></i>
                                </a>
                                <a href="' . $editUrl . '" class="btn btn-sm btn-icon btn-text-secondary waves-effect rounded-pill text-body me-1 edit-button">
                                    <i class="ri-edit-box-line ri-22px"></i>
                                </a>
                                <a href="#" onclick="event.preventDefault(); deleteCategory(' . $row->id . ');"  class="btn btn-sm btn-icon btn-text-secondary waves-effect rounded-pill text-body me-1 delete-button" data-id="' . $row->id . '">
                                    <i class="ri-delete-bin-line ri-22px"></i>
                                </a>
                            </div>';
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('content.services.service-list');
    }


    public function create()
    {
        return view('content.services.service-add');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // not more than 2 MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $service = new Service();
        $service->service_name = $request->name;
        $service->sort_desc = $request->description;

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/' . $imageName;
            $image->move(public_path('images'), $imageName);
            $service->image = $imagePath;

        }

        $service->save();
        return redirect()->route('service-list')->with('success', 'Service added successfully!');
    }

    public function edit(Request $request, $id)
    {
        try {
            $editService = Service::findOrFail($id);
            return view('content.services.service-edit', compact('editService'));
        } catch (Exception $e) {
            return redirect()->route('service-list')->with('error', 'Something went wrong! Please try again.');

        }
    }


    public function destory(Request $request, $id)
    {
        try {
            $service = Service::findOrFail($id);
            if ($service->image && file_exists(public_path($service->image))) {
                unlink(public_path($service->image));
            }
            $service->delete();

            return redirect()->route('service-list')->with('success', 'Service deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('service-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',// not more than 2 MB
        ]);

        // Find the service by ID or fail
        $service = Service::findOrFail($id);

        // Prepare data to update the service
        $data = [
            'service_name' => $request->name,
            'sort_desc' => $request->description,
        ];

        // Handle the image upload
        if ($request->hasFile('image')) {
            // Check if there is an old image and if it exists, delete it
            if ($service->image && file_exists(public_path($service->image))) {
                unlink(public_path($service->image)); // Delete the previous image
            }

            // Process the new image
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/' . $imageName;

            // Move the new image to the images folder
            $image->move(public_path('images'), $imageName);

            // Add the new image path to the update data
            $data['image'] = $imagePath;
        }

        // Attempt to update the service in the database
        try {
            $service->update($data);
            return redirect()->route('service-list')->with('success', 'Service updated successfully!');
        } catch (Exception $e) {
            return redirect()->route('service-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $serviceStatus = Service::findOrFail($id);
            $serviceStatus->status = $request->status;
            $serviceStatus->save();

            return response()->json(['success' => 'User Status status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update User Status status.'], 500);
        }
    }
    public function view(Request $request, $id)
    {
        try {
            $viewService = Service::findOrFail($id);
            return view('content.services.service-view', compact('viewService'));
        } catch (Exception $e) {
            return redirect()->route('service-list')->with('error', 'Something went wrong! Please try again.');
        }
    }


}
