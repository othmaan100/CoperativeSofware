<?php

namespace App\Listeners;

use App\Events\MemberApproved;
use App\Models\SavingsAccount;
use App\Models\SavingsProduct;

class OpenRegularSavingsAccount
{
    public function handle(MemberApproved $event): void
    {
        $product = SavingsProduct::query()->where('code', SavingsProduct::REGULAR)->first();

        if ($product) {
            SavingsAccount::openFor($event->member, $product);
        }
    }
}
