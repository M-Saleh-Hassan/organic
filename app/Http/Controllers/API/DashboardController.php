<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\DashboardResource;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Routing\Controllers\HasMiddleware;

class DashboardController extends ApiController implements HasMiddleware
{

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        return [
            'authorized:dashboard',
        ];
    }

    public function index(Project $project)
    {
        return $this->handleResponse(new DashboardResource($project));
    }

}
