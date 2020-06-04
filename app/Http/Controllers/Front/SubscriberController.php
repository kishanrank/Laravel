<?php

namespace App\Http\Controllers\Front;

use App\Subscriber;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        if (!($request->email)) {
            return response()->json(['message' => "Error in subscribing"]);
        }
        $subscriber_data = [
            'email' => $request->email
        ];
        $data = Subscriber::where('email', $request->email)->first();
        if ($data) {
            return response()->json(['message' => "This Email id is already available."]);
        }
        $subscriber = Subscriber::create($subscriber_data);
        // event(new SubscribedEvent($subscriber));
        return response()->json(['message' => 'Subscribed successfully!']);
    }
}
