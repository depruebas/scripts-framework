<?php

	# Iniciamos el timer para ver el tiempo que tarda la api en procesar una peticíon
  $start_time = microtime(true);

  # Guardamos la fecha con la que se inicia la API en cada petición, despues la utilizaremos en los
  # logs para saber cuando fue la petición
  global $init_time;
  $init_time = date( "Y-m-d H:i:s");


  # Incluimos los headers para que
  # el content-type y el cache ( no queremos que se cacheen los resultados )
  header('Content-Type: text/plain; charset=utf-8');


  # Añadimos las librerias .php que vamos a necesitar en la API
  require_once dirname(__FILE__)."/libs/ConfigClass.php";
  require_once dirname(__FILE__)."/libs/Utils.php";
  require_once dirname(__FILE__)."/libs/CustomErrorLog.php";
  require_once dirname(__FILE__)."/libs/MessagesClass.php";
  require_once dirname(__FILE__)."/libs/PDOManager.php";


  # Inicializamos CustomErrorLog, para procesar automaticamente los errores
  $e = new CustomErrorLog();


  # Defimos las costantes del programa
  define( 'DEBUG', ConfigClass::get("config.config.debug"));
  define( 'ENVIRONMENT', ConfigClass::get("config.config.environment"));
  define( "EOF", "\n");


  # Guardamos en un array de entrada los datos generales de la llamada

  if ( count( $argv) < 3)
  {
    echo EOF . "Los parametros pasados no son correctos." . EOF;
  }

  $_class = trim( $argv[1]);
  $_method = trim( $argv[2]);

  ( isset( $argv[3]) ? $data = $argv[3] : $data = []);

  # Cargamos la clase (fichero) que vamos a utilizar dinamicamente
  $class_include = dirname(__FILE__)."/scripts/".$_class.".php";

  if ( file_exists( $class_include))
  {
      require_once dirname(__FILE__)."/scripts/CommonClass.php";
      require_once $class_include;

      $connection = PDOManager::Connection( ConfigClass::get("config.databases.default"));

      $action = new $_class();
      $return = $action->{$_method} ( $data, $connection);

      $connection = null;

      echo $return;

  }
  else
  {

    return ( MessagesClass::Response( [
        'success' => false,
        'type' => 'ERROR',
        'code' => RandomString(),
        'message' => "Clase " . $class_include . " no existe",
      ]
    ));

  }

  # Si tenemos la depuración activada se registra el tiempo que tarda en procesar las peticiones
  if ( DEBUG)
  {
    $time = microtime(true) - $start_time;

    if ( $time > 1)
    {
      # formatPeriod es una función que esta en el fichero Utils.php
      $time = formatPeriod( $time);
    }

    echo EOF.( $time ) . EOF;
  }
