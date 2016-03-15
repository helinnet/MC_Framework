<?php
namespace MC\MVC;
abstract class Model {

    /**
     * Database resource
     * @var Database
     */
    protected $db;

    /**
     * Sql Query
     * @var string
     */
    protected $query;

    /**
     * Creates the Model object
     * @param Registry $services
     * @return Registry $services
     */
    public function __construct($services) {
        if (!isset($services)) {
            throw new Exception('Please provide a service container object!');
        }
        try {
            $dsn = 'mysql:host=' . $services->config->db['hostname'] . ';dbname=' . $services->config->db['dbname'];
            $this->db = new PDO($dsn, $services->config->db['username'], $services->config->db['password']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Connection error: ' . $e->getMessage());
        }
        $this->services = $services;
        return $this->db;
    }

    /**
     * Makes a connection to a database
     * @param Registry $services
     * @return PDO db
     * @throws Exception
     */
    protected function connect($hostname, $dbname, $username, $password) {
        try {
            $dsn = 'mysql:host=' . $hostname . ';dbname=' . $dbname;
            $this->db = new PDO($dsn, $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die('Connection error: ' . $e->getMessage());
        }
        return $this->db;
    }

    /**
     *  Sets query for a database
     * @param string $query
     */
    protected function query($query) {
        $this->query = $query;
    }

    /**
     * Gets all data from a database query
     * @param array $data
     * @return array
     * @throws Exception
     */
    protected function all($data = NULL) {
        if (!$this->query)
            throw new Exception("Provide some SQL-Query please!");
        $sth = $this->db->prepare($this->query);
        $sth->execute($data);
        return $sth->fetchAll();
    }

    /**
     * Gets a data row from the query
     * @param array $data
     * @return array
     * @throws Exception
     */
    protected function row($data = NULL) {
        if (!$this->query)
            throw new Exception("Provide some SQL-Query please!");
        $sth = $this->db->prepare($this->query);
        $sth->execute($data);
        return $sth->fetch();
    }

}