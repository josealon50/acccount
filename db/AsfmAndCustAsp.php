<?php
class AsfmAndCustAsp extends IDBTable {
	public function __construct($db) {
		parent::__construct($db);
        $this->tablename        = 'ASP_STORE_FORWARD JOIN CUST_ASP ON CUST_ASP.CUST_CD = ASP_STORE_FORWARD.CUST_CD AND ASP_STORE_FORWARD.AS_CD = CUST_ASP.AS_CD';

		$this->dbcolumns        = array( 'AS_CD'=>'AS_CD' , 'CUST_CD'=>'CUST_CD');

        $this->dbcolumns_function = array( 'AS_CD' => 'ASP_STORE_FORWARD.AS_CD' ,'CUST_CD' => 'ASP_STORE_FORWARD.CUST_CD');

	}
}

?>
