<?
	namespace cta;
	
	function get_default_image($cta_category_id) {
		$return = null;
		$stmt   = "SELECT `image` FROM `m_cta_categories` WHERE `id` = '$cta_category_id' LIMIT 1";
		$query  = mysql_query($stmt);

		if ($query && mysql_num_rows($query) > 0)
			$return = mysql_fetch_assoc($query)['image'];

		return $return;
	}

	function get_ctas_from_category_id($category_id) {
		$return = array();
		$stmt   = "SELECT * FROM `m_cta` WHERE `category` = '$category_id ' AND `status` = 1 ORDER BY `order`";
		$query  = mysql_query($stmt);

		if ($query) {
			while ($r = mysql_fetch_assoc($query))
				$return[$r['id']] = $r;
		}

		return $return;
	}

	function get_cta_from_id($id) {
		$return = array();
		$stmt   = "SELECT * FROM `m_cta` WHERE `id` = '$id' AND `status` = 1 LIMIT 1";
		$query  = mysql_query($stmt);

		if ($query)
			$return = mysql_fetch_assoc($query);

		return $return;
	}

	function get_category_from_cta_id($cta_id) {
		$return = array();
		$stmt   = "SELECT * FROM `m_cta_categories` WHERE `id` = '$cta_id'";
		$query  = mysql_query($stmt);

		if ($query)
			$return = mysql_fetch_assoc($query);

		return $return;
	}

	function get_buttons($cta_id) {
		$return = array();
		$stmt   = "SELECT * FROM `m_cta_buttons` WHERE `cta_id` = '$cta_id' AND `status` = 1 ORDER BY `order`";
		$query  = mysql_query($stmt);

		if ($query) {
			while ($r = mysql_fetch_assoc($query))
				$return[$r['id']] = $r;
		}

		return $return;
	}