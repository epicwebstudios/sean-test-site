<?

	
	// This function is used to check to see if this user-level has permission to access the page.
	function menu_hasPermission($user, $page){
		$user = getUser($user);
		if($user['level'] == 1){
			return true;
		} else {
			$query = mysql_query("SELECT * FROM `admin_permissions` WHERE `level` = '".$user['level']."' AND `page` = '".$page."' LIMIT 1");
			if(mysql_num_rows($query) > 0){
				return true;
			} else {
				return false;
			}
		}
	}
	
	
	// This function will generate the menu and all the sub-menus using the menu_getChildren() function.
	function menu_hasChildren($id){
		$query = mysql_query("SELECT * FROM `admin_pages` WHERE `parent` = '".$id."'");
		if(mysql_num_rows($query) > 0){
			return true;
		} else {
			return false;
		}
	}
	
	// This function will generate the menu and all the sub-menus using the menu_getChildren() function.
	function menu_generateMenu(){
		$query = mysql_query("SELECT * FROM `admin_pages` WHERE `parent` = '0' ORDER BY `order` ASC");
		if(mysql_num_rows($query) > 0){
			while($info = mysql_fetch_assoc($query)){
				if((menu_hasPermission($_COOKIE['admin_user'], $info['id'])) || ($info['id'] == "1")){
					if(($info['module'] == 0) || (checkModule($info['module']))){
						
						$level = 0;
						$id = $info['id'];
						$name = $info['name'];
						$link = "#";
						
						if($info['page']){
							$link = "?a=".$id;
						} else if($info['link']){
							$link = $info['link'];
						}
						
						if($link == "#"){
							$onclick = "return false;";
						} else {
							$onclick = "";
						}
						
						echo '<div class="parent">';
							echo '<a href="'.$link.'" onclick="'.$onclick.'" class="level_'.$level.'">'.$name.'</a>';
							menu_getChildren($info['id'], $level);
						echo '</div>';
						
					}
				}
			}
		}
	}
	
	
	// This function looks for, and creates menus for any children of the main parents.
	function menu_getChildren($id, $level){
		$level++;
		$query = mysql_query("SELECT * FROM `admin_pages` WHERE `parent` = '".$id."' ORDER BY `order` ASC");
		if(mysql_num_rows($query) > 0){
			
			echo '<div class="dropdown">';
			
			while($info = mysql_fetch_assoc($query)){
				if(menu_hasPermission($_COOKIE['admin_user'], $info['id'])){
					if(($info['module'] == 0) || (checkModule($info['module']))){
						
						$id = $info['id'];
						$name = $info['name'];
						$link = "#";
						
						if($info['page']){
							$link = "?a=".$id;
						} else if($info['link']){
							$link = $info['link'];
						}
						
						if($link == "#"){
							$onclick = "return false;";
						} else {
							$onclick = "";
						}
						
						if( menu_hasChildren($id) ){
							$arrow = '<img src="images/arrow.gif">';
							$has_arrow = 'has_arrow';
						} else {
							$has_arrow = '';
							$arrow = '';
						}
						
						echo '<div class="child '.$has_arrow.'">';
							echo $arrow;
							echo '<a href="'.$link.'" onclick="'.$onclick.'" class="level_'.$level.'">'.$name.'</a>';
							menu_getChildren($info['id'], $level);
						echo '</div>';
						
					}
				}
			}
			
			echo '</div>';
			
		}
	}


