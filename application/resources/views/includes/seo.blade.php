@if($seo)
<meta name="title" Content="{{ $general->siteName(__($pageTitle)) }}">
<meta name="description" content="{{ $seo->description }}">
<meta name="keywords" content="{{ implode(',',$seo->keywords) }}">
<link rel="shortcut icon" href="{{ asset('assets/images/general/1488847961.png') }}">
<link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/images/general/apple-icon-57x57.png') }}">
<link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/images/general/apple-icon-60x60.png') }}">
<link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/images/general/apple-icon-72x72.png') }}">
<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/images/general/apple-icon-76x76.png') }}">
<link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/images/general/apple-icon-114x114.png') }}">
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/images/general/apple-icon-120x120.png') }}">
<link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/images/general/apple-icon-144x144.png') }}">
<link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/images/general/apple-icon-152x152.png') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/general/apple-icon-180x180.png') }}">

{{--<!-- Apple Stuff -->--}}
<link rel="apple-touch-icon" href="{{ getImage(getFilePath('logoIcon') .'/logo.svg') }}">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="apple-mobile-web-app-title" content="{{ $general->siteName($pageTitle) }}">
{{--<!-- Google / Search Engine Tags -->--}}
<meta itemprop="name" content="{{ $general->siteName($pageTitle) }}">
<meta itemprop="description" content="{{ $general->seo_description }}">
<meta itemprop="image" content="{{ getImage(getFilePath('seo') .'/'. $seo->image) }}">
{{--<!-- Facebook Meta Tags -->--}}
<meta property="og:type" content="website">
<meta property="og:title" content="{{ $seo->social_title }}">
<meta property="og:description" content="{{ $seo->social_description }}">
<meta property="og:image" content="{{ getImage(getFilePath('seo') .'/'. $seo->image) }}">
<meta property="og:image:type" content="image/{{ pathinfo(getImage(getFilePath('seo')) .'/'. $seo->image)['extension'] }}">
@php $socialImageSize = explode('x', getFileSize('seo')) @endphp
<meta property="og:image:width" content="{{ $socialImageSize[0] }}">
<meta property="og:image:height" content="{{ $socialImageSize[1] }}">
<meta property="og:url" content="{{ url()->current() }}">
{{--<!-- Twitter Meta Tags -->--}}
<meta name="twitter:card" content="summary_large_image">
@endif