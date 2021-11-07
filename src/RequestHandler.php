<?php 
require_once('Database.php');

/**
 * RequestHandler class - main logic here
 */
class RequestHandler
{
	private $mysqli;
	
	function __construct()
	{
		$db = Database::getInstance();
		$this->$mysqli = $db->getConnection();
	}

	public function processRequest($server)
	{
		$this->updateTable($server);
		$this->returnImage();
	}

	private function updateTable($server)
	{	

		$query = $this->$mysqli->prepare("INSERT INTO page_views_info (ip_address, user_agent, view_date, page_url) VALUES (INET_ATON(?),?,?,?) ON DUPLICATE KEY UPDATE view_date = ?,views_count = views_count + 1;");

    	$query->bind_param('sssss', $server['REMOTE_ADDR'], $server['HTTP_USER_AGENT'], date('Y-m-d H:i:s'), basename($server['HTTP_REFERER']), date('Y-m-d H:i:s'));
    	try {
		    $query->execute();
		} catch (mysqli_sql_exception $e) {
		    die($e);                                  
		}

		return true;
	}

	private function returnImage()
	{
		header('Content-Type: image/jpeg');
		readfile('src/banner.png');
	}
}