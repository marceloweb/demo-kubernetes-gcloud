<?php

class Connection {

    private $config;
    private $db;

    public function __construct() {
        $data = include 'includes/config.php';
        $this->config = $data['database'];

        $pdo = new PDO("{$this->config['driver']}:host={$this->config['host']};dbname={$this->config['dbname']}","{$this->config['user']}","{$this->config['passwd']}");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->db = $pdo;
    }

    public function save($sql) {
        try {

           $stmt = $this->db->prepare($sql);
           $result = $stmt->execute();      
      
        } catch (PDOException $e) {
           $result = $e;
        }  
        return $result;
      }
      
      public function prepare($twitters) {
      
        $i = 1;
        $sql = "insert into twitter.ranking (name,screen_name,followers_count) values";
        foreach ($twitters as $twitter) {
           $name = addslashes($twitter['name']);
           $screenName = addslashes($twitter['screen_name']);
           $sql .= "(     
                 '{$name}',
                 '{$screenName}',
                 '{$twitter['followers_count']}'
           )";
           $sql .= ($i == count($twitters)) ? ";" : ",";
           $i++;  
        }
        return $sql;
      }

      public function getList() {

         $sql = "select distinct name,screen_name,followers_count from twitter.ranking order by followers_count desc";

         $stmt = $this->db->prepare($sql);
         $stmt->execute();

         return $stmt->fetchAll();
      }
}
