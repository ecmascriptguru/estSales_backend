<!doctype html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Styles -->
        <style>

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif
            <div class="container" style="padding-top: 150px;">
                <div class="col-lg-6 col-lg-offset-3 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2>Demo Calculator</h2>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="domain">Please select a domain.</label>
                                <select name="domain" class="form-control" id="domain">
                                    <option value="amazon.com.au">amazon.com.au</option>
                                    <option value="amazon.ca">amazon.ca</option>
                                    <option value="amazon.com" selected>amazon.com</option>
                                    <option value="amazon.co.uk">amazon.co.uk</option>
                                    <option value="amazon.de">amazon.de</option>
                                    <option value="amazon.es">amazon.es</option>
                                    <option value="amazon.fr">amazon.fr</option>
                                    <option value="amazon.in">amazon.in</option>
                                    <option value="amazon.it">amazon.it</option>
                                    <option value="amazon.jp">amazon.jp</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="bsr">Best Seller Rank</label>
                                <input type="number" id="bsr" name="bsr" value="1" min="1" max="1000000" class="form-control">
                            </div>
                            <div class="clearfix">
                                <h4>You can estimate Sales per day with the above best seller rank.</h4>
                            </div>
                            <div class="form-group">
                                <label for="estimation">Unit Sales</label>
                                <input type="number" name="estimation" id="estimation" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/welcome.js') }}"></script>
    </body>
</html>
