<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Services\CouponsService;

class CouponsSeeder extends Seeder
{
    protected $couponsService;

    public function __construct(CouponsService $couponsService)
    {
        $this->couponsService = $couponsService;
    }

    public function run()
    {
        $this->couponsService->generate();
    }
}
