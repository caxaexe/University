<?php
require_once __DIR__ . '../app/core/auth.php';

class PokemonController {
    public function index() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM pokemons ORDER BY name");
        $pokemons = $stmt->fetchAll();

        include '../app/views/pokemon_list.php';
    }

    public function create() {
        require_admin();
        $error = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $type = $_POST['type'];
            $level = $_POST['level'];
            $generation = $_POST['generation'];

            if ($name === '' || $level < 1 || $generation < 1) {
                $error = 'Проверьте корректность данных';
            } else {
                $db = Database::connect();
                $stmt = $db->prepare("INSERT INTO pokemons (name, type, level, generation) VALUES (?, ?, ?, ?)");
                $stmt->execute([$name, $type, $level, $generation]);
                header("Location: manage_pokemon.php");
                exit;
            }
        }

        include '../app/views/create_pokemon.php';
    }

    public function delete($id) {
        require_admin();
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM pokemons WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: manage_pokemon.php");
    }

    public function search($query) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM pokemons WHERE name LIKE ?");
        $stmt->execute(['%' . $query . '%']);
        $results = $stmt->fetchAll();

        include '../app/views/pokemon_search_results.php';
    }
}
