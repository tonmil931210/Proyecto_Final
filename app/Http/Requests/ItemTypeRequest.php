<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Log;
use App\Item_type;
class ItemTypeRequest extends Request
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
        log::info("entre itemTypeRequest");
        $items_type = Item_type::find($this->itemsType);
        log::info($items_type);
        switch($this->method())
        {
            case 'POST':
                return [
                    'name' => 'required|unique:items_type,name',
                ];
            case 'PUT':
                return [
                    'name' => "required|unique:item_types,name,$items_type->id",
                ];
            case 'PATCH':
                return [
                    'name' => "required|unique:item_types,name,$items_type->id",
                ];
            default:break;   
        }
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
