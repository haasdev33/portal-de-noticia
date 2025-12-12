<div class="card mb-3">
    <div class="card-body">
        <h5 class="card-title">Informações</h5>
        <p class="mb-1"><strong>Empresa:</strong> {{ \App\Models\Setting::get('business_name', config('app.name')) }}</p>
        @if(\App\Models\Setting::get('business_address'))
            <p class="mb-1"><strong>Endereço:</strong> {{ \App\Models\Setting::get('business_address') }}</p>
        @endif
        @if(\App\Models\Setting::get('business_phone'))
            <p class="mb-1"><strong>Telefone:</strong> <a href="tel:{{ \App\Models\Setting::get('business_phone') }}">{{ \App\Models\Setting::get('business_phone') }}</a></p>
        @endif
        @if(\App\Models\Setting::get('business_email'))
            <p class="mb-1"><strong>Email:</strong> <a href="mailto:{{ \App\Models\Setting::get('business_email') }}">{{ \App\Models\Setting::get('business_email') }}</a></p>
        @endif
        @if(\App\Models\Setting::get('business_hours_html'))
            <hr>
            <div>{!! \App\Models\Setting::get('business_hours_html') !!}</div>
        @endif
    </div>
</div>
