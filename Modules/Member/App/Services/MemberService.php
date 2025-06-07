<?php

namespace Modules\Member\App\Services;

use App\Constants\LogConstant;
use App\Helpers\CommonHelper;
use App\Helpers\LogHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Constants\AuthConstant;
use Modules\Member\App\Repositories\MemberRepositoryInterface;
use Modules\Member\App\Models\Member;

class MemberService
{
    private MemberRepositoryInterface $memberRepository;

    public function __construct(MemberRepositoryInterface $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function create(array $data): RedirectResponse
    {
        try {
            DB::transaction(function () use ($data) {
                $this->memberRepository->create($data +
                    [
                        'type' => AuthConstant::USER_TYPE_MEMBER
                    ]);
            });
            return redirect()->route('member.index')->with(['status' => true, 'message' => 'Member successfully created']);
        } catch (\Exception $exception) {
            LogHelper::exception($exception, [
                'keyword' => LogConstant::EXCEPTION_GENERAL
            ]);
            return redirect()->back()->withInput($data)->withErrors(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function update(array $data, $id): RedirectResponse
    {
        try {
            DB::transaction(function () use ($data, $id) {
                $this->memberRepository->update(array_filter($data), $id);
            });
            return redirect()->route('member.index')->with(['status' => true, 'message' => 'Member successfully updated']);
        } catch (\Exception $exception) {
            LogHelper::exception($exception, [
                'keyword' => LogConstant::EXCEPTION_GENERAL
            ]);
            return redirect()->back()->withInput($data)->with(['status' => false, 'message' => $exception->getMessage()]);
        }
    }

    public function getDataTable($request): JsonResponse
    {
        return datatables()->eloquent(
            $this->memberRepository->getModel()->filter($request)
        )
            ->addColumn('role', function (Member $member) {
                return $member->roles->first()->name ?? '---';
            })
            ->addColumn('status', function (Member $member) {
                return $member->nice_status;
            })
            ->addColumn('actions', function (Member $member) {
                $str = '';
                if (CommonHelper::hasPermission(['member-update']) && $member->actionPermitted()) {
                    $str .= "<a href='" . route('member.edit', $member->id) . "' class='btn btn-primary'><i class='fa fa-edit'></i></a>";
                }
                if (CommonHelper::hasPermission(['member-action']) && $member->actionPermitted()) {
                    if ($member->isActive()) {
                        $str .= "<button data-url='" . route('member.edit', $member->id) . "' data-action='active' class='btn btn-danger'><i class='fa fa-times'></i></button>";
                    } else {
                        $str .= "<button data-url='" . route('member.edit', $member->id) . "' data-action='active' class='btn btn-success'><i class='fa fa-check'></i></button>";
                    }
                }
                return $str;
            })
            ->rawColumns(['actions'])
            ->toJson();
    }
}
