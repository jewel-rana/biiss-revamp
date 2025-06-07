<?php

namespace Modules\Member\App\Repositories;

use App\Repositories\BaseRepository;
use Modules\Member\App\Models\Member;

class MemberRepository extends BaseRepository implements MemberRepositoryInterface
{
    public function __construct(Member $model)
    {
        parent::__construct($model);
    }
}
