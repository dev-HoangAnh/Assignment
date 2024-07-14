<!DOCTYPE html>

<!--
 // WEBSITE: https://themefisher.com
 // TWITTER: https://twitter.com/themefisher
 // FACEBOOK: https://www.facebook.com/themefisher
 // GITHUB: https://github.com/themefisher/
-->

<html lang="en-us">

<head>
    
    @include('client.layouts.partials.head')

</head>

<body>

    <!-- navigation -->
    <header class="navigation fixed-top">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-white">

                @include('client.layouts.partials.logo')

                @include('client.layouts.partials.nav')

                @include('client.layouts.partials.form-search')

            </nav>
        </div>
    </header>
    <!-- /navigation -->

    <!-- start of banner -->
    <div class="banner text-center">
        
        @yield('banner')

    </div>
    <!-- end of banner -->

    @yield('content')

    <footer class="footer">
        
        @include('client.layouts.partials.footer')

    </footer>

    @include('client.layouts.partials.js')

</body>

</html>
