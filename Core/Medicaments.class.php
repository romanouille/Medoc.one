<?php
class Medicaments {
	public static function search(string $text) : array {
		global $db;
		
		$query = $db->prepare("SELECT id, name FROM cis_bpdm WHERE name ILIKE :text OR name ILIKE :text2");
		$query->bindValue(":text", "%".str_replace("é", "e", str_replace("è", "e", $text))."%", PDO::PARAM_STR);
		$query->bindValue(":text2", "%$text%", PDO::PARAM_STR);
		$query->execute();
		$data = $query->fetchAll();
		$result = ["drugs" => [], "substances" => []];
		
		foreach ($data as $value) {
			$result["drugs"][] = [
				"id" => $value["id"],
				"name" => (string)$value["name"]
			];
		}
		
		
		$query = $db->prepare("SELECT cis, substance_name FROM cis_compo_bpdm WHERE substance_name ILIKE :text");
		$query->bindValue(":text", "%$text%", PDO::PARAM_STR);
		$query->execute();
		$data = $query->fetchAll();
		
		foreach ($data as $value) {
			$query2 = $db->prepare("SELECT name FROM cis_bpdm WHERE id = :id");
			$query2->bindValue(":id", $value["cis"], PDO::PARAM_INT);
			$query2->execute();
			$data2 = $query2->fetch();
			
			$result["substances"][] = [
				"cis" => (int)$value["cis"],
				"substance_name" => (string)$value["substance_name"],
				"medicament_name" => (string)$data2["name"]
			];
		}
		
		
		return $result;
	}
	
	public static function load(int $id) : array {
		global $db;
		
		$query = $db->prepare("SELECT name, status, holders FROM cis_bpdm WHERE id = :id");
		$query->bindValue(":id", $id, PDO::PARAM_INT);
		$query->execute();
		$data = $query->fetch();
		$result = [];
		if (empty($data)) {
			return $result;
		}
		
		$result["name"] = (string)trim($data["name"]);
		$result["status"] = (string)trim($data["status"]);
		$result["holders"] = (string)trim($data["holders"]);
		
		
		$query = $db->prepare("SELECT presentation, marketing_date, refund, price FROM cis_cip_bpdm WHERE cis = :cis");
		$query->bindValue(":cis", $id, PDO::PARAM_INT);
		$query->execute();
		$data = $query->fetch();
		
		$result["presentation"] = (string)trim($data["presentation"]);
		$result["marketing_date"] = (string)trim($data["marketing_date"]);
		$result["refund"] = (string)trim($data["refund"]);
		$result["price"] = (string)trim($data["price"]);
		
		
		$query = $db->prepare("SELECT substance_name, substance_dosage FROM cis_compo_bpdm WHERE cis = :cis");
		$query->bindValue(":cis", $id, PDO::PARAM_INT);
		$query->execute();
		$data = $query->fetchAll();
		
		if (count($data) > 1) {
			$result["substance_name"] = "";
			
			foreach ($data as $id=>$value) {
				$value = array_map("trim", $value);
				
				if ($id > 0) {
					$result["substance_name"] .= " + ";
				}
				
				$result["substance_name"] .= "{$value["substance_name"]} ({$value["substance_dosage"]})";
			}
		} else {
			$result["substance_name"] = (string)trim($data[0]["substance_name"]);
		}
	
		return $result;
	}
	
	public static function getDrugsRange(int $cis) : array {
		global $db;
		
		$query = $db->prepare("SELECT substance_name FROM cis_compo_bpdm WHERE cis = :cis");
		$query->bindValue(":cis", $cis, PDO::PARAM_INT);
		$query->execute();
		$data = $query->fetchAll();
		
		if (empty($data)) {
			return [];
		}
		
		$substances = [];
		
		foreach ($data as $value) {
			$query = $db->prepare("SELECT cis FROM cis_compo_bpdm WHERE substance_name = :substance_name");
			$query->bindValue(":substance_name", $value["substance_name"], PDO::PARAM_INT);
			$query->execute();
			$data2 = $query->fetchAll();
			
			foreach ($data2 as $value2) {
				$substances[] = $value2["cis"];
			}
		}
		
		$substances = array_unique($substances);
		$result = [];
		
		
		foreach ($substances as $substance) {
			$query = $db->prepare("SELECT id, name FROM cis_bpdm WHERE id = :id");
			$query->bindValue(":id", $substance, PDO::PARAM_INT);
			$query->execute();
			$data = $query->fetchAll();
			
			foreach ($data as $value) {			
				$result[] = [
					"id" => $value["id"],
					"name" => $value["name"],
				];
			}
		}
		
		return $result;
	}
	
	public static function getList(int $page) : array {
		global $db;
		
		$query = $db->prepare("SELECT id, name FROM cis_bpdm LIMIT 100 OFFSET ".(($page-1)*100));
		$query->execute();
		$data = $query->fetchAll();
		$result = [];
		
		foreach ($data as $value) {
			$result[] = [
				"id" => (int)$value["id"],
				"name" => (string)trim($value["name"])
			];
		}
		
		return $result;
	}
	
	public static function getListPagesNb() : int {
		global $db;
		
		$query = $db->prepare("SELECT COUNT(*) AS nb FROM cis_bpdm");
		$query->execute();
		$data = $query->fetch();
		
		return ceil($data["nb"]/100);
	}
	
	public static function getComments(int $cis) : array {
		global $db;
		
		$query = $db->prepare("SELECT username, content, timestamp FROM comments WHERE cis = :cis ORDER BY timestamp DESC");
		$query->bindValue(":cis", $cis, PDO::PARAM_INT);
		$query->execute();
		$data = $query->fetchAll();
		if (empty($data)) {
			return [];
		}
		$result = [];
		
		foreach ($data as $value) {
			$result[] = [
				"username" => (string)trim($value["username"]),
				"content" => (string)trim($value["content"]),
				"timestamp" => (int)$value["timestamp"]
			];
		}
		
		return $result;
	}
	
	public static function addComment(int $cis, string $username, string $content) : int {
		global $db;
		
		$query = $db->prepare("INSERT INTO comments(source_ip, source_port, username, content, cis, timestamp) VALUES(:source_ip, :source_port, :username, :content, :cis, ".time().")");
		$query->bindValue(":source_ip", $_SERVER["REMOTE_ADDR"], PDO::PARAM_STR);
		$query->bindValue(":source_port", $_SERVER["REMOTE_PORT"], PDO::PARAM_INT);
		$query->bindValue(":username", $username, PDO::PARAM_STR);
		$query->bindValue(":content", $content, PDO::PARAM_STR);
		$query->bindValue(":cis", $cis, PDO::PARAM_INT);
		$query->execute();
		
		return $db->lastInsertId();
	}
	
	public static function getRecents() : array {
		global $db;
		
		$query = $db->prepare("SELECT cis, marketing_date FROM cis_cip_bpdm ORDER BY marketing_date_timestamp DESC LIMIT 100");
		$query->execute();
		$data = $query->fetchAll();
		foreach ($data as $value) {
			$query2 = $db->prepare("SELECT name FROM cis_bpdm WHERE id = :cis");
			$query2->bindValue(":cis", $value["cis"], PDO::PARAM_INT);
			$query2->execute();
			$data2 = $query2->fetch();
			
			$result[] = [
				"id" => (int)$value["cis"],
				"date" => (string)trim($value["marketing_date"]),
				"name" => (string)trim($data2["name"])
			];
		}
		
		return $result;
	}
	
	public static function cisToName(int $cis) : string {
		global $db;
		
		$query = $db->prepare("SELECT name FROM cis_bpdm WHERE id = :cis");
		$query->bindValue(":cis", $cis, PDO::PARAM_INT);
		$query->execute();
		$data = $query->fetch();
		
		return $data["name"];
	}
}