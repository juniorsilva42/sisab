<?php

namespace App\Sisab\Interfaces;

interface ModelsInterface {

    static public function create(GenericModelInterface $object);

    static public function update(GenericModelInterface $object);

    static public function getAll();

    static public function getById($id);

    static public function delete($id);
}