@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ "SIMPLE-EMAIL" }}
@endcomponent
@endslot

{{-- Body --}}

# name:{{$name}},sex:{{$sex}}

@component('mail::panel')
this is mail::panel
@endcomponent
大风起兮云飞扬。<br>
威加海内兮归故乡。<br>
安得猛士兮守四方！<br>
@component('mail::button', ['url' => 'https://www.bilibili.com/video/BV15t411z7ST?from=search&seid=18446597577159937985'])
this is mail::button
@endcomponent


{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
