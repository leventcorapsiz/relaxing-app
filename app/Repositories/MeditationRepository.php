<?php

namespace App\Repositories;

use App\Contracts\MeditationRepositoryContract;
use App\Models\Meditation;
use App\Models\User;
use Carbon\Carbon;

class MeditationRepository extends Repository implements MeditationRepositoryContract
{
    /**
     * MeditationRepository constructor.
     * @param \App\Models\Meditation $meditation
     */
    public function __construct(Meditation $meditation)
    {
        parent::__construct($meditation);
    }

    /**
     * @param $id
     * @return \App\Models\Meditation|null|\Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param \App\Models\User $user
     * @param array $attributes
     * @return \App\Models\Meditation|\Illuminate\Database\Eloquent\Model
     */
    public function create(User $user, array $attributes)
    {
        $meditation = $this->model->newModelInstance();
        $meditation->user()->associate($user);
        $meditation->fill($attributes);
        $meditation->save();

        return $meditation;
    }

    /**
     * @param $id
     * @param array $attributes
     * @return \App\Models\Meditation|\Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $attributes)
    {
        $meditation = $this->model->find($id);
        $meditation->update($attributes);

        return $meditation->refresh();
    }

    /**
     * @param \App\Models\User $user
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getUserLastCompletedMeditation(User $user)
    {
        return $this->model
            ->where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->latest()
            ->first();
    }

    /**
     * @param \App\Models\User $user
     * @return bool
     */
    public function userHasActiveMeditation(User $user)
    {
        return $this->model
            ->where('user_id', $user->id)
            ->whereNull('completed_at')
            ->exists();
    }

    /**
     * @param \App\Models\User $user
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @return int
     */
    public function getUserTotalCompletedMeditationCount(User $user, Carbon $startDate, Carbon $endDate)
    {
        return $this->model
            ->where('user_id', $user->id)
            ->whereBetween('started_at', [$startDate, $endDate])
            ->whereNotNull('completed_at')
            ->count();
    }

    /**
     * @param \App\Models\User $user
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @return int|null
     */
    public function getUserMaxStreak(User $user, Carbon $startDate, Carbon $endDate)
    {
        return $this->model
            ->where('user_id', $user->id)
            ->whereBetween('started_at', [$startDate, $endDate])
            ->whereNotNull('completed_at')
            ->max('streak');
    }

    /**
     * @param \App\Models\User $user
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @return int|null
     */
    public function getUserTotalMeditationDuration(User $user, Carbon $startDate, Carbon $endDate)
    {
        return $this->model
            ->where('user_id', $user->id)
            ->whereBetween('started_at', [$startDate, $endDate])
            ->whereNotNull('completed_at')
            ->sum('duration_in_seconds');
    }

    /**
     * @param \App\Models\User $user
     * @param \Carbon\Carbon $startDate
     * @param \Carbon\Carbon $endDate
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserMeditationDurationByDate(User $user, Carbon $startDate, Carbon $endDate)
    {
        return $this->model
            ->selectRaw('sum(duration_in_seconds) as total_duration, DATE_FORMAT(started_at, "%Y-%m-%d") as date')
            ->where('user_id', $user->id)
            ->whereBetween('started_at', [$startDate, $endDate])
            ->whereNotNull('completed_at')
            ->groupBy('date')
            ->get();
    }
}