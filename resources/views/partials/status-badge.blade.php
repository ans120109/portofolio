@php
$warna = match ($status) {
    'antri' => 'warning',
    'dikerjakan' => 'primary',
    'selesai' => 'success',
    'batal' => 'danger',
    'admin' => 'danger',
    'operator' => 'info',
    'pengguna' => 'success',
    default => 'secondary',
};
@endphp
<span class="badge text-bg-{{ $warna }}">{{ ucfirst($status) }}</span>
