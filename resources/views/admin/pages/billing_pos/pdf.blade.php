<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Card Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 90%;
            max-width: 800px;
            margin: auto;
            padding: 20px;
            border: 1px solid #000;
            box-sizing: border-box;
        }
        .header {
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        .sub-header {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
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
    </style>
</head>

<body>
    <div class="container">
        <div class="header">ADNAN AUTOMOBILES</div>
        <div class="sub-header">Billing Invoice</div>
        <p><strong>Invoice No:</strong> #{{ $billing_pos->invoice_number }}</p>
        <p><strong>Date:</strong> {{ date('d M Y', strtotime(now())) }}, <strong>Time In:</strong> {{ $billing_pos->time_in }} <strong>Time Out:</strong> {{ $billing_pos->time_out }}</p>
        
        <table class="details-table">
            <tr>
                <th colspan="2">Customer Details</th>
                <th colspan="2">Car Details</th>
            </tr>
            <tr>
                <td><strong>Customer Name:</strong></td>
                <td>{{ $billing_pos->customer_name }}</td>
                <td><strong>Car Name:</strong></td>
                <td>{{ $billing_pos->car_name }}</td>
            </tr>
            <tr>
                <td><strong>Address:</strong></td>
                <td>{{ $billing_pos->address }}</td>
                <td><strong>Registration Number:</strong></td>
                <td>{{ $billing_pos->registration_number }}</td>
            </tr>
            <tr>
                <td><strong>Contact Number:</strong></td>
                <td>{{ $billing_pos->contact_number }}</td>
                <td><strong>Chassis Number:</strong></td>
                <td>{{ $billing_pos->chassis_number }}</td>
            </tr>
            <tr>
                <td><strong>Engineer Name:</strong></td>
                <td>{{ $billing_pos->engineer_name }}</td>
                <td><strong>Engine Number:</strong></td>
                <td>{{ $billing_pos->engine_number }}</td>
            </tr>
            <tr>
                <td><strong>Mechanic Name:</strong></td>
                <td>{{ $billing_pos->mechanic_name }}</td>
                <td><strong>Color:</strong></td>
                <td>{{ $billing_pos->color }}</td>
            </tr>
        </table>
        
        @php
            $products = $billing_pos->products ? json_decode($billing_pos->products) : [];
            $product_total = 0;

            foreach ($products as $val) {
                $product_total += $val->totals;
            }
        @endphp

        @if ( !empty($products) )
            <div class="section-title" style="text-align: center">Additionals Part (A)</div>
            <table class="details-table">
                <tr>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total Price</th>
                </tr>

                @foreach ($products as $row)
                    <tr>
                        <td>{{ $row->product_name }}</td>
                        <td>{{ $row->prdt_qty }}</td>
                        <td>{{ $row->prdt_price }}</td>
                        <td>{{ $row->totals }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="4" style="text-align: right;">Total (A) = {{ $product_total }}/- Tk</td>
                </tr>
            </table>
        @endif


        @php
            $services = $billing_pos->services ? json_decode($billing_pos->services) : [];
            $service_total = 0;

            foreach ($services as $val) {
                $service_total += $val->total_price;
            }
        @endphp

        <div class="section-title" style="text-align: center">Installation Charge / Service Charge (B)</div>
        <table class="details-table">
            <tr>
                <th>Service Name</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>

            @foreach ($services as $row)
                <tr>
                    <td>{{ $row->service_name }}</td>
                    <td>{{ $row->unit_price }}</td>
                    <td>{{ $row->total_price }}</td>
                </tr>
            @endforeach
        
                <tr>
                    <td colspan="3" style="text-align: right;">Total (B) = {{ $service_total }}/- Tk</td>
                </tr>
        </table>

        <p style="text-align: right;"> <strong>Total ( A+B )</strong> : <strong>{{ $product_total + $service_total }}/- Tk</strong> </p>


        <p><u>Remarks:</u> {{ $billing_pos->remarks }}</p>

        <table class="signature_details" style="margin-top: 80px;">
            <tr>
                <td style="text-decoration: overline;"><strong>Mechanic</strong></td>
                <td style="text-align: right; text-decoration: overline;"><strong>Service Engineer</strong></td>
            </tr>
        </table>
    </div>
</body>
</html>
