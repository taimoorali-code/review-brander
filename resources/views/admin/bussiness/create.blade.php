<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet" href="../assets/css/style.css" />
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
    <style>
        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .form-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .form-label {
            font-weight: 500;
            color: #555;
        }

        .form-select,
        .form-control {
            height: 45px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 4px rgba(74, 144, 226, 0.5);
        }

        .form-submit {
            background-color: #4a90e2;
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .form-submit:hover {
            background-color: #357ab8;
        }

        .text-link {
            color: #4a90e2;
            text-decoration: none;
            margin-top: 1rem;
            display: inline-block;
        }

        .text-link:hover {
            color: #357ab8;
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <main id="main">

        <div class="d-aside-right-bar bg-grey">
            <div class="admin-content-right">
                <div class="section-title">
                    <a href="{{route('bussiness.index')}}" class="text-primary"> <span class="material-symbols-outlined text-primary" style="visibility:hidden;">arrow_back</span>
                        <noscript><span>&rsaquo;</span></noscript> Back</a>
                </div>

                <div class="form-container">
                    <h2 class="form-title">Register New Bussiness</h2>
                    <form action="{{ route('bussiness.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Business Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="industry" class="form-label">Business Industry</label>
                            <input type="text" id="industry" name="industry" class="form-control">
                        </div>

                        <button type="submit" class="form-submit">Register Business</button>
                    </form>

                </div>
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
</body>

</html>