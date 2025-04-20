<?php

require_once __DIR__ . '/testframework.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../modules/database.php';
require_once __DIR__ . '/../modules/page.php';

$tests = new TestFramework();

function getTestDb() {
    global $config;
    $db = new Database($config['db']['path']);
    $db->Execute("CREATE TABLE IF NOT EXISTS test (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, value TEXT)");
    return $db;
}

function testDbConnection() {
    try {
        $db = getTestDb();
        return assertExpression($db instanceof Database, 'Database connection OK', 'Database connection FAILED');
    } catch (Exception $e) {
        return assertExpression(false, '', $e->getMessage());
    }
}

function testDbCreate() {
    $db = getTestDb();
    $id = $db->Create('test', ['name' => 'foo', 'value' => 'bar']);
    return assertExpression(is_numeric($id) && $id > 0, 'Create works', 'Create failed');
}

function testDbRead() {
    $db = getTestDb();
    $id = $db->Create('test', ['name' => 'baz', 'value' => 'qux']);
    $row = $db->Read('test', $id);
    return assertExpression($row['name'] === 'baz', 'Read OK', 'Read failed');
}

function testDbUpdate() {
    $db = getTestDb();
    $id = $db->Create('test', ['name' => 'update', 'value' => 'before']);
    $db->Update('test', $id, ['value' => 'after']);
    $row = $db->Read('test', $id);
    return assertExpression($row['value'] === 'after', 'Update OK', 'Update failed');
}

function testDbDelete() {
    $db = getTestDb();
    $id = $db->Create('test', ['name' => 'del', 'value' => 'me']);
    $db->Delete('test', $id);
    $row = $db->Read('test', $id);
    return assertExpression(!$row, 'Delete OK', 'Delete failed');
}

function testDbCount() {
    $db = getTestDb();
    $initial = $db->Count('test');
    $db->Create('test', ['name' => 'count', 'value' => '1']);
    $new = $db->Count('test');
    return assertExpression($new === $initial + 1, 'Count OK', 'Count failed');
}

function testDbFetchExecute() {
    $db = getTestDb();
    $db->Execute("INSERT INTO test (name, value) VALUES ('a', 'b')");
    $rows = $db->Fetch("SELECT * FROM test WHERE name = 'a'");
    return assertExpression(count($rows) > 0, 'Fetch/Execute OK', 'Fetch/Execute failed');
}

function testPageRender() {
    $tpl = __DIR__ . '/../templates/index.tpl';
    $page = new Page($tpl);
    $html = $page->Render(['title' => 'Test', 'content' => 'Hello']);
    return assertExpression(strpos($html, 'Test') !== false && strpos($html, 'Hello') !== false, 'Page render OK', 'Page render failed');
}

// Add tests
$tests->add('Database connection', 'testDbConnection');
$tests->add('Create record', 'testDbCreate');
$tests->add('Read record', 'testDbRead');
$tests->add('Update record', 'testDbUpdate');
$tests->add('Delete record', 'testDbDelete');
$tests->add('Count records', 'testDbCount');
$tests->add('Execute/Fetch SQL', 'testDbFetchExecute');
$tests->add('Page rendering', 'testPageRender');

// Run tests
$tests->run();

echo $tests->getResult() . PHP_EOL;
