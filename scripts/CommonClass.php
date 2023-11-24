<?php

#
# clase comun al resto de clases de la aplicación
# metodos comunes que se tengan que utilizar en todas o algunas de las clase
# lo podemos poner aqui para no tener que repetir codigo
#

class CommonClass
{

  function __construct()
  {
    PDOManager::Connection( ConfigClass::get("config.databases.default"));
  }

  function __destruct()
  {
    PDOManager::Close();
  }

}