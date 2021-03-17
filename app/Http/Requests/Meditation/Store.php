<?php

namespace App\Http\Requests\Meditation;

use App\Contracts\MeditationRepositoryContract;
use App\Exceptions\UserHasActiveMeditation;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
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
            throw_if(
                resolve(MeditationRepositoryContract::class)->userHasActiveMeditation($this->user()),
                new UserHasActiveMeditation('Active meditation exists.')
            );
        });
    }
}
