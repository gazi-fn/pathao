<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Record;
use Carbon\Carbon;

class RecordController extends Controller
{

    // protected $expireMinutes = 5;

    public function index(Request $request)
    {
        // $this->deleteOldRecords(); // delete records created more than 5 min ago

        if ($request->has('keys')) {
            $keyString = $request->input('keys');
            $keys = explode(',', $keyString);
            $records = Record::select('key', 'value')->whereIn('key', $keys)->get();
        } else {
            $records = Record::select('key', 'value')->get();
        }

        $results = [];
        foreach ($records as $record) {
            $results[$record['key']] = $record['value'];
        }

        return response()->json($results);
    }

    public function create(Request $request)
    {
        $post = file_get_contents("php://input");
        $records = json_decode($post, true);
        
        if (!is_array($records)) {
            return response()->json(['success' => false, 'message' => "Please enter a valid input!"]);
        }

        $insData = [];
        foreach ($records as $key => $val) {
            if (is_array($val)) {
                return response()->json(['success' => false, 'message' => "Please enter a valid input!"]);
            }
            $insData[] = ['key' => $key, 'value' => $val, 'created_at' => Carbon::now()];
        }

        Record::insert($insData);
        $this->deleteOldRecords();

        return response()->json(['success' => true, 'code' => 200]);
    }

    // private function deleteOldRecords() // Commented because this task is done by schedule at Kernel.php
    // {
    //     Record::where('created_at', '<', Carbon::now()->subMinutes($this->expireMinutes)->toDateTimeString())->delete();
    // }

}
