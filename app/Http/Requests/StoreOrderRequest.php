<?php

namespace App\Http\Requests;

use App\Rules\ValidOrderStatusRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreOrderRequest extends FormRequest {
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator) {
        throw new HttpResponseException(response()->json([
            'error' => $validator->errors(),
            'message' => 'Validation failed',
        ], 422));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'status' => ['required', 'string', new ValidOrderStatusRule],
            'customer_detail.name' => 'required|string|max:255',
            'customer_detail.email' => 'required|email|max:255',
            'customer_detail.phone' => 'required|string|max:255',
            'invoice_detail.name' => 'required|string|max:255',
            'invoice_detail.email' => 'required|email|max:255',
            'invoice_detail.phone' => 'required|string|max:255',
            'invoice_detail.tax_id' => 'required|string|max:255',
            'shipping_address.address' => 'required|string|max:255',
            'shipping_address.city' => 'required|string|max:255',
            'shipping_address.zip' => 'required|string|max:255',
            'shipping_address.state' => 'required|string|max:255',
            'shipping_address.country' => 'required|string|max:255',
            'products' => 'required|array',
            'products.*.description' => 'required|string|max:255',
            'products.*.price' => 'required|numeric',
            'products.*.quantity' => 'required|numeric',
            'products.*.total' => 'nullable|numeric',
            'products.*.discount' => 'nullable|numeric',
        ];
    }

}
