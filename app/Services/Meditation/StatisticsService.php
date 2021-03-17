<?php

namespace App\Services\Meditation;

use App\Contracts\MeditationRepositoryContract;
use App\Models\User;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;

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

    /**
     * @param \App\Models\User $user
     * @return \Illuminate\Support\Collection
     */
    public function lastSevenDays(User $user)
    {
        $startDate = today()->subDays(7);
        $endDate   = today()->endOfDay();

        $statistics = $this->meditationRepositoryContract
            ->getUserMeditationDurationByDate($user, $startDate, $endDate);

        $dates = new DatePeriod(
            $startDate,
            new DateInterval('P1D'),
            $endDate
        );

        return collect($dates)->map(function ($date) use ($statistics) {
            $output = [
                'totalDurationInSeconds' => 0,
                'date'                   => $date,
            ];

            if ($found = $statistics->where('date', $date)->first()) {
                $output = [
                    'totalDurationInSeconds' => $found->total_duration,
                    'date'                   => $date
                ];
            }
            return $output;
        });
    }
}