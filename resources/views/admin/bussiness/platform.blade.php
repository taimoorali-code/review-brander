<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connected Platforms - {{ $business->name }}</title>
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
    </style>
</head>

<body>
    <main id="main">
        <div class="d-aside-right-bar bg-grey">
            <!-- Optional: include sidebar -->
            {{-- @include('components.sidebar') --}}

            <div class="admin-content-right p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('bussiness.index') }}" class="text-primary">
                        <span class="material-symbols-outlined text-primary" style="visibility:hidden;">arrow_back</span>
                        <noscript><span>&rsaquo;</span></noscript> Back
                    </a>
                    <a href="{{ route('platform.create' , [$business->id]) }}" class="button button-outline-primary button-round" >
                         Create New Platform
                    </a>


                </div>

                <h3 class="fw-bold mb-3">{{ $business->name }} - Connected Review Platforms</h3>

                @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif
             

                <div class="transaction-table shadow-sm">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Platform</th>
                                <th>Status</th>
                                <th>Connected On</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($platforms as $platform)
                            <tr>
                                <td>{{ $platform->name }}</td>
                                <td>
                                    @if($platform->status === 'connected')
                                    <span class="btn btn-success btn-sm px-3 py-1">Connected</span>
                                    @else
                                    <span class="btn btn-secondary btn-sm px-3 py-1">Disconnected</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $platform->connected_on ? $platform->connected_on->format('d M Y') : '-' }}
                                </td>
                                <td>
                                    @if($platform->status === 'connected')
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('platform.google.connect', [$business->id, $platform->id]) }}" class="btn btn-warning btn-sm">
                                            Reconnect
                                        </a>

                                        <form action="{{ route('platform.destroy', [$business->id, $platform->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Disconnect this platform?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Disconnect</button>
                                        </form>
                                    </div>
                                    @else
                                    <a href="{{ route('platform.google.connect', [$business->id, $platform->id]) }}" class="btn btn-warning btn-sm">
                                        Connect
                                    </a>


                                    @endif
                                </td>

                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">No platforms connected yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

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