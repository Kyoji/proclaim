<?php

declare(strict_types = 1);
namespace Proclaim\Core;

class Database
{
    protected $adapter;

    function __construct( AdapterInterface $adapter )
    {
        $this->adapter = $adapter;
    }

    public function getPosts( $type = 'post' )
    {
        $pdo = &$this->adapter;
        $stmt = $pdo->prepare('SELECT * FROM proclaim_posts');
        $stmt->execute(); // $stmt->execute(['type' => $type]);
        return $stmt->fetchAll(\PDO::FETCH_CLASS, 'Proclaim\Core\Post');
    }

    public function query($query, $fetch = ['FETCH_ASSOC', 'Proclaim\Core\Post'])
    {
        $pdo = &$this->adapter;
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        if ($fetch[0] === 'FETCH_CLASS') {
            return call_user_func_array([$stmt, "fetchAll"], [constant('\PDO::' . $fetch[0]), $fetch[1]]);
        } else {
            return call_user_func_array([$stmt, "fetchAll"], [constant('\PDO::' . $fetch[0])]);
        }
    }

    public function getPostBy($type = 'id', $query = '1')
    {
        $pdo = &$this->adapter;
        $stmt = $pdo->prepare('SELECT * FROM proclaim_posts WHERE ' . $type . ' = :query');
        $stmt->execute(['query' => $query]);
        return $stmt->fetchAll(\PDO::FETCH_CLASS, 'Proclaim\Core\Post');
    }
}