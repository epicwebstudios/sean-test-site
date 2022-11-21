<?


	class PDO_DB {
		
		
		public $connection;
		
		
		public function __construct( $host, $username, $password, $database ){
			$this->connect( $host, $username, $password, $database );
		}
		
		
		public function close(){
			$this->connection = NULL;
		}
		
		
		public function connect( $host, $username, $password, $database ){
			
			$dsn = 'mysql:host='.$host.';dbname='.$database;
			
			try {
				$this->connection = new PDO( $dsn, $username, $password );
                $this->connection->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC );
			} catch( PDOException $e ){
				line( '<b>System Error</b>: Cannot connect to database.' );
			}
			
			return $this;
			
		}
		
		
		public function insert( $table, $values = array() ){
			
			$query = 'INSERT INTO `'.$table.'`';
			$binds = array();
			$set = '';
			
			if( is_array($values) ){
				foreach( $values as $column => $value ){
					if( $set != '' ){ $set .= ', '; }
					$set .= '`'.$column.'` = :'.$column;
					if( is_array($value) ){ $value = json_encode( $value ); }
					$binds[':'.$column] = $value;
				}
			}
			
			if( $set == '' ){
				return false;
			}
			
			$query .= ' SET '.$set;
			$stmt = $this->connection->prepare( $query );
			$stmt->execute( $binds );
			
			return $this->connection->lastInsertId();
			
		}
		
		
		public function insert_id(){
			return $this->connection->lastInsertId();
		}
		
		
		public function update( $table, $id, $values = array() ){
			
			$query = 'UPDATE `'.$table.'`';
			$binds = array();
			$set = '';
			
			if( is_array($values) ){
				foreach( $values as $column => $value ){
					if( $set != '' ){ $set .= ', '; }
					$set .= '`'.$column.'` = :'.$column;
					if( is_array($value) ){ $value = json_encode( $value ); }
					$binds[':'.$column] = $value;
				}
			}
			
			if( $set == '' ){
				return false;
			}
			
			$query .= ' SET '.$set.' WHERE `id` = :id ';
			
			$binds[':id'] = $id;
			
			$stmt = $this->connection->prepare( $query );
			$stmt->execute( $binds );
			
			return $stmt->rowCount();
			
		}
		
		
		public function query( $query, $values = array() ){
			
			if( (is_array($values)) && (count($values) > 0) ){
				
				$stmt = $this->connection->prepare( $query );
                $stmt->execute( $values );
				
				return $stmt;
				
			}
				
			return $this->connection->query( $query );
			
		}
		
		
		public function single( $query, $values = array() ){
			
			$query = trim( $query );
			
			if( substr($query, -7) != 'LIMIT 1' ){
            	$query .= " LIMIT 1 ";
			}
			
            $stmt = $this->query( $query, $values );
			
			return $stmt->fetch( PDO::FETCH_ASSOC );
			
		}
		
		
	}