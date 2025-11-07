<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $platform->name }} - Google Business Profiles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/css/style.css" />
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" as="style" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            display: inline-block;
            width: 24px;
            height: 24px;
            text-align: center;
            vertical-align: middle;
            line-height: 1;
        }

        .transaction-table table th,
        .transaction-table table td {
            vertical-align: middle;
        }

        .account-card {
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            margin-bottom: 20px;
            background: #fff;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.05);
        }

        .account-header {
            background-color: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #e1e1e1;
        }
    </style>
</head>

<body>
    <main id="main">
        <div class="d-aside-right-bar bg-grey">
            {{-- @include('components.sidebar') --}}

            <div class="admin-content-right p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('bussiness.index') }}" class="text-primary">
                        <span class="material-symbols-outlined text-primary" style="visibility:hidden;">arrow_back</span>
                        <noscript><span>&rsaquo;</span></noscript> Back
                    </a>
                    <a href="{{ route('platform.index', [$platform->business_id]) }}" class="button button-outline-primary button-round">
                        Back to Platforms
                    </a>
                </div>

                <h3 class="fw-bold mb-3">{{ $platform->name }} - Google Business Profiles</h3>

                @if(!empty($profiles['profiles']))
                    @foreach($profiles['profiles'] as $profile)
                        <div class="account-card">
                            <div class="account-header">
                                <h5 class="mb-0">
                                    <strong>Account:</strong> {{ $profile['account']['accountName'] ?? 'N/A' }}
                                </h5>
                                <small class="text-muted">ID: {{ $profile['account']['name'] ?? '-' }}</small>
                            </div>

                            <div class="p-3 transaction-table">
                                @if(!empty($profile['locations']))
                                    <table class="table table-striped table-bordered mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Location Name</th>
                                                <th>Title</th>
                                                <th>Store Code</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($profile['locations'] as $loc)
                                                <tr>
                                                    <td>{{ $loc['locationName'] ?? '-' }}</td>
                                                    <td>{{ $loc['title'] ?? '-' }}</td>
                                                    <td>{{ $loc['storeCode'] ?? '-' }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-success btn-sm disabled">Get Reviews</a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="p-3 text-muted">No locations found for this account.</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="alert alert-warning">No profiles found for this platform.</div>
                @endif
            </div>
        </div>
    </main>

    <script>
        document.fonts.ready.then(() => {
            document.querySelectorAll('.material-symbols-outlined').forEach(el => el.style.visibility = 'visible');
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
