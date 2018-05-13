<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Charts;
use App\Hardware;
use App\Employee;
use App\User;
use App;
use PDF;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Excel;
use App\Log;
use App\EventModel;
use App\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // $events = EventModel::all();
      //
      //
      // foreach ($events as $event)
      // {
      //       if($event->start = Carbon::today())
      //       {
      //         if($event->notified !== 'TRUE')
      //         {
      //           $notification = new Notification();
      //           $notification->title = $event->title.' is today!';
      //           $notification->description = 'Check for more details';
      //           $notification->status = 'Unread';
      //           $notification->save();
      //
      //           $event->notified = 'TRUE';
      //           $event->save();
      //         }
      //       }
      // }

      $status = Charts::database(Hardware::all(), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Device Status')
                ->elementLabel("Device Status")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('status')
                ->width(600);

      $vendor = Charts::database(Hardware::where('status', '!=', 'Disposed')->get(), 'pie', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Vendors')
                  ->elementLabel("Device Vendors")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('brand')
                  ->width(600);

      $hardware_type = Charts::database(Hardware::where('status', '!=', 'Disposed')->get(), 'donut', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Hardware Type')
                  ->elementLabel("Hardware")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('hardware_type')
                  ->width(700);

                  return view('home',
                           [
                             'status' => $status,
                             'vendor' => $vendor,
                             'hardware_type' => $hardware_type,
                             'from' => null,
                             'to' => null,
                             'date' => null
                           ]);

    }

    /*Today Date Filter*/
    public function today()
    {
      $date = 'Today';
      $status = Charts::database(Hardware::all()
                ->where('status', '!=', 'Disposed')
                ->where('created_at', '>=', Carbon::today()->toDateString()), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Device Status')
                ->elementLabel("Device Status")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('status')
                ->width(600);

      $vendor = Charts::database(Hardware::where('status', '!=', 'Disposed')
                  ->where('status', '!=', 'Disposed')
                  ->where('created_at', '>=', Carbon::today()->toDateString())
                  ->get(), 'pie', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Vendors')
                  ->elementLabel("Device Vendors")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('brand')
                  ->width(600);

      $hardware_type = Charts::database(Hardware::where('status', '!=', 'Disposed')
                  ->where('status', '!=', 'Disposed')
                  ->where('created_at', '>=', Carbon::today()->toDateString())
                  ->get(), 'donut', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Hardware Type')
                  ->elementLabel("Hardware")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('hardware_type')
                  ->width(700);

                  return view('home',
                           [
                             'status' => $status,
                             'vendor' => $vendor,
                             'hardware_type' => $hardware_type,
                             'from' => null,
                             'to' => null,
                             'date' => $date
                           ]);

    }
    /*End Today Date Filter*/

    /*Yesterday Date Filter*/
    public function yesterday()
    {
      $date = 'Yesterday';
      $yesterday = date("Y-m-d", strtotime( '-1 days' ) );
      $status = Charts::database(DB::table('hardwares')
                ->where('status', '!=', 'Disposed')
                ->whereDate('created_at', $yesterday )->get(), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Device Status')
                ->elementLabel("Device Status")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('status')
                ->width(600);

      $vendor = Charts::database(DB::table('hardwares')
                  ->where('status', '!=', 'Disposed')
                  ->whereDate('created_at', $yesterday )->get(), 'pie', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Vendors')
                  ->elementLabel("Device Vendors")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('brand')
                  ->width(600);

      $hardware_type = Charts::database(Hardware::where('status', '!=', 'Disposed')
                  ->whereDate('created_at', $yesterday )->get(), 'donut', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Hardware Type')
                  ->elementLabel("Hardware")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('hardware_type')
                  ->width(700);

                  return view('home',
                           [
                             'status' => $status,
                             'vendor' => $vendor,
                             'hardware_type' => $hardware_type,
                             'from' => null,
                             'to' => null,
                             'date' => $date
                           ]);

    }
    /*End Yesterday Date Filter*/

    /*Last 7 Days Date Filter*/
    public function week()
    {
      $date = 'Last 7 Days';
      $status = Charts::database(Hardware::all()
                ->where('status', '!=', 'Disposed')
                ->where('created_at', '>', Carbon::now()->subWeek()->toDateString()), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Device Status')
                ->elementLabel("Device Status")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('status')
                ->width(600);

      $vendor = Charts::database(Hardware::where('status', '!=', 'Disposed')
                  ->where('status', '!=', 'Disposed')
                  ->where('created_at', '>', Carbon::now()->subWeek()->toDateString())
                  ->get(), 'pie', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Vendors')
                  ->elementLabel("Device Vendors")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('brand')
                  ->width(600);

      $hardware_type = Charts::database(Hardware::where('status', '!=', 'Disposed')
                  ->where('status', '!=', 'Disposed')
                  ->where('created_at', '>', Carbon::now()->subWeek()->toDateString())
                  ->get(), 'donut', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Hardware Type')
                  ->elementLabel("Hardware")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('hardware_type')
                  ->width(700);

                  return view('home',
                           [
                             'status' => $status,
                             'vendor' => $vendor,
                             'hardware_type' => $hardware_type,
                             'from' => null,
                             'to' => null,
                             'date' => $date
                           ]);

    }
    /*End Last 7 Days Date Filter*/



    /*This Month Date Filter*/
    public function month()
    {
      $currentMonth = date('m');
      $date = 'This Month';
      $status = Charts::database(DB::table("hardwares")
                ->where('status', '!=', 'Disposed')
                ->whereRaw('MONTH(created_at) = ?',[$currentMonth])->get(), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Device Status')
                ->elementLabel("Device Status")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('status')
                ->width(600);

      $vendor = Charts::database(DB::table("hardwares")
                  ->where('status', '!=', 'Disposed')
                  ->whereRaw('MONTH(created_at) = ?',[$currentMonth])->get(), 'pie', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Vendors')
                  ->elementLabel("Device Vendors")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('brand')
                  ->width(600);

      $hardware_type = Charts::database(DB::table("hardwares")
                  ->where('status', '!=', 'Disposed')
                  ->whereRaw('MONTH(created_at) = ?',[$currentMonth])->get(), 'donut', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Hardware Type')
                  ->elementLabel("Hardware")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('hardware_type')
                  ->width(700);

                  return view('home',
                           [
                             'status' => $status,
                             'vendor' => $vendor,
                             'hardware_type' => $hardware_type,
                             'from' => null,
                             'to' => null,
                             'date' => $date
                           ]);

    }
    /*End This Month Date Filter*/

    /*Last Month Date Filter*/
    public function lastMonth()
    {
      $date = 'Last Month';
      $status = Charts::database(Hardware::all()
                ->where('status', '!=', 'Disposed')
                ->where('created_at', '<=', Carbon::now()->subMonth()), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Device Status')
                ->elementLabel("Device Status")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('status')
                ->width(600);

      $vendor = Charts::database(Hardware::all()
                  ->where('status', '!=', 'Disposed')
                  ->where('created_at', '<=', Carbon::now()->subMonth()), 'pie', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Vendors')
                  ->elementLabel("Device Vendors")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('brand')
                  ->width(600);

      $hardware_type = Charts::database(Hardware::all()
                  ->where('status', '!=', 'Disposed')
                  ->where('created_at', '<=', Carbon::now()->subMonth()), 'donut', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Hardware Type')
                  ->elementLabel("Hardware")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('hardware_type')
                  ->width(700);

                  return view('home',
                           [
                             'status' => $status,
                             'vendor' => $vendor,
                             'hardware_type' => $hardware_type,
                             'from' => null,
                             'to' => null,
                             'date' => $date
                           ]);

    }
    /*Last Month Date Filter*/

    /*Default Stats Report*/
    public function dashboard()
    {
      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Generated Dashboard Report';
      $log->action = 'Report';
      $log->save();

      $date = date('M d, Y');
      $status = Charts::database(Hardware::all(), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Device Status')
                ->elementLabel("Device Status")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('status')
                ->width(600);

      $vendor = Charts::database(Hardware::all(), 'pie', 'highcharts')
                            ->colors(['#3ba594', '#64cefc', '#ffee07'])
                            ->title('Vendors')
                            ->elementLabel("Device Vendors")
                            ->dimensions(1000, 500)
                            ->responsive(false)
                            ->groupBy('brand')
                            ->width(600);

      $hardware_type = Charts::database(Hardware::all(), 'donut', 'highcharts')
                            ->colors(['#3ba594', '#64cefc', '#ffee07'])
                            ->title('Hardware Type')
                            ->elementLabel("Hardware")
                            ->dimensions(1000, 500)
                            ->responsive(false)
                            ->groupBy('hardware_type')
                            ->width(700);



      $pdf = App::make('snappy.pdf.wrapper');
      $pdf = PDF::loadView('reports/dashboard-report',
      ['status' => $status,  'vendor' => $vendor, 'hardware_type' => $hardware_type, 'date' => $date ])
      ->setOption('enable-javascript', true)
              ->setOption('images', true)
              ->setOption('javascript-delay', 13000)
              ->setOption('enable-smart-shrinking', true)
              ->setOption('no-stop-slow-scripts', true);

      return $pdf->inline();
    }
    /*End Default Stats Report*/

    /*Stats Report with Date Range*/
    public function dashboardDateRange(Request $request, $fromd, $tod)
    {
      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Generated Dashboard Report';
      $log->action = 'Report';
      $log->save();

      $status = Charts::database(
                Hardware::where('created_at','>=',$fromd)
                ->where('created_at','<=',$tod)
                ->get()
                , 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Device Status')
                ->elementLabel("Device Status")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('status')
                ->width(600);

      $vendor = Charts::database(
                            Hardware::where('created_at','>=',$fromd)
                            ->where('created_at','<=',$tod)
                            ->get()
                            , 'pie', 'highcharts')
                            ->colors(['#3ba594', '#64cefc', '#ffee07'])
                            ->title('Vendors')
                            ->elementLabel("Device Vendors")
                            ->dimensions(1000, 500)
                            ->responsive(false)
                            ->groupBy('brand')
                            ->width(600);

      $hardware_type = Charts::database(
                            Hardware::where('created_at','>=',$fromd)
                            ->where('created_at','<=',$tod)
                            ->get()
                            , 'donut', 'highcharts')
                            ->colors(['#3ba594', '#64cefc', '#ffee07'])
                            ->title('Hardware Type')
                            ->elementLabel("Hardware")
                            ->dimensions(1000, 500)
                            ->responsive(false)
                            ->groupBy('hardware_type')
                            ->width(700);

      $fromd = Carbon::parse($fromd)->format('Y-m-d');
      $tod = Carbon::parse($tod)->format('Y-m-d');

      $pdf = App::make('snappy.pdf.wrapper');
      $pdf = PDF::loadView('reports/dashboard-reportDR',
      [
        'status' => $status,
        'vendor' => $vendor,
        'hardware_type' => $hardware_type,
        'fromd' => $fromd,
        'tod' => $tod
      ])
      ->setOption('enable-javascript', true)
              ->setOption('images', true)
              ->setOption('javascript-delay', 13000)
              ->setOption('enable-smart-shrinking', true)
              ->setOption('no-stop-slow-scripts', true);

      return $pdf->inline();


    }
    /*End Stats Report with Date Range*/


    /*Today Stats Report*/
    public function todayReport()
    {
      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Generated Dashboard Report';
      $log->action = 'Report';
      $log->save();

      $date = "Today";
      $status = Charts::database(Hardware::all()
                ->where('status', '!=', 'Disposed')
                ->where('created_at', '>=', Carbon::today()->toDateString()), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Device Status')
                ->elementLabel("Device Status")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('status')
                ->width(600);

      $vendor = Charts::database(Hardware::where('status', '!=', 'Disposed')
                  ->where('status', '!=', 'Disposed')
                  ->where('created_at', '>=', Carbon::today()->toDateString())
                  ->get(), 'pie', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Vendors')
                  ->elementLabel("Device Vendors")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('brand')
                  ->width(600);

      $hardware_type = Charts::database(Hardware::where('status', '!=', 'Disposed')
                  ->where('status', '!=', 'Disposed')
                  ->where('created_at', '>=', Carbon::today()->toDateString())
                  ->get(), 'donut', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Hardware Type')
                  ->elementLabel("Hardware")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('hardware_type')
                  ->width(700);



      $pdf = App::make('snappy.pdf.wrapper');
      $pdf = PDF::loadView('reports/dashboard-report',
      ['status' => $status,  'vendor' => $vendor, 'hardware_type' => $hardware_type, 'date' => $date ])
      ->setOption('enable-javascript', true)
              ->setOption('images', true)
              ->setOption('javascript-delay', 13000)
              ->setOption('enable-smart-shrinking', true)
              ->setOption('no-stop-slow-scripts', true);

      return $pdf->inline();
    }
    /*End Today Stats Report*/

    /*Yesterday Stats Report*/
    public function yesterdayReport()
    {
      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Generated Dashboard Report';
      $log->action = 'Report';
      $log->save();

      $date = 'Yesterday';
      $yesterday = date("Y-m-d", strtotime( '-1 days' ) );
      $status = Charts::database(DB::table('hardwares')
                ->where('status', '!=', 'Disposed')
                ->whereDate('created_at', $yesterday )->get(), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Device Status')
                ->elementLabel("Device Status")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('status')
                ->width(600);

      $vendor = Charts::database(DB::table('hardwares')
                  ->where('status', '!=', 'Disposed')
                  ->whereDate('created_at', $yesterday )->get(), 'pie', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Vendors')
                  ->elementLabel("Device Vendors")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('brand')
                  ->width(600);

      $hardware_type = Charts::database(Hardware::where('status', '!=', 'Disposed')
                  ->whereDate('created_at', $yesterday )->get(), 'donut', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Hardware Type')
                  ->elementLabel("Hardware")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('hardware_type')
                  ->width(700);



      $pdf = App::make('snappy.pdf.wrapper');
      $pdf = PDF::loadView('reports/dashboard-report',
      ['status' => $status,  'vendor' => $vendor, 'hardware_type' => $hardware_type, 'date' => $date ])
      ->setOption('enable-javascript', true)
              ->setOption('images', true)
              ->setOption('javascript-delay', 13000)
              ->setOption('enable-smart-shrinking', true)
              ->setOption('no-stop-slow-scripts', true);

      return $pdf->inline();
    }
    /*End Yesterday Stats Report*/

    /*Last 7 Days Week Stats Report*/
    public function weekReport()
    {
      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Generated Dashboard Report';
      $log->action = 'Report';
      $log->save();

      $date = 'Last 7 Days';
      $status = Charts::database(Hardware::all()
                ->where('status', '!=', 'Disposed')
                ->where('created_at', '>', Carbon::now()->subWeek()->toDateString()), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Device Status')
                ->elementLabel("Device Status")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('status')
                ->width(600);

      $vendor = Charts::database(Hardware::where('status', '!=', 'Disposed')
                  ->where('status', '!=', 'Disposed')
                  ->where('created_at', '>', Carbon::now()->subWeek()->toDateString())
                  ->get(), 'pie', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Vendors')
                  ->elementLabel("Device Vendors")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('brand')
                  ->width(600);

      $hardware_type = Charts::database(Hardware::where('status', '!=', 'Disposed')
                  ->where('status', '!=', 'Disposed')
                  ->where('created_at', '>', Carbon::now()->subWeek()->toDateString())
                  ->get(), 'donut', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Hardware Type')
                  ->elementLabel("Hardware")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('hardware_type')
                  ->width(700);



      $pdf = App::make('snappy.pdf.wrapper');
      $pdf = PDF::loadView('reports/dashboard-report',
      ['status' => $status,  'vendor' => $vendor, 'hardware_type' => $hardware_type, 'date' => $date ])
      ->setOption('enable-javascript', true)
              ->setOption('images', true)
              ->setOption('javascript-delay', 13000)
              ->setOption('enable-smart-shrinking', true)
              ->setOption('no-stop-slow-scripts', true);

      return $pdf->inline();
    }
    /*End Last 7 Days Week Stats Report*/

    /*This Month Stats Report*/
    public function monthReport()
    {
      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Generated Dashboard Report';
      $log->action = 'Report';
      $log->save();

      $currentMonth = date('m');
      $date = 'This Month';
      $status = Charts::database(DB::table("hardwares")
                ->where('status', '!=', 'Disposed')
                ->whereRaw('MONTH(created_at) = ?',[$currentMonth])->get(), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Device Status')
                ->elementLabel("Device Status")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('status')
                ->width(600);

      $vendor = Charts::database(DB::table("hardwares")
                  ->where('status', '!=', 'Disposed')
                  ->whereRaw('MONTH(created_at) = ?',[$currentMonth])->get(), 'pie', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Vendors')
                  ->elementLabel("Device Vendors")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('brand')
                  ->width(600);

      $hardware_type = Charts::database(DB::table("hardwares")
                  ->where('status', '!=', 'Disposed')
                  ->whereRaw('MONTH(created_at) = ?',[$currentMonth])->get(), 'donut', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Hardware Type')
                  ->elementLabel("Hardware")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('hardware_type')
                  ->width(700);



      $pdf = App::make('snappy.pdf.wrapper');
      $pdf = PDF::loadView('reports/dashboard-report',
      ['status' => $status,  'vendor' => $vendor, 'hardware_type' => $hardware_type, 'date' => $date ])
      ->setOption('enable-javascript', true)
              ->setOption('images', true)
              ->setOption('javascript-delay', 13000)
              ->setOption('enable-smart-shrinking', true)
              ->setOption('no-stop-slow-scripts', true);

      return $pdf->inline();
    }
    /*End This Month Stats Report*/

    /*This Last Stats Report*/
    public function lastMonthReport()
    {
      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Generated Dashboard Report';
      $log->action = 'Report';
      $log->save();

      $date = 'Last Month';
      $status = Charts::database(Hardware::all()
                ->where('status', '!=', 'Disposed')
                ->where('created_at', '<=', Carbon::now()->subMonth()), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Device Status')
                ->elementLabel("Device Status")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('status')
                ->width(600);

      $vendor = Charts::database(Hardware::all()
                  ->where('status', '!=', 'Disposed')
                  ->where('created_at', '<=', Carbon::now()->subMonth()), 'pie', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Vendors')
                  ->elementLabel("Device Vendors")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('brand')
                  ->width(600);

      $hardware_type = Charts::database(Hardware::all()
                  ->where('status', '!=', 'Disposed')
                  ->where('created_at', '<=', Carbon::now()->subMonth()), 'donut', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Hardware Type')
                  ->elementLabel("Hardware")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('hardware_type')
                  ->width(700);



      $pdf = App::make('snappy.pdf.wrapper');
      $pdf = PDF::loadView('reports/dashboard-report',
      ['status' => $status,  'vendor' => $vendor, 'hardware_type' => $hardware_type, 'date' => $date ])
      ->setOption('enable-javascript', true)
              ->setOption('images', true)
              ->setOption('javascript-delay', 13000)
              ->setOption('enable-smart-shrinking', true)
              ->setOption('no-stop-slow-scripts', true);

      return $pdf->inline();
    }
    /*End Last Month Stats Report*/

    public function deliveries()
    {
      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Generated Deliveries Report';
      $log->action = 'Report';
      $log->save();

      $delivery_count = Hardware::where('status', '=', 'Delivered')->count();

      $laptop_count = Hardware::where('status', '=', 'Delivered')
                      ->where('hardware_type', '=','Laptop')->count();

      $desktop_count = Hardware::where('status', '=', 'Delivered')
              ->where('hardware_type', '=','Desktop')->count();



      $deliveries = Charts::database(Hardware::where('status', '=', 'Delivered')->get(), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Delivery Quantity')
                ->elementLabel("Delivery Quantity")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('brand')
                ->width(600);

                 $pdf = App::make('snappy.pdf.wrapper');
                 $pdf = PDF::loadView('reports/deliveries-report',
                 ['deliveries' => $deliveries, 'delivery_count' => $delivery_count, 'laptop_count' => $laptop_count,
                   'desktop_count' => $desktop_count])
                 ->setOption('enable-javascript', true)
                         ->setOption('images', true)
                         ->setOption('javascript-delay', 13000)
                         ->setOption('enable-smart-shrinking', true)
                         ->setOption('no-stop-slow-scripts', true);

                 return $pdf->inline();


                            //return view('reports/deliveries-report', compact('deliveries' , $deliveries));
    }



    public function inventory()
    {
      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Generated Inventory Report';
      $log->action = 'Report';
      $log->save();

      $inventory_count = Hardware::where('status', '=', 'Inventory')->count();

      $laptop_count = Hardware::where('status', '=', 'Inventory')
                      ->where('hardware_type', '=','Laptop')->count();

      $desktop_count = Hardware::where('status', '=', 'Inventory')
              ->where('hardware_type', '=','Desktop')->count();



      $inventory = Charts::database(Hardware::where('status', '=', 'Inventory')->get(), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Inventory Quantity')
                ->elementLabel("Inventory Quantity")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('brand')
                ->width(600);

                 $pdf = App::make('snappy.pdf.wrapper');
                 $pdf = PDF::loadView('reports/inventory-report',
                 ['inventory'=>$inventory, 'inventory_count' => $inventory_count, 'laptop_count' => $laptop_count,
                   'desktop_count' => $desktop_count])
                 ->setOption('enable-javascript', true)
                         ->setOption('images', true)
                         ->setOption('javascript-delay', 13000)
                         ->setOption('enable-smart-shrinking', true)
                         ->setOption('no-stop-slow-scripts', true);

                 return $pdf->inline();

                 //return view('reports/deliveries-report', compact('deliveries' , $deliveries));
    }

    public function disposed()
    {
      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Generated Disposed Assets Report';
      $log->action = 'Report';
      $log->save();

      $disposed_count = Hardware::where('status', '=', 'Disposed')->count();

      $laptop_count = Hardware::where('status', '=', 'Disposed')
                      ->where('hardware_type', '=','Laptop')->count();

      $desktop_count = Hardware::where('status', '=', 'Disposed')
              ->where('hardware_type', '=','Desktop')->count();



      $disposed = Charts::database(Hardware::where('status', '=', 'Disposed')->get(), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Disposed Quantity')
                ->elementLabel("Disposed Quantity")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('brand')
                ->width(600);

                 $pdf = App::make('snappy.pdf.wrapper');
                 $pdf = PDF::loadView('reports/disposed-report',
                 ['disposed'=>$disposed, 'disposed_count' => $disposed_count, 'laptop_count' => $laptop_count,
                   'desktop_count' => $desktop_count])
                 ->setOption('enable-javascript', true)
                         ->setOption('images', true)
                         ->setOption('javascript-delay', 13000)
                         ->setOption('enable-smart-shrinking', true)
                         ->setOption('no-stop-slow-scripts', true);

                 return $pdf->inline();

                 //return view('reports/deliveries-report', compact('deliveries' , $deliveries));
    }

    public function repair()
    {
      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Generated Assets Under Repair Report';
      $log->action = 'Report';
      $log->save();

      $repair_count = Hardware::where('status', '=', 'Repair')->count();

      $laptop_count = Hardware::where('status', '=', 'Repair')
                      ->where('hardware_type', '=','Laptop')->count();

      $desktop_count = Hardware::where('status', '=', 'Repair')
              ->where('hardware_type', '=','Desktop')->count();



      $repair = Charts::database(Hardware::where('status', '=', 'Repair')->get(), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Assets Under Repair Quantity')
                ->elementLabel("Assets Under Repair Quantity")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('brand')
                ->width(600);

                 $pdf = App::make('snappy.pdf.wrapper');
                 $pdf = PDF::loadView('reports/repair-report',
                 ['repair'=>$repair, 'repair_count' => $repair_count, 'laptop_count' => $laptop_count,
                   'desktop_count' => $desktop_count])
                 ->setOption('enable-javascript', true)
                         ->setOption('images', true)
                         ->setOption('javascript-delay', 13000)
                         ->setOption('enable-smart-shrinking', true)
                         ->setOption('no-stop-slow-scripts', true);

                 return $pdf->inline();

                 //return view('reports/deliveries-report', compact('deliveries' , $deliveries));
    }


    public function deployed()
    {
      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Generated Deployed Report';
      $log->action = 'Report';
      $log->save();

      $deployed_count = Hardware::where('status', '=', 'Deployed')->count();

      $laptop_count = Hardware::where('status', '=', 'Deployed')
                      ->where('hardware_type', '=','Laptop')->count();

      $desktop_count = Hardware::where('status', '=', 'Deployed')
              ->where('hardware_type', '=','Desktop')->count();



      $deployed = Charts::database(Hardware::where('status', '=', 'Deployed')->get(), 'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Deployed Devices Quantity')
                ->elementLabel("Deployed Devices Quantity")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('brand')
                ->width(600);

                 $pdf = App::make('snappy.pdf.wrapper');
                 $pdf = PDF::loadView('reports/deployed-report',
                 ['deployed'=>$deployed, 'deployed_count' => $deployed_count, 'laptop_count' => $laptop_count,
                   'desktop_count' => $desktop_count])
                 ->setOption('enable-javascript', true)
                         ->setOption('images', true)
                         ->setOption('javascript-delay', 13000)
                         ->setOption('enable-smart-shrinking', true)
                         ->setOption('no-stop-slow-scripts', true);

                 return $pdf->inline();

                 //return view('reports/deliveries-report', compact('deliveries' , $deliveries));
    }

    public function dateRange(Request $request)
    {

      $format = 'Y-m-d';
      $from = Carbon::createFromFormat($format, $request->from);
      $to = Carbon::createFromFormat($format, $request->to);


      $status = Charts::database(
                  Hardware::
                  where('created_at','>=',$from)
                  ->where('created_at','<=',$to)
                  ->get()
                   ,'bar', 'highcharts')
                ->colors(['#3ba594', '#64cefc', '#ffee07'])
                ->title('Device Status')
                ->elementLabel("Device Status")
                ->dimensions(1000, 500)
                ->responsive(false)
                ->groupBy('status')
                ->width(600);

      $vendor = Charts::database(
                  Hardware::where('status', '!=', 'Disposed')
                  ->where('created_at','>=',$from)
                  ->where('created_at','<=',$to)
                  ->get()
                  , 'pie', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Vendors')
                  ->elementLabel("Device Vendors")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('brand')
                  ->width(600);

      $hardware_type = Charts::database(
                  Hardware::where('status', '!=', 'Disposed')
                  ->where('created_at','>=',$from)
                  ->where('created_at','<=',$to)
                  ->get()
                  , 'donut', 'highcharts')
                  ->colors(['#3ba594', '#64cefc', '#ffee07'])
                  ->title('Hardware Type')
                  ->elementLabel("Hardware")
                  ->dimensions(1000, 500)
                  ->responsive(false)
                  ->groupBy('hardware_type')
                  ->width(700);

     return view('home',
              [
                'status' => $status,
                'vendor' => $vendor,
                'hardware_type' => $hardware_type,
                'from' => $from,
                'to' => $to
              ]);
    }

    public function exportDashboardExcel()
    {
      $log = new Log();
      $log->user_id = Auth::user()->id;
      $log->created_by = Auth::user()->name;
      $log->description = 'Generated Dashboard Excel Report';
      $log->action = 'Report';
      $log->save();


      Excel::create('Dashboard '.Carbon::now()->format('M d, Y'), function($excel) {

          $excel->sheet('Dashboard '.Carbon::now()->format('M d, Y'), function($sheet) {
              $hardwares = Hardware::all();
              $inventory = Hardware::where('status', 'Inventory')->count();
              $deliveries = Hardware::where('status', 'Delivered')->count();
              $deployed = Hardware::where('status', 'Deployed')->count();
              $disposed = Hardware::where('status', 'Disposed')->count();


              $sheet->loadView('partials.dashboardExcel',
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
}
