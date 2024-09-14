<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Exception;

class TestimonialController extends Controller
{
    // Testimonial Index View with DataTables
    public function index()
    {
        if (request()->ajax()) {
            $testimonialList = Testimonial::select(['id', 'testimonial_name', 'sort_desc', 'testimonial_image', 'status']);
            return DataTables::of($testimonialList)
                ->addIndexColumn()
                ->addColumn('testimonial_image', function ($row) {
                    $imageUrl = asset('testimonial_image/' . $row->testimonial_image);
                    return $row->testimonial_image ? '<img src="' . $imageUrl . '" alt="Testimonial Image" style="width: 100px; height: auto;">' : '-';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('testimonial-edit', ['id' => $row->id]);
                    $viewUrl = route('testimonial-view', ['id' => $row->id]);

                    return '<div class="d-inline-block text-nowrap">
                                <a href="' . $viewUrl . '" class="btn btn-sm btn-icon btn-text-secondary waves-effect rounded-pill text-body me-1 view-button">
                                    <i class="ri-eye-line ri-22px"></i>
                                </a>
                                <a href="' . $editUrl . '" class="btn btn-sm btn-icon btn-text-secondary waves-effect rounded-pill text-body me-1 edit-button">
                                    <i class="ri-edit-box-line ri-22px"></i>
                                </a>
                                <a href="#" onclick="event.preventDefault(); deleteTestimonial(' . $row->id . ');" class="btn btn-sm btn-icon btn-text-secondary waves-effect rounded-pill text-body me-1 delete-button" data-id="' . $row->id . '">
                                    <i class="ri-delete-bin-line ri-22px"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['testimonial_image', 'status', 'action'])
                ->make(true);
        }

        return view('content.testimonial.list');
    }

    // Create Testimonial View
    public function create()
    {
        return view('content.testimonial.create');
    }

    // Show Testimonial Details
    public function show($id)
    {
        try {
            $viewTestimonial = Testimonial::findOrFail($id);
            return view('content.testimonial.view', compact('viewTestimonial'));
        } catch (Exception $e) {
            return redirect()->route('testimonial-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    // Edit Testimonial View
    public function edit($id)
    {
        try {
            $editTestimonial = Testimonial::findOrFail($id);
            return view('content.testimonial.edit', compact('editTestimonial'));
        } catch (Exception $e) {
            return redirect()->route('testimonial-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    // Store New Testimonial
    public function store(Request $request)
    {
        $request->validate([
            'testimonial_name' => 'required|string|max:255',
            'sort_desc' => 'required|string|max:255',
            'testimonial_image' => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $testimonial_imagePath = null;

        if ($request->hasFile('testimonial_image')) {
            $file = $request->file('testimonial_image');
            $testimonial_image = $file->getClientOriginalName();
            $testimonial_imagePath = time() . '_image_' . $testimonial_image;
            $file->move('testimonial_image', $testimonial_imagePath);
            
            $insertData = Testimonial::create([
                'testimonial_name' => $request->testimonial_name,
                'sort_desc' => $request->sort_desc,
                'testimonial_image' => $testimonial_imagePath,
                
            ]);

            if ($insertData) {
                return response()->json(['success' => 'Testimonial successfully added!']);
            } else {
                return response()->json(['error' => 'Something went wrong! Please try again.'], 500);
            }
        }
    }

    // Update Existing Testimonial
    public function update(Request $request, $id)
    {
        $request->validate([
            'testimonial_name' => 'required|string|max:255',
            'sort_desc' => 'required|string|max:255',
            'testimonial_image' => 'image|mimes:jpeg,png,jpg,gif',
        ]);

        try {
            $updateTestimonial = Testimonial::findOrFail($id);
            $testimonial_imagePath = $updateTestimonial->testimonial_image;

            if ($request->hasFile('testimonial_image')) {
                if ($testimonial_imagePath && file_exists(public_path('testimonial_image/' . $testimonial_imagePath))) {
                    unlink(public_path('testimonial_image/' . $testimonial_imagePath));
                }

                $file = $request->file('testimonial_image');
                $testimonial_image = $file->getClientOriginalName();
                $testimonial_imagePath = time() . '_image_' . $testimonial_image;
                $file->move('testimonial_image', $testimonial_imagePath);
            }

        
            return redirect()->route('testimonial-list')->with('success', 'Testimonial updated successfully!');
        } catch (Exception $e) {
            return redirect()->route('testimonial-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    // Delete Testimonial
    public function destroy($id)
    {
        try {
            $testimonial = Testimonial::findOrFail($id);
            $testimonial_imagePath = public_path('testimonial_image/' . $testimonial->testimonial_image);

            $testimonial->delete();

            if (file_exists($testimonial_imagePath)) {
                unlink($testimonial_imagePath);
            }

            return redirect()->route('testimonial-list')->with('success', 'Testimonial deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('testimonial-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    // Update Testimonial Status (Active/Inactive)
    public function updateStatus(Request $request, $id)
    {
        try {
            $testimonialStatus = Testimonial::findOrFail($id);
            $testimonialStatus->status = $request->status;
            $testimonialStatus->save();

            return response()->json(['success' => 'Testimonial status updated successfully.']);
        } catch (Exception $e)   {
            return response()->json(['error' => 'Failed to update client status.'], 500);
        }
    }
}

