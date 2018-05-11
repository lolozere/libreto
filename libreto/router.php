<?php

class Router

{

  private $subdomain;
  private $directories;

  public function __construct() {
    $this->split();
  }

  public function split() {

    // directories
    $directories = explode( '/', trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/') );
    $this->directories = array_filter(array_map("urldecode", $directories));

    // subdomain
    $server_name = explode(".",$_SERVER["SERVER_NAME"]);
    if (array_key_exists(0, $server_name) && array_key_exists(2, $server_name)):
      $name = urldecode($server_name[0]);
      $this->subdomain = strtok( $name ,'?');
    endif;

  }

  public function provider(){
    return $this->subdomain;
  }

  public function template(){
    if( array_key_exists(0, $this->directories) ):
      $templates = glob(ROOT . DS . "views" . DS . "templates" . DS . "*.php");
      $templates = array_map(function($file) {
        return basename($file, ".php");
      }, $templates);
      $directory = strtolower($this->directories[0]);
      if( in_array($directory, $templates) ):
        return $directory;
      else:
        return "libreto";
      endif;
    else:
      header('Location: /site/');
      exit();
    endif;
  }

  public function name(){

    global $libreto;

    if($this->template() != "libreto"):
      $n = 1;
    else:
      $n = 0;
    endif;

    if (array_key_exists($n + 0, $this->directories)):
      $name = urldecode($this->directories[$n + 0]);
      $name = strtok( $name ,'?');
      return $name;
    else:
      return false;
    endif;

  }

  public function pad(){

    global $libreto;

    if($this->template() != "libreto"):
      $n = 1;
    else:
      $n = 0;
    endif;

    if (array_key_exists($n + 1, $this->directories)):
      $name = $this->directories[$n + 1];
    else:
      return false;
    endif;

    if ($pad = $libreto->pads()->find($name)):
      if ($pad->visible()) :
        return $pad;
      endif;
    else:
      return false;
    endif;

  }

}
