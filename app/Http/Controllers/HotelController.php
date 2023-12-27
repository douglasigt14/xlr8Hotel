<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Price;
use App\Models\Room;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index()
    {
        return Hotel::select("id","name","location", "image_url")->get();
    }

    public function store(Request $request)
    {


            $hotel = new Hotel;

            if ($request->hasFile('image_url')) {
                $image = $request->file('image_url');

                $imageName = time() . '_' . $image->getClientOriginalName();

                $image->move(public_path('images'), $imageName);
                $hotel->image_url = 'images/' . $imageName; 
            }

           
            $hotel->name = $request->input('name');
            $hotel->location = $request->input('location');
           
            $hotel->save();

            return response()->json(['msg' => 'Criado com sucesso']);
    }

    public function update($id, Request $request)
    {
        $hotel = Hotel::select("id","name","location", "image_url")->where('id', $id)->first();
        if($hotel){
            if ($request->hasFile('image_url')) {
                $image = $request->file('image_url');
    
                $imageName = time() . '_' . $image->getClientOriginalName();
    
                $image->move(public_path('images'), $imageName);
                $hotel->image_url = 'images/' . $imageName;
            }
              $hotel->location = $request->input('location');
              $hotel->name = $request->input('name');
              $hotel->save();
    
            return response()->json(['msg' => $hotel->name.' editado']);
        }
        return response()->json(['msg' => 'Hotel not found']);
       
    }

    public function destroy($id)
    {
        $hotel = Hotel::findOrFail($id);
        $hotel->delete();
        return response()->json(['msg' => $hotel->name.' deletado']);
    }

    public function detailsAll()
    {
        $hotels = Hotel::select("id", "name", "location", "image_url")->get();

        
        foreach ($hotels as $hotel) {
            $rooms = Room::select("id", "room_type", "number_of_rooms")->where('hotel_id', $hotel->id)->get();
            foreach ($rooms as $room) {
                $room->prices =  Price::select("id", "stay_date","price")->where('room_id', $room->id)->get();
            }
            $hotel->rooms  = $rooms->toArray();
        }

        return $hotels->toArray();
    }

    public function detailsForId($hotalId)
    {
        $hotels = Hotel::select("id", "name", "location", "image_url")->where('id',$hotalId)->get();

        
        foreach ($hotels as $hotel) {
            $rooms = Room::select("id", "room_type", "number_of_rooms")->where('hotel_id', $hotel->id)->get();
            foreach ($rooms as $room) {
                $room->prices =  Price::select("id", "stay_date","price")->where('room_id', $room->id)->get();
            }
            $hotel->rooms  = $rooms->toArray();
        }

        return $hotels->toArray();
    }
}