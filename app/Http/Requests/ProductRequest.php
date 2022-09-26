<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
        $unique = 'unique:products,name';

        if($this->route()->getName() == 'products.update' && $this->isMethod('PUT')) {
            
            $unique = Rule::unique('products', 'name')->ignore($this->product);

        }

        return [
            'name' => ['required', 'max:100', $unique],
            'description' => ['required', 'max:255'],
            'price' => ['required', 'numeric'],
            'in_stock' => ['required', 'numeric', 'digits_between:1,6'],
            'active_for_sale' => ['nullable', 'boolean']
        ];
    }
}
