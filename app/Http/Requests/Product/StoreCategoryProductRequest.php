<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryProductRequest extends FormRequest
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
            "name" => "required|min:1|max:250",
            "slug" => [
                'required',
                Rule::unique('category_products', 'slug')->whereNull('deleted_at'),
            ],
            "avatar" => "mimes:jpeg,jpg,png,svg,webp|nullable|file|max:2048",
            "order" => "nullable|numeric",
            "language_id" => "required|numeric",
        ];
    }
    public function messages()
    {
        return [
            "name.required" => "Tên danh mục bắt buộc nhập",
            "name.min" => "Tên danh mục > 1 kí tự",
            "name.max" => "Tên danh mục < 250 kí tự",
            "slug.required" => "Đường dẫn bắt buộc nhập",
            "slug.unique" => "Đường dẫn đã tồn tại",
            "avatar.mimes" => "Ảnh đại diện phải là định dạng jpeg,jpg,png,svg,webp <= 2MB",
            "avatar.max" => "Kích cỡ ảnh đại diện phải nhỏ hơn < 2MB",
            "order.numberic" => "Sắp xếp phải là số",
            'language_id.required' => "Ngôn ngữ bắt buộc chọn",
            'language_id.numberic' => "Ngôn ngữ sai định dạng"
        ];
    }
}
