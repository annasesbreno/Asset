<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\HardwareType;
use App\storageType;
use App\Processor;
use Redirect;
use Auth;
use App\Log;
class HardwareInfoController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function hardwareType()
  {
    $hardwareTypes = HardwareType::where('status', '=', 'Created')
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
    return view('hardwareInfo.hardwareType', compact('hardwareTypes', $hardwareTypes));
  }

  public function brand()
  {
    $brands = Brand::where('status', '=', 'Created')
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);

    return view('hardwareInfo.brand', compact('brands', $brands));
  }

  public function processor()
  {
    $processors = Processor::where('status', '=', 'Created')
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
    return view('hardwareInfo.processor', compact('processors', $processors));
  }
  public function storageType()
  {
    $storageTypes = StorageType::where('status', '=', 'Created')
                    ->orderBy('created_at', 'desc')
                    ->paginate(5);
    return view('hardwareInfo.storageType', compact('storageTypes', $storageTypes));
  }

  /*Hardware Type*/
  public function addHT(Request $request)
  {
    $hardwaretype = new HardwareType();
    $hardwaretype->name = $request->name;
    $hardwaretype->status = "Created";
    $hardwaretype->created_by = Auth::user()->name;
    $hardwaretype->save();

    $notification = array(
             'message' => "Successful",
             'alert-type' => 'success'
         );

         $log = new Log();
         $log->user_id = Auth::user()->id;
         $log->created_by = Auth::user()->name;
         $log->description = 'Added Hardware Type';
         $log->action = 'Add';
         $log->save();

    return Redirect::back()->with($notification);
  }

  public function editHT(Request $request, $id)
  {
    $hardwaretype = HardwareType::findOrFail($id);
    $hardwaretype->name = $request->name;
    $hardwaretype->save();

    $notification = array(
             'message' => "Successful",
             'alert-type' => 'success'
         );

    $log = new Log();
    $log->user_id = Auth::user()->id;
    $log->created_by = Auth::user()->name;
    $log->description = 'Edited Hardware Type';
    $log->action = 'Edit';
    $log->save();

    return Redirect::back()->with($notification);
  }

  public function RemoveHT(Request $request, $id)
  {
    $hardwaretype = HardwareType::findOrFail($id);
    $hardwaretype->status = "Removed";
    $hardwaretype->save();

    $notification = array(
             'message' => "Successful",
             'alert-type' => 'success'
         );

    $log = new Log();
    $log->user_id = Auth::user()->id;
    $log->created_by = Auth::user()->name;
    $log->description = 'Deleted Hardware Type';
    $log->action = 'Delete';
    $log->save();

    return Redirect::back()->with($notification);
  }
  /*End Hardware Type*/

  /*Brand*/
  public function addBrand(Request $request)
  {
    $brand = new Brand();
    $brand->name = $request->name;
    $brand->status = "Created";
    $brand->created_by = Auth::user()->name;
    $brand->save();

    $notification = array(
             'message' => "Successful",
             'alert-type' => 'success'
         );

    $log = new Log();
    $log->user_id = Auth::user()->id;
    $log->created_by = Auth::user()->name;
    $log->description = 'Added Hardware Brand';
    $log->action = 'Add';
    $log->save();

    return Redirect::back()->with($notification);
  }
  public function EditBrand(Request $request, $id)
  {
    $brand = Brand::findOrFail($id);
    $brand->name = $request->name;
    $brand->save();

    $notification = array(
             'message' => "Successful",
             'alert-type' => 'success'
         );

    $log = new Log();
    $log->user_id = Auth::user()->id;
    $log->created_by = Auth::user()->name;
    $log->description = 'Edited Hardware Brand';
    $log->action = 'Edit';
    $log->save();

    return Redirect::back()->with($notification);
  }

  public function RemoveBrand(Request $request, $id)
  {
    $brand = Brand::findOrFail($id);
    $brand->status = "Removed";
    $brand->save();

    $notification = array(
             'message' => "Successful",
             'alert-type' => 'success'
         );

    $log = new Log();
    $log->user_id = Auth::user()->id;
    $log->created_by = Auth::user()->name;
    $log->description = 'Deleted Hardware Brand';
    $log->action = 'Delete';
    $log->save();

    return Redirect::back()->with($notification);
  }
  /*End Brand*/

  /*Processor*/
  public function AddProcessor(Request $request)
  {
    $processor = new Processor();
    $processor->name = $request->name;
    $processor->status = "Created";
    $processor->created_by = Auth::user()->name;
    $processor->save();

    $notification = array(
             'message' => "Successful",
             'alert-type' => 'success'
         );

    $log = new Log();
    $log->user_id = Auth::user()->id;
    $log->created_by = Auth::user()->name;
    $log->description = 'Added Hardware Processor';
    $log->action = 'Add';
    $log->save();


    return Redirect::back()->with($notification);
  }
  public function EditProcessor(Request $request, $id)
  {
    $processor = Processor::findOrFail($id);
    $processor->name = $request->name;
    $processor->save();

    $notification = array(
             'message' => "Successful",
             'alert-type' => 'success'
         );

         $log = new Log();
         $log->user_id = Auth::user()->id;
         $log->created_by = Auth::user()->name;
         $log->description = 'Edited Hardware Processor';
         $log->action = 'Edit';
         $log->save();

    return Redirect::back()->with($notification);
  }

  public function RemoveProcessor(Request $request, $id)
  {
    $processor = Processor::findOrFail($id);
    $processor->status = "Removed";
    $processor->save();

    $notification = array(
             'message' => "Successful",
             'alert-type' => 'success'
         );

         $log = new Log();
         $log->user_id = Auth::user()->id;
         $log->created_by = Auth::user()->name;
         $log->description = 'Deleted Hardware Processor';
         $log->action = 'Delete';
         $log->save();
    return Redirect::back()->with($notification);
  }
  /*End Processor*/

  /*Storage Type*/
  public function AddStorageType(Request $request)
  {
    $st = new StorageType();
    $st->name = $request->name;
    $st->status = "Created";
    $st->created_by = Auth::user()->name;
    $st->save();

    $notification = array(
             'message' => "Successful",
             'alert-type' => 'success'
         );

         $log = new Log();
         $log->user_id = Auth::user()->id;
         $log->created_by = Auth::user()->name;
         $log->description = 'Added Hardware Storage Type';
         $log->action = 'Add';
         $log->save();
    return Redirect::back()->with($notification);
  }
  public function EditStorageType(Request $request, $id)
  {
    $st = StorageType::findOrFail($id);
    $st->name = $request->name;
    $st->save();

    $notification = array(
             'message' => "Successful",
             'alert-type' => 'success'
         );

         $log = new Log();
         $log->user_id = Auth::user()->id;
         $log->created_by = Auth::user()->name;
         $log->description = 'Edited Hardware Storage Type';
         $log->action = 'Edit';
         $log->save();

    return Redirect::back()->with($notification);
  }

  public function RemoveStorageType(Request $request, $id)
  {
    $st = StorageType::findOrFail($id);
    $st->status = "Removed";
    $st->save();

    $notification = array(
             'message' => "Successful",
             'alert-type' => 'success'
         );

         $log = new Log();
         $log->user_id = Auth::user()->id;
         $log->created_by = Auth::user()->name;
         $log->description = 'Deleted Hardware Storage Type';
         $log->action = 'Delete';
         $log->save();

    return Redirect::back()->with($notification);
  }
  /*End Storage Type*/
}
