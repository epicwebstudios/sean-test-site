<?


	class CSVExport {
		
		
		private $filename;
		private $method;
		private $output;
		private $path;
		private $row;
		
		
		public function __construct( $filename = false ){
			$this->filename( $filename );
			$this->method	= 'download';
			$this->output	= array();
			$this->path		= false;
			$this->row		= array();
		}
		
		
		public function column( $type, $data, $precision = 0 ){
			$this->row[] = array( 'type' => $type, 'data' => $data );
			return $this;
		}
		
		
		public function finish(){
			
			if( count($this->row) > 0 ){
				$this->row();
			}
			
			if( $this->method == 'download' ){
				if( $this->filename ){
					header( 'Content-Type: text/csv' );
					header( 'Content-disposition: inline; filename="'.$this->filename.'"' );
				}
			}
			
			$this->output = implode( "\n", $this->output );
			
			if( $this->method == 'save' ){
				if( ($this->path) && ($this->filename) ){
					file_put_contents( $this->path.$this->filename, $this->output );
					return;
				}
			}
			
			if( $this->method == 'return' ){
				return $this->output;
			}
			
			echo $this->output;
			return;
			
		}
		
		
		public function filename( $filename ){
			
			if( $filename ){
				
				$filename = iconv( 'UTF-8', 'ASCII//TRANSLIT', $filename );
				$filename = trim( $filename );
				$filename = strtolower( $filename );
				$filename = preg_replace( '/[^A-Za-z0-9-. ]/', '', $filename );
				$filename = str_replace( ' ', '-', $filename );
				$filename = preg_replace( '/-{2,}/','-', $filename );
		
				if( substr($filename, -4) != '.csv' ){
					$filename .= '.csv';
				}
				
				$this->filename = $filename;
				
			} else {
				$this->filename = false;
			}
			
			return $this;
			
		}
		
		
		public function method( $method ){
			
			switch( $method ){
					
				case 'download':
				case 'save':
				case 'return':
				case 'output':
					$this->method = $method;
					break;
					
				default:
					$this->method = 'download';
					
			}
			
			return $this;
			
		}
		
		
		public function row(){
			
			if( count($this->row) > 0 ){
				
				$row = array();
				
				foreach( $this->row as $column ){
					$row[] = $this->parse( $column );
				}
				
				$this->output[] = implode( ',', $row );
				
			}
			
			$this->row = array();
			
			return $this;
			
		}
		
		
		private function parse( $array ){
			
			$data 		= $array['data'];
			$precision 	= $array['precision'];
			
			switch( $array['type'] ){
					
				case 'bool':
				case 'boolean':
					$output = 'No';
					if( $data ){
						$output = 'Yes';
					}
					break;
				
				case 'date':
					if( strval($data) !== strval(intval($data)) ){
						$data = strtotime( $data, '12:00:00 PM' );
					}
					if( $data != '0' ){
						$data = date( 'n/j/Y', $data );
					} else {
						$data = '" "';
					}
					$output = $data;
					break;
				
				case 'datetime':
					if( strval($data) !== strval(intval($data)) ){
						$data = strtotime( $data );
					}
					if( $data != '0' ){
						$data = date( 'n/j/Y H:i:s', $data );
					} else {
						$data = '" "';
					}
					$output = $data;
					break;
					
				case 'longdate':
					if( strval($data) !== strval(intval($data)) ){
						$data = strtotime( $data );
					}
					if( $data != '0' ){
						$data = date( 'l, F j, Y', $data );
					} else {
						$data = '';
					}
					$data = '"'.$data.'"';
					$output = $data;
					break;
					
				case 'money':
					$data = '$'.number_format( $array['data'], 2 );
					$output = $data;
					break;
				
				case 'number':
					$data = number_format( $data, $precision );
					$output = $data;
					break;
				
				case 'percent':
				case 'percentage':
					if( 
						( strval($data) === strval(intval($data)) ) || 
						( strval($data) === strval(floatval($data)) )
					){
						if( $data <= 1 ){
							$data = ( $data * 100 );
						}
						$data = number_format( $data, $precision ).'%';
					}
					$output = $data;
					break;
				
				case 'time':
					if( strval($data) !== strval(intval($data)) ){
						$data = strtotime( $data );
					}
					if( $data != '0' ){
						$data = date( 'g:i:s A', $data );
					} else {
						$data = '" "';
					}
					$output = $data;
					break;
				
				case 'text':
				default:
					$data = str_replace( '"', '""', $data );
					$data = '"'.$data.'"';
					$output = $data;
					
			}
			
			return $output;
			
		}
		
		
		public function path( $path ){
			
			if( substr($path, -1) != '/' ){
				$path .= '/';
			}
			
			if( file_exists($path) ){
				$this->path = $path;
			}
			
			return $this;
			
		}
		
		
	}

