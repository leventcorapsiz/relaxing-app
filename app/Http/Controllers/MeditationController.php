<?php

namespace App\Http\Controllers;

use App\Http\Requests\Meditation\Complete;
use App\Http\Requests\Meditation\Store;
use App\Http\Resources\Meditation;
use App\Services\MeditationService;

class MeditationController extends Controller
{
    /**
     * @var \App\Services\MeditationService
     */
    protected $meditationService;

    /**
     * MeditationController constructor.
     * @param \App\Services\MeditationService $meditationService
     */
    public function __construct(MeditationService $meditationService)
    {
        $this->meditationService = $meditationService;
    }

    /**
     * @param \App\Http\Requests\Meditation\Store $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Store $request)
    {
        return response()
            ->json(
                new Meditation(
                    $this->meditationService->createNewMeditationForUser($request->user())
                )
            );
    }

    /**
     * @param \App\Http\Requests\Meditation\Complete $request
     * @param $meditationID
     * @return \Illuminate\Http\JsonResponse
     */
    public function complete(Complete $request, $meditationID)
    {
        return response()
            ->json(
                new Meditation(
                    $this->meditationService->completeUserMeditation($request->user(), $meditationID)
                )
            );
    }
}