<?php
namespace App\Controllers;
use Firebase\JWT\JWT;

class JwtController
{
    private static $secret_key = 'Sdw1s9x8@';
    private static $encrypt = ['HS256'];
    private static $aud = null;

    public static function SignIn($data)
    {
        $time = time();

        $token = array(
            'exp' => $time + (60*60),
            'aud' => self::Aud(),
            'data' => $data
        );

        return JWT::encode($token, self::$secret_key);
    }

    public static function Check($token)
    {
        try {
          if(empty($token))
          {
              return '[{"message":"Invalid token supplied"}]';
          }
          else{
            $decode = JWT::decode(
                $token,
                self::$secret_key,
                self::$encrypt
            );
          }
          if($decode->aud !== self::Aud()){
              return '[{"message":"Invalid user login in"}]';
          }
          else{
            return true;
          }
        } catch (\Firebase\JWT\ExpiredException $ee){
            return $ee->getMessage();
        } catch (\Firebase\JWT\DomainException $de){
            return $de->getMessage();
        } catch (\Firebase\JWT\Exception $e){
            return $e->getMessage();
        }

    }

    public static function GetData($token)
    {
        return JWT::decode(
            $token,
            self::$secret_key,
            self::$encrypt
        )->data;
    }

    private static function Aud()
    {
        $aud = '';

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }

        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();

        return sha1($aud);
    }
}
