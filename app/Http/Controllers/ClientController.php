<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Exception;

class ClientController extends Controller
{
    // Client Index View with DataTables
    public function index()
    {
        if (request()->ajax()) {
            $clientList = Client::select(['id', 'client_name', 'sort_desc', 'client_image', 'status']);
            return DataTables::of($clientList)
                ->addIndexColumn()
                ->addColumn('client_image', function ($row) {
                    $imageUrl = asset('client_image/' . $row->client_image);
                    return $row->client_image ? '<img src="' . $imageUrl . '" alt="Client Image" style="width: 100px; height: auto;">' : '-';
                })
                
                ->addColumn('action', function ($row) {
                    $editUrl = route('client-edit', ['id' => $row->id]);
                    $viewUrl = route('client-view', ['id' => $row->id]);

                    return '<div class="d-inline-block text-nowrap">
                                <a href="' . $viewUrl . '" class="btn btn-sm btn-icon btn-text-secondary waves-effect rounded-pill text-body me-1 view-button">
                                    <i class="ri-eye-line ri-22px"></i>
                                </a>
                                <a href="' . $editUrl . '" class="btn btn-sm btn-icon btn-text-secondary waves-effect rounded-pill text-body me-1 edit-button">
                                    <i class="ri-edit-box-line ri-22px"></i>
                                </a>
                                <a href="#" onclick="event.preventDefault(); deleteClient(' . $row->id . ');"  class="btn btn-sm btn-icon btn-text-secondary waves-effect rounded-pill text-body me-1 delete-button" data-id="' . $row->id . '">
                                    <i class="ri-delete-bin-line ri-22px"></i>
                                </a>
                            </div>';
                })
                ->rawColumns([ 'client_image','status', 'action'])
                ->make(true);
        }

        return view('content.client.list');
    }

    // Create Client View
    public function create()
    {
        return view('content.client.create');
    }

    // Show Client Details
    public function show($id)
    {
        try {
            $viewClient = Client::findOrFail($id);
            return view('content.client.view', compact('viewClient'));
        } catch (Exception $e) {
            return redirect()->route('client-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    // Edit Client View
    public function edit($id)
    {
        try {
            $editClient = Client::findOrFail($id);
            return view('content.client.edit', compact('editClient'));
        } catch (Exception $e) {
            return redirect()->route('client-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    // Store New Client
    public function store(Request $request)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'sort_desc' => 'required|string|max:255',
            'client_image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $client_imagePath = null;

        if ($request->hasFile('client_image')) {
            $file = $request->file('client_image');
            $client_image = $file->getClientOriginalName();
            $client_imagePath = time() . '_image_' . $client_image;
            $file->move('client_image', $client_imagePath);
            
            $insertData = Client::create([
                'client_name' => $request->client_name,
                'sort_desc' => $request->sort_desc,
                'client_image' => $client_imagePath,
                
            ]);
            if ($insertData) {
                return response()->json(['success' => 'Client successfully added!']);
            } else {
                return response()->json(['error' => 'Something went wrong! Please try again.'], 500);
            }
        }
    }
    // Update Existing Client
    public function update(Request $request, $id)
    {
        $request->validate([
            'client_name' => 'required|string|max:255',
            'sort_desc' => 'required|string|max:255',
            'client_image' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        try {
            // Find the group by ID
            $updateClient = Client::findOrFail($id);

            // Initialize variables for file paths
            $client_imagePath = $updateClient->client_image;
            

            // Handle group image upload
            if ($request->hasFile('client_image')) {
                // Delete the old image if it exists
                if ($client_imagePath && file_exists(public_path('client_image/' . $client_imagePath))) {
                    unlink(public_path('client_image/' . $client_imagePath));
                }

                // Store the new image
                $file = $request->file('client_image');
                $client_image = $file->getClientOriginalName();
                $client_imagePath = time() . '_image_' . $client_image;
                $file->move('client_image', $client_imagePath);
            }

            return redirect()->route('client-list')->with('success', 'Client updated successfully!');
        } catch (Exception $e) {
            return redirect()->route('client-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    // Delete Client
    public function destroy($id)
    {try {
        // Find the group by ID
        $client = Client::findOrFail($id);

        $client_imagePath = public_path('client_image/' . $client->client_image);
       

        $client->delete();

        if (file_exists($client_imagePath)) {
            unlink($client_imagePath);
        }
    
            return redirect()->route('client-list')->with('success', 'Client deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('client-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    // Update Client Status (Active/Inactive)
    public function updateStatus(Request $request, $id)
    {
        try {
            $clientStatus = Client::findOrFail($id);
            $clientStatus->status = $request->status;
            $clientStatus->save();

            return response()->json(['success' => 'Client status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update client status.'], 500);
        }
    }
}
