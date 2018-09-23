<?php
class DbManager {
    protected $connections = array();
    protected $repository_connection_map = array();
    protected $repositories = array();

    public function connect($name, $params) {
        $params = array_merge(array(
            'dsn' => null,
            'user' => '',
            'password' => '',
            'options' => array(),
        ), $params);

        $con = new PDO(
            $params['dsn'],
            $params['user'],
            $params['password'],
            $params['options']
        );

        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $this->connetions[$name] = $con;
    }

    public function getConnection($name = null) {
        if (is_null($name)) {
            return current($this->connections);
        }
        return $this->connections[$name];
    }

    public function setRepositryConnectionMap($repositry_name, $name) {
        $this->repository_connection_map[$repository_name] = $name;
    }

    public function getConnectionForRepositry($repositry_name) {
        if(isset($this->repository_connection_map[$repository_name])) {
            $name = $this->repository_connection_map[$repository_name];
            $con = $this->getConnection($name);
        } else {
            $con = $this->getConnection();
        }
        return $con;
    }

    public function get($repositry_name) {
        if (!isset($this->repositores[$repository_name])) {
            $repositry_class = $repository_name . 'Repository';
            $con = $this->getConnectionForRepositry($repository_name);

            $repositry = new $repository_class($con);

            $this->repositories[$repositry_name] = $repository;
        }
        return $this->repositories[$repositry_name];
    }

    public function __destruct() {
        foreach($this->repositories as $repository) {
            unset($repository);
        }

        foreach($this->connections as $con) {
            unset($con);
        }
    }
}
