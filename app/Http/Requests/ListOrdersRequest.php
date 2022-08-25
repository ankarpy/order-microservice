<?php

namespace App\Http\Requests;

use App\Enum\OrderStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class ListOrdersRequest extends FormRequest
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
            "id" => "nullable|numeric",
            "status" => ["nullable", ("in:".implode(',', array_column(OrderStatusEnum::cases(), 'value')))],
            "date_from" => "nullable|date",
            "date_to" => "nullable|date",
        ];
    }
}
