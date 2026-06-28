<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Register</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/favicon/favicon.ico') }}">
    <link rel="manifest" href="{{ asset('assets/favicon/manifest.json') }}">

    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{ asset('assets/vendors/simplebar/css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/vendors/simplebar.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link href="{{ asset('assets/css/examples.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendors/@coreui/icons/css/free.min.css') }}" rel="stylesheet">
</head>

<body>
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
        <div class="container" style="max-width: 32rem">
            <div class="d-flex flex-column gap-4">
                <div class="text-center">
                    <i class="icon icon-xxl cil-apps text-center"></i>
                </div>
                <div class="card p-4">
                    <div class="card-body d-flex flex-column gap-4">
                        <h2 class="h5 text-center">Create new account</h2>
                        <form class="row gap-3" action="{{ route('auth.store') }}" method="post" autocomplete="off"
                            novalidate>
                            @csrf
                            <div>
                                <label class="form-label" for="name">Name</label>
                                <input class="form-control @error('name') is-invalid @enderror" id="name" name="name" type="text" placeholder="Name"
                                    value="{{ old('name') }}" autocomplete="off">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="email">Email address</label>
                                <input class="form-control @error('email') is-invalid @enderror" id="email" name="email" type="text" placeholder="Email"
                                   value="{{ old('email') }}" autocomplete="off">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="username">User Name</label>
                                <input class="form-control @error('username') is-invalid @enderror" id="username" name="username" type="text"
                                    placeholder="User Name" autocomplete="off">
                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group @error('password') is-invalid @enderror">
                                    <input class="form-control" id="password" name="password" type="password"
                                        placeholder="Your password" autocomplete="off">
                                    <span class="input-group-text">
                                        <button class="bg-transparent border-0 p-0 link-secondary" type="button"
                                            data-coreui-toggle="tooltip" aria-label="Show password"
                                            data-coreui-original-title="Show password">
                                            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path class="ci-primary" fill="var(--ci-primary-color, currentcolor)"
                                                    d="M256 144.927a103.309 103.309 0 1 0 103.309 103.309A103.426 103.426 0 0 0 256 144.927m0 174.618a71.309 71.309 0 1 1 71.309-71.309A71.39 71.39 0 0 1 256 319.545">
                                                </path>
                                                <path class="ci-primary" fill="var(--ci-primary-color, currentcolor)"
                                                    d="m397.222 131.1-.218-.223c-77.75-77.749-204.258-77.749-282.008 0L16 233.79v28.893l98.778 102.689.218.222a199.41 199.41 0 0 0 282.008 0l99-102.911V233.79ZM464 249.79l-89.732 93.285a167.41 167.41 0 0 1-236.536 0L48 249.79v-3.107l89.729-93.283c65.247-65.13 171.3-65.13 236.542 0L464 246.683Z">
                                                </path>
                                                <path class="ci-primary" fill="var(--ci-primary-color, currentcolor)"
                                                    d="M240 232h32v32h-32z"></path>
                                            </svg>
                                        </button>
                                    </span>
                                </div>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div>
                                <button class="btn btn-primary mt-4 w-100" type="submit">Create new account</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center text-body-secondary">
                    Already have an account?
                    <a href="{{ route('login') }}">Sign in</a>
                </div>
            </div>
        </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('assets/vendors/@coreui/coreui/js/coreui.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/simplebar/js/simplebar.min.js') }}"></script>
</body>

</html>
