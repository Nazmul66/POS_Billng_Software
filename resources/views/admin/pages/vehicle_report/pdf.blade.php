<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">

    <title>Job Card Invoice</title>
    <style>
        body {
            font-family: "Playfair Display", serif;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-collapse: collapse;
            padding: 0;
            margin: 0 auto;
            }

    .header-left {
      text-align: center;
      padding-left: 38px;
    }

    .arabic-text {
      color: #c00;
      font-size: 18px;
      font-weight: bold;
      line-height: 1.2;
    }

    .company-name {
      font-size: 40px;
      font-weight: bold;
      color: #c00;
      margin: 0;
      line-height: 1.2;
    }

    .tagline {
      font-size: 18px;
      color: #e68a00;
      font-weight: bold;
      line-height: 1.5;
    }

    .address {
      font-size: 12px;
      font-weight: 700;
      color: #000;
      font-family: "Inter", sans-serif;
      line-height: 1.5;
      margin-bottom: 20px;
    }

    .header-right {
      text-align: right;
      padding-right: 20px;
    }

    .header-right img {
      max-width: 150px;
      width: 120px;
    }

    .container {
      width: 90%;
      max-width: 800px;
      margin: auto;
      padding: 0px 20px 20px 20px;
      border: 1px solid #000;
      box-sizing: border-box;
      border-bottom: none;
    }
        .details-table, .description-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            word-wrap: break-word;
            table-layout: fixed;
        }
        .details-table th, .details-table td, 
        .description-table th, .description-table td {
            border: 1px solid #000;
            padding: 10px;
            text-align: left;
        }
        .description-table td {
            height: 80px;
        }
        td ul{
            padding: 0;
        }
        td ul li{
            margin-bottom: 12px;
            margin-left: 20px;
        }
        td ul li i{
            color: #4e474efa;
            font-weight: 500;  
        }
        td ul li a{
            color: #3F51B5 !important;
            background: #006ffd12;
        }
        td ol{
            padding: 0;
        }
        td ol li{
            margin-bottom: 12px;
            margin-left: 20px;
        }
        td ol li i{
            color: #4e474efa;
            font-weight: 500;  
        }
        td ol li a{
            color: #3F51B5 !important;
            background: #006ffd12;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .signature_details {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            word-wrap: break-word;
            table-layout: fixed;
        }

        /* Responsive Design */
        @media screen and (max-width: 600px) {
            .header {
                font-size: 20px;
            }
            .sub-header {
                font-size: 16px;
            }
            .details-table th, .details-table td, 
            .description-table th, .description-table td {
                padding: 8px;
                font-size: 14px;
            }
            .description-table td {
                height: auto;
            }
        }
        .footer {
            position: fixed;
            bottom: 70px;
            left: 0;
            right: 0;
            height: 80px;
            background-color: #0d2f4b;
            color: white;
            font-size: 15px;
            padding: 10px 20px;
        }

    .footer-table {
      width: 100%;
      table-layout: fixed;
    }

    .footer-left,
    .footer-right {
      vertical-align: top;
      line-height: 1.8;
    }

    .footer-left p,
    .footer-right p {
      margin: 0;
    }

    .footer-right {
      text-align: right;
    }

    strong {
      font-weight: 600;
    }
    .watermark {
      position: fixed;
      top: 50%;
      left: 50%;
      width: 500px;
      height: auto;
      opacity: 0.07;
      transform: translate(-60%, -60%);
      z-index: -1;
    }
    </style>
</head>

<body>

    {{-- Watermark Image --}}
    <img src="{{ public_path('admin/images/car_logo.jpg') }}" class="watermark" alt="Watermark">
    
     {{-- Header --}}
    <div class="container" style="border: none;">
        <table class="header-table">
          <tr>
            <td class="header-left">
              <div class="company-name">ANOWARA MOTORS</div>
              <div class="tagline">Service Without Compromise</div>
              <div class="address">
                Plot- 395, Block-J, Baridhara, South Point School Main Gate Road, Dhaka-1212
              </div>
            </td>
            <td class="header-right">
              <img src="{{ public_path('admin/images/car_logo.jpg') }}" alt="Anowara Motors Logo">
            </td>
          </tr>
        </table>
      </div>

    <div class="container" style="margin-top: -24px;">
        {{-- <div class="header">ADNAN AUTOMOBILES</div>
        <div class="sub-header">Job Card</div> --}}
        <p><strong>Invoice No:</strong> #{{ $vehicle_pdf->invoice_number }}</p>
        <p><strong>Date:</strong> {{ date('d M Y', strtotime(now())) }}, <strong>Time In:</strong> {{ $vehicle_pdf->time_in }} <strong>Time Out:</strong> {{ $vehicle_pdf->time_out }}</p>
        
        <table class="details-table">
            <tr>
                <th colspan="2">Customer Details</th>
                <th colspan="2">Car Details</th>
            </tr>
            <tr>
                <td><strong>Customer Name:</strong></td>
                <td>{{ $vehicle_pdf->customer_name }}</td>
                <td><strong>Car Name:</strong></td>
                <td>{{ $vehicle_pdf->car_name }}</td>
            </tr>
            <tr>
                <td><strong>Address:</strong></td>
                <td>{{ $vehicle_pdf->address }}</td>
                <td><strong>Registration Number:</strong></td>
                <td>{{ $vehicle_pdf->registration_number }}</td>
            </tr>
            <tr>
                <td><strong>Contact Number:</strong></td>
                <td>{{ $vehicle_pdf->contact_number }}</td>
                <td><strong>Chassis Number:</strong></td>
                <td>{{ $vehicle_pdf->chassis_number }}</td>
            </tr>
            <tr>
                <td><strong>Engineer Name:</strong></td>
                <td>{{ $vehicle_pdf->engineer_name }}</td>
                <td><strong>Engine Number:</strong></td>
                <td>{{ $vehicle_pdf->engine_number }}</td>
            </tr>
            <tr>
                <td><strong>Mechanic Name:</strong></td>
                <td>{{ $vehicle_pdf->mechanic_name }}</td>
                <td><strong>Color:</strong></td>
                <td>{{ $vehicle_pdf->color }}</td>
            </tr>
        </table>
        
        <div class="section-title">Description</div>
        <table class="description-table">
            <tr>
                <th>Customer Experience</th>
                <th>Test Drive Experience</th>
            </tr>
            <tr>
                <td>{!! $vehicle_pdf->customer_experience !!}</td>
                <td>{!! $vehicle_pdf->test_drive_experience !!}</td>
            </tr>
        </table>
        
        <div class="section-title">Additional Parts</div>
        <table class="description-table">
            <tr>
                <td>{!! $vehicle_pdf->additional_part !!}</td>
            </tr>
        </table>

        <p><u>Remarks:</u> {{ $vehicle_pdf->remarks }}</p>

        <table class="signature_details" style="margin-top: 80px;">
            <tr>
                <td><strong>Mechanic:</strong></td>
                <td><strong>Service Engineer:</strong></td>
            </tr>
        </table>
    </div>

    <div class="container" style="padding: 0;">
        <footer class="footer">
            <table class="footer-table">
              <tr>
                <td class="footer-left">
                  <p><strong>E-mail:</strong> anowaramotors2025@gmail.com</p>
                  <p><strong>Facebook:</strong> @anowaramotors</p>
                </td>
                <td class="footer-right">
                  <p><strong>Hotline :</strong> 01337-146333</p>
                  <p>01337-146861</p>
                </td>
              </tr>
            </table>
          </footer>
    </div>
</body>
</html>
