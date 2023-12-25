<?php


namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        $hotels = Hotel::select("id", "name", "location", "image_url")->get();

        $result = [];
        foreach ($hotels as $hotel) {
            $result[] = [
                "name" => $hotel->name,
                "rooms" => Room::select("id", "room_type", "number_of_rooms")->get()
            ];
        }

        return $result;
    }

    public function store(Request $request)
    {
        Room::create($request->all());
        return response()->json(['msg' => 'Criado com sucesso']);
    }

    public function show($id)
    {
        $room = Room::find($id) ?? [];
        return $room;
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $room->update($request->all());
        return response()->json(['msg' => $room->room_type.' editado']);
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return response()->json(['msg' => $room->room_type.' deletado']);
    }
}
