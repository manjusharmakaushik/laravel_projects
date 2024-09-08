<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Exception;

class UserController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $data = User::select(['id', 'name', 'email', 'number', 'status']);
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $editUrl = route('user-edit', ['id' => $row->id]);
                    $viewUrl = route('user-view', ['id' => $row->id]);

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

        return view('content.users.user-list');
    }

    public function create()
    {
        return view('content.users.user-add');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'number' => 'required|numeric',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'number' => $request->number,
                'password' => Hash::make($request->password),
            ]);

            return response()->json(['success' => 'User successfully added!']);
        } catch (Exception $e) {

            return response()->json(['error', $e->getMessage()]);
        }
    }

    public function view(Request $request, $id)
    {
        try {
            $viewUser = User::findOrFail($id);
            return view('content.users.user-view', compact('viewUser'));
        } catch (Exception $e) {
            return redirect()->route('user-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $editUser = User::findOrFail($id);
            return view('content.users.user-edit', compact('editUser'));
        } catch (Exception $e) {
            return redirect()->route('user-list')->with('error', 'Something went wrong! Please try again.');

        }
    }
    public function destory(Request $request, $id)
    {
        try {
            $deleteUser = User::findOrFail($id)->delete();
            return redirect()->route('user-list')->with('success', 'Category Delete successfully added!');
        } catch (Exception $e) {
            return redirect()->route('user-list')->with('error', 'Something went wrong! Please try again.');

        }
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'number' => 'required|string|max:10',
            'password' => 'sometimes|required|string|min:8',
        ]);

        $data = $request->all();
        try {
            $updateUser = User::find($id);
            $updateUser->update($data);

            return response()->json(['success' => true, 'message' => 'User updated successfully!']);
        } catch (Exception $e) {
            return response()->json(['error' => false, 'message' => 'Something went wrong! Please try again.']);
        }
    }
    public function updateStatus(Request $request, $id)
    {
        try {
            $userStatus = User::findOrFail($id);
            $userStatus->status = $request->status;
            $userStatus->save();

            return response()->json(['success' => 'User Status status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update User Status status.'], 500);
        }
    }

}
