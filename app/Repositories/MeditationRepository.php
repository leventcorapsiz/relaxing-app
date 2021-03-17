<?php

namespace App\Repositories;

use App\Contracts\MeditationRepositoryContract;
use App\Models\Meditation;

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
}