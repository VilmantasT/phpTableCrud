<?php


class DBConnector
{
    private $servername = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "masinos";
    private $conn;

    function __construct()
    {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->db);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }


    public function getAllCars()
    {
        $q = "SELECT id, Numeris, Marke, Modelis, Metai, Leistinas_greitis, Fiksuotas_greitis, Bauda, Sumoketa FROM automobiliai";
        return $this->conn->query($q);
    }

    // CRUD read 1 dalis
    public function getCarByID($id)
    {
        $q = "SELECT * FROM `automobiliai` WHERE `id` = ?";
        $stmt = $this->conn->prepare($q);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // CRUD Create dalis
    public function addCar($Numeris, $Marke, $Modelis, $Metai, $Leistinas_greitis, $Fiksuotas_greitis, $Bauda, $Sumoketa)
    {
        $q = "INSERT INTO `automobiliai` ( `Numeris`, `Marke`, `Modelis`, `Metai`, `Leistinas_greitis`, `Fiksuotas_greitis`, `Bauda`, `Sumoketa`) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($q);
        $stmt->bind_param("sssiiiis", $Numeris, $Marke, $Modelis, $Metai, $Leistinas_greitis, $Fiksuotas_greitis, $Bauda, $Sumoketa);
        $stmt->execute();
    }

    // CRUD Delete dalis
    public function deleteCar($id)
    {
        $q = "DELETE FROM `automobiliai` WHERE id = ?";
        $stmt = $this->conn->prepare($q);
        $stmt->bind_param("i", $id);
        $stmt->execute();
    }

    // CRUD update dalis
    public function updateCar($id, $Marke, $Modelis, $Metai, $Leistinas_greitis, $Fiksuotas_greitis, $Bauda, $Sumoketa)
    {
        $q = "UPDATE `automobiliai` SET `Marke` = ?,`Modelis` = ?,`Metai` = ?,`Leistinas_greitis` = ?, `Fiksuotas_greitis` = ?, `Bauda` = ?, `Sumoketa` = ? WHERE `id` = ?;";
        $stmt = $this->conn->prepare($q);
        $stmt->bind_param("sssssssi", $Marke, $Modelis, $Metai, $Leistinas_greitis, $Fiksuotas_greitis, $Bauda, $Sumoketa);
        $stmt->execute();
    }
}
