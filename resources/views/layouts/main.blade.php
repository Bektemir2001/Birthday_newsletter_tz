
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Birthday-newsletter</title>
    <link rel="stylesheet" href="{{asset('assets/css/backend-plugin.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/backend.css?v=1.0.0')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body class="  ">
<div class="wrapper">
    @include('includes.site_bar')
    @include('includes.navbar')

    <div class="content-page">
        <div class="container-fluid">
            @if(session('notification'))
                <div class="toast fade show bg-success text-white border-0 rounded p-2 mt-3" role="alert" aria-live="assertive" aria-atomic="true" id="notification_id">
                    <div class="toast-header bg-success text-white">
                        <svg class="bd-placeholder-img rounded mr-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img">
                            <rect width="100%" height="100%" fill="#fff"></rect>
                        </svg>
                        <strong class="mr-auto text-white">Notification</strong>
                        <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close">
                            <span aria-hidden="true" onclick="close_notification()">×</span>
                        </button>
                    </div>
                    <div class="toast-body">
                        {{session('notification')}}
                    </div>
                </div>
            @endif
            @yield('content')
            <!-- Page end  -->
        </div>
    </div>
</div>
<!-- Wrapper End-->
<footer class="iq-footer">
    <div class="container-fluid">
        <div class="row">
        </div>
    </div>
</footer>
<script src="{{asset('assets/js/backend-bundle.min.js')}}"></script>
<script src="{{asset('assets/js/app.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
    function close_notification()
    {
        document.getElementById('notification_id').className = 'd-none';
    }
</script>

</body>
</html>
