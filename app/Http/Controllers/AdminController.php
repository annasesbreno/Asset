<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Notification;
use App\EventModel;
use Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Log;

class AdminController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function notifications()
  {
    $events = EventModel::all();


    foreach ($events as $event)
    {
          if($event->start = Carbon::today())
          {
            if($event->notified !== 'TRUE')
            {
              $notification = new Notification();
              $notification->title = $event->title.' is today!';
              $notification->description = 'Check for more details';
              $notification->status = 'Unread';
              $notification->save();

              $event->notified = 'TRUE';
              $event->save();
            }
          }
    }
  }

  public function readNotif(Request $request, $id)
  {
    $notification = Notification::findOrFail($id);
    $notification->status = 'Read';
    $notification->save();

  }

  public function index()
  {
    $users = User::where('status', 'Created')->paginate(5);
    return view('admin.administrators', compact('users'));
  }

  public function changeRole(Request $request, $id)
  {
    $user = User::findOrFail($id);
    $user->role = $request->role;
    $user->save();

    $notification = array(
             'message' => "Role Changed",
             'alert-type' => 'info'
         );

    return Redirect::back()->with($notification);
  }

  public function deleteUser(Request $request, $id)
  {
    $user = User::findOrFail($id);
    $user->status = 'Deleted';
    $user->save();

    $notification = array(
             'message' => "User Deleted",
             'alert-type' => 'info'
         );

    return Redirect::back()->with($notification);
  }

  public function profile()
  {
    return view('admin.profile');
  }

  public function EditProfile(Request $request)
  {
    $user = User::findOrFail(Auth::user()->id);
    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();

    $notification = array(
             'message' => "Profile Updated",
             'alert-type' => 'info'
         );

    return Redirect::back()->with($notification);
  }
}
