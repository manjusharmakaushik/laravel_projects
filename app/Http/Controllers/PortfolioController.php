<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use Exception;

class PortfolioController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = Portfolio::select(['id', 'project_name', 'sort_disc', 'project_complete_year','technology','project_image', 'status']);
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $editUrl = route('portfolio-edit', ['id' => $row->id]);
                    $viewUrl = route('portfolio-view', ['id' => $row->id]);
                    
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

        return view('content.portfolio.portfolio-list');
    }

    public function create()
    {
        return view('content.portfolio.portfolio-add');
    }
    public function store(Request $request)
    {
        
        // $validator = Validator::make($request->all(), [
        //     'project_name' => 'required|string|max:255',
        //     'sort_disc' => 'required|string|max:255',
        //     'project_complete_year' => 'required|numeric',
        //     'technology'=>'required|string|max:255',
        //     'project_image'=>'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            
        // ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'status' => 'error',
        //         'errors' => $validator->errors()
        //     ], 422);
        // }
        // dd($request->all());
        try {
            $portfolio = Portfolio::create([
                'project_name' => $request->project_name,
                'sort_disc' => $request->sort_disc,
                'project_complete_year' => $request->project_complete_year,
                'technology'=> $request->technology,
                'project_image'=> $request->project_image,
            ]);

            return response()->json(['success' => 'Portfolio successfully added!']);
        } catch (Exception $e) {

            return response()->json(['error', $e->getMessage()]);
        }
    }

    public function view(Request $request, $id)
    {
        try {
            $viewPortfolio = Portfolio::findOrFail($id);
            return view('content.portfolio.portfolio-view', compact('viewPortfolio'));
        } catch (Exception $e) {
            return redirect()->route('portfolio-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function edit(Request $request, $id)
    {
        try {
            $editPortfolio = Portfolio::findOrFail($id);
            return view('content.portfolio.portfolio-edit', compact('editPortfolio'));
        } catch (Exception $e) {
            return redirect()->route('portfolio-list')->with('error', 'Something went wrong! Please try again.');

        }
    }
    public function destory(Request $request, $id)
    {
        try {
            $deletePortfolio = Portfolio::findOrFail($id)->delete();
            return redirect()->route('portfolio-list')->with('success', 'Category Delete successfully added!');
        } catch (Exception $e) {
            return redirect()->route('portfolio-list')->with('error', 'Something went wrong! Please try again.');

        }
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'project_name' => 'required|string|max:255',
            'sort_disc' => 'required|string|max:255',
            'project_complete_year' => 'required|numeric',
            'technology'=>'required|string|max:255',
            'project_image'=>'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $data = $request->all();
        try {
            $updatePortfolio = Portfolio::find($id);
            $updatePortfolio->update($data);

            return response()->json(['success' => true, 'message' => 'Portfolio updated successfully!']);
        } catch (Exception $e) {
            return response()->json(['error' => false, 'message' => 'Something went wrong! Please try again.']);
        }
    }
    public function updatePortStatus(Request $request, $id)
    {
        try {
            $portfolioStatus = Portfolio::findOrFail($id);
            $portfolioStatus->status = $request->status;
            $portfolioStatus->save();

            return response()->json(['success' => 'Portfolio Status status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update Portfolio Status status.'], 500);
        }
    }
}
