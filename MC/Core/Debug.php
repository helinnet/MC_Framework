<?php
namespace MC\Core;
class Debug {
     protected static  $file ;

    public static function debug($var) {
        echo "<pre>";
        echo "Type = " . gettype($var) . PHP_EOL ;
        print_r($var);
    }
   public static function log($message , $file = null) {
       $now = date('Y-m-d H-m-s');
       if(!empty($file)) self::setFile ($file);

      file_put_contents(self::$file, '[ ' . $now . ' ] : '.  $message . PHP_EOL, FILE_APPEND);

   }
 public static function getFile() {
       return self::$file;
   }
   public static function setFile($file) {
       self::$file = $file;
   }

}