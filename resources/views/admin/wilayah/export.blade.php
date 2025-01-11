<!DOCTYPE html>
<html>
<head>
    <title>Data Wilayah</title>
    <style>
        @page {
            size: A4;
            margin: 2.54cm;
        }
        
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            background: white;
        }

        .container {
            max-width: 21cm;
            margin: 0 auto;
            padding: 30px;
            position: relative;
        }

        /* Border Dekoratif */
        .page-border {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 2px solid #000;
            margin: 1.5cm;
            pointer-events: none;
            z-index: 1000;
        }

        /* Border Dalam */
        .inner-border {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border: 1px solid #000;
            margin: 1.7cm;
            pointer-events: none;
            z-index: 1000;
        }

        /* Ornamen Sudut */
        .corner {
            position: fixed;
            width: 20px;
            height: 20px;
            border: 2px solid #000;
            z-index: 1001;
        }

        .corner-top-left {
            top: 1.3cm;
            left: 1.3cm;
            border-right: none;
            border-bottom: none;
        }

        .corner-top-right {
            top: 1.3cm;
            right: 1.3cm;
            border-left: none;
            border-bottom: none;
        }

        .corner-bottom-left {
            bottom: 1.3cm;
            left: 1.3cm;
            border-right: none;
            border-top: none;
        }

        .corner-bottom-right {
            bottom: 1.3cm;
            right: 1.3cm;
            border-left: none;
            border-top: none;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px double #000;
            padding-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .header p {
            margin: 5px 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 12px;
            position: relative;
            z-index: 1;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 12px;
            position: relative;
            z-index: 1;
        }

        .signature {
            margin-top: 50px;
            text-align: right;
        }

        .signature-line {
            border-bottom: 1px solid #000;
            width: 200px;
            margin-left: auto;
            margin-bottom: 5px;
        }

        @media print {
            .no-print { 
                display: none; 
            }
            body {
                margin: 0;
                padding: 0;
                background: white;
            }
            .container {
                width: 100%;
                max-width: none;
            }
            .page-border, .inner-border, .corner {
                position: fixed;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="no-print" style="padding: 20px; background: #f0f0f0; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; cursor: pointer;">Print Dokumen</button>
    </div>

    <!-- Border dan Ornamen -->
    <div class="page-border"></div>
    <div class="inner-border"></div>
    <div class="corner corner-top-left"></div>
    <div class="corner corner-top-right"></div>
    <div class="corner corner-bottom-left"></div>
    <div class="corner corner-bottom-right"></div>

    <div class="container">
        <div class="header">
            <h1>DATA WILAYAH</h1>
            <p>Sistem Informasi Pendataan Wilayah</p>
            <p>Tanggal: {{ date('d/m/Y') }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th style="width: 5%">No.</th>
                    <th style="width: 15%">Kode Wilayah</th>
                    <th style="width: 20%">Nama Wilayah</th>
                    <th style="width: 10%">Jenis</th>
                    <th style="width: 20%">Wilayah Induk</th>
                    <th style="width: 10%">Status</th>
                    <th style="width: 10%">Penduduk</th>
                    <th style="width: 10%">Luas (km²)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($wilayah as $index => $w)
                    <tr>
                        <td style="text-align: center">{{ $index + 1 }}</td>
                        <td>{{ $w->kode_wilayah }}</td>
                        <td>{{ $w->nama_wilayah }}</td>
                        <td>{{ ucfirst($w->jenis) }}</td>
                        <td>{{ $w->parent ? $w->parent->nama_wilayah : '-' }}</td>
                        <td>{{ ucfirst($w->status) }}</td>
                        <td style="text-align: right">{{ number_format($w->detail->jumlah_penduduk ?? 0) }}</td>
                        <td style="text-align: right">{{ number_format($w->detail->luas_wilayah ?? 0, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="footer">
            <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
            <div class="signature">
                <p>Mengetahui,</p>
                <p>Administrator</p>
                <div class="signature-line"></div>
                <p>{{ auth()->user()->name }}</p>
            </div>
        </div>
    </div>
</body>
</html> 