    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
        <link rel="stylesheet" href="../assets/css/style.css" />
        <!-- Preload the Material Symbols font -->
        <link rel="preload" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" as="style" />
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

        <style>
            /* Reserve space for the icon before it loads */
            .material-symbols-outlined {
                font-variation-settings:
                    'FILL' 0,
                    'wght' 400,
                    'GRAD' 0,
                    'opsz' 24;
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
                <!-- Include Sidebar Component -->
                @include('components.sidebar')

                <div class="admin-content-right">
                    @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3 mx-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mt-3 mx-3" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show mt-3 mx-3" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-3">
                       <h2 class="box-heading mt-3">All Bussiness</h2>
                        <a href="{{route('bussiness.create')}}" class="button button-outline-primary button-round">Add Bussines</a>

                    </div>

                  
                    <div class="transaction-table shadow-sm">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Bussiness</th>
                                    <th>Industry</th>
                                    <th>PlatForm</th>
                                    <th>Action</th>

                                    <!-- No Action header -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($businesses as $bussines)
                                <tr>
                                    <td>{{ $bussines->name }}</td>
                                    <td>{{ $bussines->industry ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('platform.index', $bussines->id) }}" class="text-primary" title="View Details">
                                            <span class="material-symbols-outlined" style="visibility:hidden;">chevron_right</span>
                                            <noscript><span>&rsaquo;</span></noscript>
                                        </a>
                                    </td>
                                   <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('bussiness.edit', $bussines->id) }}" class="btn btn-warning btn-sm">
                                            Edit
                                        </a>

                                        <form action="{{ route('bussiness.destroy', $bussines->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this Bussines?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                         

                                    </div>
                                   


                                </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>
        </main>
        <script>
            document.fonts.ready.then(() => {
                document.querySelectorAll('.material-symbols-outlined').forEach(el => {
                    el.style.visibility = 'visible';
                });
            });
        </script>

        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
            integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
        </script>
        <script src="assets/js/script.js"></script>
    </body>

    </html>