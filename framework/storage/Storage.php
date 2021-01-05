<?php

class Storage
{
    protected static $storagePath = 'data-store.json';
    protected static $contents = array();
    protected static $uniqueId = 1;

    public static function create($data = array()) {
        return static::save(static::$tableName, $data);
    }

    public static function save($tableName, $data = array())
    {
        if (!isset(static::$contents[$tableName])) {
            static::$contents[$tableName] = array();
        }

        $db = static::fetchDB();
        $all = static::fetchAll();
        $totalItems = count($all);
        $lastItem = end($all);
        $currentId = $totalItems > 0 ? $lastItem['id'] + 1 : static::$uniqueId;

        $db[$tableName][$currentId] = array();

        foreach ($data as $key => $value) {
            $db[$tableName][$currentId][$key] = $value;
        }

        $db[$tableName][$currentId]['id'] = $currentId;
        file_put_contents(static::$storagePath, json_encode($db));

        return self::fetch(static::$tableName, $currentId);
    }

    private static function fetchDB() {
        return json_decode(file_get_contents(static::$storagePath), true);
    }

    public static function fetchAll($tableName = null) {
        $key = $tableName ?? static::$tableName;
        $data = static::fetchDB();
        if (!isset($data[$key])) {
            $data[$key] = array();
        }
        return $data[$key];
    }

    public static function findById($id = 1) {
        static::fetch(static::$tableName, $id);
    }

    /**
     * @param $tableName
     * @param int $id
     * @throws Exception
     */
    public static function fetch($tableName, $id = 1)
    {
        $retrievedData = self::fetchAll($tableName);

        if (!isset($retrievedData[$id])) {
            return null;
        }

        return $retrievedData[$id];
    }
}