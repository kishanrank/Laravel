<footer id="footer">
    <!-- container -->
    <div class="container">
        <!-- row -->
        <div class="row">
            <div class="col-md-3">
                <div class="footer-widget">
                    <div class="footer-logo text-dark">
                        <div class="text-dark">
                            <a href="/" class="logo" style="text-decoration: none">{{ $setting->site_name}}</a>
                        </div>
                    </div>
                    <ul class="footer-nav">
                        <li><a>Privacy Policy</a></li>
                        <li><a>Advertisement</a></li>
                    </ul>
                    <div class="footer-copyright">
                        <span>&copy;
                            Copyright &copy;<script>
                                document.write(new Date().getFullYear());
                            </script> All rights reserved
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-6">
                        <div class="footer-widget">
                            <h3 class="footer-title">About Us</h3>
                            <ul class="footer-links">
                                <li><a href="{{ route('aboutus')}}">About Us</a></li>
                                <li><a href="#">Carrier</a></li>
                                <li><a href="{{ route('contactus')}}">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                    @if($headerCategories)
                    <div class="col-md-6">
                        <div class="footer-widget">
                            <h3 class="footer-title">Catagories</h3>
                            <ul class="footer-links">
                                @foreach($headerCategories as $category)
                                <li><a href="{{route('posts.by.category', ['categoryslug' => $category->slug])}}">{{$category->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-md-3">
                <div class="footer-widget">
                    <h3 class="footer-title">Join our Newsletter</h3>
                    <div>
                        <p id="subscribe-message"></p>
                    </div>
                    <div class="footer-newsletter">
                        <form id="subscribe_form" method="POST">
                            @csrf
                            <input class="input" id="email" type="email" name="email" placeholder="Enter your email">
                            <button type="submit" id="subscribebtn" class="newsletter-btn"><i class="fa fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-2">
                <div class="footer-widget">
                    <h3 class="footer-title">Follow Us On</h3>
                    <ul class="footer-social">
                        <li><a href="https://www.linkedin.com/in/kishanrank/" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                        <li><a href="https://github.com/kishanrank" target="_blank"><i class="fa fa-github"></i></a></li>
                        <li><a href="https://twitter.com/kishan__rank" target="_blank"><i class="fa fa-twitter"></i></a></li>
                        <li><a href="https://www.instagram.com/___k._m._rank___/" target="_blank"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </div>

        </div>
        <!-- /row -->
    </div>
    <!-- /container -->
</footer>