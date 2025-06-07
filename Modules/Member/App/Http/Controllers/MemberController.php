<?php

namespace Modules\Member\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Modules\Auth\Constants\AuthConstant;
use Modules\Auth\Entities\User;
use Modules\Member\App\Http\Requests\StoreMemberRequest;
use Modules\Member\App\Http\Requests\UpdateMemberRequest;
use Modules\Member\App\Models\Member;
use Modules\Member\App\Services\MemberService;

class MemberController extends Controller
{

    private MemberService $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    public function index(Request $request)
    {
        $search = trim($request->input('search'));
        $query = Member::with('issuedBooks')
            ->withCount('issuedBooks')
            ->where('type', AuthConstant::USER_TYPE_MEMBER);
        if (isset($_GET['search'])) :
            $query->where('name', 'like', '%' . $search . '%');
            $query->orWhere('email', 'like', '%' . $search . '%');
            $query->orWhere('contact_number', 'like', '%' . $search . '%');
            $query->orWhere('address', 'like', '%' . $search . '%');
        endif;
        $members = $query->orderBy('id', 'DESC')->paginate(10);

        $title = 'All Members';
        return view('member::index', compact('members', 'title'));
    }

    public function create()
    {
        return view('member::create');
    }

    public function store(StoreMemberRequest $request): RedirectResponse
    {
        return $this->memberService->create($request->validated());
    }

    public function show(Member $member)
    {
        return view('member::show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('member::edit', compact('member'));
    }

    public function update(UpdateMemberRequest $request, $id): RedirectResponse
    {
        return $this->memberService->update($request->validated(), $id);
    }

    public function destroy(Member $member)
    {
        //
    }
}
