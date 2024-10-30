<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Support\StoreSupportRequest;
use App\Http\Resources\QuestionResource;
use App\Http\Resources\ReportResource;
use App\Http\Resources\TopicResource;
use App\Models\SupportRequest;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends ApiController
{
    public function index(Request $request)
    {
        $filters = $this->getFilters($request);
        $topics = Topic::search($filters['search'])
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($filters['limit']);
        return $this->handlePaginateResponse(TopicResource::collection($topics));
    }

    public function getQuestions(Request $request, Topic $topic)
    {
        $filters = $this->getFilters($request);
        $questions = $topic->questions()
            ->search($filters['search'])
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($filters['limit']);
        return $this->handlePaginateResponse(QuestionResource::collection($questions));
    }

    public function support(StoreSupportRequest $request)
    {
        SupportRequest::create($request->validated() + [
            'user_id' => $request->user()->id,
        ]);
        return $this->handleResponseMessage('Support Request is sent successfully');
    }
}
