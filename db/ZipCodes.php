<?php

class ZipCodes extends IDBTable {
	
	public function __construct($db) {
		parent::__construct($db);
		$this->tablename		= 'ZIP';
		$this->dbcolumns 		= array(
										  'ZIP_CD'=>'Zip Code'
										, 'ST_CD'=>'State Code'
										, 'DEL_TAX_CD'=>'Delivery Tax Code'
										, 'CITY'=>'City'
										, 'USE_WR_ST_TAX_ON_PU'=>'State Tax on Pickup'
										, 'USE_WR_ST_TAX_ON_DEL'=>'State Tax on Delivery'
										, 'DEL_UPCHARGE'=>'Delivery Upcharge'
										, 'STORE_CD'=>'Store Code'
										);
		$this->setAutoIDColumn("ZIP_CD");
	}
}