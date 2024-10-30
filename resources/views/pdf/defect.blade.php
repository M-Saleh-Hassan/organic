@php
    use Illuminate\Support\Facades\Storage;
    use App\Http\Resources\WeatherResource;

@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
        rel="stylesheet">
    <title>Report</title>
    <style>
        @font-face {
            font-family: 'DM Sans';
            src: url({{ asset('pdf/DMSans-VariableFont_opsz,wght.ttf') }}) format('truetype');
        }

        body {
            font-family: 'DM Sans', sans-serif;
        }

        * {
            padding: 0;
            margin: 0;
            font-family: 'DM Sans', sans-serif;
            box-sizing: border-box;
        }

        .layout-table {
            width: 100%;
        }

        .layout-table tr td {
            vertical-align: bottom;
        }

        .layout-table tr .col-3 {
            padding: 0 12px;
            width: 25%;
        }

        .layout-table tr .col-4 {
            padding: 0 12px;
            width: 33.33%;
        }

        .layout-table tr .col-5 {
            padding: 0 12px;
            width: 41.66%;
        }

        .layout-table tr .col-6 {
            padding: 0 12px;
            width: 50%;
        }

        .layout-table tr .col-12 {
            padding: 0 12px;
            width: 100%;
        }

        .ps-0 {
            padding-left: 0 !important;
        }

        .pe-0 {
            padding-right: 0 !important;
        }

        .report-wrapper {
            width: 100vw;
        }

        .report-wrapper .green-row {
            background-color: #5DB971;
            height: 30px;
            width: 100%;
        }

        .report-wrapper .content-wrapper {
            padding: 50px 120px;
        }

        .report-wrapper .content-wrapper .report-header {
            margin-bottom: 60px;
        }

        .report-wrapper .content-wrapper .report-header .title {
            font-size: 40px;
            line-height: 1.4;
            font-weight: 600;
            color: #2C3E50;
        }

        .report-wrapper .content-wrapper .report-header .logo {
            display: table;
            margin-left: auto;
        }

        .report-wrapper .content-wrapper .field {
            border-bottom: 1px solid rgba(196, 196, 196, 0.5);
            padding: 15px 0;
            margin-bottom: 20px;
        }

        .report-wrapper .content-wrapper .field.weather-field {
            padding: 0;
        }

        .report-wrapper .content-wrapper .field .label {
            font-size: 16px;
            line-height: 1.4;
            font-weight: 500;
            color: #2C3E50;
            display: inline-block;
        }

        .report-wrapper .content-wrapper .field .value {
            font-size: 16px;
            line-height: 1.4;
            font-weight: 400;
            color: #617080;
            padding-left: 20px;
            display: inline-block;
        }

        .report-wrapper .content-wrapper .field .weather-icon {
            display: inline-block;
            width: 40px;
            height: 40px;
        }

        .report-wrapper .content-wrapper .field .weather-icon img {
            max-width: 100%;
            max-height: 100%;
        }

        .report-wrapper .content-wrapper .field .value .weather-value {
            font-size: 28px;
            font-weight: 600;
            color: #2C3E50;
        }

        .report-wrapper .content-wrapper .field .value .weather-label {
            font-size: 14px;
            font-weight: 400;
            color: #617080;
            margin-right: 15px;
        }

        .report-wrapper .content-wrapper .report-content {
            padding-top: 30px;
        }

        .report-wrapper .content-wrapper .report-content .content-group {
            padding-top: 50px;
        }

        .report-wrapper .content-wrapper .report-content .content-group .content-title {
            font-size: 24px;
            line-height: 1.4;
            font-weight: 600;
            color: #2C3E50;
            margin-bottom: 20px;
        }

        .report-wrapper .content-wrapper .report-content .content-group .images {
            font-size: 14px;
            line-height: 1.4;
            font-weight: 600;
            color: #2C3E50;
        }

        .report-wrapper .content-wrapper .report-content .content-group .image {
            height: 180px;
            position: relative;
        }

        .report-wrapper .content-wrapper .report-content .content-group .image img {
            max-width: 100%;
            max-height: 100%;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .report-wrapper .content-wrapper .report-content .content-group .table {
            width: 100%;
            border-collapse: collapse;
        }

        .report-wrapper .content-wrapper .report-content .content-group .table tr {
            border-bottom: 1px solid #E2E8F0;
        }

        .report-wrapper .content-wrapper .report-content .content-group .table tr th {
            text-align: left;
            font-size: 12px;
            line-height: 1.5;
            font-weight: 600;
            padding: 10px;
            color: #2C3E50;
        }

        .report-wrapper .content-wrapper .report-content .content-group .table tr td {
            text-align: left;
            font-size: 14px;
            line-height: 1.4;
            font-weight: 400;
            padding: 20px 10px;
            color: #617080;
        }

        .report-wrapper .content-wrapper .report-signature {
            padding-top: 100px;
        }

        .report-wrapper .content-wrapper .report-footer {
            padding-top: 100px;
        }
    </style>
</head>

<body>
    <div class="report-wrapper">
        <div class="green-row"></div>
        <div class="content-wrapper">
            <div class="report-header">
                <table class="layout-table">
                    <tbody>
                        <tr>
                            <td class="col-6 ps-0">
                                <h1 class="title">Defect</h1>
                            </td>
                            <td class="col-6 pe-0">
                                <div class="logo">
                                    <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('pdf/logo-icon-text.svg'))) }}" alt="Logo">
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="report-info">
                <table class="layout-table">
                    <tbody>
                        <tr>
                            <td class="col-5">
                                <div class="field">
                                    <p class="label">Report no</p>
                                    <p class="value">{{ $report->id }}</p>
                                </div>
                            </td>
                            <td class="col-3"></td>
                            <td class="col-4">
                                <table class="layout-table">
                                    <tbody>
                                        <tr>
                                            <td class="col-6 ps-0">
                                                <div class="field">
                                                    <p class="label">Date</p>
                                                    <p class="value">
                                                        {{ \Carbon\Carbon::parse($report->created_at)->format('m/d/Y') }}
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="col-6 pe-0">
                                                <div class="field">
                                                    <p class="label">Time</p>
                                                    <p class="value">
                                                        {{ \Carbon\Carbon::parse($report->created_at)->format('h:i A') }}
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="layout-table">
                    <tbody>
                        <tr>
                            <td class="col-5">
                                <div class="field">
                                    <p class="label">Project Name</p>
                                    <p class="value">{{ $project->name }}</p>
                                </div>
                            </td>
                            <td class="col-3"></td>
                            <td class="col-4">
                                <div class="field">
                                    <p class="label">Location</p>
                                    <p class="value">{{ optional($project->country)->name }},
                                        {{ optional($project->city)->name }}</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="layout-table">
                    <tbody>
                        <tr>
                            <td class="col-5">
                                <div class="field">
                                    <p class="label">Company</p>
                                    <p class="value">{{ $project->company }}</p>
                                </div>
                            </td>
                            <td class="col-3"></td>
                            <td class="col-4">
                                <div class="field weather-field">
                                    <p class="label">Weather</p>
                                    <div class="weather-icon">
                                        <img src="data:image/jpeg;base64,{{ base64_encode(file_get_contents(public_path('pdf/report-weather-icon.svg'))) }}" alt="Logo">
                                    </div>
                                    <p class="value">
                                        @php
                                            $weather = new WeatherResource($project->getWeatherData());
                                        @endphp
                                        <span class="weather-value">{{ $weather['main']['temp_max'] }}&deg;</span>
                                        <span class="weather-label">Hi</span>
                                        <span class="weather-value">{{ $weather['main']['temp_min'] }}&deg;</span>
                                        <span class="weather-label">Lo</span>
                                    </p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table class="layout-table">
                    <tbody>
                        <tr>
                            <td class="col-12">
                                <div class="field">
                                    <p class="label">Address</p>
                                    <p class="value">{{ $project->address }}</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="report-content">
                @foreach ($report->getDefects() as $defect)
                    <div class="content-group">
                        <h2 class="content-title">DEFECT INFO</h2>
                        <table class="layout-table">
                            <tbody>
                                <tr>
                                    <td class="col-6">
                                        <div class="field">
                                            <p class="label">Title</p>
                                            <p class="value">{{ $defect->title }}</p>
                                        </div>
                                    </td>
                                    <td class="col-6">
                                        <div class="field">
                                            <p class="label">Layer</p>
                                            <p class="value"></p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-6">
                                        <div class="field">
                                            <p class="label">Type of work</p>
                                            <p class="value">{{ $defect->work_type }}</p>
                                        </div>
                                    </td>
                                    <td class="col-6">
                                        <div class="field">
                                            <p class="label">Assignee</p>
                                            <p class="value">{{ $defect->assignee->first_name }}
                                                {{ $defect->assignee->last_name }}</p>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="col-6">
                                        <div class="field">
                                            <p class="label">Due Date</p>
                                            <p class="value">{{ \Carbon\Carbon::parse($defect->due_date)->format('F j, Y') }}</p>
                                        </div>
                                    </td>
                                    <td class="col-6">
                                        <div class="field">
                                            <p class="label">Status</p>
                                            <p class="value">{{ $defect->status }}</p>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                @endforeach
                {{-- <div class="content-group">
                    <h2 class="content-title">FLOOR PLANS</h2>
                    <table class="layout-table">
                        <tbody>
                            <tr>
                                <td class="col-3">
                                    <img src="./report-placeholder-img.png" alt="">
                                </td>
                                <td class="col-3">
                                    <img src="./report-placeholder-img.png" alt="">
                                </td>
                                <td class="col-3">
                                    <img src="./report-placeholder-img.png" alt="">
                                </td>
                                <td class="col-3">
                                    <img src="./report-placeholder-img.png" alt="">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div> --}}
            </div>
            <div class="report-signature">
                <table class="layout-table">
                    <tbody>
                        <tr>
                            <td class="col-6">
                                <div class="field">
                                    <p class="label">Place</p>
                                    <p class="value"></p>
                                </div>
                            </td>
                            <td class="col-6">
                                <div class="field">
                                    <p class="label">Name</p>
                                    <p class="value"></p>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-6">
                                <div class="field">
                                    <p class="label">Date</p>
                                    <p class="value"></p>
                                </div>
                            </td>
                            <td class="col-6">
                                <div class="field">
                                    <p class="label">Signature</p>
                                    <p class="value"></p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</body>

</html>
