<?php
	
	require_once "dbConfig.php";
	define ("area_exam", ""); //used to query bgy's
	
	class mySqlConnect {
		
		public $dbCon;
		public $dbQuery;
	
		//Class Constructor
		public function __construct (){
			$this->_dbOpen();
		}
		
		//Open Method
		private function _dbOpen(){
			$this->dbCon = mysql_connect(dbHost,dbUser,dbPass);
			if (!$this->dbCon || !mysql_select_db(dbFile, $this->dbCon)) {
				die ("Connection Failed" . mysql_error() );
			}else{
				// echo "Connected";
			}
		}
		
		//Close Method
		public function _dbClose(){
			if (isset($this->dbCon)){
				mysql_close($this->dbCon);
				unset($this->dbCon);
			}
		}
		
		//Query Method
		public function _dbQuery($dbSql){
			$dbQuery = mysql_query($dbSql, $this->dbCon);
			$this->_dbConfirm($dbQuery);
				
			return $dbQuery;				
		}
		
		//get data from db
		public function _dbFetch($dbQuery){
			return mysql_fetch_assoc($dbQuery);
		}
		
		private function _dbConfirm( $dbQuery ){
			if( !$dbQuery ){
				echo "You have an error on your last SQL Statement " . mysql_error();
			}
		}
		
	}
?>