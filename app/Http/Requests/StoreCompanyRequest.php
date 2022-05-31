<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCompanyRequest extends FormRequest
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
            'name' => ['required'],
            'introduce' => ['required'],
            'phone' => ['required'],
            'logo' => ['required'],
            'tax_num' => ['required'],
            'status' => ['required'],
            'description' => ['required'],
            'address' => ['required'],
            'staff_num' => ['required']
        ];
    }

    public function attributes()
    {
        return [
            'name' => '名称',
            'introduce' => '简介',
            'phone' => '联系电话',
            'logo' => 'LOGO',
            'tax_num' => '营业执照号',
            'status' => '状态',
            'description' => '详细介绍',
            'address' => '地址',
            'staff_num' => '员工数',
        ];
    }
}
