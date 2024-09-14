<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceTechCategory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Exception;

class ServiceTechCategoryController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = ServiceTechCategory::select(['service_id', 'servicetech_name', 'image', 'status']);
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $editUrl = route('service-tech-cat-edit', ['id' => $row->service_id]);
                    $viewUrl = route('service-tech-cat-view', ['id' => $row->service_id]);

                    return '<div class="d-inline-block text-nowrap">
                                <a href="' . $viewUrl . '" class="btn btn-sm btn-icon btn-text-secondary waves-effect rounded-pill text-body me-1 view-button">
                                    <i class="ri-eye-line ri-22px"></i>
                                </a>
                                <a href="' . $editUrl . '" class="btn btn-sm btn-icon btn-text-secondary waves-effect rounded-pill text-body me-1 edit-button">
                                    <i class="ri-edit-box-line ri-22px"></i>
                                </a>
                                <a href="#" onclick="event.preventDefault(); deleteCategory(' . $row->service_id . ');"  class="btn btn-sm btn-icon btn-text-secondary waves-effect rounded-pill text-body me-1 delete-button" data-id="' . $row->service_id . '">
                                    <i class="ri-delete-bin-line ri-22px"></i>
                                </a>
                            </div>';
                })

                ->rawColumns(['status', 'action'])
                ->make(true);
        }

        return view('content.servicetechcat.servicetechcat-list');
    }


    public function create()
    {
        return view('content.servicetechcat.servicetechcat-add');
    }
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'servicetech_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $servicetechcat = new ServiceTechCategory();
        $servicetechcat->servicetech_name = $request->servicetech_name;

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/' . $imageName;
            $image->move(public_path('images'), $imageName);
            $servicetechcat->image = $imagePath;

        }

        $servicetechcat->save();
        return redirect()->route('service-tech-cat-list')->with('success', 'Service Tech Category added successfully!');
    }

    public function edit(Request $request, $id)
    {
        try {
            $editServicetechcat = ServiceTechCategory::findOrFail($id);
            return view('content.servicetechcat.servicetechcat-edit', compact('editServicetechcat'));
        } catch (Exception $e) {
            return redirect()->route('service-tech-cat-list')->with('error', 'Something went wrong! Please try again.');

        }
    }


    public function destory(Request $request, $id)
    {
        try {
            $deleteCategory = ServiceTechCategory::findOrFail($id)->delete();
            // if ($servicetechcat->image && file_exists(public_path($servicetechcat->image))) {
            //     unlink(public_path($servicetechcat->image));
            // }
            // $servicetechcat->delete();

            return redirect()->route('service-tech-cat-list')->with('success', 'Service Tech Cat deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('service-tech-cat-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'servicetech_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        // Find the service by ID or fail
        $servicetechcat = ServiceTechCategory::findOrFail($id);

        // Prepare data to update the service
        // $data = [
        //     'servicetech_name' => $request->name,
        // ];

        // Handle the image upload
        if ($request->hasFile('image')) {
            // Check if there is an old image and if it exists, delete it
            if ($servicetechcat->image && file_exists(public_path($servicetechcat->image))) {
                unlink(public_path($servicetechcat->image)); // Delete the previous image
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
            $servicetechcat = ServiceTechCategory::findOrFail($id);
            $servicetechcat->update($data);
            return redirect()->route('service-tech-cat-list')->with('success', 'Service Tech Category updated successfully!');
        } catch (Exception $e) {
            return redirect()->route('service-tech-cat-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $serviceStatus = ServiceTechCategory::findOrFail($id);
            $serviceStatus->status = $request->status;
            $serviceStatus->save();

            return response()->json(['success' => 'User Status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update User Status.'], 500);
        }
    }
    public function view(Request $request, $id)
    {
        try {
            $viewServicetechcat = ServiceTechCategory::findOrFail($id);
            return view('content.servicetechcat.servicetechcat-view', compact('viewServicetechcat'));
        } catch (Exception $e) {
            return redirect()->route('service-tech-cat-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

}
