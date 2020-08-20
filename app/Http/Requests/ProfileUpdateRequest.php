<?php

namespace App\Http\Requests;

use App\Rules\TwitterUsername;
use Illuminate\Validation\Rule;
use App\Rules\InstagramUsername;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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
            'first_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns,filter', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
            'username' => ['nullable', 'string', 'max:255'],
            'personal_site' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'instagram_username' => ['nullable', new InstagramUsername],
            'twitter_username' => ['nullable', new TwitterUsername],
        ];
    }
}
