<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Log;
class LogsController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index()
  {
    $logs = Log::orderBy('created_at', 'desc')->paginate(5);
    return view('logs.logViewer', compact('logs'));
  }

  public function added()
  {
    $logs = Log::where('action', 'Add')->orderBy('created_at', 'desc')->paginate(5);
    return view('logs.AddedLogViewer', compact('logs'));
  }

  public function edited()
  {
    $logs = Log::where('action', 'Edit')->orderBy('created_at', 'desc')->paginate(5);
    return view('logs.EditedLogViewer', compact('logs'));
  }

  public function deleted()
  {
    $logs = Log::where('action', 'Delete')->orderBy('created_at', 'desc')->paginate(5);
    return view('logs.DeletedLogViewer', compact('logs'));
  }

  public function logs()
  {
    $logs = Log::where('action', 'Log')->orderBy('created_at', 'desc')->paginate(5);
    return view('logs.UserLogsViewer', compact('logs'));
  }

  public function reports()
  {
    $logs = Log::where('action', 'Report')->orderBy('created_at', 'desc')->paginate(5);
    return view('logs.ReportLogViewer', compact('logs'));
  }
}
