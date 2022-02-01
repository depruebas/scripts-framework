<?php

class Test extends CommonClass
{

	public function Init( $data = null, $connection = null)
	{

		echo EOF . "I'm Init method" . EOF . EOF;


		$params['query'] = "select * from city limit 10";
    $params['params'] = array( );
    $rows = PDOManager::ExecuteQuery( $params, $connection->data);

    print_r($rows);
	}

}