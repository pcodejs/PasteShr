<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Paste;
use App\Models\Report;
use Datatables;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index')->with('page_title', 'Reported Pastes');
    }

    public function destroy($id)
    {
        $report = Report::findOrfail($id);
        $report->delete();
        return redirect()->back()->withSuccess('Successfully deleted.');
    }

    public function get(Request $request)
    {
        if ($request->ajax()) {
            $reports = Report::select(['id', 'paste_id', 'user_id', 'reason', 'created_at']);
            return Datatables::of($reports)
                ->addColumn('check', function ($report) {
                    return '<input type="checkbox" class="check" name="check[]" value="' . $report->id . '" data-pid="' . $report->paste_id . '">';
                })
                ->addColumn('paste', function ($report) {
                    if (isset($report->paste)) {
                        return '<a target="_blank" href="' . $report->paste->url . '">' . $report->paste->title . '</a>';
                    } else {
                        return 'deleted paste';
                    }

                })
                ->editColumn('reason', function ($report) {
                    return '<a class="view_report" data-reason="' . $report->reason . '"><i class="fa fa-eye"></i> View</a>';
                })
                ->addColumn('user', function ($report) {
                    if (isset($report->user)) {
                        return '<a target="_blank" href="' . url('admin/users/' . $report->user->id . '/edit') . '">' . $report->user->name . '</a>';
                    } else {
                        return 'deleted user';
                    }

                })
                ->addColumn('action', function ($report) {
                    $action = '<a class="btn btn-sm btn-danger" href="' . url('admin/reported-pastes/' . $report->id . '/delete') . '"><i class="fa fa-trash"></i> Delete Report</a>';
                    if (isset($report->paste)) {
                        $action .= '<a class="btn btn-sm btn-danger ml-2" href="' . url('admin/pastes/' . $report->paste->id . '/delete') . '"><i class="fa fa-trash"></i> Delete paste</a>';
                    }

                    return $action;
                })
                ->make(true);
        }
    }

    public function deleteSelected(Request $request)
    {
        if (!empty($request->ids)) {
            $reports = Report::whereIn('id', $request->ids)->delete();
            echo "success";
        } else {
            echo "error";
        }
    }

}
