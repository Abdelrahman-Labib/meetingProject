<?php

namespace App\Http\Controllers;

use App\Jobs\SendMeetingMail;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Http\Request;

class MeetingController extends Controller
{
    public function store(Request $request)
    {
        //VALIDATE REQUEST
        $rules = [
            'name'           => 'required|max:190',
            'start_datetime' => 'required|date_format:Y-m-d H:i:s',
            'end_datetime'   => 'required|date_format:Y-m-d H:i:s',
        ];
        $request->validate($rules);

        //STORE MEETING
        $meeting = Meeting::create($rules);

        $users = User::select('id','email')->chunk(50, function($data) use ($meeting){
            dispatch(new SendMeetingMail($data, $meeting));
        });

        $meeting->users()->attach($users);

        return 'Store successfully';
    }
}
