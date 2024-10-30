<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReportControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->project = Project::factory()->create();
        $this->report = Report::factory()->create(['project_id' => $this->project->id]);
    }

    public function testIndex()
    {
        $this->actingAs($this->user, 'sanctum');
        $response = $this->getJson(route('reports.index', ['project' => $this->project->id]));
        $response->assertStatus(200);
    }

    public function testShow()
    {
        $this->actingAs($this->user, 'sanctum');
        $response = $this->getJson(route('reports.show', ['project' => $this->project->id, 'report' => $this->report->id]));
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $this->actingAs($this->user, 'sanctum');
        $data = Report::factory()->make(['project_id' => $this->project->id])->toArray();
        $response = $this->postJson(route('reports.store', ['project' => $this->project->id]), $data);
        $response->assertStatus(201);
    }

    public function testUpdate()
    {
        $this->actingAs($this->user, 'sanctum');
        $data = ['name' => 'Updated Report Name'];
        $response = $this->putJson(route('reports.update', ['project' => $this->project->id, 'report' => $this->report->id]), $data);
        $response->assertStatus(200);
    }

    public function testDestroy()
    {
        $this->actingAs($this->user, 'sanctum');
        $response = $this->deleteJson(route('reports.destroy', ['project' => $this->project->id, 'report' => $this->report->id]));
        $response->assertStatus(200);
    }

    public function testDownload()
    {
        $this->actingAs($this->user, 'sanctum');
        $response = $this->getJson(route('reports.download', ['report' => $this->report->id]));
        $response->assertStatus(200);
    }

    public function testTestReport()
    {
        $this->actingAs($this->user, 'sanctum');
        $file = new \Illuminate\Http\UploadedFile(resource_path('test.html'), 'test.html', 'text/html', null, true);
        $response = $this->postJson(route('reports.testReport'), ['html_file' => $file]);
        $response->assertStatus(200);
    }
}
