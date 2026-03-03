<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salon Performance Report - {{ $today->format('Y-m-d') }}</title>
    <style>
        body { font-family: 'Helvetica', 'Arial', sans-serif; color: #333; line-height: 1.5; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #1e3a8a; padding-bottom: 10px; }
        .header h1 { color: #1e3a8a; margin: 0; font-size: 24px; }
        .header p { margin: 5px 0 0; color: #666; font-size: 14px; }
        .section { margin-bottom: 30px; }
        .section-title { background: #f3f4f6; padding: 8px 15px; border-left: 4px solid #1e3a8a; font-weight: bold; font-size: 16px; margin-bottom: 15px; color: #1e3a8a; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; font-size: 12px; }
        th, td { border: 1px solid #e5e7eb; padding: 10px; text-align: left; }
        th { background-color: #f9fafb; font-weight: bold; color: #374151; }
        .text-right { text-align: right; }
        .footer { text-align: center; font-size: 10px; color: #9ca3af; margin-top: 50px; border-top: 1px solid #e5e7eb; padding-top: 10px; }
        .summary-box { display: inline-block; width: 45%; margin-right: 4%; vertical-align: top; }
        .total-row { font-weight: bold; background-color: #f3f4f6; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Neeliya Mendis Salons</h1>
        <p>Performance Analytics & Sales Report</p>
        <p>Generated on: {{ $today->format('F d, Y') }}</p>
    </div>

    {{-- Sales Summary --}}
    <div class="section">
        <div class="section-title">Sales Overview</div>
        
        <div style="margin-bottom: 20px;">
            <div class="summary-box">
                <h4 style="margin-bottom: 10px;">Daily Sales ({{ $today->format('F Y') }})</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th class="text-right">Revenue (Rs.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalDaily = 0; @endphp
                        @foreach(array_combine($dailyDates, $dailyPrices) as $date => $price)
                            <tr>
                                <td>{{ Carbon\Carbon::parse($date)->format('M d') }}</td>
                                <td class="text-right">{{ number_format($price, 2) }}</td>
                            </tr>
                            @php $totalDaily += $price; @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td>Total Month-to-Date</td>
                            <td class="text-right">Rs. {{ number_format($totalDaily, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="summary-box" style="margin-right: 0;">
                <h4 style="margin-bottom: 10px;">Monthly Sales ({{ $today->format('Y') }})</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Month</th>
                            <th class="text-right">Revenue (Rs.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalMonthly = 0; @endphp
                        @foreach(array_combine($monthlyLabels, $monthlyPrices) as $month => $price)
                            <tr>
                                <td>{{ $month }}</td>
                                <td class="text-right">{{ number_format($price, 2) }}</td>
                            </tr>
                            @php $totalMonthly += $price; @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td>Total Year-to-Date</td>
                            <td class="text-right">Rs. {{ number_format($totalMonthly, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    {{-- Service Usage --}}
    <div class="section" style="page-break-before: always;">
        <div class="section-title">Service Popularity Breakdown</div>

        <div>
            <div class="summary-box">
                <h4 style="margin-bottom: 10px;">Weekly Service Usage</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th class="text-right">Bookings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(array_combine($weeklyServiceNames, $weeklyServiceCounts) as $name => $count)
                            <tr>
                                <td>{{ $name }}</td>
                                <td class="text-right">{{ $count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="summary-box" style="margin-right: 0;">
                <h4 style="margin-bottom: 10px;">Monthly Service Usage</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th class="text-right">Bookings</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(array_combine($monthlyServiceNames, $monthlyServiceCounts) as $name => $count)
                            <tr>
                                <td>{{ $name }}</td>
                                <td class="text-right">{{ $count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="footer">
        <p>&copy; {{ date('Y') }} Neeliya Mendis Salons. All rights reserved.</p>
        <p>This is a system-generated report.</p>
    </div>

</body>
</html>
