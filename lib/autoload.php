<?php

spl_autoload_register(function($class)
{
  $file = str_replace('\\',DIRECTORY_SEPARATOR,$class . '.php');
  if($path = stream_resolve_include_path($file)) {
    require_once $path;
  }
},false,true);