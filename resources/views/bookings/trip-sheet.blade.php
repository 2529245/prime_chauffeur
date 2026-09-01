<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <title>Trip Sheet - {{ $booking->id }}</title>

    <style>
        @page {
            size: A4;
            margin: 12mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 8px;
            vertical-align: top;
        }

        .no-border {
            border: none !important;
        }

.header-logo {
    height: 70px;
    width: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

        .bold {
            font-weight: bold;
        }

        .big-row {
            height: 45px;
        }

        .note-box {
            height: 110px;
        }

        .signature-space {
            border-bottom: 1px solid #000;
            height: 60px;
        }

        .signature-box-table td {
            border: 1px dashed #000;
            padding: 5px;
            height: 45px;
        }

        .reservation-info {
            text-align: right;
            padding-top: 10px;
        }

        .center {
            text-align: center;
        }
    </style>
</head>

<body>

    {{-- Trip sheet header --}}
    <table class="no-border">

        <tr class="no-border">

            <td class="no-border" style="text-align: center;">

                @if(file_exists(public_path('images/logo1.png')))
                    <img src="{{ public_path('images/logo1.png') }}"
                         class="header-logo">
                @endif

                <div class="reservation-info">

                    <div class="bold" style="font-size:14px;">
                        Reservation# {{ $booking->id }}
                    </div>

                    <div>
                        Booked on:
                        {{ optional($booking->created_at)->format('d-M-Y H:i A') }}
                    </div>

                </div>

            </td>

        </tr>

    </table>


    <h2 style="margin:10px 0;">
        TRIP SHEET
    </h2>


    {{-- Booking date and time --}}
    <table>

        <tr>
            <td class="bold big-row">
                Booking Date:<br>

                {{ optional($booking->pick_up_time)->format('d-M-Y') }}
            </td>
        </tr>

        <tr>
            <td class="bold big-row">
                Pick Up Time:<br>

                {{ optional($booking->pick_up_time)->format('H:i') }}
            </td>
        </tr>

    </table>


    {{-- Vehicle and driver --}}
    <table style="margin-top:12px;">

        <tr class="bold center">

            <th># of Pax</th>

            <th>Vehicle Type</th>

            <th>Plate No.</th>

            <th>Driver Detail</th>

        </tr>


        <tr style="height:55px;">

            <td class="center">
                1
            </td>


            <td>
                {{ optional($booking->vehicle)->vehicle_name ?? 'N/A' }}
            </td>


            <td>
                {{ optional($booking->vehicle)->vehicle_plate_no ?? 'N/A' }}
            </td>


            <td>

                @if($booking->driver)

                    {{ $booking->driver->name }}

                    @if($booking->driver->contact_no)
                        <br>
                        {{ $booking->driver->contact_no }}
                    @endif

                @else

                    N/A

                @endif

            </td>

        </tr>

    </table>


    {{-- Guest and route details --}}
    <table style="margin-top:18px;">

        <tr>

            <td style="height:100px;">

                <span class="bold">
                    Guest Information:
                </span>

                <br><br>

                Name:
                {{ $booking->guest_name ?? 'N/A' }}

                <br>

                Contact Number:
                {{ $booking->guest_contact_number ?? 'N/A' }}

            </td>


            <td style="height:100px;">

                <span class="bold">
                    Routing Information:
                </span>

                <br><br>

                PU Location:
                {{ $booking->pick_up_location ?? 'N/A' }}

                <br>

                DO Location:
                {{ $booking->drop_off_location ?? 'N/A' }}

            </td>

        </tr>

    </table>


    {{-- Special note --}}
    <table style="margin-top:18px;">

        <tr>

            <td class="bold">
                Special Note:
            </td>

        </tr>

        <tr>

            <td class="note-box">
                {{ $booking->special_instructions ?? 'N/A' }}
            </td>

        </tr>

    </table>


    {{-- Signature spacing --}}
    <div style="height:80px;"></div>


    {{-- Signature section --}}
    <table>

        <tr class="center">

            <td>
                Gratuity(AED):
                <div class="signature-space"></div>
            </td>

            <td>
                New Total(AED):
                <div class="signature-space"></div>
            </td>

            <td>
                Signature:
                <div class="signature-space"></div>
            </td>

            <td>
                Date:
                <div class="signature-space"></div>
            </td>

        </tr>

    </table>


    {{-- Trip timing boxes --}}
    <table class="signature-box-table"
           style="margin-top:8px;">

        <tr class="center">

            <td>G-out</td>

            <td>Arr Time</td>

            <td>Pax Load</td>

            <td>Pax Drop</td>

            <td>G-in</td>

            <td>Mis-out</td>

            <td>Mis-in</td>

        </tr>

    </table>


    {{-- Trip sheet footer --}}
    <div class="footer"
         style="text-align:center; margin-top:10px; font-size:10px;">

        Generated on:
        {{ now()->format('d/m/Y H:i') }}

        —
        
        Booking ID:
        {{ $booking->id }}

    </div>

</body>
</html>