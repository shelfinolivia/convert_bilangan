<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konversi Bilangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
            border: none;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="text-center mb-4">
        <h1 class="fw-bold">Konversi Bilangan</h1>
        <p class="text-muted">Konversikan bilangan antar basis dengan mudah</p>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card p-4">
                <form id="convertForm">
                    <div class="mb-3">
                        <label for="number" class="form-label">Masukkan Bilangan</label>
                        <input type="text" class="form-control" id="number" name="number" required>
                    </div>
                    <div class="mb-3">
                        <label for="from_base" class="form-label">Basis Awal</label>
                        <select class="form-select" id="from_base" name="from_base" required>
                            <option value="2">Biner</option>
                            <option value="8">Oktal</option>
                            <option value="10">Desimal</option>
                            <option value="16">Hexadesimal</option>
                        </select>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-custom w-100">Konversi</button>
                    </div>
                </form>
                <div id="result" class="alert alert-success mt-4 d-none"></div>
                <div id="error" class="alert alert-danger mt-4 d-none"></div>
                <button type="button" id="clearButton" class="btn btn-secondary w-100 d-none mt-3">Clear</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('convertForm').addEventListener('submit', function (e) {
        e.preventDefault();

        const number = document.getElementById('number').value;
        const fromBase = document.getElementById('from_base').value;

        fetch('/convert', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ number, from_base: fromBase })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('error').classList.add('d-none');
            document.getElementById('clearButton').classList.remove('d-none'); // Tampilkan tombol Clear
            if (data.error) {
                document.getElementById('error').classList.remove('d-none');
                document.getElementById('error').textContent = data.error;
            } else {
                document.getElementById('result').classList.remove('d-none');
                document.getElementById('result').innerHTML = `
                    <strong>Bilangan Masukan:</strong> ${data.input} <br>
                    <strong>Hasil:</strong>
                    <ul>
                        <li>Biner: ${data.results.binary}</li>
                        <li>Oktal: ${data.results.octal}</li>
                        <li>Desimal: ${data.results.decimal}</li>
                        <li>Hexadesimal: ${data.results.hexadecimal}</li>
                    </ul>
                `;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('error').classList.remove('d-none');
            document.getElementById('error').textContent = 'Terjadi kesalahan. Silakan coba lagi.';
        });
    });

    document.getElementById('clearButton').addEventListener('click', function () {
        // Reset input fields
        document.getElementById('number').value = '';
        document.getElementById('from_base').value = '2';

        // Hide result and error messages
        document.getElementById('result').classList.add('d-none');
        document.getElementById('result').innerHTML = '';
        document.getElementById('error').classList.add('d-none');
        document.getElementById('error').textContent = '';

        // Sembunyikan tombol Clear
        document.getElementById('clearButton').classList.add('d-none');
    });
</script>
</body>
</html>
