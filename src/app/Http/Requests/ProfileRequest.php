<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'profile_image' => 'nullable|image|mimes:jpeg,png|max:2048',
        ];
    }

    /**
     * カスタムエラーメッセージ
     */
    public function messages()
    {
        return [
            'profile_image.image' => 'プロフィール画像は画像ファイルを指定してください。',
            'profile_image.mimes' => 'プロフィール画像の拡張子は .jpeg または .png にしてください。',
            'profile_image.max' => 'プロフィール画像のサイズは 2MB 以下にしてください。',
        ];
    }
}
