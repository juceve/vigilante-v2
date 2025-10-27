<table>
    <tr>
        <td>
            RESUMEN OPERACIONAL
        </td>
    </tr>
    <tr>
        <td>
            Cliente:&nbsp; {{ $cliente->nombre ?? 'Todos' }}
        </td>
    </tr>
    <tr>
        <td>
            Fecha Inicio:&nbsp; {{ formatearFecha($parametros[1]) }}
        </td>
    </tr>
    <tr>
        <td>
            Fecha Fin:&nbsp; {{ formatearFecha($parametros[2]) }}
        </td>
    </tr>
    <thead>
        <tr>
            <th>CLIENTE</th>
            <th>REG. RONDAS</th>
            <th>REG. VISITAS</th>
            <th>REG. PASES QR</th>
            <th>REG. PANICOS</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($resultados as $item)
            <tr>
                <td>{{ $item['cliente'] }}</td>
                <td>{{ $item['rondas'] }}</td>
                <td>{{ $item['visitas'] }}</td>
                <td>{{ $item['flujopases'] }}</td>
                <td>{{ $item['panicos'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
