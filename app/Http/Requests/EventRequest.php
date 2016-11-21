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

    public function messages()
    {
        return [
            'name.required' => 'El nombre es un campo obligatorio',
            'start_date.required'  => 'La fecha de inicio es un campo obligatorio',
            'finish_date.required' => 'La fecha de terminación es un campo obligatorio',
            'start_time.required'  => 'La hora de inicio es un campo obligatorio',
            'finish_time.required' => 'La hora de terminación es un campo obligatorio',
            'location.required' => 'La localización es un campo obligatorio',
            'place.required' => 'El Lugar es un campo obligatorio',
        ];
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
