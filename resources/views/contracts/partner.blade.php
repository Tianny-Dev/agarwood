<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Contract {{ $contract_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size:14px; }
        .header { text-align: center; margin-bottom: 20px; }
        .section { margin-bottom: 20px; }
        .info-table { width: 100%; border-collapse: collapse; }
        .info-table td { padding:5px; border:1px solid #ddd; }
        .qr { text-align:center; margin-top:30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Investment Contract</h1>
        <p>Contract Number: {{ $contract_number }}</p>
    </div>

    <div class="section">
        <h2>Partner / User Information</h2>
        <table class="info-table">
            <tr><td>Full Name</td><td>{{ $user->first_name }} {{ $user->last_name }}</td></tr>
            <tr><td>Email</td><td>{{ $user->email }}</td></tr>
            @if(isset($user->phone_number))
            <tr><td>Phone Number</td><td>{{ $user->phone_number }}</td></tr>
            @endif
            @if(isset($user->birthday))
            <tr><td>Birthday</td><td>{{ $user->birthday }}</td></tr>
            @endif
            @if(isset($user->gender))
            <tr><td>Gender</td><td>{{ ucfirst($user->gender?->value ?? 'N/A') }}</td></tr>
            @endif
            @if(isset($user->address))
            <tr><td>Address</td><td>{{ $user->address }}</td></tr>
            @endif
        </table>
    </div>

    <div class="section">
        <h2>Partner Details</h2>
        <table class="info-table">
            <tr><td>ID Type</td><td>{{ $partner->id_type }}</td></tr>
            @if(isset($partner->is_paid))
            <tr><td>Payment Status</td><td>{{ $partner->is_paid ? 'Paid' : 'Unpaid' }}</td></tr>
            @endif
        </table>
    </div>

    <div class="section">
        <h2>Terms & Conditions</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
    </div>

    @if($qr)
        <div class="qr">
            <p>Scan the QR Code below:</p>
            <img src="{{ storage_path('app/public/' . $qr->image_path) }}" alt="QR Code" width="150">
        </div>
    @endif
</body>
</html>
