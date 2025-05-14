<?php

namespace Modules\Library\App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Helpers\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Library;
use App\Models\LibraryIssue;
use App\Models\LibraryReturn;
use App\Models\LibraryStock;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IssueController extends Controller
{
    use ValidatesRequests;

    public function index(Request $request): View
    {
        $title = ucwords($request->get('type', 'All'), '_') . ' Issues';
        $issues = LibraryIssue::with(['item', 'member', 'stock'])->filter($request)->orderBy('id', 'desc')->get();
        return view('library::library.issue.index', compact('issues', 'title'));
    }

    public function create(Request $request): View
    {
        $data['item'] = ($request->filled('id')) ? Library::find($request->input('id')) : '';
        $data['type'] = ($data['item']) ? $data['item']->type : '';
        $data['title'] = ($data['item']) ? 'New ' . ucfirst($data['item']->type) . ' Issue' : 'New Issue';
        return view('library::library.issue.create', $data);
    }

    public function takeReturn(Request $request, LibraryIssue $issue): JsonResponse
    {
        try {
            DB::transaction(function () use ($request, $issue) {
                $issue->update([
                    'is_returned' => true
                ]);
                LibraryReturn::create([
                    'user_id' => $issue->user_id,
                    'issue_id' => $issue->id,
                    'item_id' => $issue->item_id,
                    'late_count' => $issue->lateCount()
                ]);
            });
        } catch (\Exception $e) {
            LogHelper::exception($e, [
                'keyword' => 'Issue Return Exception',
            ]);
        }
        return response()->json(['status' => true, 'message' => __('Success')]);
    }

    public function extend($id): View
    {
        $data['issue'] = LibraryIssue::with(['member', 'item'])->find($id);
        $data['title'] = 'Extend validity of Issue';

        return view('library::library.issue.extend', $data);
    }

    public function getDataByQrString(Request $request, $qr_string)
    {
        $bookInfo = Library::where('qr_string_unique', $qr_string)->first();

        return json_encode($bookInfo);
    }

    public function store(Request $request): JsonResponse
    {
        $data = ['status' => false, 'message' => 'Failed to issue item'];
        try {
            //validation rules
            $validator = Validator::make($request->all(), [
                'member_id' => 'required|exists:users,account_id',
                'book_id' => 'required|exists:libraries,id',
                'copy_number' => 'required|exists:library_stocks,id'
            ]);

            //validation fails
            if ($validator->fails()) {
                $data['message'] = $validator->errors()->first();
                return response()->json($data);
            }

            $existing = LibraryIssue::where(['stock_id' => $request->copy_number, 'is_returned' => 0])->first();

            if (!$existing) {
                $issue = null;
                DB::transaction(function () use ($request, &$issue) {
                    $issue = new LibraryIssue();
                    $issue->item_id = $request->book_id;
                    $issue->user_id = CommonHelper::getUserIdByMemberID($request->member_id);
                    $issue->admin_id = auth()->user()->id;
                    $issue->stock_id = $request->copy_number;
                    $issue->start_date = date('Y-m-d', strtotime($request->issueDate));
                    $issue->end_date = date('Y-m-d', strtotime("+ {$request->issueDays} Day", strtotime($request->issueDate)));
                    $issue->bundle = ($request->bundle) ? $request->bundle : null;

                    $issue->save();

                    //update stock status
                    $stock = LibraryStock::findOrFail($request->copy_number);
                    $stock->issued = 1;
                    $stock->save();
                });

                if ($issue) {
                    $data['status'] = true;
                    $data['message'] = 'Your item has been successfully Issued.';
                }
            } else {
                $data['message'] = 'Item has already been Issued.';
            }
        } catch (\Exception $exception) {
            LogHelper::exception($exception, ['keyword' => 'Issue Create Exception',]);
            $data['message'] = $exception->getMessage();
        }

        return response()->json($data);
    }

    public
    function destroy($id)
    {
        //
    }
}
