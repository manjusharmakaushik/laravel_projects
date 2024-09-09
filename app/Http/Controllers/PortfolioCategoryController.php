<?php

namespace App\Http\Controllers;

use App\Models\PortfolioCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Exception;

class PortfolioCategoryController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $data = PortfolioCategory::select(['id', 'category_name', 'category_image', 'status', 'status']);
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('action', function ($row) {
                    $editUrl = route('portfolio-cat-edit', ['id' => $row->id]);
                    $viewUrl = route('portfolio-cat-view', ['id' => $row->id]);

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

        return view('content.portfolio-category.list');
    }

    public function create()
    {
        return view('content.portfolio-category.create');
    }

    public function view(Request $request, $id)
    {
        try {
            $viewPortfolioCategory = PortfolioCategory::findOrFail($id);
            return view('content.portfolio-category.view', compact('viewPortfolioCategory'));
        } catch (Exception $e) {
            return redirect()->route('user-list')->with('error', 'Something went wrong! Please try again.');
        }
    }

    public function destory(Request $request, $id)
    {
        try {
            $deletePortfolioCategory = PortfolioCategory::findOrFail($id)->delete();
            return redirect()->route('portfolio-cat-list')->with('success', 'Portfolio Category successfully added!');
        } catch (Exception $e) {
            return redirect()->route('portfolio-cat-list')->with('error', 'Something went wrong! Please try again.');

        }
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $portfolioCategoryStatus = PortfolioCategory::findOrFail($id);
            $portfolioCategoryStatus->status = $request->status;
            $portfolioCategoryStatus->save();

            return response()->json(['success' => 'Portfolio Category status updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update Portfolio Category  status.'], 500);
        }
    }
}
