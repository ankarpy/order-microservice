<?php

namespace App\Http\Requests;

use App\Enum\OrderShippingEnum;
use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "customer_name" => "required|max:70",
            "customer_email" => "required|email",
            "shipping" => ["required", ("in:".implode(',', array_column(OrderShippingEnum::cases(), 'value')))],
            "invoice_address_title" => "required",
            "invoice_zip_code" => "required",
            "invoice_city" => "required",
            "invoice_address" => "required",
            "shipping_address_title" => "required",
            "shipping_zip_code" => "required",
            "shipping_city" => "required",
            "shipping_address" => "required",
            "cart"   => "required|array",
            "cart.*" => "array",
            "cart.*.*" => "numeric",
        ];
    }
}
