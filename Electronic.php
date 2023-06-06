<?php
class Electronic extends Product
{
    public function save()
    {
        $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
        $stmt = $db->prepare('INSERT INTO products (type, name, price, details) VALUES (?, ?, ?, ?)');
        $stmt->execute(['electronic', $this->name, $this->price, $this->details]);
    }
}
?>
