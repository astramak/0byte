<?php

/**
 * Ajax controller
 */
class Ajax_Controller extends Controller {

	/**
	 * Some statistics
	 */
	public function stats() {
		$part = $this->requestPart();

		switch ($part) {
			case 'top_users':
				return $this->topUsers();
				break;
			case 'top_blogs':
				return $this->topBlogs();
				break;
			default:
				$this->not_found();
		}
	}

	/**
	 * Top users list
	 */
	private function topUsers() {
		$users = DB::select('
			select
				name,
				(ratep - ratem + prate / %d + crate / %d + brate / %d) rate
			from
				users
			order by
				rate desc
			limit %d', array(
				RATE_POST,
				RATE_COMMENT,
				RATE_BLOG, 10
			), CACHE_BIG
		);

		$this->output(
			json_encode($users->fetchAll()),
			'application-json'
		);


//} elseif (request::get_get('top_user',0)) {
//    if (!$api) $_SESSION['tp2']='us';
//   $result=db_query(" SELECT * FROM `users` WHERE `lvl`='0'  ORDER BY (ratep - ratem + prate / %d + crate / %d + brate / %d) DESC LIMIT %d",$post_r,$com_r,$blog_r,$limit);
//   while ($row = db_fetch_assoc($result)) {
//        $arr[$i]['name']=$row['name'];
//        $arr[$i]['rate']=$row['ratep']-$row['ratem']+$row['prate']/$post_r+$row['crate']/$com_r+$row['brate']/$blog_r;
//        $i++;
//    }
	}

	/**
	 * Top blogs list
	 */
	private function topBlogs() {

	}

}
