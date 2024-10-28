<?php
namespace App\classes;

interface StorageInterface
{
    public function save($data);
    public function load($id);
}
?>