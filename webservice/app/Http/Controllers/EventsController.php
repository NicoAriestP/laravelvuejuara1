<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventsController extends Controller
{
    public function index(Request $request)
    {
        if ($request->search) {
            return [
                'success' => true,
                'data' => Event::query()
                    ->where('name', 'like', $request->search)
                    ->get()
            ];
        } else {
            $events = Event::all();

            foreach ($events as &$event) {
                $event->formatted_date = Carbon::make($event->date)->isoFormat('D MMMM YYYY');
            }

            return ['success' => true, 'data' => $events];
        }
    }

    public function show(Event $event, Request $request)
    {
        $event->formatted_date = Carbon::make($event->date)->isoFormat('D MMMM YYYY');

        if ($request->user_id) {
            if (EventUser::query()
                ->where('user_id', $request->user_id)
                ->where('event_id', $event->id)->exists()) {
                $event->joined = true;
            }
        }

        return $event;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'date' => 'required|date',
            'description' => 'required',
            'image' => 'required',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'message' => $validator->errors()];
        }

        $imageValidator = Validator::make($request->all(), [
            'image' => 'mimes:jpg,jpeg,png'
        ]);

        if ($imageValidator->fails()) {
            return ['success' => false, 'message' => 'Validasi image gagal, cek kembali extension dan ukuran file'];
        }

        $path = Storage::put('events', $request->file('image'));

        $event = Event::query()->create([
            'name' => $request->name,
            'address' => $request->address,
            'date' => $request->date,
            'image_url' => $path,
            'description' => $request->description,
        ]);

        return ['success' => true, 'message' => 'Data berhasil disimpan', 'data' => $event];
    }

    public function update(Event $event, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'date' => 'required|date',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'message' => $validator->errors()];
        }

        $event->name = $request->name;
        $event->address = $request->address;
        $event->date = $request->date;
        $event->description = $request->description;

        if ($request->file('image')) {
            $imageValidator = Validator::make($request->all(), [
                'image' => 'mimes:jpg,jpeg,png'
            ]);

            if ($imageValidator->fails()) {
                return ['success' => false, 'message' => 'Validasi image gagal, cek kembali extension dan ukuran file'];
            }

            $event->image_url = Storage::put('events', $request->file('image'));
        }

        $event->save();

        return ['success' => true, 'message' => 'Data berhasil disimpan', 'data' => $event];
    }

    public function destroy($id)
    {
        $event = Event::query()->find($id);

        if (!$event) {
            return ['success' => false, 'message' => 'Data tidak ada'];
        }

        $event->delete();

        return ['success' => true, 'message' => 'Data berhasil dihapus'];
    }

    public function join(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'event_id' => 'required',
        ]);

        if ($validator->fails()) {
            return ['success' => false, 'message' => $validator->errors()];
        }

        if (!User::query()->find($request->user_id)) {
            return ['success' => false, 'message' => 'Data gagal disimpan, silahkan cek kembali isian data anda'];
        }

        if (!Event::query()->find($request->event_id)) {
            return ['success' => false, 'message' => 'Data gagal disimpan, silahkan cek kembali isian data anda'];
        }

        EventUser::query()->create([
            'user_id' => $request->user_id,
            'event_id' => $request->event_id,
        ]);

        return ['success' => true, 'message' => 'Data berhasil disimpan'];
    }

    public function users($id)
    {
        $result = EventUser::query()->where('event_id', $id)->with('users')->get();

        return ['data' => $result, 'total' => count($result)];
    }
}
