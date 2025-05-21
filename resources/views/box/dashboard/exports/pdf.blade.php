{{-- resources/views/box/dashboard/exports/pdf.blade.php --}}
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Historial de Transacciones</title>
  <style>
    @page {
      margin: 100px 25px;
    }
    body {
      font-family: 'Helvetica', Arial, sans-serif;
      margin: 0;
      font-size: 12px;
      color: #333;
    }
    header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      height: 100px;
      text-align: center;
    }
    header img {
      height: 50px;
      margin-top: 10px;
    }
    header .company-info {
      font-size: 10px;
      color: #555;
      margin-top: 5px;
    }
    header h1 {
      margin: 5px 0 0;
      font-size: 18px;
      color: #222;
    }
    footer {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      height: 30px;
      text-align: center;
      font-size: 10px;
      color: #666;
    }
    footer .page {
      line-height: 30px;
    }
    main {
      margin-top: 120px;
      margin-bottom: 40px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    thead th {
      background-color: #4A5568;
      color: #fff;
      padding: 8px;
      border: 1px solid #2D3748;
      font-size: 12px;
    }
    tbody tr:nth-child(even) {
      background-color: #F7FAFC;
    }
    tbody td {
      padding: 6px;
      border: 1px solid #E2E8F0;
      font-size: 12px;
    }
  </style>
</head>
<body>
  <header>
    <img src="{{ asset('images/logo-fritolay.png') }}" alt="Logo Empresa">
    <div class="company-info">Fecha de generación: {{ now()->format('d/m/Y H:i') }}</div>
    <h1>Historial de Transacciones</h1>
  </header>

  <main>
    <table>
      <thead>
        <tr>
          <th>Fecha</th>
          <th>Vendedor</th>
          <th>Tipo</th>
          <th>Cantidad</th>
          <th>Notas</th>
        </tr>
      </thead>
      <tbody>
        @foreach($transactions as $tx)
          <tr>
            <td>{{ $tx->created_at->translatedFormat('d/m/Y H:i') }}</td>
            <td>{{ $tx->vendor->name }}</td>
            <td>{{ $tx->type === 'issue' ? 'Salida' : 'Ingreso' }}</td>
            <td>{{ $tx->quantity }}</td>
            <td>{{ Str::limit($tx->notes, 50) }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </main>

  <footer>
    <div class="page">Página {PAGENO} de {nbpg}</div>
  </footer>
</body>
</html>
