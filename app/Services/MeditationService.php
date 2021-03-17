<?php

namespace App\Services;

use App\Contracts\MeditationRepositoryContract;
use App\Models\User;

class MeditationService
{
    /**
     * @var \App\Contracts\MeditationRepositoryContract
     */
    protected $meditationRepositoryContract;

    /**
     * MeditationService constructor.
     * @param \App\Contracts\MeditationRepositoryContract $meditationRepositoryContract
     */
    public function __construct(MeditationRepositoryContract $meditationRepositoryContract)
    {
        $this->meditationRepositoryContract = $meditationRepositoryContract;
    }

    /**
     * @param \App\Models\User $user
     * @return \App\Models\Meditation|\Illuminate\Database\Eloquent\Model
     */
    public function createNewMeditationForUser(User $user)
    {
        if ($lastMeditation = $this->meditationRepositoryContract->getUserLastCompletedMeditation($user)) {
            if ($lastMeditation->completed_at->isYesterDay()) {
                return $this->meditationRepositoryContract
                    ->create(
                        $user,
                        [
                            'started_at' => now(),
                            'streak'     => $lastMeditation->streak + 1
                        ]
                    );
            }
        }

        return $this->meditationRepositoryContract->create($user, ['started_at' => now()]);
    }

    /**
     * @param \App\Models\User $user
     * @param $meditationID
     * @return \App\Models\Meditation|\Illuminate\Database\Eloquent\Model
     */
    public function completeUserMeditation(User $user, $meditationID)
    {
        $meditation = $this->meditationRepositoryContract->find($meditationID);

        return $this->meditationRepositoryContract->update(
            $meditation->id,
            [
                'completed_at'        => now(),
                'duration_in_seconds' => now()->diffInSeconds($meditation->started_at)
            ]
        );
    }
}