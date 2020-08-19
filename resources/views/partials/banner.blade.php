<!-- Banner Section -->
<section class="banner-section">
    <div class="banner-carousel thm__owl-carousel owl-theme owl-carousel" data-options='{"loop": false, "items": 1, "margin": 0, "dots": false, "nav": false, "active": true, "autoplay": false}'>
        <!-- Slide Item -->
        <div class="slide-item">
            <div class="image-layer lazy-image" style="background-image: url('{{ secure_asset('images/1.jpg') }}');"></div>

            <div class="container">
                <div class="content-box text-center">
                    <div class="btn-box">
                        @guest()
                            <a href="{{ secure_url('access') }}" target="_blank" class="thm-btn btn-style-one"><i class="fas fa-star"></i> &nbsp;Accès au site</a>
                        @endguest
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
<!--End Banner Section -->
