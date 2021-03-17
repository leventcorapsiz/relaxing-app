<?php

namespace App\Http\Requests\Meditation;

use App\Contracts\MeditationRepositoryContract;
use App\Exceptions\MeditationIsAlreadyCompleted;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class Complete extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $meditation = resolve(MeditationRepositoryContract::class)->find($this->route('meditation'));

        return $meditation && $this->user()->id == $meditation->user_id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * @param \Illuminate\Contracts\Validation\Validator $validator
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function () use ($validator) {
            $meditation = resolve(MeditationRepositoryContract::class)->find($this->route('meditation'));
            throw_if(
                !is_null($meditation->completed_at),
                new MeditationIsAlreadyCompleted('Already completed.')
            );
        });
    }
}
