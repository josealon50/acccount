<?php

class ZipLocationDist extends IDBTable {
	function __construct($db) {
		parent::__construct($db);
		$this->tablename = 'ZIP_LOCATION_DIST';
		$this->dbcolumns = array(
			'ID'=>'ID',
			'CREATED_AT'=>'CREATED_AT',
			'UPDATED_AT'=>'UPDATED_AT',
			'ZIP_CD'=>'ZIP_CD',
			'S_DIST'=>'S_DIST',
			'S_STORE_CD'=>'S_STORE_CD',
			'W_STORE_CD'=>'W_STORE_CD',
			'W_DIST'=>'W_DIST',
			'S_STORE_CD2'=>'S_STORE_CD2',
			'S_DIST2'=>'S_DIST2',
			'S_STORE_CD3'=>'S_STORE_CD3',
			'S_DIST3'=>'S_DIST3',
			'S_STORE_CD4'=>'S_STORE_CD4',
			'S_DIST4'=>'S_DIST4',
			'S_STORE_CD5'=>'S_STORE_CD5',
			'S_DIST5'=>'S_DIST5'
		);
		$this->setAutoIDColumn("ID");
	}
}