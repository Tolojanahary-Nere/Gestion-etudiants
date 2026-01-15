<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Bulletin de notes - {{ $student->name }}</title>
    <style>
        body {
            font-family: sans-serif;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }
        .school-name {
            font-size: 24px;
            font-weight: bold;
            color: #2c3e50;
        }
        .report-title {
            font-size: 18px;
            margin-top: 5px;
            text-transform: uppercase;
        }
        .student-info {
            margin-bottom: 20px;
        }
        .student-info p {
            margin: 5px 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #2c3e50;
        }
        .total-row td {
            font-weight: bold;
            background-color: #e9ecef;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="school-name">Gestion Étudiants</div>
        <div class="report-title">Bulletin de Notes</div>
    </div>

    <div class="student-info">
        <p><strong>Étudiant :</strong> {{ $student->name }}</p>
        <p><strong>Email :</strong> {{ $student->email }}</p>
        @if($student->phone)
            <p><strong>Téléphone :</strong> {{ $student->phone }}</p>
        @endif
        <p><strong>Date :</strong> {{ now()->format('d/m/Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Matière</th>
                <th>Note</th>
                <th>Appréciation</th>
            </tr>
        </thead>
        <tbody>
            @forelse($grades as $grade)
            <tr>
                <td>{{ $grade->subject->name }}</td>
                <td>{{ $grade->value }} / 20</td>
                <td>
                    @if($grade->value >= 16) Excellent
                    @elseif($grade->value >= 14) Très Bien
                    @elseif($grade->value >= 12) Bien
                    @elseif($grade->value >= 10) Passable
                    @else Insuffisant
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" style="text-align: center;">Aucune note enregistrée.</td>
            </tr>
            @endforelse
        </tbody>
        @if($grades->count() > 0)
        <tfoot>
            <tr class="total-row">
                <td>Moyenne Générale</td>
                <td>{{ number_format($average, 2) }} / 20</td>
                <td>
                    @if($average >= 10) Admis
                    @else Ajourné
                    @endif
                </td>
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        <p>Document généré automatiquement par l'application Gestion Étudiants.</p>
    </div>
</body>
</html>
