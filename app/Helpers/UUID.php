<?php
/**
 * Created by PhpStorm.
 * User: Mahmoud
 * Date: 2/12/2018
 * Time: 8:50 PM
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Password;

class UUID
{

    public static function generate($length=64, $modelClass = null, $fieldName=null,$prefix = 'K')
    {
//        $token = substr(Password::getRepository()->createNewToken(), 0, $length);
        $numbers = '0123456789';
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $numbersLength = strlen($numbers);
        $token = $numbers[rand(0, $numbersLength - 1)];
        for ($i = 0; $i < $length-1; $i++) {
            $token .= $characters[rand(0, $charactersLength - 1)];
        }

        if ($modelClass && $fieldName) {
            if ($modelClass::where($fieldName, '=', $prefix.$token)->exists()) {
                //Model Found -- call self.
                self::generate($length, $modelClass, $fieldName);
            } else {
                //Model Not found. is uinque
                return $prefix.$token;
            }
        } else {
            return $prefix.$token;
        }
    }
    public static function generateMobile($length=64, $modelClass = null, $fieldName=null)
    {
//        $token = substr(Password::getRepository()->createNewToken(), 0, $length);
        $numbers = '0123456789';
        $numbersLength = strlen($numbers);
        $token = $numbers[rand(0, $numbersLength - 1)];
        for ($i = 0; $i < $length-1; $i++) {
            $token .= $numbers[rand(0, $numbersLength - 1)];
        }

        if ($modelClass && $fieldName) {
            if ($modelClass::where($fieldName, '=', $token)->exists()) {
                //Model Found -- call self.
                self::generate($length, $modelClass, $fieldName);
            } else {
                //Model Not found. is uinque
                return $token;
            }
        } else {
            return $token;
        }
    }

}