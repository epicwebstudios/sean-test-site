<?


	class AdminModule {
		
		
		public $actions;
		public $pagination;
		public $permissions;
		public $per_page;
		public $name;
		public $columns;
		
		
		public function __construct( $name ){
			
			$this->name = $name;
			
			$this->actions = array(
				'add' 		=> 'Add New',
				'edit' 		=> 'Edit',
				'delete'	=> 'Delete',
				'reorder'	=> 'Reorder',
			);
			
			$this->columns = array();
			
			$this->permissions = array(
				'add' 		=> true,
				'edit' 		=> true,
				'delete'	=> true,
				'reorder' 	=> true,
			);
			
			$this->per_page = 50;
			
			$this->calculate_pagination();
			
		}
		
		
		public function add_column( $title, $width = false, $sort_by = false ){
			
			$this->columns[] = array(
				'title' 	=> $title,
				'width' 	=> $width,
				'sort_by' 	=> $sort_by,
			);
			
			return $this;
			
		}
		
		
		public function calculate_pagination( $records = false, $page = false ){
			
			$single = array(
				'records' 	=> 0,
				'pages' 	=> 1,
				'current'	=> 1,
				'first'		=> false,
				'prev'		=> false,
				'next'		=> false,
				'last'		=> false,
				'low'		=> 1,
				'high'		=> $this->per_page,
			);
			
			if( $records ){
				$this->pagination = $single;
				return $this;
			}
			
			$single['records'] = $records;
			
			if( !$this->per_page ){
				$this->pagination = $single;
				return $this;
			}
			
			$single['pages'] = ceil( $records / $this->per_page );
			
			if( $page ){
				if( $page < 1 ){
					$page = 1;
				} else if( $page > $single['pages'] ){
					$page = $single['pages'];
				}
			}
			
			$single['current'] = $page;
			
			if( $single['current'] > 1 ){
				$single['first'] 	= 1;
				$single['prev'] 	= ( $single['current'] - 1 );
			}
			
			if( $single['current'] < $single['pages'] ){
				$single['last'] 	= $single['pages'];
				$single['next'] 	= ( $single['current'] + 1 );
			}
			
			$single['low'] 	= ( ( $single['current'] - 1 ) * $this->per_page );
			$single['high'] = ( $single['low'] + $this->per_page );
			$single['low']	= ( $single['low'] + 1 );
			
			$this->pagination = $single;
			
			return $this;
			
		}
		
		
		public function pagination(){
			
			$output = '';
			
			$output .= '<div class="pagination">';
			
				$output .= 'Showing ';
				$output .= '<b>'.$this->pagination['low'].'</b>';
				$output .= ' - ';
				$output .= '</b>'.$this->pagination['high'].'</b>';
				$output .= ' (of ';
				$output .= '</b>'.$this->pagination['records'].'</b>';
				$output .= ')';
			
				$output .= '<button';
					$output .= ' class="first"';
					$output .= ' title="First Page"';
					if( $this->pagination['last'] ){
						$output .= ' data-id="'.$this->pagination['first'].'"';
						$output .= ' href="'.$this->url.'"';
					} else {
						$output .= ' disabled';
					}
				$output .= '>&laquo;</button>';

				$output .= '<button';
					$output .= ' class="prev"';
					$output .= ' title="Previous Page"';
					if( $this->pagination['next'] ){
						$output .= ' data-id="'.$this->pagination['next'].'"';
						$output .= ' href="'.$this->url.'"';
					} else {
						$output .= ' disabled';
					}
				$output .= '>&lt;</button>';

				$output .= 'Page';
				$output .= '<input';
					$output .= ' type="text"';
					$output .= ' class="current"';
					$output .= ' value="'.number_format( $this->pagination['current'] ).'"';
				$output .= '>';
				$output .= 'of <b>'.number_format( $this->pagination['pages'] ).'</b>';

				$output .= '<button';
					$output .= ' class="next"';
					$output .= ' title="Next Page"';
					if( $this->pagination['next'] ){
						$output .= ' data-id="'.$this->pagination['next'].'"';
						$output .= ' href="'.$this->url.'"';
					} else {
						$output .= ' disabled';
					}
				$output .= '>&gt;</button>';

				$output .= '<button';
					$output .= ' class="last"';
					$output .= ' title="Last Page"';
					if( $this->pagination['last'] ){
						$output .= ' data-id="'.$this->pagination['last'].'"';
						$output .= ' href="'.$this->url.'"';
					} else {
						$output .= ' disabled';
					}
				$output .= '>&raquo;</button>';
			
			$output .= '</div>';
			
			echo $output;
			
		}
		
		
	}

