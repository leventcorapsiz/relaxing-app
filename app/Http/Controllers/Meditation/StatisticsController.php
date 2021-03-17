<?php

namespace App\Http\Controllers\Meditation;

use App\Http\Controllers\Controller;
use App\Services\Meditation\StatisticsService;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    /**
     * @var \App\Services\Meditation\StatisticsService
     */
    protected $statisticsService;

    /**
     * StatisticsController constructor.
     * @param \App\Services\Meditation\StatisticsService $statisticsService
     */
    public function __construct(StatisticsService $statisticsService)
    {
        $this->statisticsService = $statisticsService;
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function summary(Request $request)
    {
        // todo : get date parameters from request
        return response()
            ->json($this->statisticsService->summary(
                $request->user(),
                now()->subMonth(),
                now())
            );
    }
}