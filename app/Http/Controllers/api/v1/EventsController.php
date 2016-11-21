<?php

namespace App\Http\Controllers\api\v1;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;

use Log;
use Illuminate\Http\Response;
use App\Event;

class EventsController extends Controller
{
    public function __construct()
    {
        $this -> middleware('isAdmin');
    }

    public function index() {
        log::info("entro a index event");
        $events = Event::where('state', '=', 'no eliminado');
        return Response() -> Json([
            'data' => [
                'Events' => $this -> transformCollection($events)
            ]
        ],200);
    }

    public function show($id) {
        log::info("entro a show event");
        $event = Event::find($id);
        $status_code = 200;
        $message = '';
        $previous = '';
        $next = '';
        if ($event) {
            $previous = $this -> SearchingIds($event);
            $next = $this -> SearchingIds($event, '>');
        } else {
            $status_code = 404;
            $message = 'User does not found';
        }

        return Response() -> Json([
                'data' => [
                    'previous' => $previous,
                    'next' => $next,
                    'event' => $this -> transform($event),
                    'message' => $message
                ]
            ], $status_code);

    }

    public function store(EventRequest $request) {
        log::info("entro a store event");
        $status_code = 200;
        $message = '';
        $input = $request -> only(['name', 'start_date', 'finish_date', 'start_time', 'finish_time', 'location', 'place']);
        $event = Event::create($input);
        if (!$event) {
            $status_code = 404;
            $message = 'problem with create event';
        }
        return Response() -> Json([
                    'data' => [
                        'event' => $this -> transform($event),
                        'message' => $message
                    ]
                ], $status_code);
    }

    public function update(EventRequest $request, $id) {
        log::info("entro a update event");
        $status_code = 200;
        $message = '';
        $event = Event::find($id);
        $event -> name = $request -> name;
        $event -> start_date = $request -> start_date;
        $event -> finish_date = $request -> finish_date;
        $event -> start_time = $request -> start_time;
        $event -> finish_time = $request -> finish_time;
        $event -> location = $request -> location;
        $event -> place = $request -> place;
        $event -> save();
        if (!$event) {
            $status_code = 404;
            $message = 'problem with update event';
        }
        return Response() -> Json([
                'data' => [
                    'event' => $this -> transform($event),
                    'message' => $message
                ]
            ], $status_code);
}

    public function destroy($id) {
        log::info("entro a destroy event");
        $event = Event::find($id);
        $event -> state = 'eliminado';
        $event->save();
        if ($event) {
            return Response() -> Json(['message' => 'ok'], 200);
        }
        return Response() -> Json(['message' => 'error'], 400);
    }

    private function transformCollection($events) {
    	return array_map([$this, 'transform'], $events -> toArray());
    }

    private function transform($event) {
    	return [
            'id' => $event['id'],
			'name' => $event['name'],
			'start_date' => $event['start_date'],
            'finish_date' => $event['finish_date'],
            'start_time' => $event['start_time'],
            'finish_time' => $event['finish_time'],
            'location' => $event['location'],
            'place' => $event['place'],
    	];
    }

    private function SearchingIds($event, $type_search = '<') {
        $value = Event::where('id', $type_search, $event -> id);
        if ($type_search == '<') {
            return $value -> max('id');
        } 
        return $value -> min('id');
    }
}
