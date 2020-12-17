<?php

class Zip extends IDBTable {

	public function __construct($db) {
		parent::__construct($db);
		$this->tablename        = 'ZIP';
		$this->dbcolumns        = array(
										  'STORE_CD'=>'STORE_CD'
										, 'AS_CD'=>'AS_CD'
										, 'APPLICATION_DT'=>'APPLICATION_DT'
										, 'APPLICATION_STATUS'=>'APPLICATION_STATUS'
										, 'APPLICATION_ID'=>'APPLICATION_ID'
									);


		$this->errorMsg 			= "";

	}
