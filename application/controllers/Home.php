<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function login(){
		$this->load->view('head');
		$this->load->view('header_login');
		$this->load->view('login');
	}

	public function logout(){
		session_destroy();
		header("location:".base_url('login'));
	}

	public function signup() {
		$data = $this->security->xss_clean($this->input->post());
		$data['status'] = "0";
		$data['first_name'] = ucfirst($data['first_name']);
		$data['last_name'] = ucfirst($data['last_name']);

		//check whether user exists or not
		$query = $this->db->query("SELECT * FROM users where email = '" . $data['email'] . "'");
		$userData = $query->result_array(); 
		
		if(!empty($userData)) {
			
			if($userData[0]['status'] == 1){
				$_SESSION['msg'] = array('body'=>'User already Exists!', status=>'fail');
				header("location:".base_url("login"));
				return false;
			}

			if($userData[0]['status'] == 0){
				$_SESSION['msg'] = array('body'=>'Please validate your email', status=>'fail');
				header("location:".base_url("login"));
				return false;
			}
		}
		//print_r($data); die();
		$_SESSION['msg'] = array('body'=>"Sign up successfull, Please login.", status=>'success');
		$this->db->insert('users', $data);
		header("location:".base_url());
	}

	public function signin() {
		$data = $this->input->post();
		//check whether user exists or not
		$query = $this->db->query("SELECT * FROM users where email = '" . $data['email'] . "' and password='" . $data['password'] . "'");
		$userData = $query->result_array(); 
		
		if(!empty($userData)) {
			
			/*if($userData[0]['status'] == 0){
				$_SESSION['msg'] = array('body'=>'Please validate your email', status=>'fail');
				header("location:".base_url("login"));
				return false;
			}*/

			$_SESSION['user'] = $userData[0]; 

			header("location:".base_url());
			return false;

		} else {
			$_SESSION['msg'] = array('body'=>'Wrong email or password', status=>'fail');
			header("location:".base_url("login"));
			return false;
		}		
	}

	public function index() {

		isLoggedIn();
		
		$arrThoughtIds = array();
		$arrLikeData = array();
		$arrCommentData = array();

		$qr = "select t.*, c.comment_id, c.comment from thoughts t LEFT join comments c on t.thought_id = c.object_id where t.to_user_id = " . $_SESSION['user']['user_id'] . " order by t.created desc ";
		$query = $this->db->query($qr);
		$postData = $query->result_array(); 
		
		foreach($postData as $key => $post) {
			array_push($arrThoughtIds, $post['thought_id']);

			$shareURLCmnt = urlencode(base_url('user/'.$_SESSION['user']['user_id'].'/review/'.$post['thought_id']));
			$shareTextprofile = "This is what people think about me. Checkout the anonymous comment posted on my profile.";
			$socialShareUrls = array (
				"facebook" 	=> "https://www.facebook.com/sharer/sharer.php?u=$shareURLCmnt",
				"twitter" 	=> "https://twitter.com/intent/tweet?url=$shareURLCmnt&text=$shareTextprofile",
				"whatsapp"	=> "whatsapp://send?text=".urlencode($shareTextprofile)."%20$shareURLCmnt"
			); 
			$strSocialUrls = json_encode($socialShareUrls);
			$postData[$key]['socialShareUrls'] = $strSocialUrls; 

		}

		/*$qr = "select object_id, count(like_id) as like_count from likes where object_id in ( " . implode("," ,$arrThoughtIds) . " ) GROUP BY object_id";
		$query = $this->db->query($qr);
		$likeData = $query->result_array(); 
		
		foreach($likeData as $like) {
			$arrLikeData[$like['object_id']] = $like['like_count'];
		}
		
		foreach($postData as $postKey=>$post) {
			$postData[$postKey]['like_count'] = array_key_exists($post['thought_id'], $arrLikeData) ? $arrLikeData[$post['thought_id']] : 0;
		}*/

		$data['thoughtsData'] = $postData;

		$shareURLprofile = urlencode(base_url('user/'.$_SESSION['user']['user_id']));
		$shareTextprofile = "Let me know what do you think about me by giving me an anonymous comment.";
		$data['shareUrl']['profile']['twitter'] = "https://twitter.com/intent/tweet?url=$shareURLprofile&text=$shareTextprofile";
		$data['shareUrl']['profile']['facebook'] = "https://www.facebook.com/sharer/sharer.php?u=$shareURLprofile";
		$data['shareUrl']['profile']['whatsapp'] = "whatsapp://send?text=".urlencode($shareTextprofile)."%20$shareURLprofile";

		$this->load->view('head');
		$this->load->view('header2');
		$this->load->view('home2', $data);
		$this->load->view('footer', $data);
	}

	public function add_tag() {
		$tag =  strtolower($this->input->post('txtTag'));
		$toUserId = $this->input->post('user_id');
		
		$query = $this->db->query("SELECT * FROM tags where tag_name = '" . $tag . "'");
		$tagsData = $query->result_array(); 

		if(!empty($tagsData[0])) {
			$tagId = $tagsData[0]['tag_id']; 
		} else {
			if($this->db->insert('tags', array("tag_name" => $tag))) {
				$tagId = $this->db->insert_id();
			}
		}
		
		$query = $this->db->query("SELECT * FROM user_tags where user_id = ".$toUserId." and tag_id = " . $tagId );
		$tagsData = $query->result_array(); 

		if(!empty($tagsData[0])) {
			header(':', true, 404);
			echo json_encode(array( "msg" => "Tag already exists" ));
			return false;
		}

		$userTagsData = array(
			"tag_id" => $tagId,
			"user_id" => $toUserId,
			"from_user_id" => $_SESSION['user']['user_id'],
		);

		if($this->db->insert('user_tags', $userTagsData)) {
			$userTagId = $this->db->insert_id();
		}

		echo json_encode(array( "user_tag_id" => $userTagId, "tag_id" => $tagId ));
	}

	public function tag_details($tagId, $tagName) {
		$qr = "SELECT *, count(tv.tag_vote_id) tag_count FROM users u, tag_votes tv where u.user_id = tv.to_user_id and tv.tag_id = $tagId group by tv.to_user_id order by tag_count desc" ;
		$query = $this->db->query($qr);
		$tagsData = $query->result_array(); 

		$data = array("tagsData" => $tagsData, "tagName" => $tagName);

		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('tags_details', $data);
	}

	public function vote_details($tagId, $userId) {
		$qr = "SELECT u.user_id, u.first_name, u.last_name, u.image from users u, tag_votes tv where u.user_id = tv.from_user_id and tv.tag_id = $tagId and tv.to_user_id=$userId";
		$query = $this->db->query($qr);
		echo json_encode($query->result_array());
	} 

	public function search() {
		$searchText = $this->security->xss_clean($this->input->get('search'));
		$arrSearchTxt = explode(" ", $searchText);

		$qr = "SELECT * FROM users WHERE (first_name = '" . $arrSearchTxt[0] . "' OR last_name = '" . $arrSearchTxt[0] . "')";
		if(!empty($arrSearchTxt[1])) {
			$qr .= " AND (first_name = '" . $arrSearchTxt[1] . "' OR last_name = '" . $arrSearchTxt[1] . "')";
		}
		
		$query = $this->db->query($qr);
		$data = array("userData" => $query->result_array(), "searchText"=>$searchText); 

		$this->load->view('head');
		$this->load->view('header2');
		$this->load->view('search_results', $data);
		$this->load->view('footer', $data);

	}

	public function upp() {
		$filename = $_FILES['upp']['name'];

        $file_extension = pathinfo($filename, PATHINFO_EXTENSION);
        $file_extension = strtolower($file_extension);

		$newFileName = md5($_SERVER['REMOTE_ADDR'] . time()) . "." . $file_extension;

		$file_location = FCPATH . "public/uploads/images/$newFileName";
		$location = base_url()."public/uploads/images/$newFileName";

		if(!in_array($file_extension, $this->config->item('image_ext'))){
			$_SESSION['msg'] = "File upload failed. Supported formats are jpg, png, jpeg, gif";
			header("location:".base_url());
			return false;
		}

		move_uploaded_file($_FILES['upp']['tmp_name'], $file_location);
		$this->db->update('users', array("image" => $location), "user_id=" . $_SESSION['user']['user_id']);
		$_SESSION['user']['image'] = $location;
		header("location:".base_url());
	}

	public function get_standard_tags() {
		$qr = "SELECT * FROM tags WHERE tag_id < 1001" ;
		$query = $this->db->query($qr);
		
		$arrTags = array();
		foreach($query->result_array() as $tag) {
			array_push($arrTags, $tag['tag_name']);
		}

		echo json_encode($arrTags);
	}

	public function thoughts() {

		isLoggedIn();
		$defTags = implode(",", $this->config->item('defTags'));
		$qr = "SELECT *, COUNT(ufl.user_feedback_like_id) as like_count FROM users u, user_feedback uf, user_feedback_likes ufl WHERE u.user_id = uf.to_user_id AND uf.user_feedback_id = ufl.user_feedback_id AND u.user_id = " . $_SESSION['user']['user_id'] . " GROUP BY uf.user_feedback_id ";
		$query = $this->db->query($qr);
		$thoughtsData = $query->result_array(); 

		$data = array("thoughtsData" => $thoughtsData);
		
		$this->load->view('head');
		$this->load->view('header');
		$this->load->view('thoughts', $data);
		$this->load->view('footer', $data);
	}
	
	public function publish($thoughId) {
		$this->db->update("thoughts", array("is_published" => 1), array("thought_id" => $thoughId));
		echo json_encode(array( "status" => "success" ));
	}
	public function unpublish($thoughId) {
		$this->db->update("thoughts", array("is_published" => 0), array("thought_id" => $thoughId));
		echo json_encode(array( "status" => "success" ));
	}

	public function replythought() {

        $fromUserId = !empty($_SESSION['user']) ? $_SESSION['user']['user_id'] : 0;
        $thoughId = $this->input->post('thoughtId');
        $ip = $_SERVER['REMOTE_ADDR'];
        $thoughtId = 0;

        $qr = "SELECT count(*) as replyCount FROM comments WHERE object_id = $thoughId " ;

        $query = $this->db->query($qr);
        $thoughtsCountData = $query->result_array(); 
        //print_r($thoughtsCountData);
        if($thoughtsCountData[0]['replyCount'] >= 1) {
            header(':', true, 400);
			echo json_encode(array( "msg" => "You have already Replied" ));
			return false;
        }

        $data = array(
            "object_id" => $thoughId,
            "from_user_id" => $fromUserId,
            "comment" => strip_tags( $this->security->xss_clean($this->input->post('comment')) ),
            "ip" => $_SERVER['REMOTE_ADDR'],
        );

        if($this->db->insert('comments', $data)) {
            $replyId = $this->db->insert_id();
        }

        echo json_encode(array( "status" => "Success", "replyId" => $replyId ));

	}
	public function deletethought($thoughId) {

		$this->db->delete('thoughts', array('thought_id' => $thoughId));
		echo json_encode(array( "status" => "Success" ));

	}

	public function deletereply($replyId) {

		$this->db->delete('comments', array('comment_id' => $replyId));
		echo json_encode(array( "status" => "Success" ));
		
	}
}
