@component('mail::message')
# Your Contract is Ready

Hello {{ $user->first_name }},

Your contract (Number: {{ $contract->contract_number }}) has been generated.

@component('mail::button', ['url' => asset('storage/' . $contract->file_path)])
Download Contract
@endcomponent

@if($contract->status === 'unpaid')
    **Note:** Your contract is currently unpaid. QR code will be generated after payment.
@endif

Thanks,<br>
{{ config('app.name') }}
@endcomponent