<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Validator;

class Api extends Model {
    
    public function getInsertTable($table, $data){
        try {
            $lastInsertedID = DB::table($table)->insertGetId($data);
            $result = (object) array('status' => true, 'message' => null, 'lastID' => $lastInsertedID);
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $result = (object) array('status' => false, 'message' => $message, 'lastID' => null);
        }
        return $result;
    }
    
    public function getUpdateTable($table, $fieldName, $name, $data){
        try {
            DB::table($table)->where($fieldName, '=', $name)->update($data);
            $result = (object) array('status' => true, 'message' => null);
        } catch (Exception $ex) {
            $message = $ex->getMessage();
            $result = (object) array('status' => false, 'message' => $message);
        }
        return $result;
    }
    
    public function getEncryptData(){
        $salt = 'ROOMSCHEDULE';
        $secure = '2023ROOM';
        $chipher = 'DES-EDE3-CBC';
        $max_random = 6;
        $encrypt = array(
            'salt' =>  $salt,
            'secure' => $secure,
            'chipher' => $chipher,
            'max_random' => $max_random,
            'alphanum' => 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ'
        );
        return $encrypt;
    }
    
    public function get_decode($value){
        $getData = $this->getEncryptData();
        $salt = $getData['salt'];
        $iv = $getData['secure'];
        $ciphering = $getData['chipher'];
        $max_random = $getData['max_random'];
        $decode64 = base64_decode($value);
        $getDecrypt = openssl_decrypt($decode64, $ciphering, $salt, 0, $iv);
        $result = substr($getDecrypt, 0, -$max_random);
        return $result;
    }
    
    public function get_encode($value){
        $getData = $this->getEncryptData();
        $salt = $getData['salt'];
        $iv = $getData['secure'];
        $ciphering = $getData['chipher'];
        $max_random = $getData['max_random'];
        $charsetnumber = $getData['alphanum'];
        $key_number = '';
        for ($i = 0; $i < $max_random; $i++) {
            $key_number .= $charsetnumber[(mt_rand(0, strlen($charsetnumber) - 1))];
        }
        $string = $value.$key_number;
        $result = base64_encode(openssl_encrypt($string, $ciphering, $salt, 0, $iv));
        return $result;
    }
    
    
    
}
