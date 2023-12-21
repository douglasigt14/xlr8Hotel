<?php


namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        return Room::all();
    }

    public function store(Request $request)
    {
        return Room::create($request->all());
    }

    public function show($id)
    {
        return Room::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $room->update($request->all());
        return $room;
    }

    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return response()->json(['message' => 'Room deleted successfully']);
    }
}
