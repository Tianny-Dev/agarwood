{{-- <!DOCTYPE html>
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
            @if (isset($user->phone_number))
            <tr><td>Phone Number</td><td>{{ $user->phone_number }}</td></tr>
            @endif
            @if (isset($user->birthday))
            <tr><td>Birthday</td><td>{{ $user->birthday }}</td></tr>
            @endif
            @if (isset($user->gender))
            <tr><td>Gender</td><td>{{ ucfirst($user->gender?->value ?? 'N/A') }}</td></tr>
            @endif
            @if (isset($user->address))
            <tr><td>Address</td><td>{{ $user->address }}</td></tr>
            @endif
        </table>
    </div>

    <div class="section">
        <h2>Partner Details</h2>
        <table class="info-table">
            <tr><td>ID Type</td><td>{{ $partner->id_type }}</td></tr>
            @if (isset($partner->is_paid))
            <tr><td>Payment Status</td><td>{{ $partner->is_paid ? 'Paid' : 'Unpaid' }}</td></tr>
            @endif
        </table>
    </div>

    <div class="section">
        <h2>Terms & Conditions</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit...</p>
    </div>

    @if ($qr)
        <div class="qr">
            <p>Scan the QR Code below:</p>
            <img src="{{ storage_path('app/public/' . $qr->image_path) }}" alt="QR Code" width="150">
        </div>
    @endif
</body>
</html> --}}

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Contract {{ $contract_number }}</title>
    <style>
        @page {
            margin: 50;
        }

        body {
            font-family: "Times New Roman", Times, serif;
        }
    </style>
</head>

<body>

    @php
        $today = \Carbon\Carbon::now();
    @endphp

    {{-- qr code start --}}
    @if ($qr)
        <div style="position: absolute; top: -45px; right: -35px;">
            <img src="{{ storage_path('app/public/' . $qr->image_path) }}" alt="QR Code" width="90">
        </div>
    @endif
    {{-- qr code end --}}

    {{-- header start --}}
    <div class="header" style="margin-top: 30px;">
        <div style="text-align: center;">
            <h3 style="margin-top: 0;">MEMORANDUM OF UNDERSTANDING</h3>
            <h3>FARMING PARTNERSHIP AGREEMENT – AGARWOOD SEEDLINGS</h3>
        </div>
        <p style="font-size: 16px;">
            This Memorandum of Understanding (“MOU”) is entered into on this
            {{ $today->format('j') }} day of {{ $today->format('F') }}, {{ $today->format('Y') }}, by and between:
        </p>
    </div>
    {{-- header end --}}

    {{-- PARTNER(S) start --}}
    <div class="section">
        <h3 style="margin-top: 10px;">PARTNER(S):</h3>
        <table style="width: 100%; padding: 1px;">
            <tr>
                <td style="width: 50px; font-size: 15px;">Name:</td>
                <td>
                    <div style="border-bottom: 1px solid black; padding-left: 3px; width: 50%; font-size: 15px;">
                        {{ $user->first_name }} {{ $user->last_name }}
                    </div>
                </td>
            </tr>
            <tr>
                <td style="font-size: 15px;">Address:</td>
                <td>
                    <div style="border-bottom: 1px solid black; padding-left: 3px; width: 50%; font-size: 15px;">
                        {{ $user->address }}
                    </div>
                </td>
            </tr>
        </table>
    </div>
    {{-- PARTNER(S) end --}}

    {{-- and --}}
    <p style="font-size: 18px;">AND</p>

    {{-- AGARWOOD HIGHLAND VALLEY INC start --}}
    <div class="section">
        <h3 style="margin-top: 0;">AGARWOOD HIGHLAND VALLEY INC. (Farmer):</h3>
        <table style="width: 100%; padding: 1px;">
            <tr>
                <td style="width: 50px; font-size: 15px;">Name:</td>
                <td>
                    <div style="border-bottom: 1px solid black; padding-left: 3px; width: 50%; font-size: 15px;">123
                    </div>
                </td>
            </tr>
            <tr>
                <td style="font-size: 15px;">Address:</td>
                <td>
                    <div style="border-bottom: 1px solid black; padding-left: 3px; width: 50%; font-size: 15px;">123
                    </div>
                </td>
            </tr>
        </table>

        <p style="font-size: 16px;">The above are hereinafter collectively referred to as the
            <strong>“Parties.”</strong>
        </p>
    </div>
    {{-- AGARWOOD HIGHLAND VALLEY INC end --}}

    {{-- 1. PURPOSE start --}}
    <div class="section">
        <h3 style="margin-top: 0;">1. PURPOSE</h3>
        <p style="font-size: 16px;">This MOU sets forth the preliminary understanding between the
            Partner(s) and the Farmer regarding the funding, planting, care, and cultivation of <strong>ten
                (10) agarwood seedlings</strong> over a period of <strong>five (5) years.</strong></p>
    </div>
    {{-- 1. PURPOSE end --}}

    {{-- 2. PROJECT DESCRIPTION start --}}
    <div class="section">
        <h3 style="margin-top: 0;">2. PROJECT DESCRIPTION</h3>
        <p style="font-size: 16px;">The Partner(s) shall provide funding for the acquisition of ten (10)
            agarwood seedlings. The Farmer shall assume full responsibility for the planting, cultivation,
            and maintenance of the seedlings for a period of five (5) years commencing seven (7) days after
            signing the agreement and upon payment of the 150,000 pesos planting funds.
        </p>

        <p style="font-size: 16px;"><strong>This agreement expressly excludes inoculation and harvesting
                activities</strong>,
            once the agarwood tree is ready for the procedure of inoculation and harvesting within 3 – 5 years
            of planting contract agreement. The Partner shall have the option to secure this services if any.
        </p>
    </div>
    {{-- 2. PROJECT DESCRIPTION end --}}

    {{-- 3. FUND DETAILS start --}}
    <div class="section">
        <h3 style="margin-top: 0;">3. FUND DETAILS</h3>

        <ul>
            <li><strong>Funded Amount:</strong> PHP 150,000.00 (One Hundred Fifty Thousand Pesos Only)</li>
            <li><strong>Form of Funds:</strong> Cash payment from the Partner(s) to the Farmer</li>
            <li><strong>Use of Funds:</strong> Solely for the purchase, planting, and cultivation of ten (10) agarwood
                seedlings on the Farmer’s land</li>
        </ul>
    </div>
    {{-- 3. FUND DETAILS end --}}

    {{-- 4. PARTNER’S PARTICIPATION AND RETURNS start --}}
    <div class="section">
        <h3 style="margin-top: 0;">4. PARTNER’S PARTICIPATION AND RETURNS</h3>
        <p style="font-size: 16px;">The Partner(s) acknowledge that the funding provided
            under this MOU covers only the <strong>initial planting and care phase</strong> for five (5) years.</p>

        <p style="font-size: 16px;">This MOU <strong>does not grant profit-sharing rights</strong>, ownership of resin,
            or entitlement
            to proceeds from agarwood harvesting unless a <strong>separate written agreement</strong> is executed after
            the cultivation period.</p>
    </div>
    {{-- 4. PARTNER’S PARTICIPATION AND RETURNS end --}}

    {{-- 5. RESPONSIBILITIES OF THE FARMER start --}}
    <div class="section">
        <h3 style="margin-top: 0;">5. RESPONSIBILITIES OF THE FARMER</h3>
        <p><strong>a. Cultivation and Maintenance</strong></p>
        <p style="font-size: 16px;">The Farmer shall exercise proper agricultural practices and reasonable diligence
            to ensure healthy growth and survival of the seedlings throughout the five-year period.</p>


        <p><strong>b. Guarantee of Survival</strong></p>
        <p style="font-size: 16px;">The Farmer guarantees the survival of <strong>at least eight (8)
                out of ten (10)</strong> seedlings during the five-year cultivation period.</p>

        <p><strong>c. Replacement Clause</strong></p>
        <p style="font-size: 16px;">Seedlings that die due to <strong>negligence or mismanagement</strong>
            shall be replaced by the Farmer at no cost to the Partner(s).</p>

        <p><strong>d. Force Majeure</strong></p>
        <p style="font-size: 16px;">Losses due to events beyond reasonable control, such as natural disasters, extreme
            weather conditions, pest outbreaks, fire, or other acts of God, shall exempt the Farmer from liability,
            provided that such events are reported in writing within <strong>fifteen (15) days</strong> from occurrence.
        </p>

        <p><strong>e. Exclusion of Inoculation and Harvesting</strong></p>
        <p style="font-size: 16px;">The Farmer shall not be responsible for inoculation or harvesting under this MOU.
        </p>
    </div>
    {{-- 5. RESPONSIBILITIES OF THE FARMER end --}}

    {{-- 6. TERM OF AGREEMENT start --}}
    <div class="section">
        <h3 style="margin-top: 0;">6. TERM OF AGREEMENT</h3>

        <p style="font-size: 16px;">This MOU shall be effective for a period of <strong>five (5) years</strong>,
            beginning
            from the date the seedlings are transferred and planted on the Farmer’s land.</p>
    </div>
    {{-- 6. TERM OF AGREEMENT end --}}

    {{-- 7. GOVERNANCE AND COMMUNICATION start --}}
    <div class="section">
        <h3 style="margin-top: 0;">7. GOVERNANCE AND COMMUNICATION</h3>

        <p style="font-size: 16px;">All day-to-day cultivation decisions shall be under the discretion of the Farmer.
            The Farmer shall, however, promptly inform the Partner(s) of any major risks, disease outbreaks, or
            significant
            farming challenges affecting the seedlings.</p>
    </div>
    {{-- 7. GOVERNANCE AND COMMUNICATION end --}}

    {{-- 8. DONEE / SUCCESSOR-IN-INTEREST (IN CASE OF DEATH OF PARTNER) start --}}
    <div class="section">
        <h3 style="margin-top: 0;">8. DONEE / SUCCESSOR-IN-INTEREST (IN CASE OF DEATH OF PARTNER)</h3>

        <p style="font-size: 16px;">In the event of the <strong>death, incapacity, or permanent inability</strong> of
            the Partner:</p>
        <ol start="1">
            <li>The Partner may designate a <strong>Donee, Heir, or Successor-in-Interest</strong> in writing, whose
                name shall be attached to and form part of this MOU.</li>
            <li>Upon such event, all rights, interests, and participation of the Partner under this MOU shall
                <strong>automatically transfer</strong> to the designated Donee or lawful heir.
            </li>
            <li>The Farmer agrees to recognize the Donee or heir as the continuing Partner under the same terms and
                conditions of this MOU.</li>
            <li>If no written designation exists, the Partner’s <strong>legal heirs</strong> shall be deemed the
                successor-in-interest, subject to applicable laws.</li>
        </ol>
    </div>
    {{-- 8. DONEE / SUCCESSOR-IN-INTEREST (IN CASE OF DEATH OF PARTNER) end --}}

    {{-- 9. EXIT STRATEGY AFTER FIVE (5) YEARS start --}}
    <div class="section">
        <h3 style="margin-top: 0;">9. EXIT STRATEGY AFTER FIVE (5) YEARS</h3>
        <p style="font-size: 16px;">Upon completion of the five-year period, the Parties may mutually discuss and agree
            on:</p>
        <ul>
            <li>Inoculation and harvesting arrangements</li>
            <li>Revenue sharing or return of investment</li>
            <li>Extension or renewal of partnership</li>
            <li>Transfer or donation of interests</li>
        </ul>

        <p style="font-size: 16px;"><strong>No Party is obligated to continue beyond Year 5 without a new written
                agreement.</strong></p>
    </div>
    {{-- 9. EXIT STRATEGY AFTER FIVE (5) YEARS end --}}

    {{-- 10. MISCELLANEOUS start --}}
    <div class="section">
        <h3 style="margin-top: 0;">10. MISCELLANEOUS</h3>
        <ul>
            <li><strong>Amendments:</strong> Any amendment must be in writing and signed by both Parties.</li>
            <li><strong>Termination:</strong> This MOU may be terminated by mutual agreement or upon material breach.
            </li>
            <li><strong>Non-Binding Nature:</strong> This MOU represents a good-faith understanding and shall not be
                considered a legally binding contract unless converted into a formal agreement.</li>
            <li><strong>Governing Law:</strong> This MOU shall be interpreted in accordance with the laws of the
                Republic of the Philippines.</li>
        </ul>

        <p style="font-size: 16px;">IN WITNESS WHEREOF, the Parties have executed this Memorandum of Understanding on
            the date first written above.</p>
    </div>
    {{-- 10. MISCELLANEOUS end --}}

    {{-- PARTNER(S) start --}}
    <h3 style="margin-top: 0;">PARTNER(S):</h3>
    <table style="width: 100%; padding: 1px;">
        <tr>
            <td style="width: 50px; font-size: 15px;">Signature:</td>
            <td>
                <div style="border-bottom: 1px solid black; padding-left: 3px; width: 50%; font-size: 15px;">123</div>
            </td>
        </tr>
        <tr>
            <td style="width: 50px; font-size: 15px;">Name:</td>
            <td>
                <div style="border-bottom: 1px solid black; padding-left: 3px; width: 50%; font-size: 15px;">
                    {{ $user->first_name }} {{ $user->last_name }}</div>
            </td>
        </tr>
        <tr>
            <td style="font-size: 15px;">Date:</td>
            <td>
                <div style="border-bottom: 1px solid black; padding-left: 3px; width: 50%; font-size: 15px;">
                    {{ $today->format('j F Y') }}
                </div>
            </td>
        </tr>
    </table>
    {{-- PARTNER(S) end --}}

    {{-- AGARWOOD HIGHLAND VALLEY INC. (Farmer) start --}}
    <h3>AGARWOOD HIGHLAND VALLEY INC. (Farmer):</h3>
    <table style="width: 100%; padding: 1px;">
        <tr>
            <td style="width: 50px; font-size: 15px;">Signature:</td>
            <td>
                <div style="border-bottom: 1px solid black; padding-left: 3px; width: 50%; font-size: 15px;">123</div>
            </td>
        </tr>
        <tr>
            <td style="width: 50px; font-size: 15px;">Name:</td>
            <td>
                <div style="border-bottom: 1px solid black; padding-left: 3px; width: 50%; font-size: 15px;">123</div>
            </td>
        </tr>
        <tr>
            <td style="font-size: 15px;">Date:</td>
            <td>
                <div style="border-bottom: 1px solid black; padding-left: 3px; width: 50%; font-size: 15px;">123</div>
            </td>
        </tr>
    </table>
    {{-- AGARWOOD HIGHLAND VALLEY INC. (Farmer) end --}}

    {{-- WITNESS start --}}
    <h3>WITNESS:</h3>
    <table style="width: 100%; padding: 1px;">
        <tr>
            <td style="width: 50px; font-size: 15px;">Signature:</td>
            <td>
                <div style="border-bottom: 1px solid black; padding-left: 3px; width: 50%; font-size: 15px;">123</div>
            </td>
        </tr>
        <tr>
            <td style="width: 50px; font-size: 15px;">Name:</td>
            <td>
                <div style="border-bottom: 1px solid black; padding-left: 3px; width: 50%; font-size: 15px;">123</div>
            </td>
        </tr>
        <tr>
            <td style="font-size: 15px;">Date:</td>
            <td>
                <div style="border-bottom: 1px solid black; padding-left: 3px; width: 50%; font-size: 15px;">123</div>
            </td>
        </tr>
    </table>
    {{-- WITNESS end --}}

    <script>
        // Get today's date
        const today = new Date();
        const day = today.getDate();
        const month = today.toLocaleString('default', {
            month: 'long'
        }); // full month name
        const year = today.getFullYear();

        // Fill the <p> with formatted date
        const p = document.getElementById('mou-date');
        p.textContent =
            `This Memorandum of Understanding (“MOU”) is entered into on this ${day} day of ${month}, ${year}, by and between:`;

        document.getElementById('mou-table-date').textContent = `${day} ${month} ${year}`;
    </script>
</body>

</html>
