@extends('admin.app.main')
@section('main')
    <h1 class="text-white">Rekap Barang</h1>

    <style id="printStyles">
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
            padding: 10px;
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .header h1,
        .footer h3 {
            margin: 0;
        }

        .details {
            margin-bottom: 20px;
        }

        .details table {
            width: 98%;
            margin-left: 15px;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .details th,
        .details td {
            padding: 8px;
            border: 1px solid #ddd;
        }

        .details th {
            background-color: #f2f2f2;
        }

        .details tfoot td {
            font-weight: bold;
        }

        .print-btn {
            display: none;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }
    </style>

    <form action="{{ route('rekap.cari') }}" method="POST" class="mb-3" id="searchForm">
        @csrf
        <div class="row">
            <div class="col">
                <label for="tanggal_masuk_awal" class="form-label text-white">Tanggal Masuk Awal</label>
                <input type="date" class="form-control" id="tanggal_masuk_awal" name="tanggal_masuk_awal"
                    value="{{ $tanggalMasukAwal ?? '' }}">
            </div>
            <div class="col">
                <label for="tanggal_masuk_akhir" class="form-label text-white">Tanggal Masuk Akhir</label>
                <input type="date" class="form-control" id="tanggal_masuk_akhir" name="tanggal_masuk_akhir"
                    value="{{ $tanggalMasukAkhir ?? '' }}">
            </div>
            <div class="col">
                <label for="status" class="form-label text-white">Status</label>
                <select class="form-select" id="status" name="status">
                    <option value="">-- Pilih Status --</option>
                    <option value="Lunas">Lunas</option>
                    <option value="Proses">Proses</option>
                </select>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary me-2">Cari</button>
            <button type="button" class="btn btn-success" onclick="printTable()">Print</button>
<a href="{{ route('rekap.export') }}" class="btn btn-danger">Export Data</a>

        </div>
    </form>
    @if (session('success'))
        <div>{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div>{{ session('error') }}</div>
    @endif
    <form action="{{ route('rekap.import') }}" method="POST" enctype="multipart/form-data" class="mb-3">
        @csrf
        <div class="row">
            <div class="col">
                <input type="file" class="form-control" name="file" required>
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Import Excel</button>
            </div>
        </div>
    </form>

    <div class="container" id="printSection">
        <div class="header mt-3">
            <h4 class="pt-5">LAPORAN PEMASUKAN SERVICE LOMBOK MACBOOK</h4>
        </div>
        <div class="details">
            <table style="font-size: 12px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Masuk</th>
                        <th>Nama</th>
                        <th>Tindakan</th>
                        <th>Merek</th>
                        <th>Type</th>
                        <th>Jenis Barang</th>
                        <th>Tanggal Keluar</th>
                        <th>Harga</th>
                        {{-- <th>Status</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->tanggal_masuk }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->tindakan }}</td>
                            <td>{{ $item->merek }}</td>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->category->nama }}</td>
                            <td>{{ $item->tanggal_keluar }}</td>
                            <td>@currency($item->harga)</td>
                            {{-- <td>{{ $item->status }}</td> --}}
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="8">Total Harga</td>
                        <td colspan="2">@currency($totalHargaLunas)</td>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="footer">
            <h4>Terima Kasih</h4>
            <p>Lombok Macbook</p>
            <p class="pt-3">Rekap dari {{ $tanggalMasukAwalFormatted }} sampai {{ $tanggalMasukAkhirFormatted }} </p>

            <p id="printDate"></p> <!-- Element for print date -->
        </div>
    </div>
@endsection

<script>
    function printTable() {
        const printDateElement = document.getElementById('printDate');
        const now = new Date();
        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are zero-based
        const year = now.getFullYear();
        const formattedDate = `${day}/${month}/${year} ${now.getHours()}:${String(now.getMinutes()).padStart(2, '0')}`;

        printDateElement.innerText = `Tanggal Cetak: ${formattedDate}`;

        const printContents = document.getElementById('printSection').innerHTML;
        const originalContents = document.body.innerHTML;
        const printStyles = document.getElementById('printStyles').outerHTML;

        document.body.innerHTML = printStyles + printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload(); // Reload the page to restore the original content
    }
</script>
