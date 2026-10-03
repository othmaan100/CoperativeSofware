<?php

namespace App\Events;

use App\Models\Member;
use Illuminate\Foundation\Events\Dispatchable;

class MemberApproved
{
    use Dispatchable;

    public function __construct(public Member $member)
    {
    }
}
