<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Exception;

class ServiceSectorController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $data = Sector::select(['id', 'sector_name', 'image', 'status']);
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $editUrl = route('sector-edit', ['id' => $row->id]);
                    $viewUrl = route('sector-view', ['id' => $row->id]);

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
   
        return view('content.sector.sector-list');
    }
    


    public function create()
    {
        return view('content.sector.sector-add');
    }
     


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            // 'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $service = new Sector();
        $service->sector_name = $request->name;
        // $service->sort_desc = $request->description;

        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/' . $imageName;
            $image->move(public_path('images'), $imageName);
            $service->image = $imagePath;
         }

        $service->save();
        return redirect()->route('sector-list')->with('success', 'Service Sector added successfully!');
    }   


    public function edit(Request $request, $id)
    {
        try {
            $editSector = Sector::findOrFail($id);
            return view('content.sector.sector-edit', compact('editSector'));
        } catch (Exception $e) {
            return redirect()->route('sector-list')->with('error', 'Something went wrong! Please try again.');

        }
    }
    
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            // 'description' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the service by ID or fail
        $service = Sector::findOrFail($id);

        // Prepare data to update the service
        $data = [
            'sector_name' => $request->name
            
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
            return redirect()->route('sector-list')->with('success', 'Sector updated successfully!');
        } catch (Exception $e) {
            return redirect()->route('sector-list')->with('error', 'Something went wrong! Please try again.');
        }
    }



    public function destory(Request $request, $id)
    {
        try {
            $service = Sector::findOrFail($id);
            if ($service->image && file_exists(public_path($service->image))) {
                unlink(public_path($service->image));
            }
            $service->delete();

            return redirect()->route('sector-list')->with('success', 'Sector deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('sector-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $serviceStatus = Sector::findOrFail($id);
            $serviceStatus->status = $request->status;
            $serviceStatus->save();

            return response()->json(['success' => 'Sector Status status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update User Status status.'], 500);
        }
    }
    public function view(Request $request, $id)
    {
        try {
            $viewService = Sector::findOrFail($id);
            return view('content.sector.sector-view', compact('viewService'));
        } catch (Exception $e) {
            return redirect()->route('sector-list')->with('error', 'Something went wrong! Please try again.');
        }
    }







}
