<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="../assets/css/style.css" />
</head>

<body>
    <main id="main">


        <div class="d-aside-right-bar bg-grey">
            <!-- Include Sidebar Component -->
            @include('components.sidebar')

            <div class="admin-content-right">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3>All Customers</h3>

                    <div style="display: flex; gap: 5px; align-items: center;"> 
                        <a href="{{ route('customers.create') }}" class="button button-outline-primary button-round">Add New Customer</a>

                        <!-- CSV Upload Button -->
                        <form id="importForm" action="{{ route('customers.import') }}" method="POST" enctype="multipart/form-data" style="display:inline-block;">
    @csrf
    <input type="file" id="csvFileInput" name="csv_file" accept=".csv" required style="display: none;">
    
    <button type="button" class="btn btn-success" id="importBtn">
        <i class="bi bi-upload"></i> Import CSV
    </button>
</form>

<!-- Bootstrap Icons (optional for upload icon) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<script>
    // Trigger file picker when button clicked
    document.getElementById('importBtn').addEventListener('click', function() {
        document.getElementById('csvFileInput').click();
    });

    // Auto-submit when a file is chosen
    document.getElementById('csvFileInput').addEventListener('change', function() {
        if (this.files.length > 0) {
            document.getElementById('importForm').submit();
        }
    });
</script>

                    </div>
                </div>

                <div class="transaction-table shadow-sm">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customers as $customer)
                            <tr>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>
                                    <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this customer?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No customers found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{ $customers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>

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