<?php

namespace App\Services\Meditation;

use App\Contracts\MeditationRepositoryContract;
use App\Models\User;
use Carbon\Carbon;

class StatisticsService
{
    /**
     * @var \App\Contracts\MeditationRepositoryContract
     */
    protected $meditationRepositoryContract;

    /**
     * StatisticsService constructor.
     * @param \App\Contracts\MeditationRepositoryContract $meditationRepositoryContract
     */
    public function __construct(MeditationRepositoryContract $meditationRepositoryContract)
    {
        $this->meditationRepositoryContract = $meditationRepositoryContract;
    }

    /**
     * @param \App\Models\User $user
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @return array
     */
    public function summary(User $user, Carbon $startDate, Carbon $endDate)
    {
        $totalCompletedMeditation = $this
            ->meditationRepositoryContract
            ->getUserTotalCompletedMeditationCount(
                $user,
                $startDate,
                $endDate
            );

        $maxStreakInRow = $this
            ->meditationRepositoryContract
            ->getUserMaxStreak(
                $user,
                $startDate,
                $endDate
            );

        $totalMeditationDurationInSeconds = $this
            ->meditationRepositoryContract
            ->getUserTotalMeditationDuration(
                $user,
                $startDate,
                $endDate
            );

        return compact('totalCompletedMeditation', 'maxStreakInRow', 'totalMeditationDurationInSeconds');
    }
}