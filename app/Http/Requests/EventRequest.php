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
        log::info("entre eventRequest");
        $event = Event::find($this->events);
        log::info($event);
        switch($this->method())
        {
            case 'POST':
                return [
                    'name' => 'required|unique:events,name',
                    'start_date' => 'required',
                    'finish_date' => 'required',
                    'start_time' => 'required',
                    'finish_time' => 'required',
                    'location' => 'required',
                    'place' => 'required'
                ];
            case 'PUT':
                return [
                    'name' => "required|unique:events,name,$event->id",
                    'start_date' => 'required',
                    'finish_date' => 'required',
                    'start_time' => 'required',
                    'finish_time' => 'required',
                    'location' => 'required',
                    'place' => 'required'
                ];
            case 'PATCH':
                return [
                    'name' => "required|unique:events,name,$event->id",
                    'start_date' => 'required',
                    'finish_date' => 'required',
                    'start_time' => 'required',
                    'finish_time' => 'required',
                    'location' => 'required',
                    'place' => 'required'
                ];
            default:break;   
        }
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
