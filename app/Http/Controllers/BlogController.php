<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Exception;

class BlogController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $data = Blog::select(['id', 'heading', 'short_desc','image', 'status']);
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $editUrl = route('blog-edit', ['id' => $row->id]);
                    $viewUrl = route('blog-view', ['id' => $row->id]);

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
   
        return view('content.blog.blog-list');
    }
    


    public function create()
    {
        return view('content.blog.blog-add');
    }
     


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'short_desc' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required|string'
        ]);
        $description = $request->input('description');
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $blog = new Blog();
        $blog->heading = $request->name;
        $blog->short_desc = $request->short_desc;
        $blog->description = $request->description;
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imagePath = 'images/' . $imageName;
            $image->move(public_path('images'), $imageName);
            $blog->image = $imagePath;
         }

        echo $blog->save();
        return redirect()->route('blog-list')->with('success', 'Blog Sector added successfully!');
    }   


    public function edit(Request $request, $id)
    {
        try {
            $editBlog = Blog::findOrFail($id);
            return view('content.blog.blog-edit', compact('editBlog'));
        } catch (Exception $e) {
            return redirect()->route('blog-list')->with('error', 'Something went wrong! Please try again.');

        }
    }
    
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
             'short_desc' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Find the blog by ID or fail
        $blog = Blog::findOrFail($id);

        // Prepare data to update the service
        $data = [
            'heading' => $request->name,
            'short_desc' => $request->short_desc,
            'description' => $request->description
            
        ];

        // Handle the image upload
        if ($request->hasFile('image')) {
            // Check if there is an old image and if it exists, delete it
            if ($blog->image && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image)); // Delete the previous image
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

        // Attempt to update the blog in the database
        try {
            $blog->update($data);
            return redirect()->route('blog-list')->with('success', 'Sector updated successfully!');
        } catch (Exception $e) {
            return redirect()->route('blog-list')->with('error', 'Something went wrong! Please try again.');
        }
    }



    public function destory(Request $request, $id)
    {
        try {
            $blog = Blog::findOrFail($id);
            if ($blog->image && file_exists(public_path($blog->image))) {
                unlink(public_path($blog->image));
            }
            $blog->delete();

            return redirect()->route('blog-list')->with('success', 'Blog deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('blog-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $blogStatus = Blog::findOrFail($id);
            $blogStatus->status = $request->status;
            $blogStatus->save();

            return response()->json(['success' => 'Sector Status status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update User Status status.'], 500);
        }
    }
    public function view(Request $request, $id)
    {
        try {
            $viewBlog = Blog::findOrFail($id);
            return view('content.blog.blog-view', compact('viewBlog'));
        } catch (Exception $e) {
            return redirect()->route('blog-list')->with('error', 'Something went wrong! Please try again.');
        }
    }







}
