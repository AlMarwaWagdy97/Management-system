<style>
    body {
      padding-top: 70px; /* Adjust this value to accommodate the fixed navbar height */
    }

    .navbar.fixed-top {
      transition: top 0.3s; /* Add a smooth transition effect */
    }

    .navbar.fixed-top.navbar-scroll-down {
      top: -50px; /* Change this value to adjust how far the navbar retracts when scrolling down */
    }
  </style>
  <nav class="navbar-scroll navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Fixed Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>
  </nav>

{{-- @section('script') --}}
<script>
     window.addEventListener('scroll', function () {
      var navbar = document.querySelector('.navbar-scroll');
      var scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
    console.log(scrollPosition);
      if (scrollPosition > 50) {
        navbar.classList.remove('navbar-scroll-down');
      } else {
        navbar.classList.add('navbar-scroll-down');
      }
    });


    $(document).ready(function() {
        
        $('#mainBack').on('click', function() {
            const cliledBack = $('#chiledBack').attr('href');
            $(this).attr('href', cliledBack);
        });

        $(window).scroll(function() {
            var scrollTop = $(window).scrollTop();

            if (scrollTop >= 100) {
                $('#scroll-top').removeClass('hideClass');
            } else {
                $('#scroll-top').addClass('hideClass');
            }


        });
    });
</script>
{{-- @endsection --}}
