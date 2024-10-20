<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Hash;

use App\Models\Api;

use DB;
use Str;

class ApiController extends Controller {
    
    public function postApiUserLogin(Request $request){
        if($request->header("accept") != "application/json") {
            return response()->json([
                "status" => 0,
                "message" => "Format accept must application/json",
                "data" => null
            ]);
        }

        if($request->header("key") != "room_schedule_test") {
            return response()->json([
                "status" => 0,
                "message" => "Key is invalid",
                "data" => null
            ]);
        }
        $data = $request->all();
        $username = $data['username'];
        $password = $data['password'];
        
        $sqlUsername = DB::table('users')
                ->where('username', '=', $username)
                ->first();
        if($sqlUsername == null){
            return response()->json([
                "status" => 0,
                "message" => "Data user not found",
                "data" => null
            ]);
        }
        if (Hash::check($password, $sqlUsername->password)) {
            $modelApi = New Api;
            $dataParam = array(
                'object_id' => $modelApi->get_encode($sqlUsername->id),
                'username' => $sqlUsername->username
            );
            return response()->json([
                "status" => 1,
                "message" => null,
                "data" => $dataParam
            ]);
        }
        if($sqlUsername == null){
            return response()->json([
                "status" => 0,
                "message" => "Data user not found",
                "data" => null
            ]);
        }
    }
    
//    {
//        "status": 1,
//        "message": null,
//        "data": {
//            "object_id": "bzRWT28vZ3BUM0E9",
//            "username": "myuser"
//        }
//    }
    
    public function postApiBookingRoom(Request $request){
        if($request->header("accept") != "application/json") {
            return response()->json([
                "status" => 0,
                "message" => "Format accept must application/json",
                "data" => null
            ]);
        }

        if($request->header("key") != "room_schedule_test") {
            return response()->json([
                "status" => 0,
                "message" => "Key is invalid",
                "data" => null
            ]);
        }
        if($request->header('object_id') == null){
            return response()->json([
                "status" => 0,
                "message" => "Object ID is empty",
                "data" => null
            ]);
        }
        $modelApi = New Api;
        $data = $request->all();
        if(!isset($data['date'])){
            return response()->json([
                "status" => 0,
                "message" => "Date is empty",
                "data" => null
            ]);
        }
        if(!isset($data['from'])){
            return response()->json([
                "status" => 0,
                "message" => "Time From is empty",
                "data" => null
            ]);
        }
        if(!isset($data['to'])){
            return response()->json([
                "status" => 0,
                "message" => "Time To is empty",
                "data" => null
            ]);
        }
        if(!isset($data['participant'])){
            return response()->json([
                "status" => 0,
                "message" => "Participant is empty",
                "data" => null
            ]);
        }
        
        $object_id = $request->header('object_id');
        $getId = $modelApi->get_decode($object_id);
        if($getId == ''){
            return response()->json([
                "status" => 0,
                "message" => "Data user session not found",
                "data" => null
            ]);
        }
        if($data['participant'] > $modelApi->getMaxParticipant()){
            return response()->json([
                "status" => 0,
                "message" => "Max participant only ".$modelApi->getMaxParticipant(),
                "data" => null
            ]);
        }
        $dateFrom = $data['date'].' '.$data['from'].':00';
        $dateTo = $data['date'].' '.$data['to'].':00';
        $sqlSchedule = DB::table('schedule')
                    ->where('date', '=', $data['date'])
                    ->where('to', '>=', $dateFrom)
                    ->where('from', '<=', $dateTo)
                    ->get();
        if(count($sqlSchedule) > 0){
            return response()->json([
                "status" => 0,
                "message" => "use another time schedule",
                "data" => null
            ]);
        }
        $dataInsert = array(
            'user_id' => $getId,
            'date' => $data['date'],
            'from' => $dateFrom,
            'to' => $dateTo,
            'entry' => $data['participant']
        );
        $insert = $modelApi->getInsertTable('schedule', $dataInsert);
        if($insert->status == false){
            return response()->json([
                "status" => 0,
                "message" => $insert->message,
                "data" => null
            ]);
        }
        
        $idSchedule = $modelApi->randString(5).$insert->lastID.$modelApi->randString(8);
        $dataResponse = array(
            'schedule_id' => $idSchedule,
            'date' => $data['date'],
            'from' => $data['from'],
            'to' => $data['to'],
            'participant' => $dataInsert['entry']
        );
        
        return response()->json([
            "status" => 1,
            "message" => null,
            "data" => $dataResponse
        ]);
    }
    
//    {
//        "status": 1,
//        "message": null,
//        "data": {
//            "schedule_id": "VHMZM1V79IA38C", //07KA92ODZKV7KJ
//            "date": "2024-10-20",
//            "from": "12:00",
//            "to": "14:00",
//            "participant": "6"
//        }
//    }
    
    public function postApiBookingParticipant(Request $request){
        if($request->header("accept") != "application/json") {
            return response()->json([
                "status" => 0,
                "message" => "Format accept must application/json",
                "data" => null
            ]);
        }

        if($request->header("key") != "room_schedule_test") {
            return response()->json([
                "status" => 0,
                "message" => "Key is invalid",
                "data" => null
            ]);
        }
        if($request->header('object_id') == null){
            return response()->json([
                "status" => 0,
                "message" => "Object ID is empty",
                "data" => null
            ]);
        }
        $modelApi = New Api;
        $data = $request->all();
        if(!isset($data['schedule_id'])){
            return response()->json([
                "status" => 0,
                "message" => "Schedule ID empty",
                "data" => null
            ]);
        }
        if(!isset($data['participant'])){
            return response()->json([
                "status" => 0,
                "message" => "Participant is empty",
                "data" => null
            ]);
        }
        
        $object_id = $request->header('object_id');
        $getId = $modelApi->get_decode($object_id);
        if($getId == ''){
            return response()->json([
                "status" => 0,
                "message" => "Data user session not found",
                "data" => null
            ]);
        }
        if($data['participant'] > $modelApi->getMaxParticipant()){
            return response()->json([
                "status" => 0,
                "message" => "Max participant only ".$modelApi->getMaxParticipant(),
                "data" => null
            ]);
        }
        $getScheduleId = $modelApi->getSubstrString($data['schedule_id']);
        $sqlSchedule = DB::table('schedule')
                    ->where('id', '=', $getScheduleId)
                    ->first();
        if($sqlSchedule == null){
            return response()->json([
                "status" => 0,
                "message" => "no data schedule",
                "data" => null
            ]);
        }
        if($sqlSchedule->to <= date('Y-m-d H:i:s')){
            return response()->json([
                "status" => 0,
                "message" => "schedule has expired",
                "data" => null
            ]);
        }
        $dataUpdate = array(
            'entry' => $data['participant']
        );
        $insert = $modelApi->getUpdateTable('schedule', 'id', $sqlSchedule->id, $dataUpdate);
        if($insert->status == false){
            return response()->json([
                "status" => 0,
                "message" => $insert->message,
                "data" => null
            ]);
        }
        
        $dataResponse = array(
            'schedule_id' => $data['schedule_id'],
            'date' => $sqlSchedule->date,
            'from' => date('H:i', strtotime($sqlSchedule->from)),
            'to' => date('H:i', strtotime($sqlSchedule->to)),
            'participant' => $dataUpdate['entry']
        );
        
        return response()->json([
            "status" => 1,
            "message" => null,
            "data" => $dataResponse
        ]);
    }
    
//    {
//        "status": 1,
//        "message": null,
//        "data": {
//            "schedule_id": "VHMZM1V79IA38C",
//            "date": "2024-10-20 00:00:00",
//            "from": "11:40",
//            "to": "14:00",
//            "participant": "20"
//        }
//    }
    
    public function postApiBookingMemo(Request $request){
        if($request->header("accept") != "application/json") {
            return response()->json([
                "status" => 0,
                "message" => "Format accept must application/json",
                "data" => null
            ]);
        }

        if($request->header("key") != "room_schedule_test") {
            return response()->json([
                "status" => 0,
                "message" => "Key is invalid",
                "data" => null
            ]);
        }
        if($request->header('object_id') == null){
            return response()->json([
                "status" => 0,
                "message" => "Object ID is empty",
                "data" => null
            ]);
        }
        $modelApi = New Api;
        $data = $request->all();
        if(!isset($data['schedule_id'])){
            return response()->json([
                "status" => 0,
                "message" => "Schedule ID empty",
                "data" => null
            ]);
        }
        if(!isset($data['memo'])){
            return response()->json([
                "status" => 0,
                "message" => "Memo is empty",
                "data" => null
            ]);
        }
        
        $object_id = $request->header('object_id');
        $getId = $modelApi->get_decode($object_id);
        if($getId == ''){
            return response()->json([
                "status" => 0,
                "message" => "Data user session not found",
                "data" => null
            ]);
        }
        $getScheduleId = $modelApi->getSubstrString($data['schedule_id']);
        $sqlSchedule = DB::table('schedule')
                    ->where('id', '=', $getScheduleId)
                    ->first();
        if($sqlSchedule == null){
            return response()->json([
                "status" => 0,
                "message" => "no data schedule",
                "data" => null
            ]);
        }
        if($sqlSchedule->from <= date('Y-m-d H:i:s')){
            return response()->json([
                "status" => 0,
                "message" => "add memo while on schedule datetime or after schedule",
                "data" => null
            ]);
        }
        $dataUpdate = array(
            'file_link' => $data['memo']
        );
        $insert = $modelApi->getUpdateTable('schedule', 'id', $sqlSchedule->id, $dataUpdate);
        if($insert->status == false){
            return response()->json([
                "status" => 0,
                "message" => $insert->message,
                "data" => null
            ]);
        }
        
        $dataResponse = array(
            'schedule_id' => $data['schedule_id'],
            'date' => $sqlSchedule->date,
            'from' => date('H:i', strtotime($sqlSchedule->from)),
            'to' => date('H:i', strtotime($sqlSchedule->to)),
            'participant' => $sqlSchedule->entry,
            'memo' => $data['memo'],
        );
        
        return response()->json([
            "status" => 1,
            "message" => null,
            "data" => $dataResponse
        ]);
    }
    
//{
//    "status": 1,
//    "message": null,
//    "data": {
//        "schedule_id": "VHMZM1V79IA38C",
//        "date": "2024-10-20 00:00:00",
//        "from": "11:40",
//        "to": "14:00",
//        "participant": 15,
//        "memo": "https://www.scribd.com/document/427141813/Example-of-Memo"
//    }
//}
    
    public function postApiMyScheduleBooking(Request $request){
        if($request->header("accept") != "application/json") {
            return response()->json([
                "status" => 0,
                "message" => "Format accept must application/json",
                "data" => null
            ]);
        }

        if($request->header("key") != "room_schedule_test") {
            return response()->json([
                "status" => 0,
                "message" => "Key is invalid",
                "data" => null
            ]);
        }
        if($request->header('object_id') == null){
            return response()->json([
                "status" => 0,
                "message" => "Object ID is empty",
                "data" => null
            ]);
        }
        $modelApi = New Api;
        $object_id = $request->header('object_id');
        $getId = $modelApi->get_decode($object_id);
        if($getId == ''){
            return response()->json([
                "status" => 0,
                "message" => "Data user session not found",
                "data" => null
            ]);
        }
        $sqlSchedule = DB::table('schedule')
                    ->where('user_id', '=', $getId)
                    ->get();
        $dataSchedule = null;
        if(count($sqlSchedule) > 0){
            $dataSchedule = $sqlSchedule;
        }
        $dataArray = array();
        if($dataSchedule != null){
            foreach($dataSchedule as $row){
                $idSchedule = $modelApi->randString(5).$row->id.$modelApi->randString(8);
                $dataArray[] = array(
                    'schedule_id' => $idSchedule,
                    'date' => $row->date,
                    'from' => date('H:i', strtotime($row->from)),
                    'to' => date('H:i', strtotime($row->to)),
                    'participant' => $row->entry,
                    'memo' => $row->file_link
                );
            }
        }
        
        return response()->json([
            "status" => 1,
            "message" => null,
            "data" => $dataArray
        ]);
    }
    
//{
//    "status": 1,
//    "message": null,
//    "data": [
//        {
//            "schedule_id": "CPM0M1JZJK2KNW",
//            "date": "2024-10-20 00:00:00",
//            "from": "11:40",
//            "to": "14:00",
//            "participant": 15,
//            "memo": "https://www.scribd.com/document/427141813/Example-of-Memo"
//        },
//        {
//            "schedule_id": "9GXZY2WTOEPXRZ",
//            "date": "2024-10-20 00:00:00",
//            "from": "15:00",
//            "to": "17:00",
//            "participant": 6,
//            "memo": null
//        }
//    ]
//}
    
    
    
    
}