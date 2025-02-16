<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'categories' => 'required|array',
            'categories.*' => 'string',
            'condition' => 'required|string|in:良好,目立った傷や汚れなし,やや傷や汚れあり,状態が悪い',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '商品画像を選択してください。',
            'image.image' => '画像ファイルをアップロードしてください。',
            'categories.required' => 'カテゴリーを1つ以上選択してください。',
            'condition.required' => '商品の状態を選択してください。',
            'name.required' => '商品名を入力してください。',
            'description.required' => '商品の説明を入力してください。',
            'price.required' => '販売価格を入力してください。',
            'price.numeric' => '販売価格は数値で入力してください。',
        ];
    }
}
