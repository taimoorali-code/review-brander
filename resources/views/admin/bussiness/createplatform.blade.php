<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connect Platform - {{ $business->name }}</title>
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

        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.06);
        }

        .form-submit {
            background: #4a90e2;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <main id="main">
        <div class="d-aside-right-bar bg-grey">
            <div class="admin-content-right p-4">
                <div class="section-title mb-3">
                    <a href="{{ route('platform.index', $business->id) }}" class="text-primary">
                        <span class="material-symbols-outlined text-primary" style="visibility:hidden;">arrow_back</span>
                        <noscript><span>&rsaquo;</span></noscript> Back
                    </a>
                </div>

                <div class="form-container">
                    <h3 class="form-title">Connect New Platform for {{ $business->name }}</h3>

                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <form action="{{ route('platform.store', $business->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Platform Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email (optional)</label>
                            <input type="email" name="email" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Credentials (JSON format)</label>
                            <textarea name="credentials" class="form-control" rows="4" placeholder='{"api_key": "xyz", "account_id": "123"}'></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Connect Platform</button>
                    </form>

                </div>

            </div>
        </div>
    </main>

    <script>
        document.fonts.ready.then(() => {
            document.querySelectorAll('.material-symbols-outlined').forEach(el => el.style.visibility = 'visible');
        });
    </script>
</body>

</html>