<?php

namespace App\Repositories;

interface ActivityRepositoryInterface
{
    public function all();

    public function aggregate(array $aggregations);
}