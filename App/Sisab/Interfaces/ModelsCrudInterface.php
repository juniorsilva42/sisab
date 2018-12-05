<?php

namespace App\Sisab\Interfaces;

interface ModelsCrudInterface {

    static public function create(ModelsInterface $object);

    static public function update(ModelsInterface $object);

    static public function getAll();

    static public function getById($id);

    static public function delete($id);
}