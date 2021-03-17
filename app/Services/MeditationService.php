<?php

namespace App\Services;

use App\Contracts\MeditationRepositoryContract;

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
}