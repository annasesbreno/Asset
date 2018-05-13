<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hardware;
use App\HardwareType;
use App\Brand;
use App\Processor;
use App\StorageType;
use App\Employee;
use App\User;
use Redirect;
use Excel;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Log;
class HardwareController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function searchHardware(Request $request)
  {
    if($request->ajax())
    {

      /*
      if (Request::is('deliveries'))
      {
        $status = 'Delivered';
      }
      else if(Request::is('inventory'))
      {
        $status = 'Inventory';
      }
      */
      $output = "";
      $hardwares = Hardware::where('model_name', 'LIKE', '%'.$request->search.'%')
                          ->orWhere('serial', 'LIKE', '%'.$request->search.'%')
                          ->get();

      if($hardwares)
      {
        foreach ($hardwares as $hardware)
        {
          $csrf = csrf_field();
          $put = method_field('PUT');
          $delete = method_field('DELETE');


          $output.= '<tr>'.
                    "<td><input type='checkbox' name='checkbox' class='sub_chk' data-id=$hardware->id></td>".
                    '<td>'.$hardware->serial.'</td>'.
                    '<td>'.$hardware->model_name.'</td>'.
                    '<td>'.$hardware->hardware_type.'</td>'.
                    '<td>'.$hardware->brand.'</td>'.
                    '<td>'.$hardware->processor.'</td>'.
                    '<td>'.$hardware->ram.'</td>'.
                    '<td>'.$hardware->storage.'</td>'.
                    '<td>'.$hardware->storage_type.'</td>'.
                    '<td>'.$hardware->purchased_date->format('M d, Y').'</td>'.
                    '<td>'.$hardware->warranty_date->format('M d, Y').'</td>'.
                    '<td>'.$hardware->status.'</td>'.
                    "
                    <td>
                    <a href='/device/$hardware->id' target='_blank' class='btn btn-primary btn-xs'>View Details</a>
                    </td>
                    ".
                    '</tr>';
        }
      }

      return Response($output);
    }
  }

  public function searchUser(Request $request)
  {
    if($request->ajax())
    {
      /*
      if (\Request::is('deliveries'))
      {
        $status = 'Delivered';
      }
      else if(\Request::is('inventory'))
      {
        $status = 'Inventory';
      }
      */
      $output = "";
      $hardwares = Hardware::where('model_name', 'LIKE', '%'.$request->search.'%')
                          ->orWhere('serial', 'LIKE', '%'.$request->search.'%')
                          ->get();

      if($hardwares)
      {
        foreach ($hardwares as $hardware)
        {
          $csrf = csrf_field();
          $put = method_field('PUT');
          $delete = method_field('DELETE');


          $output.= '<tr>'.
                    "<td><input type='checkbox' name='checkbox' class='sub_chk' data-id=$hardware->id></td>".
                    '<td>'.$hardware->serial.'</td>'.
                    '<td>'.$hardware->model_name.'</td>'.
                    '<td>'.$hardware->hardware_type.'</td>'.
                    '<td>'.$hardware->brand.'</td>'.
                    '<td>'.$hardware->owners->emp_id.'</td>'.
                    '<td>'.$hardware->processor.'</td>'.
                    '<td>'.$hardware->ram.'</td>'.
                    '<td>'.$hardware->storage.'</td>'.
                    '<td>'.$hardware->storage_type.'</td>'.
                    '<td>'.$hardware->purchased_date->format('M d, Y').'</td>'.
                    '<td>'.$hardware->warranty_date->format('M d, Y').'</td>'.
                    '<td>'.$hardware->status.'</td>'.
                    "
                    <td>
                    <a href='/device/$hardware->id' target='_blank' class='btn btn-primary btn-xs'>View Details</a>
                    </td>
                    ".
                    '</tr>';
        }
      }

      return Response($output);
    }
  }




  public function showDevice(Request $request, $id)
  {
    $hardware = Hardware::findOrFail($id);

    return view('showDevice', compact('hardware'));

  }

  public function InDelivery(Request $request, $id)
  {
      $hardware = Hardware::findOrFail($id);
      $hardware->status = "Inventory";
      $hardware->disposed_date = null;
      $hardware->save();

      $notification = array(
               'message' => "Device Updated",
               'alert-type' => 'success'
           );

      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Put Delivery to Inventory';
      $log->action = 'Edit';
      $log->save();

      return Redirect::back()->with($notification);
  }

  public function putDeviceOnDelivery(Request $request, $id)
  {
      $hardware = Hardware::findOrFail($id);
      $hardware->status = "Delivered";
      $hardware->save();

      $notification = array(
               'message' => "Device Updated",
               'alert-type' => 'success'
           );

      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Put Device to Delivery';
      $log->action = 'Edit';
      $log->save();

      return Redirect::back()->with($notification);
  }

  public function OutDelivery(Request $request, $id)
  {

    $hardware = Hardware::findOrFail($id);
    $hardware->status = "Deployed";
    $hardware->user_id = $request->deployed_by;
    $hardware->deployed_date = date('Y-m-d');
    $hardware->save();

    $employee = new Employee;
    $employee->hardware_id = $hardware->id;
    $employee->emp_id = $request->emp_id;
    $employee->name = $request->fullname;
    $employee->seat = $request->seat;

    $employee->save();

    $notification = array(
             'message' => "Device Updated",
             'alert-type' => 'success'
         );

    $log = new Log();
    $log->user_id = Auth::user()->id;
    $log->created_by = Auth::user()->name;
    $log->description = 'Deployed a Device';
    $log->action = 'Edit';
    $log->save();

    return Redirect::back()->with($notification);
  }



  public function deliveries()
  {
    $hardwares = Hardware::where('status', '=', 'Delivered')->orderBy('created_at', 'desc')->paginate(10);

    return view('deliveries', compact('hardwares'));
  }

  public function deliveriesSortByWarrantyASC()
  {
    $hardwares = Hardware::where('status', '=', 'Delivered')->orderBy('warranty_date', 'asc')->paginate(10);

    return view('deliveries', compact('hardwares'));
  }

  public function deliveriesSortByWarrantyDESC()
  {
    $hardwares = Hardware::where('status', '=', 'Delivered')->orderBy('warranty_date', 'desc')->paginate(10);

    return view('deliveries', compact('hardwares'));
  }

  public function deliveriesSortByPurchasedDateASC()
  {
    $hardwares = Hardware::where('status', '=', 'Delivered')->orderBy('purchased_date', 'asc')->paginate(10);

    return view('deliveries', compact('hardwares'));
  }

  public function deliveriesSortByPurchasedDateDESC()
  {
    $hardwares = Hardware::where('status', '=', 'Delivered')->orderBy('purchased_date', 'desc')->paginate(10);

    return view('deliveries', compact('hardwares'));
  }

  public function editDelivery(Request $request, $id)
  {
    $hardware = Hardware::findOrFail($id);

    $hardware->serial = $request->serial;
    $hardware->model_name = $request->model_name;
    $hardware->ram = $request->ram;
    $hardware->storage = $request->storage;
    $hardware->purchased_date = $request->purchased_date;
    $hardware->warranty_date = $request->warranty_date;

    $hardware_type = HardwareType::find($request->hardware_type);
    $brand_name = Brand::find($request->brand);
    $processor_name = Processor::find($request->processor);
    $storage_type = StorageType::find($request->storage_type);

    $hardware->hardwaretype_id = $hardware_type->id;
    $hardware->brand_id = $brand_name->id;
    $hardware->processor_id = $processor_name->id;
    $hardware->storagetype_id = $storage_type->id;

    $hardware->hardware_type = $hardware_type->name;
    $hardware->brand = $brand_name->name;
    $hardware->processor = $processor_name->name;
    $hardware->storage_type = $storage_type->name;

    $hardware->save();

    $notification = array(
             'message' => "Device Updated",
             'alert-type' => 'success'
         );

    $log = new Log();
    $log->user_id = Auth::user()->id;
    $log->created_by = Auth::user()->name;
    $log->description = 'Edited a Delivery';
    $log->action = 'Edit';
    $log->save();

    return Redirect::back()->with($notification);
  }

  public function deleteDelivery(Request $request, $id)
  {
     $hardware = Hardware::findOrFail($id);

     $hardware->status = "Disposed";
     $hardware->disposed_date = date('Y-m-d');

     $hardware->save();

     $notification = array(
              'message' => "Device Removed",
              'alert-type' => 'success'
          );

      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Disposed a Delivery';
      $log->action = 'Delete';
      $log->save();

     return Redirect::back()->with($notification);
  }

  public function repair(Request $request, $id)
  {
     $hardware = Hardware::findOrFail($id);

     $hardware->status = "Repair";

     $hardware->save();

     $notification = array(
              'message' => "Success",
              'alert-type' => 'success'
          );

      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Put Device on Repair';
      $log->action = 'Edit';
      $log->save();

     return Redirect::back()->with($notification);
  }


  public function importExcel(Request $request)
  {
    $excel = Excel::load(Input::file('excel'));
    $rows = Excel::load(Input::file('excel'), function ($reader){})->get()->toArray();

    if($excel->get()->first()->count() === 10)
    {
      foreach($rows as $row)
      {
        $hardware = new Hardware();

        $hardware_type = HardwareType::where('status', '=', 'Created')
                         ->where('name',$row['hardware_type'])->first();

        $brand = Brand::where('status', '=', 'Created')
                        ->where('name', '=', array_get($row, 'brand'))->first();

        $processor = Processor::where('status', '=', 'Created')
                          ->where('name', '=', array_get($row, 'processor'))->first();

        $storage_type = StorageType::where('status', '=', 'Created')
                        ->where('name', '=',array_get($row, 'storage_type'))->first();



        if($hardware_type != NULL && $brand != NULL && $processor != NULL && $storage_type != NULL )
        {
          $hardware->serial = $row['serial'];
          $hardware->model_name = $row['model_name'];
          $hardware->hardwaretype_id = $hardware_type->id;
          $hardware->brand_id = $brand->id;
          $hardware->processor_id = $processor->id;
          $hardware->ram = $row['ram'];
          $hardware->storage = $row['storage'];
          $hardware->storagetype_id = $storage_type->id;
          $hardware->purchased_date = $row['purchased_date'];
          $hardware->warranty_date = $row['warranty_date'];
          $hardware->status = "Delivered";

          $hardware->hardware_type = $hardware_type->name;
          $hardware->brand = $brand->name;
          $hardware->processor = $processor->name;
          $hardware->storage_type = $storage_type->name;

          $hardware->save();
        }
      }

        $notification = array(
                 'message' => "Delivery Data Saved",
                 'alert-type' => 'info'
             );


        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->created_by = Auth::user()->name;
        $log->description = 'Made a Bulk Delivery Entry';
        $log->action = 'Add';
        $log->save();

        return Redirect::back()->with($notification);
    }
    else
    {
      $notification = array(
               'message' => "Something wrong happened",
               'alert-type' => 'error'
           );
      return Redirect::back()->with($notification);
    }



  }

  public function importExcelDeployed(Request $request)
  {
        $excel = Excel::load(Input::file('excel'));
        $rows = Excel::load(Input::file('excel'), function ($reader){})->get()->toArray();

        if($excel->get()->first()->count() === 15)
        {
          foreach($rows as $row)
          {
            $hardware = new Hardware();

            $hardware_type = HardwareType::where('status', '=', 'Created')
                             ->where('name',$row['hardware_type'])->first();

            $brand = Brand::where('status', '=', 'Created')
                            ->where('name', '=', array_get($row, 'brand'))->first();

            $processor = Processor::where('status', '=', 'Created')
                              ->where('name', '=', array_get($row, 'processor'))->first();

            $storage_type = StorageType::where('status', '=', 'Created')
                            ->where('name', '=',array_get($row, 'storage_type'))->first();


            if($hardware_type != NULL && $brand != NULL && $processor != NULL && $storage_type != NULL )
            {
              $hardware->serial = $row['serial'];
              $hardware->user_id = Auth::user()->id;
              $hardware->model_name = $row['model_name'];
              $hardware->hardwaretype_id = $hardware_type->id;
              $hardware->brand_id = $brand->id;
              $hardware->processor_id = $processor->id;
              $hardware->ram = $row['ram'];
              $hardware->storage = $row['storage'];
              $hardware->storagetype_id = $storage_type->id;
              $hardware->purchased_date = $row['purchased_date'];
              $hardware->warranty_date = $row['warranty_date'];
              $hardware->status = "Deployed";

              $hardware->hardware_type = $hardware_type->name;
              $hardware->brand = $brand->name;
              $hardware->processor = $processor->name;
              $hardware->storage_type = $storage_type->name;

              $hardware->save();

              $employee = new Employee();
              $employee->hardware_id = $hardware->id;
              $employee->emp_id = $row['emp_id'];
              $employee->seat = $row['seatnum'];
              $employee->name = $row['deployed_to'];
              $employee->save();
            }

          }
        $notification = array(
                 'message' => "Excel Data Saved",
                 'alert-type' => 'info'
             );

             $log = new Log();
             $log->user_id = Auth::user()->id;
             $log->created_by = Auth::user()->name;
             $log->description = 'Made a Bulk Deployed Devices Entry';
             $log->action = 'Add';
             $log->save();

        return Redirect::back()->with($notification);
        }
        else
        {
          $notification = array(
                   'message' => "Something wrong happened",
                   'alert-type' => 'error'
               );
          return Redirect::back()->with($notification);
        }
  }

  public function repairAllSelected(Request $request)
  {
    $ids = $request->ids;
    DB::table("hardwares")->whereIn('id',explode(",",$ids))->update([
      'status' => 'Disposed',
      'disposed_date' => date('Y-m-d')
    ]);

    $notification = array(
             'message' => "All Selected Devices Removed",
             'alert-type' => 'error'
         );

         $log = new Log();
         $log->user_id = Auth::user()->id;
         $log->created_by = Auth::user()->name;
         $log->description = 'Disposed Devices';
         $log->action = 'Delete';
         $log->save();

    return Redirect::back()->with($notification);

  }

  public function deleteAllSelected(Request $request)
  {
    $ids = $request->ids;
    DB::table("hardwares")->whereIn('id',explode(",",$ids))->update([
      'status' => 'Disposed',
      'disposed_date' => date('Y-m-d')
    ]);

    $notification = array(
             'message' => "All Selected Devices Removed",
             'alert-type' => 'error'
         );

         $log = new Log();
         $log->user_id = Auth::user()->id;
         $log->created_by = Auth::user()->name;
         $log->description = 'Disposed Devices';
         $log->action = 'Delete';
         $log->save();

    return Redirect::back()->with($notification);

  }

  public function InAllSelected(Request $request)
  {
    $ids = array();

    $ids = explode(",",$request->ids);

    foreach ($ids as $id)
    {
      $hardware = Hardware::findOrFail($id);
      $hardware->status = "Inventory";
      $hardware->disposed_date = null;
      $hardware->save();
    }

    $notification = array(
             'message' => "Devices put to Inventory",
             'alert-type' => 'info'
         );

         $log = new Log();
         $log->user_id = Auth::user()->id;
         $log->created_by = Auth::user()->name;
         $log->description = 'Put Delivered Items to Inventory';
         $log->action = 'Edit';
         $log->save();

    return Redirect::back()->with($notification);

  }

  public function DeliveryAllSelected(Request $request)
  {
    $ids = array();

    $ids = explode(",",$request->ids);

    foreach ($ids as $id)
    {
      $hardware = Hardware::findOrFail($id);
      $hardware->status = "Delivered";
      $hardware->save();
    }

    $notification = array(
             'message' => "Devices put to Delivery",
             'alert-type' => 'info'
         );

         $log = new Log();
         $log->user_id = Auth::user()->id;
         $log->created_by = Auth::user()->name;
         $log->description = 'Put Devices to Inventory';
         $log->action = 'Edit';
         $log->save();

    return Redirect::back()->with($notification);

  }

  public function inventory()
  {
    $hardwares = Hardware::where('status', '=', 'Inventory')->orderBy('created_at', 'desc')->paginate(10);

    return view('inventory', compact('hardwares'));
  }

  public function repairPage()
  {
    $hardwares = Hardware::where('status', '=', 'Repair')->orderBy('created_at', 'desc')->paginate(10);

    return view('repair', compact('hardwares'));
  }

  public function disposed()
  {
    $hardwares = Hardware::where('status', '=', 'Disposed')->orderBy('created_at', 'desc')->paginate(10);

    return view('disposed', compact('hardwares'));
  }

  public function inventorySortByWarrantyASC()
  {
    $hardwares = Hardware::where('status', '=', 'Inventory')->orderBy('warranty_date', 'asc')->paginate(10);

    return view('inventory', compact('hardwares'));
  }

  public function inventorySortByWarrantyDESC()
  {
    $hardwares = Hardware::where('status', '=', 'Inventory')->orderBy('warranty_date', 'desc')->paginate(10);

    return view('inventory', compact('hardwares'));
  }

  public function inventorySortByPurchasedDateASC()
  {
    $hardwares = Hardware::where('status', '=', 'Inventory')->orderBy('purchased_date', 'asc')->paginate(10);

    return view('inventory', compact('hardwares'));
  }

  public function inventorySortByPurchasedDateDESC()
  {
    $hardwares = Hardware::where('status', '=', 'Inventory')->orderBy('purchased_date', 'desc')->paginate(10);

    return view('inventory', compact('hardwares'));
  }

  public function deployed()
  {
    $hardwares = Hardware::where('status', '=', 'Deployed')->orderBy('created_at', 'desc')->paginate(10);

    return view('deployed', compact('hardwares'));
  }

  public function deployedSortByWarrantyASC()
  {
    $hardwares = Hardware::where('status', '=', 'Deployed')->orderBy('warranty_date', 'asc')->paginate(10);

    return view('deployed', compact('hardwares'));
  }

  public function deployedSortByWarrantyDESC()
  {
    $hardwares = Hardware::where('status', '=', 'Deployed')->orderBy('warranty_date', 'desc')->paginate(10);

    return view('deployed', compact('hardwares'));
  }

  public function deployedSortByPurchasedDateASC()
  {
    $hardwares = Hardware::where('status', '=', 'Deployed')->orderBy('purchased_date', 'asc')->paginate(10);

    return view('deployed', compact('hardwares'));
  }

  public function deployedSortByPurchasedDateDESC()
  {
    $hardwares = Hardware::where('status', '=', 'Deployed')->orderBy('purchased_date', 'desc')->paginate(10);

    return view('deployed', compact('hardwares'));
  }

  public function singleDelivery(Request $request)
  {
    $delivery = new Hardware();

    $delivery->serial = $request->serial;
    $delivery->model_name = $request->model;
    $delivery->hardwaretype_id = $request->ht;
    $delivery->brand_id = $request->brand;
    $delivery->processor_id = $request->processor;
    $delivery->ram = $request->ram;
    $delivery->storage = $request->storage;
    $delivery->storagetype_id = $request->st;
    $delivery->purchased_date = $request->pd;
    $delivery->warranty_date = $request->wt;


    $hardware_type = HardwareType::find($request->ht);
    $brand_name = Brand::find($request->brand);
    $processor_name = Processor::find($request->processor);
    $storage_type = StorageType::find($request->st);

    $delivery->hardware_type = $hardware_type->name;
    $delivery->brand = $brand_name->name;
    $delivery->processor = $processor_name->name;
    $delivery->storage_type = $storage_type->name;


    $delivery->save();

    $notification = array(
             'message' => "Delivery Saved",
             'alert-type' => 'info'
         );
         $log = new Log();
         $log->user_id = Auth::user()->id;
         $log->created_by = Auth::user()->name;
         $log->description = 'Entered a Single Entry of Delivered Device';
         $log->action = 'Add';
         $log->save();
    return Redirect::back()->with($notification);
  }

  public function singleDeployed(Request $request)
  {
    $hardware = new Hardware();

    $hardware->serial = $request->serial;
    $hardware->model_name = $request->model;
    $hardware->hardwaretype_id = $request->ht;
    $hardware->brand_id = $request->brand;
    $hardware->processor_id = $request->processor;
    $hardware->ram = $request->ram;
    $hardware->storage = $request->storage;
    $hardware->storagetype_id = $request->st;
    $hardware->purchased_date = $request->pd;
    $hardware->warranty_date = $request->wt;
    $hardware->status = 'Deployed';
    $hardware->user_id = $request->db;
    $hardware->deployed_date = $request->dd;


    $hardware_type = HardwareType::find($request->ht);
    $brand_name = Brand::find($request->brand);
    $processor_name = Processor::find($request->processor);
    $storage_type = StorageType::find($request->st);

    if($hardware_type !== NULL && $brand_name !== NULL && $processor_name !== NULL && $storage_type !== NULL)
    {
      $hardware->hardware_type = $hardware_type->name;
      $hardware->brand = $brand_name->name;
      $hardware->processor = $processor_name->name;
      $hardware->storage_type = $storage_type->name;
    }
    else
    {
      $hardware->hardware_type ='';
      $hardware->brand ='';
      $hardware->processor = '';
      $hardware->storage_type = '';
    }

    $hardware->save();

    $employee = new Employee();

    $employee->hardware_id = $hardware->id;
    $employee->emp_id = $request->empid;
    $employee->seat = $request->sn;
    $employee->name = $request->dt;
    $employee->save();

    $notification = array(
             'message' => "Device Saved",
             'alert-type' => 'info'
         );

         $log = new Log();
         $log->user_id = Auth::user()->id;
         $log->created_by = Auth::user()->name;
         $log->description = 'Entered a Single Entry of Deployed Device';
         $log->action = 'Add';
         $log->save();

    return Redirect::back()->with($notification);
  }

  public function exportDeliveryExcel()
  {
    $log = new Log();
    $log->user_id = Auth::user()->id;
    $log->created_by = Auth::user()->name;
    $log->description = 'Generated a Delivery Excel Report';
    $log->action = 'Report';
    $log->save();

    Excel::create('Delivery '.Carbon::now()->format('M d, Y'), function($excel) {

        $excel->sheet('Delivery '.Carbon::now()->format('M d, Y'), function($sheet) {
            $hardwares = Hardware::where('status', 'Delivered')->get();
            $inventory = Hardware::where('status', 'Inventory')->count();
            $deliveries = Hardware::where('status', 'Delivered')->count();
            $deployed = Hardware::where('status', 'Deployed')->count();
            $disposed = Hardware::where('status', 'Disposed')->count();


            $sheet->loadView('partials.deliveriesExcel',
                      [
                        'hardwares' => $hardwares,
                        'inventory' => $inventory,
                        'deliveries' => $deliveries,
                        'deployed' => $deployed,
                        'disposed' => $disposed
                      ]);
            $sheet->getProtection()->setPassword('secret');
            $sheet->getProtection()->setSheet(true);

            $sheet->getStyle('A1:A4')->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

        });

    })->download('xls');
  }

  public function exportInventoryExcel()
  {
    $log = new Log();
    $log->user_id = Auth::user()->id;
    $log->created_by = Auth::user()->name;
    $log->description = 'Generated an Inventory Excel Report';
    $log->action = 'Report';
    $log->save();

    Excel::create('Inventory Excel Report '.Carbon::now()->format('M d, Y'), function($excel) {

        $excel->sheet('Inventory '.Carbon::now()->format('M d, Y'), function($sheet) {
            $hardwares = Hardware::where('status', 'Inventory')->get();
            $inventory = Hardware::where('status', 'Inventory')->count();
            $deliveries = Hardware::where('status', 'Delivered')->count();
            $deployed = Hardware::where('status', 'Deployed')->count();
            $disposed = Hardware::where('status', 'Disposed')->count();


            $sheet->loadView('partials.inventoriesExcel',
                      [
                        'hardwares' => $hardwares,
                        'inventory' => $inventory,
                        'deliveries' => $deliveries,
                        'deployed' => $deployed,
                        'disposed' => $disposed
                      ]);

            $sheet->getProtection()->setPassword('secret');
            $sheet->getProtection()->setSheet(true);

            $sheet->getStyle('A1:A4')->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

        });

    })->download('xls');
  }

  public function exportDeployedExcel()
  {
    $log = new Log();
    $log->user_id = Auth::user()->id;
    $log->created_by = Auth::user()->name;
    $log->description = 'Generated a Deployed Excel Report';
    $log->action = 'Report';
    $log->save();

    Excel::create('Deployed Excel '.Carbon::now()->format('M d, Y'), function($excel) {

        $excel->sheet('Deployed Excel '.Carbon::now()->format('M d, Y'), function($sheet) {
            $hardwares = Hardware::where('status', 'Deployed')->get();
            $inventory = Hardware::where('status', 'Inventory')->count();
            $deliveries = Hardware::where('status', 'Delivered')->count();
            $deployed = Hardware::where('status', 'Deployed')->count();
            $disposed = Hardware::where('status', 'Disposed')->count();


            $sheet->loadView('partials.deployedExcel',
                      [
                        'hardwares' => $hardwares,
                        'inventory' => $inventory,
                        'deliveries' => $deliveries,
                        'deployed' => $deployed,
                        'disposed' => $disposed
                      ]);
            $sheet->getProtection()->setPassword('secret');
            $sheet->getProtection()->setSheet(true);

            $sheet->getStyle('A1:A4')->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

        });

    })->download('xls');
  }

  public function exportDisposedExcel()
  {
    $log = new Log();
    $log->user_id = Auth::user()->id;
    $log->created_by = Auth::user()->name;
    $log->description = 'Generated a Disposed Excel Report';
    $log->action = 'Report';
    $log->save();

    Excel::create('Disposed Excel '.Carbon::now()->format('M d, Y'), function($excel) {

        $excel->sheet('Disposed Excel '.Carbon::now()->format('M d, Y'), function($sheet) {
            $hardwares = Hardware::where('status', 'Disposed')->get();
            $inventory = Hardware::where('status', 'Inventory')->count();
            $deliveries = Hardware::where('status', 'Delivered')->count();
            $deployed = Hardware::where('status', 'Deployed')->count();
            $disposed = Hardware::where('status', 'Disposed')->count();


            $sheet->loadView('partials.disposedExcel',
                      [
                        'hardwares' => $hardwares,
                        'inventory' => $inventory,
                        'deliveries' => $deliveries,
                        'deployed' => $deployed,
                        'disposed' => $disposed
                      ]);
            $sheet->getProtection()->setPassword('secret');
            $sheet->getProtection()->setSheet(true);

            $sheet->getStyle('A1:A4')->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

        });

    })->download('xls');
  }

  public function exportRepairExcel()
  {
    $log = new Log();
    $log->user_id = Auth::user()->id;
    $log->created_by = Auth::user()->name;
    $log->description = 'Generated Under Repair Assets Excel Report';
    $log->action = 'Report';
    $log->save();

    Excel::create('Under Repair Excel '.Carbon::now()->format('M d, Y'), function($excel) {

        $excel->sheet('Under Repair Excel '.Carbon::now()->format('M d, Y'), function($sheet) {
            $hardwares = Hardware::where('status', 'Repair')->get();
            $inventory = Hardware::where('status', 'Inventory')->count();
            $deliveries = Hardware::where('status', 'Delivered')->count();
            $deployed = Hardware::where('status', 'Deployed')->count();
            $disposed = Hardware::where('status', 'Disposed')->count();
            $repair = Hardware::where('status', 'Repair')->count();


            $sheet->loadView('partials.repairExcel',
                      [
                        'hardwares' => $hardwares,
                        'inventory' => $inventory,
                        'deliveries' => $deliveries,
                        'deployed' => $deployed,
                        'disposed' => $disposed,
                        'repair' => $repair
                      ]);
            $sheet->getProtection()->setPassword('secret');
            $sheet->getProtection()->setSheet(true);

            $sheet->getStyle('A1:A4')->getProtection()->setLocked(\PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);

        });

    })->download('xls');
  }

}
