<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ShipDistricts;
use App\Models\ShipDivision;
use App\Models\ShipState;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ShippingAreaController extends Controller
{
    public function AllDivision()
    {
        $division = ShipDivision::latest()->get();
        return view('backend.ship.division.all_division',compact('division'));
    }

    public function AddDivision()
    {
        return view('backend.ship.division.add_division');
    }

    public function StoreDivision(Request $request)
    {
        ShipDivision::insert([
            'division_name' => $request->division_name,
        ]);
        $notification = array(
            'message' => 'ShipDivision Add Successfully',
            'alert_type' => 'success'
        );
        return redirect()->route('all.division')->with($notification);
    }

    public function EditDivision($id)
    {
        $division = ShipDivision::findOrFail($id);
        return view('backend.ship.division.edit_division',compact('division'));
    }

    public function UpdateDivision(Request $request)
    {
        $division_id = $request->id ;
        ShipDivision::findOrFail($division_id)->update([
            'division_name' => $request->division_name,
        ]);
        $notification = array(
            'message' => 'ShipDivision Updated Successfully',
            'alert_type' => 'success'
        );
        return redirect()->route('all.division')->with($notification);

    }

    public function DeleteDivision($id)
    {
        ShipDivision::findOrFail($id)->delete();
        $notification = array(
            'message' => 'ShipDivision Deleted Successfully',
            'alert_type' => 'success'
        );
        return redirect()->route('all.division')->with($notification);
    }


    /////////////////// District aArea
    public function AllDistrict()
    {
        $district = ShipDistricts::latest()->get();
        return view('backend.ship.district.all_district',compact('district'));
    }

    public function AddDistrict()
    {
        $division = ShipDivision::orderBy('division_name','ASC')->get();
        return view('backend.ship.district.add_district',compact('division'));
    }

    public function StoreDistrict(Request $request)
    {
        ShipDistricts::insert([
            'division_id' => $request->division_id,
            'district_name' => $request->district_name,
        ]);
        $notification = array(
            'message' => 'ShipDistrict Add Successfully',
            'alert_type' => 'success'
        );
        return redirect()->route('all.district')->with($notification);
    }

    public function EditeDistrict($id)
    {
        $division = ShipDivision::orderBy('division_name','ASC')->get();
        $district = ShipDistricts::findOrFail($id);
        return view('backend.ship.district.edit_district',compact('district','division'));
    }


    public function UpdateDistrict(Request $request)
    {
        $district_id = $request->id ;
        ShipDistricts::findOrFail($district_id)->update([
            'division_id' => $request->division_id,
            'district_name' => $request->district_name,
        ]);
        $notification = array(
            'message' => 'ShipDistrict Updated Successfully',
            'alert_type' => 'success'
        );
        return redirect()->route('all.district')->with($notification);

    }

    public function DeleteDistrict($id)
    {
        ShipDistricts::findOrFail($id)->delete();
        $notification = array(
            'message' => 'ShipDistrict Deleted Successfully',
            'alert_type' => 'success'
        );
        return redirect()->route('all.district')->with($notification);
    }



/////////////////// State Area

   public function AllState()
   {
       $state = ShipState::latest()->get();
       return view('backend.ship.state.all_state',compact('state'));
   }

   public function AddState()
   {
       $division = ShipDivision::orderBy('division_name','ASC')->get();
       $district = ShipDistricts::orderBy('district_name','ASC')->get();
       return view('backend.ship.state.add_state',compact('division','district'));
   }

   public function StoreState(Request $request)
   {
       ShipState::insert([
           'division_id' => $request->division_id,
           'district_id' => $request->district_id,
           'state_name' => $request->state_name,
       ]);
       $notification = array(
           'message' => 'shipState Add Successfully',
           'alert_type' => 'success'
       );
       return redirect()->route('all.state')->with($notification);
   }

   public function EditeState($id)
   {
       $division = ShipDivision::orderBy('division_name','ASC')->get();
       $district = ShipDistricts::orderBy('district_name','ASC')->get();
       $state = ShipState::findOrFail($id);
       return view('backend.ship.state.edit_state',compact('district','division','state'));
   }

   public function UpdateState(Request $request)
   {
       $state_id = $request->id ;
       ShipState::findOrFail($state_id)->update([
           'division_id' => $request->division_id,
           'district_id' => $request->district_id,
           'state_name' => $request->state_name,
       ]);
       $notification = array(
           'message' => 'shipState Updated Successfully',
           'alert_type' => 'success'
       );
       return redirect()->route('all.state')->with($notification);
   }

   public function DeleteState($id)
   {
       ShipState::findOrFail($id)->delete();
       $notification = array(
           'message' => 'ShipState Deleted Successfully',
           'alert_type' => 'success'
       );
       return redirect()->route('all.state')->with($notification);
   }

    public function GetDistrict($division_id){
        $dist = ShipDistricts::where('division_id', $division_id)->orderBy('district_name','ASC')->get();
        return json_encode($dist);

    }// End Method


}
