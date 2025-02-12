<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TaskUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'status' => ['required', Rule::in(['assigned', 'accepted', 'resolved', 'rejected'])],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Заголовок обязателен.',
            'title.max' => 'Заголовок не должен превышать 255 символов.',
            'content.required' => 'Контент обязателен.',
            'status.required' => 'Поле "Статус" обязательно для заполнения.',
            'status.in' => 'Выбранный статус недействителен. Он должен быть одним из: assigned, accepted, resolved, rejected.',

        ];
    }
}
