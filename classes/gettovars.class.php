<?php
class GetToVars{
  private $vars = array();
  public function __construct($get_array){
    if(count($get_array) > 0){
      foreach($get_array as $name => $value){
        $var = "var $name = \"$value\" ;";
        array_push( $this -> vars , $var );
      }
    }
  }
  
  public function __toString(){
    $str = implode( "\n" , $this -> vars );
    return trim($str);
  }
}
?>