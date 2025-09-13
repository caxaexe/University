<?php

class Pokemon {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Получение всех покемонов
    public function getAllPokemons($filter = '') {
        $query = "SELECT * FROM pokemons";
        
        if ($filter) {
            $query .= " WHERE type LIKE ? OR generation LIKE ?";
        }
        
        $stmt = $this->db->prepare($query);
        
        if ($filter) {
            $stmt->execute(["%$filter%", "%$filter%"]);
        } else {
            $stmt->execute();
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Получение покемона по ID
    public function getPokemonById($id) {
        $query = "SELECT * FROM pokemons WHERE id = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Добавление нового покемона
    public function addPokemon($name, $type, $generation, $imagePath) {
        $query = "INSERT INTO pokemons (name, type, generation, image_path) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$name, $type, $generation, $imagePath]);
    }

    // Обновление данных покемона
    public function updatePokemon($id, $name, $type, $generation, $imagePath) {
        $query = "UPDATE pokemons SET name = ?, type = ?, generation = ?, image_path = ? WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$name, $type, $generation, $imagePath, $id]);
    }

    // Удаление покемона
    public function deletePokemon($id) {
        $query = "DELETE FROM pokemons WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>
