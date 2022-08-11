<?php

namespace App\Http\Controllers;

use App\Notifications\IdleNotification;
use App\Mail\IdleMail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Auth;
use Notification;
use Mail;

class NotificationController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
      }

      /**
       * Store the PushSubscription.
       *
       * @param \Illuminate\Http\Request $request
       * @return \Illuminate\Http\JsonResponse
       */
      public function store(Request $request){
          $this->validate($request,[
              'endpoint'    => 'required',
              'keys.auth'   => 'required',
              'keys.p256dh' => 'required'
          ]);
          $endpoint = $request->endpoint;
          $token = $request->keys['auth'];
          $key = $request->keys['p256dh'];
          $user = Auth::user();
          $user->updatePushSubscription($endpoint, $key, $token);

          return response()->json(['success' => true],200);
      }

      public function notifyIdle() {
        $content = array (
            'title' => 'This is an idle notification',
            'body' => "I'm sorry, but I don't have anything to say you. Bye"
        );
        Auth::user()->notify(new IdleNotification($content));
        $mail_sent = Auth::user()->mail(new IdleMail($content));
        if($mail_sent !== 200) Log::channel('mailing-error')->error('Mailto '.Auth::user()->email.' could not be sent.');
        return redirect()->back();

      }

      public function push(){
        $content = array(
            'title' => 'Oh',
            'body' => 'This is a notification'
        );

        return redirect()->back();
    }
}
