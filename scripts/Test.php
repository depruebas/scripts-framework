<?php

class Test extends CommonClass
{

	public function Init( $data = null)
	{

		echo EOF . "I'm Init method" . EOF . EOF;

		$params_ins['table'] = 'city';
		$params_ins['fields'] = [
			'city' => 'BBBBB',
			'country_id' => 18
		];

		$rows_ins = PDOManager::Insert( $params_ins);

		dc ( $rows_ins);

		$params['query'] = "select * from city order by last_update  desc limit 10 ";
    $params['params'] =  [];
    $rows = PDOManager::Execute( $params);

		dc($rows, true);

		echo "hola";
	}

}