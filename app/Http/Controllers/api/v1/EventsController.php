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
        $events = Event::all();
        return Response() -> Json([
            'data' => [
                'Events' => $this -> transformCollection($events)
            ]
        ],200);
    }

    public function show($id) {
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
        $status_code = 200;
        $message = '';
        $input = $request -> only(['name', 'date', 'user_id']);
        $event = Event::create($input);
        log::info('entre2');
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
        $status_code = 200;
        $message = '';
        $event = Event::find($id);
        $event -> name = $request -> name;
        $event -> date = $request -> date;
        $event -> user_id = $request -> user_id;
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
        $event = Event::destroy($id);
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
			'date' => $event['date'],
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
