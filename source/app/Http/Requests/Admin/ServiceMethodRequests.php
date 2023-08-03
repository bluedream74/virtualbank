<?php

/**
 * Created by PhpStorm.
 * User: kbin
 * Date: 9/3/2018
 * Time: 5:37 PM
 */
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Factory;
use Validator;

class ServiceMethodRequests extends FormRequest
{
    protected $action;

    public function __construct(Request $request, Factory $factory)
    {
        $this->action = !empty($request->route()->getName()) ? $request->route()->getName() : '';
    }

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
        $rules['method_title'] = ['required'];
        return $rules;
    }

    public function attributes()
    {
        $attributes = parent::attributes();
        return $attributes;
    }
}