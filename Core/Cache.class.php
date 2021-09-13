<?php
class Cache {
	/**
	 * Lit une entrée
	 *
	 * @param string $name Nom de l'entrée
	 *
	 * @return string Contenu de l'entrée
	 */
	public static function read(string $name) : string {
		global $db;
		
		$query = $db->prepare("SELECT value FROM cache WHERE name = :name");
		$query->bindValue(":name", $name, PDO::PARAM_STR);
		$query->execute();
		$data = $query->fetch();
		
		return $data["value"];
	}
	
	/**
	 * Écrit une entrée
	 *
	 * @param string $name Nom de l'entrée
	 * @param string $value Contenu de l'entrée
	 * @param int $duration Durée de vie de l'entrée
	 *
	 * @return bool Résultat
	 */
	public static function write(string $name, string $value, int $duration = 3600) : bool {
		global $db;
		
		$query = $db->prepare("INSERT INTO cache(name, value, expiration) VALUES(:name, :value, ".(time()+$duration).")");
		$query->bindValue(":name", $name, PDO::PARAM_STR);
		$query->bindValue(":value", $value, PDO::PARAM_STR);
		
		return $query->execute();
	}
	
	/**
	 * Vérifie si une entrée existe
	 *
	 * @param string $name Nom de l'entrée
	 *
	 * @return bool Résultat
	 */
	public static function exists(string $name) : bool {
		global $db;
		
		$query = $db->prepare("SELECT COUNT(*) AS nb FROM cache WHERE name = :name");
		$query->bindValue(":name", $name, PDO::PARAM_STR);
		$query->execute();
		$data = $query->fetch();
		
		return $data["nb"] == 1;
	}
	
	/**
	 * Supprime du cache les entrées expirées
	 *
	 * @return bool Résultat
	 */
	public static function purge() : bool {
		global $db;
		
		$query = $db->prepare("DELETE FROM cache WHERE ".time()." > expiration");
		
		return $query->execute();
	}
}