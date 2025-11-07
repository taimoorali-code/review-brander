<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connect Platform - {{ $business->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <style>
        body {
            background-color: #f8f9fa;
        }

        .platform-container {
            max-width: 900px;
            margin: 2rem auto;
        }

        .platform-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
            text-align: center;
            padding: 2rem 1rem;
            transition: all 0.2s ease;
        }

        .platform-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .platform-logo {
            height: 50px;
            margin-bottom: 15px;
        }

        .connect-btn {
            margin-top: 10px;
            background-color: #4a90e2;
            color: #fff;
            border: none;
            padding: 8px 20px;
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .connect-btn:hover {
            background-color: #357abd;
        }

        .disabled-btn {
            background: #ddd;
            color: #777;
            cursor: not-allowed;
        }

        .section-title {
            text-align: center;
            margin-bottom: 2rem;
        }
    </style>
</head>

<body>
    <main>
        <div class="platform-container">
            <div class="section-title">
                <h3>Connect Platform for <span class="text-primary">{{ $business->name }}</span></h3>
                <p>Select a platform below to connect.</p>
            </div>

            <div class="row g-4 justify-content-center">

                <!-- Google -->
                <div class="col-md-4 col-sm-6">
                    <div class="platform-card">
                        <div class="mb-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
                                <path fill="#EA4335" d="M24 9.5c3.54 0 6.67 1.22 9.17 3.59l6.85-6.85C35.61 2.37 30.24 0 24 0 14.64 0 6.56 5.47 2.45 13.41l7.98 6.19C12.01 13.25 17.56 9.5 24 9.5z" />
                                <path fill="#34A853" d="M46.11 24.55c0-1.58-.14-3.1-.39-4.55H24v9.02h12.47c-.54 2.88-2.17 5.33-4.62 6.96l7.18 5.58C43.25 37.57 46.11 31.57 46.11 24.55z" />
                                <path fill="#FBBC05" d="M10.43 28.41c-.63-1.88-.99-3.88-.99-5.91s.36-4.03.99-5.91L2.45 10.4C.88 13.42 0 17.02 0 21.09c0 4.07.88 7.67 2.45 10.69l7.98-6.19z" />
                                <path fill="#4285F4" d="M24 48c6.24 0 11.61-2.06 15.47-5.61l-7.18-5.58c-2 1.35-4.56 2.15-7.47 2.15-6.44 0-11.99-3.75-14.57-9.1l-7.98 6.19C6.56 42.53 14.64 48 24 48z" />
                            </svg>
                        </div>
                        <h5>Google My Business</h5>
                        <p class="text-muted small">Sync your GMB profiles and reviews.</p>
                        <a href="{{ route('platform.google.connect', $business->id) }}" class="btn btn-primary">
                            Connect Google Business
                        </a>

                    </div>

                </div>

            </div>
        </div>
    </main>
</body>

</html>