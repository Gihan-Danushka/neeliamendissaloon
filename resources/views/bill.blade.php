<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Receipt</title>
<style>
  /* ==== Exact driver size: 72.1mm × 210mm ==== */
  @page { size: 72.1mm 210mm; margin: 1mm 2mm 3mm 2mm; } /* top,right,bottom,left */
  * { box-sizing: border-box; color:#000 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
  html, body { margin: 0; padding: 0; background:#fff; }
  body {
    font-family: DejaVu Sans, Arial, sans-serif;
    font-size: 10.5px;
    line-height: 1.22;
  }

  /* Safe content width: page (72.1) - margins (2+2) = 68.1mm.
     We keep it a bit under (66mm) so borders/glyphs never hit the edge. */
  .wrap { width: 66mm; margin: 0 auto; }

  .center { text-align:center; }
  .right  { text-align:right; }
  .bold   { font-weight:700; }
  .semi   { font-weight:600; }
  .mono   { font-family:"DejaVu Sans Mono","Courier New",monospace; }

  .title { font-size:14px; font-weight:800; margin:0 0 0.8mm 0; }
  .line  { border-top:1px dashed #000; margin:1.1mm 0; height:0; }

  /* Logo: tight top spacing */
  .logo { display:block; margin:0 auto 0.6mm auto; height:10.5mm; }

  table { width:100%; border-collapse:collapse; }
  td, th { padding:0; vertical-align:top; }

  /* Items: Description + Rate (no Subtotal) */
  table.items { table-layout:fixed; }
  .c-desc { width:70%; word-wrap:break-word; }
  .c-rate { width:30%; text-align:right; }
  .items thead th {
    font-size:9.8px; font-weight:700; padding:.6mm 0 .6mm;
    border-bottom:1px solid #000; text-transform:uppercase;
  }
  .items tbody td { padding:.65mm 0; border-bottom:1px dotted #000; }

  .totals td { padding:.8mm 0; font-size:11px; }
  .totals .grand td {
    border-top:1px solid #000; border-bottom:1px solid #000;
    padding:1.0mm 0; font-weight:700;
  }

  .foot { margin-top:1.6mm; font-size:9.6px; text-align:center; font-weight:600; }
</style>
</head>
<body>
<div class="wrap">

  <!-- Header -->
  <div class="center">
    {{-- Commented out logo to avoid PHP GD extension requirement error --}}
    {{-- @php $logoPath = public_path('images/img/blackLogoGloryLuxe.png'); @endphp
    @if(file_exists($logoPath))
      <img src="{{ $logoPath }}" class="logo" alt="Logo">
    @endif --}}
    <div class="title">Glory Luxe Beauty Studio</div>
    <div class="semi">144 Diulapitiya Road, Marandagahamula</div>
    <div class="semi">070 422 3885</div>
  </div>

  <div class="line"></div>

  <!-- Client + meta -->
  <table>
    <tr>
      <td style="width:58%;">
        <div class="bold">{{ $client->name }}</div>
        @if(!empty($client->address)) <div class="semi">{{ $client->address }}</div> @endif
        @if(!empty($client->contact)) <div class="semi">Contact: {{ $client->contact }}</div> @endif
      </td>
      <td style="width:42%;" class="right semi">
        <div>Date: {{ date('d-m-Y') }}</div>
        <div>Time: {{ date('H:i') }}</div>
        <div>Inv #: {{ $invoiceNumber ?? '001' }}</div>
      </td>
    </tr>
  </table>

  <div class="line"></div>

  <!-- Items (no subtotal) -->
  <table class="items">
    <thead>
      <tr>
        <th class="c-desc">Description</th>
        <th class="c-rate">Rate</th>
      </tr>
    </thead>
    <tbody class="mono">
      @foreach($services as $service)
        @php
          $name  = is_array($service) ? ($service['name'] ?? '') : ($service->name ?? '');
          $price = is_array($service) ? (float)($service['price'] ?? 0) : (float)($service->price ?? 0);
        @endphp
        <tr>
          <td class="c-desc">{{ mb_strimwidth($name, 0, 42, '…', 'UTF-8') }}</td>
          <td class="c-rate">Rs. {{ number_format($price, 2) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="line"></div>

  <!-- Totals -->
  <table class="totals mono">
    <tr class="grand">
      <td>TOTAL</td>
      <td class="right">Rs. {{ number_format($total, 2) }}</td>
    </tr>
    <tr>
      <td>Cash Given</td>
      <td class="right">Rs. {{ number_format($cashGiven, 2) }}</td>
    </tr>
    <tr>
      <td>Balance</td>
      <td class="right">Rs. {{ number_format($balance, 2) }}</td>
    </tr>
  </table>

  <div class="line"></div>

  <div class="foot">
    Thank you for your visit!<br>
    No refunds on services. Please keep this receipt.
  </div>

</div>
</body>
</html>
