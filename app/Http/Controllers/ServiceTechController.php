<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\servicetechegory;
use App\Models\ServiceTech;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Exception;

class ServiceTechController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = ServiceTech::join('service_tech_categories','service_teches.service_id','=','service_tech_categories.service_id')->select(['service_id','id', 'name', 'image', 'status']);
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $editUrl = route('service-tech-edit', ['id' => $row->id]);
                    $viewUrl = route('service-tech-view', ['id' => $row->id]);

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

        return view('content.servicetech.servicetech-list');
    }


    public function create()
    {
        return view('content.servicetech.servicetech-add');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $servicetech = new ServiceTech();
        $servicetech->name = $request->name;

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/' . $imageName;
            $image->move(public_path('images'), $imageName);
            $servicetech->image = $imagePath;

        }

        $servicetech->save();
        return redirect()->route('service-tech-list')->with('success', 'Service Tech Category added successfully!');
    }

    public function edit(Request $request, $id)
    {
        try {
            $editServicetech = ServiceTech::findOrFail($id);
            return view('content.servicetech.servicetech-edit', compact('editServicetech'));
        } catch (Exception $e) {
            return redirect()->route('servicetech-list')->with('error', 'Something went wrong! Please try again.');

        }
    }


    public function destory(Request $request, $id)
    {
        try {
            $service = ServiceTech::findOrFail($id);
            if ($servicetech->image && file_exists(public_path($servicetech->image))) {
                unlink(public_path($servicetech->image));
            }
            $servicetech->delete();

            return redirect()->route('servicetech-list')->with('success', 'Service Tech Cat deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('servicetech-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the service by ID or fail
        $service = ServiceTech::findOrFail($id);

        // Prepare data to update the service
        $data = [
            'name' => $request->name,
        ];

        // Handle the image upload
        if ($request->hasFile('image')) {
            // Check if there is an old image and if it exists, delete it
            if ($servicetech->image && file_exists(public_path($servicetech->image))) {
                unlink(public_path($servicetech->image)); // Delete the previous image
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
            $servicetech->update($data);
            return redirect()->route('servicetech-list')->with('success', 'Service Tech Category updated successfully!');
        } catch (Exception $e) {
            return redirect()->route('servicetech-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $serviceStatus = ServiceTech::findOrFail($id);
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
            $viewServicetech = ServiceTech::findOrFail($id);
            return view('content.servicetech.servicetech-view', compact('viewServicetech'));
        } catch (Exception $e) {
            return redirect()->route('servicetech-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

}

