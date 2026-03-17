<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Customer Order Form</title>
    <style>
        @page {
            margin: 15px 20px;
        }
        body { 
            font-family: DejaVu Sans, sans-serif; 
            font-size: 8.5px; 
            line-height: 1.15; 
            margin: 0;
            padding: 0;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 3px; 
        }
        th, td { 
            border: 1px solid #000; 
            padding: 2px 3px; 
            text-align: left; 
            vertical-align: top; 
        }
        .section-title { 
            font-weight: bold; 
            font-size: 9px;
            margin: 2px 0 1px 0; 
            background-color: #f0f0f0;
            padding: 2px 4px;
            border: 1px solid #000;
        }
        .logo { width: 70px; }
        .no-border { border: none !important; }
        .no-border td { border: none !important; }
        .small { font-size: 7.5px; line-height: 1.1; }
        .center { text-align: center; }
        .box {
            border: 1px solid #000;
            padding: 3px;
            margin-bottom: 3px;
        }
        .brand-checkbox {
            display: inline-block;
            margin-right: 8px;
            font-size: 8px;
        }
        .header-right {
            text-align: right;
        }
        h3 {
            margin: 0 0 2px 0;
            font-size: 11px;
        }
        p {
            margin: 1px 0;
        }
        input[type="checkbox"] {
            margin-right: 3px;
        }
    </style>
</head>
<body>
    <!-- HEADER -->
    <table class="no-border" style="margin-bottom: 5px;">
        <tr>
            <td style="width: 60%;" class="no-border">
                <img src="{{ public_path('images/logo.png') }}" class="logo"><br>
              <p style="margin:0; font-size:7.5px;">
        <b>
            KLA COMPUTER {{ $service->branch->name ?? '' }}<br>
            {!! nl2br(e($alamat['line1'])) !!}<br>
            Telp: {{ $alamat['telp'] }}
        </b>
    </p>
            </td>
            <td class="header-right no-border" style="width: 40%;">
                <h3>CUSTOMER ORDER<br>FORM (COF)</h3>
                <p style="font-size:8px;"><b>COF ID:</b> {{ $case->cof_id }}</p>
            </td>
        </tr>
    </table>

    <!-- BRAND CHECKBOXES -->
    <div style="border: 1px solid #000; padding: 3px; margin-bottom: 3px;">
        <span class="brand-checkbox">☐ <b>HP</b></span>
        <span class="brand-checkbox">☐ <b>Lenovo</b></span>
        <span class="brand-checkbox">☐ <b>Dell</b></span>
        <span class="brand-checkbox">☐ <b>ASUS</b></span>
        <span class="brand-checkbox">☐ <b>Acer</b></span>
        <span class="brand-checkbox">☐ <b>TOSHIBA</b></span>
        <span class="brand-checkbox">☐ _____________</span>
    </div>
    <p class="small" style="margin: 2px 0 4px 0; font-style: italic;">(harap di beri tanda ✓ sesuai dengan merk)</p>

    <!-- DATES -->
    <table style="margin-bottom: 4px;">
        <tr>
            <td style="width: 33%;"><b>Received Date</b></td>
            <td style="width: 33%;"><b>Started Date</b></td>
            <td style="width: 34%;"><b>Finished Date</b></td>
        </tr>
        <tr>
<td style="height: 15px;">{{ \Carbon\Carbon::parse($case->received_date)->translatedFormat('d F Y') }}</td>
<td style="height: 15px;">{{ \Carbon\Carbon::parse($case->started_date)->translatedFormat('d F Y') }}</td>
<td style="height: 15px;">{{ \Carbon\Carbon::parse($case->finished_date)->translatedFormat('d F Y') }}</td>
        </tr>
    </table>

    <!-- CUSTOMER INFO -->
    <div class="section-title">CUSTOMER</div>
    <table style="margin-bottom: 4px;">
        <tr>
            <td style="width:28%;"><b>Contact</b> (Company/Personal)</td>
            <td>{{ $case->contact }}</td>
        </tr>
        <tr>
            <td><b>Customer Name</b></td>
            <td>{{ $case->customer_name }}</td>
        </tr>
        <tr>
            <td><b>Address</b></td>
            <td>{{ $case->address }}</td>
        </tr>
        <tr>
            <td><b>Phone Number</b></td>
            <td>{{ $case->phone_number }}</td>
        </tr>
    </table>

    <!-- SERVICE UNIT -->
    <div class="section-title">SERVICE UNIT</div>
    <table style="margin-bottom: 4px;">
        <tr>
            <td style="width:28%;"><b>Product Number</b></td>
            <td>{{ $case->product_number }}</td>
        </tr>
        <tr>
            <td><b>Serial Number</b></td>
            <td>{{ $case->serial_number }}</td>
        </tr>
        <tr>
            <td><b>Nama Type</b></td>
            <td>{{ $case->nama_type }}</td>
        </tr>
        <tr>
            <td><b>Fault Description</b></td>
            <td>{{ $case->fault_description }}</td>
        </tr>
    </table>

    <!-- ACCESSORIES -->
    <div class="section-title">ACCESSORIES</div>
    <div style="border: 1px solid #000; padding: 3px; margin-bottom: 4px; min-height: 25px;">
        {{ $case->accessories }}
    </div>

    <!-- KONDISI UNIT -->
    <div class="section-title">KONDISI UNIT</div>
    <div style="border: 1px solid #000; padding: 3px; margin-bottom: 4px; min-height: 25px;">
        <p class="small" style="font-style: italic;">(kosong, ada baret & casing back cover yg keren tidak)</p>
        {{ $case->kondisi_unit }}
    </div>

    <!-- REPAIR SUMMARY -->
    <div class="section-title">REPAIR SUMMARY</div>
    <div style="border: 1px solid #000; padding: 3px; margin-bottom: 4px; min-height: 30px;">
        {{ $case->repair_summary }}
    </div>

    <!-- DISCLAIMERS -->
    <p class="small" style="margin: 2px 0; line-height: 1.3;">
        <b>**)</b> Pihak Service Center tidak bertanggungjawab atas keamanan dan kehilangan data, harap sebelum memasukkan<br>
        service dupat menim data terlebih dahulu<br>
        <b>**)</b> Produk barang service yang sudah selesai 90 hari kerja sejak selesai service/cancel service. Setelah jangka waktu<br>
        tersebut, pihak perusahaan menjual sewewnag baml untuk di scrap<br>
        <b>**)</b> DP minimal 50% sebagai syarat order part<br>
        <b>**)</b> Pembayaran DP tidak dapat dikembalikan (barang yang sudah dipesan tidak dapat dicancel)
    </p>

    <!-- SERVICE PRICING -->
    <table style="margin-bottom: 4px; font-size: 7.5px;">
        <tr>
            <th colspan="2" class="center"><b>Jasa Pemeriksan</b></th>
            <th colspan="2" class="center"><b>Jasa Pengecekan</b></th>
        </tr>
        <tr>
            <td style="width: 32%;">☐ Printer Low End / Deskjet</td>
            <td style="width: 18%;">35.000-50.000</td>
            <td style="width: 32%;">☐ Printer Low End / Deskjet</td>
            <td style="width: 18%;">25.000</td>
        </tr>
        <tr>
            <td>☐ Printer Middle Laserjet / Officejet</td>
            <td>50.000-60.000</td>
            <td>☐ Printer Middle Laserjet / Officejet</td>
            <td>25.000</td>
        </tr>
        <tr>
            <td>☐ Ink Tank Printer</td>
            <td>40.000-90.000</td>
            <td>☐ Ink Tank Printer</td>
            <td>25.000</td>
        </tr>
        <tr>
            <td>☐ Server / Work Station</td>
            <td>100.000-125.000</td>
            <td>☐ Server / Work Station</td>
            <td>60.000</td>
        </tr>
        <tr>
            <td>☐ PC / Notebook / PC All In One</td>
            <td>50.000-60.000</td>
            <td>☐ PC / Notebook / PC All In One</td>
            <td>30.000</td>
        </tr>
    </table>

    <p class="small" style="margin: 2px 0; font-style: italic; text-align: center;">
        (harga di beri tanda ✓ sesuai dengan jenis type)
    </p>

    <!-- SIGNATURE BOXES -->
    <table style="margin-top: 5px; margin-bottom: 3px;">
        <tr>
            <td style="width: 50%; text-align: center; vertical-align: top; height: 60px;">
                <b>Penerimaan</b><br>
                <b>Tanggal</b>
            </td>
            <td style="width: 50%; text-align: center; vertical-align: top; height: 60px;">
                <b>Pengambilan</b><br>
                <b>Tanggal</b>
            </td>
        </tr>
    </table>

    <p class="small center" style="margin: 2px 0;">
        Tanda tangan Anda merupakan persetujuan Anda terhadap syarat-syarat perbaikan di atas.
    </p>
</body>
</html>