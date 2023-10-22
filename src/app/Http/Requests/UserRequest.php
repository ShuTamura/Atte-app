<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|string|max:191',
            'email' => 'required|email|unique:users|string|max:191',
            'password' => 'required|confirmed|min:8|max:191'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => '名前を入力してください',
            'name.string' => '正しく入力してください',
            'name.max' => '文字数が多すぎます',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => '正しく入力してください',
            'email.unique' => 'そのメールアドレスは既に使われています',
            'email.string' => '正しく入力してください',
            'email.max' => '文字数が多すぎます',
            'password.required' => 'パスワードを入力してください',
            'password.confirmed' => 'パスワードが一致しません',
            'password.max' => '文字数が多すぎます',
            'password.min' => 'パスワードは８文字以上で入力してください',
        ];
    }
}
