<?
	namespace social_media_icons;

	function get_types() {
		$return = array();
		$stmt   = "SELECT * FROM `m_social_types`";
		$query  = mysql_query($stmt);

		while ($row = mysql_fetch_assoc($query))
			$return[$row['id']] = $row;

		return $return;
	}

	function get_items() {
		$return = array();
		$stmt   = "SELECT * FROM `m_social` WHERE `status` = 1 ORDER BY `order` ASC";
		$query  = mysql_query($stmt);

		while ($row = mysql_fetch_assoc($query))
			$return[$row['id']] = $row;

		return $return;
	}