<?php 

namespace App\Services;

use App\Repositories\ActivityRepositoryInterface;

class ActivityService
{
    public function __construct(
        protected ActivityRepositoryInterface $activityRepository
    ){}

    public function all()
    {
        return $this->activityRepository->all();
    }

    public function with(array $relations)
    {
        return $this->activityRepository->with($relations);
    }

    public function aggregate(array $aggregations)
    {
        return $this->activityRepository->aggregate($aggregations);
    }
}