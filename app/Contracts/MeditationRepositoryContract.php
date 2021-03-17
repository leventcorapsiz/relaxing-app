<?php

namespace App\Contracts;

use App\Models\User;
use Carbon\Carbon;

interface MeditationRepositoryContract
{
    /**
     * @param $id
     * @return \App\Models\Meditation|null|\Illuminate\Database\Eloquent\Model
     */
    public function find($id);

    /**
     * @param \App\Models\User $user
     * @param array $attributes
     * @return \App\Models\Meditation|\Illuminate\Database\Eloquent\Model
     */
    public function create(User $user, array $attributes);

    /**
     * @param $id
     * @param array $attributes
     * @return \App\Models\Meditation|\Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $attributes);

    /**
     * @param \App\Models\User $user
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getUserLastCompletedMeditation(User $user);

    /**
     * @param \App\Models\User $user
     * @return bool
     */
    public function userHasActiveMeditation(User $user);

    /**
     * @param \App\Models\User $user
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @return int
     */
    public function getUserTotalCompletedMeditationCount(User $user, Carbon $startDate, Carbon $endDate);

    /**
     * @param \App\Models\User $user
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @return int|null
     */
    public function getUserMaxStreak(User $user, Carbon $startDate, Carbon $endDate);

    /**
     * @param \App\Models\User $user
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @return int|null
     */
    public function getUserTotalMeditationDuration(User $user, Carbon $startDate, Carbon $endDate);

    /**
     * @param \App\Models\User $user
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserMeditationDurationByDate(User $user, Carbon $startDate, Carbon $endDate);
}
