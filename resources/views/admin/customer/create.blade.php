<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
<link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="/assets/css/style.css" />

    <style>
        body {
            background-color: #f7f8fa;
            font-family: 'Inter', sans-serif;
        }

        .form-container {
            max-width: 650px;
            margin: 2rem auto;
            padding: 2rem 2.5rem;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            border-radius: 10px;
        }

        .form-title {
            font-size: 1.6rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .form-label {
            font-weight: 500;
            color: #555;
        }

        .form-control {
            height: 45px;
            border-radius: 6px;
        }

        .form-control:focus {
            border-color: #4a90e2;
            box-shadow: 0 0 5px rgba(74, 144, 226, 0.3);
        }

        .btn-primary {
            background-color: #4a90e2;
            border: none;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #357ab8;
        }

        .section-title h4 {
            font-weight: 600;
            color: #4a90e2;
            margin-bottom: 1rem;
        }

        .text-danger {
            font-size: 0.875rem;
        }

        .back-link {
            text-decoration: none;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            margin-bottom: 1rem;
            color: #4a90e2;
        }

        .back-link:hover {
            color: #357ab8;
        }

        .back-link .material-symbols-outlined {
            margin-right: 4px;
            font-size: 20px;
        }
    </style>
</head>

<body>
    <main id="main">
        <div class="d-aside-right-bar bg-grey d-flex">

            <div class="admin-content-right flex-grow-1 p-4">
                <div class="section-title">
                    <a href="{{ route('customers.index') }}" class="back-link">
                        <span class="material-symbols-outlined">arrow_back</span> Back
                    </a>
                </div>

              <div class="form-container">
            <h2 class="form-title">Register New Customer</h2>

            <form method="POST" action="{{ route('customers.store') }}">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name"
                        value="{{ old('name', $customer->name ?? '') }}" placeholder="Enter full name">
                    @error('name')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="{{ old('email', $customer->email ?? '') }}" placeholder="Enter email">
                    @error('email')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                        value="{{ old('phone', $customer->phone ?? '') }}" placeholder="Enter phone number">
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control" id="address" name="address" rows="3"
                        placeholder="Enter address">{{ old('address', $customer->address ?? '') }}</textarea>
                </div>

                <button type="submit" class="btn btn-primary w-100">Save Customer</button>
            </form>
        </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>