<?php

namespace App\Repositories;

use App\Models\Hall;
use App\Repositories\Interfaces\HallRepositoryInterface;

class HallRepository implements HallRepositoryInterface
{
    public function getAll()
    {
        return Hall::all();
    }

    public function getById($id)
    {
        return Hall::findOrFail($id);
    }

    public function create(array $data)
    {
        return Hall::create($data);
    }

    public function update($id, array $data)
    {
        $hall = Hall::findOrFail($id);
        $hall->update($data);
        return $hall;
    }

    public function delete($id)
    {
        return Hall::destroy($id);
    }
}
