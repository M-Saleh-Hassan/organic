<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Report\StoreReportRequest;
use App\Http\Requests\Report\UpdateReportRequest;
use App\Http\Resources\ReportDataResource;
use App\Http\Resources\ReportResource;
use App\Models\Project;
use App\Models\Report;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class ReportController extends ApiController implements HasMiddleware
{

    /**
     * Get the middleware that should be assigned to the controller.
     */
    public static function middleware(): array
    {
        $routeAction = Route::currentRouteAction();
        list($controller, $method) = explode('@', $routeAction);
        if ($method != 'download' && $method != 'testReport') {
            return [
                'authorized:reports',
            ];
        }
        return [];
    }

    public function index(Request $request, Project $project)
    {
        $filters = $this->getFilters($request);
        $reports = $project->reports()->search($filters['search'])
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($filters['limit']);

        return $this->handlePaginateResponse(ReportResource::collection($reports));
    }

    public function show(Project $project, Report $report)
    {
        return $this->handleResponse(new ReportResource($report));
    }

    public function store(StoreReportRequest $request, Project $project)
    {
        DB::beginTransaction();
        $report = Report::create($request->validated() + [
            'user_id' => $request->user()->id,
        ]);
        if ($request->has('subcontractors_ids')) {
            $report->subcontractors()->sync($request->subcontractors_ids);
        }
        DB::commit();

        return $this->handleResponse(new ReportResource($report));
    }

    public function update(UpdateReportRequest $request, Project $project, Report $report)
    {
        DB::beginTransaction();
        $report->update($request->validated());
        if ($request->has('subcontractors_ids')) {
            $report->subcontractors()->sync($request->subcontractors_ids);
        }
        DB::commit();

        return $this->handleResponse(new ReportResource($report));
    }

    public function destroy(Request $request, Project $project, Report $report)
    {
        $report->delete();
        return $this->handleResponseMessage('Report deleted successfully');
    }

    public function download(Request $request, Report $report)
    {
        $html = view('pdf.' . $report->report_type, [
            'report' => $report,
            'project' => $report->project()
                ->withoutGlobalScope('belongsToAuthenticatedTenant')
                ->withoutGlobalScope('onlyAssignedProjectsToCurrentUser')->first()
        ])->render();
        // return $html;
        $dompdf = new Dompdf();
        // Load the HTML content
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper([0, 0, 1440, 2160]); // 1440px width and 2160px height
        $options = $dompdf->getOptions();
        $options->set('defaultFont', 'DM Sans');
        // Render PDF (important step!)
        $dompdf->render();

        // Output PDF to browser
        return $dompdf->stream('report.pdf');
    }

    public function testReport(Request $request)
    {
        // Validate the file input
        $request->validate([
            'html_file' => 'required|file|mimetypes:text/html,text/plain',
        ]);

        // Get the uploaded file
        $file = $request->file('html_file');

        // Read the file content
        $htmlContent = file_get_contents($file->getRealPath());

        $html = view('pdf.test', [
            'content' => $htmlContent,
        ])->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        // $dompdf->setPaper('A4', 'portrait');

        // Render PDF (important step!)
        $dompdf->render();

        // Output PDF to browser
        return $dompdf->stream('test.pdf');
    }
}
