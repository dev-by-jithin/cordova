<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin-@yield('title')</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/favicon/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('assets/favicon/manifest.json') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendors/simplebar/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/simplebar.css') }}">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/examples.css') }}" rel="stylesheet">

    @stack('stylesheets')

    <script src="{{ asset('assets/js/config.js') }}"></script>
    <script src="{{ asset('assets/js/color-modes.js') }}"></script>
    <script src="{{ asset('assets/js/jQuery.v4.js') }}"></script>
    <link href="{{ asset('assets/vendors/@coreui/icons/css/free.min.css') }}" rel="stylesheet">
</head>

<body>

    <div class="sidebar sidebar-light sidebar-fixed border-end" id="sidebar">
        <div class="sidebar-header border-bottom" style="padding-bottom:14px;">
            <div class="sidebar-brand me-auto">
                <div class="sidebar-brand-full"><i class="icon icon-xxl cil-apps ms-2"></i>
                    <h3 class="d-inline fw-bold">Admin</h3>
                </div>
                <div class="sidebar-brand-narrow"><i class="icon icon-xxl cil-apps ms-3"></i></div>
            </div>
            <button class="btn-close d-lg-none" type="button" data-coreui-theme="dark" aria-label="Close"
                onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"></button>
        </div>
        <ul class="sidebar-nav" data-coreui="navigation" data-simplebar>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="var(--ci-primary-color, currentcolor)"
                            d="M425.706 142.294A240 240 0 0 0 16 312v88h144v-32H48v-56c0-114.691 93.309-208 208-208s208 93.309 208 208v56H352v32h144v-88a238.43 238.43 0 0 0-70.294-169.706"
                            class="ci-primary" />
                        <path fill="var(--ci-primary-color, currentcolor)"
                            d="M80 264h32v32H80zm160-136h32v32h-32zm-104 40h32v32h-32zm264 96h32v32h-32zm-102.778 71.1 69.2-144.173-28.85-13.848-69.183 144.135a64.141 64.141 0 1 0 28.833 13.886M256 416a32 32 0 1 1 32-32 32.036 32.036 0 0 1-32 32"
                            class="ci-primary" />
                    </svg>
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('result.index') ? 'active' : '' }}"
                    href="{{ route('result.index') }}">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="var(--ci-primary-color, currentcolor)"
                            d="M105.361 398.32A195.891 195.891 0 0 1 343.42 91.125l23.256-23.255A227.875 227.875 0 0 0 82.733 420.948 228.03 228.03 0 0 0 366.24 452.1l-23.312-23.312c-75.028 43.98-173.271 33.829-237.567-30.468"
                            class="ci-primary" />
                        <path fill="var(--ci-primary-color, currentcolor)"
                            d="M468.916 353.07a243.54 243.54 0 0 0 0-186.459 248 248 0 0 0-2.747-6.354 242.3 242.3 0 0 0-50.059-72.686L404.8 76.257l-11.317 11.314-172.27 172.269 172.63 172.631 10.957 10.953 11.31-11.314a242.2 242.2 0 0 0 49.452-71.358 249 249 0 0 0 3.354-7.682m-64.557-231.12a211.57 211.57 0 0 1 0 275.781L266.468 259.84Z"
                            class="ci-primary" />
                    </svg>
                    Result Publish
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('payment.index') ? 'active' : '' }}"
                    href="{{ route('payment.index') }}">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="var(--ci-primary-color, currentColor)" d="M480 48H32v416h448ZM64 432V80h384v352Z"
                            class="ci-primary" />
                        <path fill="var(--ci-primary-color, currentColor)"
                            d="M120 136h104v24h-28.8c12.6 8.2 20.8 21.4 22.8 40H224v24h-6.5c-3.8 28.3-25.7 47.4-58.8 47.9L224 344h-42l-58-64v-24h30c17.7 0 29.2-8.8 33-24H120v-24h67c-4.8-14.5-16-24-35-24h-32Z"
                            class="ci-primary" />
                        <path fill="var(--ci-primary-color, currentColor)"
                            d="M280 152h120v24H280zm0 64h120v24H280zm0 64h80v24h-80z" class="ci-primary" />
                        <path fill="var(--ci-primary-color, currentColor)" d="M120 344h160v24H120z"
                            class="ci-primary" />
                    </svg>
                    Payment
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('report.index') ? 'active' : '' }}"
                    href="{{ route('report.index') }}">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="var(--ci-primary-color, currentcolor)"
                            d="M112 152h288v32H112zm0 88h288v32H112zm0 88h152v32H112z" class="ci-primary" />
                        <path fill="var(--ci-primary-color, currentcolor)" d="M480 48H32v416h448Zm-32 384H64V80h384Z"
                            class="ci-primary" />
                    </svg>
                    Report
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}"
                    href="{{ route('user.index') }}">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="var(--ci-primary-color, currentcolor)"
                            d="m491.693 256.705-54.957-49.461 16.407-13.406a80.5 80.5 0 0 0 18.363-21.522c18.148-31.441 12.867-70.042-13.144-96.052s-64.612-31.291-96.051-13.142a80.5 80.5 0 0 0-21.52 18.362l-13.408 16.407-49.461-54.956-.579-.611a24.03 24.03 0 0 0-33.941 0l-65.6 65.605 1.19 23.7 33.108 27.056a48.6 48.6 0 0 1 11.079 12.889c10.807 18.722 7.57 41.8-8.056 57.426s-38.7 18.862-57.426 8.058a48.7 48.7 0 0 1-12.9-11.086l-27.047-33.1-23.7-1.189-71.26 71.26a24 24 0 0 0 0 33.942l175.357 175.359a80 80 0 0 0 113.138 0L492.3 291.225a24.03 24.03 0 0 0 0-33.94ZM288.657 449.617a48 48 0 0 1-67.883 0L51.069 279.911l53.1-53.095 15.91 19.473.1.119a80.5 80.5 0 0 0 21.521 18.363c31.441 18.149 70.041 12.867 96.052-13.144s31.291-64.61 13.143-96.05a80.5 80.5 0 0 0-18.363-21.521l-19.591-16.01 47.124-47.124 56.018 62.241 24.282-.579 25.062-30.67a48.6 48.6 0 0 1 12.888-11.078c18.722-10.807 41.8-7.569 57.426 8.056s18.864 38.7 8.057 57.426a48.6 48.6 0 0 1-11.079 12.889l-30.67 25.061-.58 24.282 62.243 56.018Z"
                            class="ci-primary" />
                    </svg>
                    User
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('number.index') ? 'active' : '' }}"
                    href="{{ route('number.index') }}">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="var(--ci-primary-color, currentcolor)"
                            d="M112 152h288v32H112zm0 88h288v32H112zm0 88h152v32H112z" class="ci-primary"></path>
                        <path fill="var(--ci-primary-color, currentcolor)" d="M480 48H32v416h448Zm-32 384H64V80h384Z"
                            class="ci-primary"></path>
                    </svg>
                    Numbers
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('number.fake') ? 'active' : '' }}"
                    href="{{ route('number.fake') }}">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="var(--ci-primary-color, currentcolor)"
                            d="m496.059 182.581-.025-70.7-32 .012.017 48.172-66.288 23.779-45.729.007v-30.964A96.55 96.55 0 0 0 329.92 91.3l43.129-43.413h42.84v-32h-56.157l-53.987 54.344a96.82 96.82 0 0 0-100.511-.554l-53.056-53.84-56.158.05.029 32 42.748-.038L180.824 90.5a96.56 96.56 0 0 0-22.79 62.39v30.99l-43.235.007L48 160.093v-48.172H16v70.742l80.035 28.509.007 84.715H16.034v32h80.01v8.01a159.7 159.7 0 0 0 9.7 54.979l-89.71 34.572v70.439h32v-48.476l71.73-27.642a159.794 159.794 0 0 0 249.578 29.044 161.5 161.5 0 0 0 23.058-29.146l71.638 27.727v48.493h32v-70.421l-89.618-34.685a159.2 159.2 0 0 0 9.614-55.1v-7.794h80v-32h-80v-84.6ZM240 463.029C176.991 455.235 128.045 401.2 128.045 335.9l-.01-120.011h30v.007H240Zm-49.966-279.154v-30.988a65 65 0 0 1 130 0v30.968Zm194 151.849A128.28 128.28 0 0 1 272 462.979V215.887h80.032v-.036h32Z"
                            class="ci-primary"></path>
                    </svg>
                    Find Fake
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('price.index') ? 'active' : '' }}"
                    href="{{ route('price.index') }}">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="var(--ci-primary-color,currentColor)"
                            d="M176 152h224v32H176zm0 88h224v32H176zm0 88h224v32H176zm0 88h128v32H176z"
                            class="ci-primary"></path>
                        <path fill="var(--ci-primary-color,currentColor)"
                            d="M480 48H32v416h448ZM64 432V80h384v352ZM96 144h48v48H96zm0 88h48v48H96zm0 88h48v48H96zm24-188c18 0 32 14 32 32s-14 32-32 32-32-14-32-32 14-32 32-32Z"
                            class="ci-primary"></path>
                    </svg>
                    Price
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('scheme.index') ? 'active' : '' }}"
                    href="{{ route('scheme.index') }}">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="var(--ci-primary-color, currentcolor)"
                            d="M472 40H40a24.03 24.03 0 0 0-24 24v384a24.03 24.03 0 0 0 24 24h432a24.03 24.03 0 0 0 24-24V64a24.03 24.03 0 0 0-24-24m-8 400H48V72h416Z"
                            class="ci-primary"></path>
                        <path fill="var(--ci-primary-color, currentcolor)"
                            d="M152 240h32v-40h40v-32h-40v-40h-32v40h-40v32h40zm44.284 45.089L168 313.373l-28.284-28.284-22.627 22.627L145.373 336l-28.284 28.284 22.627 22.627L168 358.627l28.284 28.284 22.627-22.627L190.627 336l28.284-28.284zM288 168h112v32H288zm0 120h112v32H288zm0 64h112v32H288z"
                            class="ci-primary"></path>
                    </svg>
                    Scheme
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('rate.index') ? 'active' : '' }}"
                    href="{{ route('rate.index') }}">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="var(--ci-primary-color, currentColor)" d="M480 48H32v416h448ZM64 432V80h384v352Z"
                            class="ci-primary" />
                        <path fill="var(--ci-primary-color, currentColor)"
                            d="M120 136h104v24h-28.8c12.6 8.2 20.8 21.4 22.8 40H224v24h-6.5c-3.8 28.3-25.7 47.4-58.8 47.9L224 344h-42l-58-64v-24h30c17.7 0 29.2-8.8 33-24H120v-24h67c-4.8-14.5-16-24-35-24h-32Z"
                            class="ci-primary" />
                        <path fill="var(--ci-primary-color, currentColor)"
                            d="M280 152h120v24H280zm0 64h120v24H280zm0 64h80v24h-80z" class="ci-primary" />
                        <path fill="var(--ci-primary-color, currentColor)" d="M120 344h160v24H120z"
                            class="ci-primary" />
                    </svg>
                    Rate
                </a>
            </li>
            <li class="nav-group {{ (request()->routeIs('group.index') || request()->routeIs('mode.index') || request()->routeIs('ticket.index')) ? 'show' : '' }}"
                aria-expanded="{{ (request()->routeIs('group.index') || request()->routeIs('mode.index') || request()->routeIs('ticket.index')) ? 'true' : 'false' }}">
                <a class="nav-link nav-group-toggle" href="#">
                    <svg class="nav-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="var(--ci-primary-color, currentcolor)"
                            d="M494 198.671a40.54 40.54 0 0 0-32.174-27.592l-115.909-18.837-53.732-104.414a40.7 40.7 0 0 0-72.37 0l-53.732 104.414-115.907 18.837a40.7 40.7 0 0 0-22.364 68.827l82.7 83.368-17.9 116.055a40.672 40.672 0 0 0 58.548 42.538L256 428.977l104.843 52.89a40.69 40.69 0 0 0 58.548-42.538l-17.9-116.055 82.7-83.368A40.54 40.54 0 0 0 494 198.671m-32.53 18.7L367.4 312.2l20.364 132.01a8.671 8.671 0 0 1-12.509 9.088L256 393.136 136.744 453.3a8.671 8.671 0 0 1-12.509-9.088L144.6 312.2l-94.069-94.83a8.7 8.7 0 0 1 4.778-14.706l131.841-21.426 61.119-118.767a8.694 8.694 0 0 1 15.462 0l61.119 118.767 131.841 21.426a8.7 8.7 0 0 1 4.778 14.706Z"
                            class="ci-primary"></path>
                    </svg>
                    Masters
                </a>
                <ul class="nav-group-items compact"
                    style="height: {{ (request()->routeIs('group.index') || request()->routeIs('mode.index') || request()->routeIs('ticket.index')) ? 'auto' : '0px' }};">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('group.index') ? 'active' : '' }}"
                            href="{{ route('group.index') }}">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                            Group
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('mode.index') }}">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                            Mode
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('ticket.index') }}">
                            <span class="nav-icon"><span class="nav-icon-bullet"></span></span>
                            Ticket
                        </a>
                    </li>
                </ul>
            </li>
        </ul>
        <div class="sidebar-footer border-top d-none d-md-flex">
            <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
        </div>
    </div>

    <div class="wrapper d-flex flex-column min-vh-100">

        <header class="header header-sticky p-0 mb-4">
            <div class="container-fluid border-bottom px-4">

                <button class="header-toggler" type="button"
                    onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
                    style="margin-inline-start: -14px">
                    <svg class="icon icon-lg" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path fill="var(--ci-primary-color, currentcolor)"
                            d="M80 96h352v32H80zm0 144h352v32H80zm0 144h352v32H80z" class="ci-primary" />
                    </svg>
                </button>

                <ul class="header-nav ms-auto">
                    <li class="nav-item">
                        @session('success')
                            <div class="alert alert-success alert-dismissible fade show mb-0 py-2" role="alert">
                                {{ $value }}
                                <button type="button" class="btn-close pt-1" data-coreui-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endsession
                        @session('error')
                            <div class="alert alert-danger alert-dismissible fade show mb-0 py-2" role="alert">
                                {{ $value }}
                                <button type="button" class="btn-close pt-1" data-coreui-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endsession
                    </li>

                </ul>

                <ul class="header-nav">
                    <li class="nav-item py-1">
                        <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
                    </li>
                    <li class="nav-item dropdown">
                        <button class="btn btn-link nav-link py-2 px-2 d-flex align-items-center" type="button"
                            aria-expanded="false" data-coreui-toggle="dropdown">
                            <svg class="icon icon-lg theme-icon-active" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512 512">
                                <path fill="var(--ci-primary-color, currentcolor)"
                                    d="M256 16C123.452 16 16 123.452 16 256s107.452 240 240 240 240-107.452 240-240S388.548 16 256 16m-22 446.849a208.35 208.35 0 0 1-169.667-125.9c-.364-.859-.706-1.724-1.057-2.587L234 429.939Zm0-69.582L50.889 290.76A210 210 0 0 1 48 256q0-9.912.922-19.67L234 339.939Zm0-90L54.819 202.96a206 206 0 0 1 9.514-27.913Q67.1 168.5 70.3 162.191L234 253.934Zm0-86.015L86.914 134.819a209.4 209.4 0 0 1 22.008-25.9q3.72-3.72 7.6-7.228L234 166.027Zm0-87.708-89.648-49.093A206.95 206.95 0 0 1 234 49.151ZM464 256a207.775 207.775 0 0 1-198 207.761V48.239A207.79 207.79 0 0 1 464 256"
                                    class="ci-primary" />
                            </svg>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem">
                            <li>
                                <button class="dropdown-item d-flex align-items-center" type="button"
                                    data-coreui-theme-value="light">
                                    <svg class="icon icon-lg me-3" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512">
                                        <path fill="var(--ci-primary-color, currentcolor)"
                                            d="M256 104c-83.813 0-152 68.187-152 152s68.187 152 152 152 152-68.187 152-152-68.187-152-152-152m0 272a120 120 0 1 1 120-120 120.136 120.136 0 0 1-120 120M240 16h32v48h-32zm0 432h32v48h-32zm208-208h48v32h-48zm-432 0h48v32H16zm372.687 171.314 22.627-22.627 32 32-22.627 22.627zm-320-320 22.628-22.628 32 32-22.628 22.628zm-.002 329.375 32-32 22.628 22.626-32 32zm320.002-320.003 32-32 22.628 22.628-32 32z"
                                            class="ci-primary" />
                                    </svg>
                                    Light
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item d-flex align-items-center" type="button"
                                    data-coreui-theme-value="dark">
                                    <svg class="icon icon-lg me-3" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512">
                                        <path fill="var(--ci-primary-color, currentcolor)"
                                            d="M268.279 496c-67.574 0-130.978-26.191-178.534-73.745S16 311.293 16 243.718A252.25 252.25 0 0 1 154.183 18.676a24.44 24.44 0 0 1 34.46 28.958 220.12 220.12 0 0 0 54.8 220.923A218.75 218.75 0 0 0 399.085 333.2a220.2 220.2 0 0 0 65.277-9.846 24.439 24.439 0 0 1 28.959 34.461A252.26 252.26 0 0 1 268.279 496M153.31 55.781A219.3 219.3 0 0 0 48 243.718C48 365.181 146.816 464 268.279 464a219.3 219.3 0 0 0 187.938-105.31 253 253 0 0 1-57.13 6.513 250.54 250.54 0 0 1-178.268-74.016 252.15 252.15 0 0 1-67.509-235.4Z"
                                            class="ci-primary" />
                                    </svg>
                                    Dark
                                </button>
                            </li>
                            <li>
                                <button class="dropdown-item d-flex align-items-center active" type="button"
                                    data-coreui-theme-value="auto">
                                    <svg class="icon icon-lg me-3" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 512 512">
                                        <path fill="var(--ci-primary-color, currentcolor)"
                                            d="M256 16C123.452 16 16 123.452 16 256s107.452 240 240 240 240-107.452 240-240S388.548 16 256 16m-22 446.849a208.35 208.35 0 0 1-169.667-125.9c-.364-.859-.706-1.724-1.057-2.587L234 429.939Zm0-69.582L50.889 290.76A210 210 0 0 1 48 256q0-9.912.922-19.67L234 339.939Zm0-90L54.819 202.96a206 206 0 0 1 9.514-27.913Q67.1 168.5 70.3 162.191L234 253.934Zm0-86.015L86.914 134.819a209.4 209.4 0 0 1 22.008-25.9q3.72-3.72 7.6-7.228L234 166.027Zm0-87.708-89.648-49.093A206.95 206.95 0 0 1 234 49.151ZM464 256a207.775 207.775 0 0 1-198 207.761V48.239A207.79 207.79 0 0 1 464 256"
                                            class="ci-primary" />
                                    </svg>
                                    Auto
                                </button>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item py-1">
                        <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#" role="button"
                            aria-haspopup="true" aria-expanded="false">
                            <div class="avatar avatar-md"><img class="avatar-img"
                                    src="{{ asset('assets/img/avatars/9.jpg') }}" alt="user@email.com"></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end pt-0">
                            <a class="dropdown-item mt-2" href="{{ route('profile') }}">
                                <i class="icon icon me-2 cil-user"></i>
                                Profile
                            </a>

                            <div class="dropdown-divider"></div>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="icon icon me-2 cil-account-logout"></i>
                                    Logout
                                </button>
                            </form>

                        </div>
                    </li>
                </ul>
            </div>

            @yield('breadcrumb')

        </header>

        <div class="body flex-grow-1">
            <div class="container-lg px-4">

                @yield('content')

            </div>
        </div>


        <footer class="footer px-4">
            <div>
                &copy; 2026 All Rights Reserved.
            </div>
        </footer>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('assets/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/simplebar/js/simplebar.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const header = document.querySelector("header.header");

        document.addEventListener("scroll", () => {
            if (header) {
                header.classList.toggle("shadow-sm", document.documentElement.scrollTop > 0);
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
