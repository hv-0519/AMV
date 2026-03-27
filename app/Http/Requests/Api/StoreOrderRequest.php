<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
{
    /**
     * Determine whether the request is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'order_type' => ['required', Rule::in(['dine-in', 'pickup', 'delivery'])],
            'payment_method' => ['required', Rule::in(['cash', 'card', 'upi', 'online'])],
            'delivery_address' => ['nullable', 'string', 'max:500', 'required_if:order_type,delivery'],
            'notes' => ['nullable', 'string', 'max:300'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'integer', 'exists:menu_items,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:20'],
            'guest_name' => [$this->user() ? 'nullable' : 'required', 'string', 'max:100'],
            'guest_email' => [$this->user() ? 'nullable' : 'required', 'email', 'max:255'],
            'guest_phone' => [$this->user() ? 'nullable' : 'required', 'string', 'max:20'],
        ];
    }
}
