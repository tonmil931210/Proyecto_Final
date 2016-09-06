<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Contracts\Validation\Validator;
use Log;
use App\Event;
class EventRequest extends Request
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
        log::info("entrw1");
        $event = Event::find($this->events);
        log::info($event);
        switch($this->method())
        {
            case 'POST':
                return [
                    'name' => 'required|unique:events,name',
                    'date' => 'required',
                    'user_id' => 'required',
                ];
            case 'PUT':
                return [
                    'name' => "required|unique:events,name,$event->id",
                    'date' => 'required',
                    'user_id' => 'required',
                ];
            case 'PATCH':
                return [
                    'name' => "required|unique:events,name,$event->id",
                    'date' => 'required',
                    'user_id' => 'required',
                ];
            default:break;   
        }
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
