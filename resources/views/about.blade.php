@extends('layouts.app')

@section('content')
    <div class="container video-container" aria-label="Bagverse intro video">
        <div class="video-wrapper">
            <video autoplay loop muted playsinline preload="auto">
                {{-- Tip: ensure this src is a direct MP4 file URL --}}
                <source src="https://www.pexels.com/download/video/6648428/" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
        <div class="video-text">
            <h2 style="color: var(--accent)">The Legacy of Bagverse.</h2>
            <p>Innovation Meets Imagination: Explore the Future of Digital Realms.</p>
        </div>
    </div>

    <section class="mission-vision" aria-labelledby="mv-heading">
        <div class="container">
            <div class="box">
                <div class="icon">&#9733;</div>
                <h2 id="mv-heading-1">Our Mission</h2>
                <p>
                    Our mission is to build immersive digital experiences and innovative solutions within the Bagverse
                    universe.
                    We are dedicated to pushing the boundaries of creativity, technology, and interactivity for our global
                    community.
                </p>
            </div>
            <div class="box">
                <div class="icon">&#128161;</div>
                <h2 id="mv-heading-2">Our Vision</h2>
                <p>
                    Our vision is to become a leading force in the metaverse, inspiring users worldwide with engaging and
                    transformative
                    digital experiences. We aim for Bagverse to be a symbol of innovation, community, and limitless
                    imagination.
                </p>
            </div>
        </div>
    </section>

    <section class="about-section container" aria-labelledby="about-heading">
        <div class="about-images" role="list" aria-label="Gallery">
            <img src="https://media.istockphoto.com/id/626234448/photo/luxury-handbags.jpg?s=612x612&w=0&k=20&c=Zz4OsUc67DLv5wLftwYd1_NeYmQmb4RCBuaCVttpM4w="
                alt="Luxury handbags 1" role="listitem">
            <img src="https://t4.ftcdn.net/jpg/08/70/77/87/360_F_870778714_7mw1EdmeCPCd6UlwTnegP72XqGYYDmCd.jpg"
                alt="Luxury handbags 2" role="listitem">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS_MpMdIZ70AJgCSBu04FgU1oRMx3EplY0_vmEC1dEG_tZtS8aY1b5dofgTEm_v1nm9oTs&usqp=CAU"
                alt="Luxury handbags 3" role="listitem">
            <img src="https://images.stockcake.com/public/6/a/c/6acbd867-1384-48d5-8552-7b34e3aa2d52_medium/luxury-bag-shopping-stockcake.jpg"
                alt="Luxury handbags 4" role="listitem">
        </div>
        <div class="about-content">
            <h2 id="about-heading" style="color: var(--accent); font-size: clamp(1.3rem, 2.6vw, 1.9rem);">About BagVerse
            </h2>
            <p>
                Bagverse is dedicated to creating an immersive digital universe where innovation meets imagination. Our
                platform offers
                unique experiences, interactive worlds, and cutting-edge technology that inspire creativity and connection.
                We believe
                in building a sustainable, inclusive, and engaging metaverse for everyone. Bagverse is designed to cater to
                explorers,
                creators, and visionaries alike.
            </p>
        </div>
    </section>

    <!-- Bootstrap CSS -->

    <!-- Section 1: BagVerse Intro -->
    <div class="section1 py-5">
        <div class="container d-flex flex-column flex-md-row align-items-center gap-4">
            <div class="content-section1 flex-1">
                <div class="title1 mb-3">
                    <p style="color: var(--accent); font-weight: bold;">A Different BagVerse</p>
                </div>
                <div class="content1">
                    <h3>✨ Elegance You Can Wear, Time You Can Trust ✨</h3>
                    <p style="font-size:.95rem;">
                        At Bagverse, we are dedicated to blending timeless craftsmanship with modern design to create bags
                        that
                        transcend trends. With an unwavering commitment to quality and style, each Bagverse bag is
                        meticulously
                        crafted to offer not only functionality but also a symbol of sophistication.
                    </p>
                </div>
            </div>
            <div class="image-section1 flex-1 text-center">
                <img src="https://img.drz.lazcdn.com/static/pk/p/ecdd46d66e0495ed2c2c1d46c4e87e86.jpg_720x720q80.jpg"
                    alt="Bagverse product" class="img-fluid rounded">
            </div>
        </div>
    </div>

    <!-- Section 2: Mission -->
    <div class="section2 py-5" style="margin-top: 100px">
        <div class="container d-flex flex-column flex-md-row align-items-center gap-4">
            <div class="image-section2 flex-1 text-center">
                <img src="https://bechlo.pk/cdn/shop/files/tdk3bmLDhp.jpg?v=1729672119&width=1214" alt="Lifestyle shot"
                    class="img-fluid rounded">
            </div>
            <div class="content-section2 flex-1 mt-2">
                <div class="title2 mb-3">
                    <p style="color: var(--accent); font-weight: bold;">The Mission</p>
                </div>
                <div class="content2">
                    <h3>✨ Elegance in Every Moment ✨</h3>
                    <p style="font-size:.98rem;">
                        With a resolute purpose, our mission was meticulously defined: to craft exquisitely high-quality,
                        yet
                        affordable bags that we eagerly desired to carry ourselves. Our bags are not only impeccably
                        designed
                        to exude sophistication but also crafted to surpass any rival, setting the standard for unparalleled
                        quality and style.
                    </p>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonials Section -->
    <div class="container py-5">
        <h2 class="text-center mb-4" style="color: #b56576; font-size: clamp(1.3rem,2.6vw,1.9rem)">What Our Clients Say
        </h2>

        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
            <!-- Indicators -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1"></button>
            </div>

            <!-- Carousel Inner -->
            <div class="carousel-inner">
                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-4 text-center">
                            <div class="testimonial-card p-4 rounded shadow-sm">
                                <img src="https://www.shutterstock.com/image-photo/portrait-young-investor-banker-workplace-260nw-2364566447.jpg"
                                    alt="Client 1" class="img-fluid rounded-circle mb-3">
                                <p><i class="fa fa-quote-left"></i> Excellent craftsmanship. The bag feels luxurious! <i
                                        class="fa fa-quote-right"></i></p>
                                <h5 style="color:#b56576;">- Sorah Johnson</h5>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="testimonial-card p-4 rounded shadow-sm">
                                <img src="https://i.pravatar.cc/150?img=1" alt="Client 2"
                                    class="img-fluid rounded-circle mb-3">
                                <p><i class="fa fa-quote-left"></i> A perfect bag for daily use. Highly recommended! <i
                                        class="fa fa-quote-right"></i></p>
                                <h5 style="color:#b56576;">- Michael Brown</h5>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="testimonial-card p-4 rounded shadow-sm">
                                <img src="https://i.pravatar.cc/150?img=2" alt="Client 3"
                                    class="img-fluid rounded-circle mb-3">
                                <p><i class="fa fa-quote-left"></i> Absolutely stunning design. Worth every penny! <i
                                        class="fa fa-quote-right"></i></p>
                                <h5 style="color:#b56576;">- Emma Wilson</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-4 text-center">
                            <div class="testimonial-card p-4 rounded shadow-sm">
                                <img src="https://i.pravatar.cc/150?img=4" alt="Client 4"
                                    class="img-fluid rounded-circle mb-3">
                                <p><i class="fa fa-quote-left"></i> This bag is elegant and stylish. I love its premium
                                    quality! <i class="fa fa-quote-right"></i></p>
                                <h5 style="color:#b56576;">- James Smith</h5>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="testimonial-card p-4 rounded shadow-sm">
                                <img src="https://i.pravatar.cc/150?img=5" alt="Client 5"
                                    class="img-fluid rounded-circle mb-3">
                                <p><i class="fa fa-quote-left"></i> Durable, sleek, and stylish. I use it every day! <i
                                        class="fa fa-quote-right"></i></p>
                                <h5 style="color:#b56576;">- David Miller</h5>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <div class="testimonial-card p-4 rounded shadow-sm">
                                <img src="https://www.shutterstock.com/image-photo/man-suit-looks-camera-smiles-260nw-606177233.jpg"
                                    alt="Client 6" class="img-fluid rounded-circle mb-3">
                                <p><i class="fa fa-quote-left"></i> A masterpiece! The best bag I have ever owned. <i
                                        class="fa fa-quote-right"></i></p>
                                <h5 style="color:#b56576;">- Olivia Davis</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Controls -->
            <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel"
                data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>
    <!-- Custom CSS -->
    <style>
        .testimonial-card {
            background: #fff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .testimonial-card img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 3px solid #b56576;
        }

        .testimonial-card p {
            font-style: italic;
            color: #333;
            font-size: 0.95rem;
            margin-bottom: 10px;
        }

        .testimonial-card h5 {
            font-weight: bold;
            margin-top: 5px;
        }
    </style>
    <section class="count2 text-center mt-5">
        <div class="container">
            <div class="row pt-3 pb-3">
                <div class="col-md-3">
                    <div class="icon-box">
                        <i class="fa-solid fa-handshake icon-box" style="color: white; font-size: 30px;"></i>
                    </div>
                    <h2 class="counter mt-3" data-target="1000">0</h2>
                    <p class="pc">Satisfied Clients</p>
                </div>
                <div class="col-md-3">
                    <div class="icon-box">
                        <i class="fa-solid fa-wand-magic-sparkles" style="color:white; font-size: 30px;"></i>
                    </div>
                    <h2 class="counter mt-3" data-target="10000">0+</h2>
                    <p class="pc">Designs</p>
                </div>
                <div class="col-md-3">
                    <div class="icon-box">
                        <i class="fa-solid fa-person" style="color:white; font-size: 30px;"></i>
                    </div>
                    <h2 class="counter mt-3" data-target="100">0</h2>
                    <p class="pc">Team Members</p>
                </div>
                <div class="col-md-3">
                    <div class="icon-box">
                        <i class="fa-solid fa-earth-americas" style="color:white; font-size: 30px;"></i>
                    </div>
                    <h2 class="counter mt-3" data-target="10">0</h2>
                    <p class="pc">Countries</p>
                </div>
            </div>
        </div>
    </section>



    <!-- Brands Section -->
    <section class="brands-section py-5 text-center mt-5">
        <h2 style="color: var(--accent); font-size:clamp(1.3rem,2.6vw,1.9rem)">Brands We Have Worked With</h2>
        <div class="brands-container mt-4 d-flex flex-wrap justify-content-center align-items-center gap-4">
            <img src="https://tse1.explicit.bing.net/th/id/OIP.aRiABS-HeLJpCSfh1tIPfgHaGB?rs=1&pid=ImgDetMain&o=7&rm=3"
                alt="Gucci" style="height:50px;">
            <img src="https://tse1.mm.bing.net/th/id/OIP.LwDyrFdo2Ens3Gx6PqcYgwHaEV?rs=1&pid=ImgDetMain&o=7&rm=3"
                alt="Louis Vuitton" style="height:50px;">
            <img src="https://tse2.mm.bing.net/th/id/OIP.PdR0zBmyObLUfPvIBksF0AHaEK?rs=1&pid=ImgDetMain&o=7&rm=3"
                alt="Prada" style="height:50px;">
            <img src="https://logos-world.net/wp-content/uploads/2020/12/Hermes-Logo.png" alt="Hermes"
                style="height:50px;">
            <img src="https://tse1.mm.bing.net/th/id/OIP.C_qpa0zLSa2Mm2bbQxPcSgHaEv?rs=1&pid=ImgDetMain&o=7&rm=3"
                alt="Chanel" style="height:50px;">
            <img src="https://tse3.mm.bing.net/th/id/OIP.9T2XG00E9smBu_xTIXuvJwHaFj?rs=1&pid=ImgDetMain&o=7&rm=3"
                alt="Fendi" style="height:50px;">
            <img src="https://tse2.mm.bing.net/th/id/OIP.62u2sy37jM3jRWzm_HwTDgHaCA?rs=1&pid=ImgDetMain&o=7&rm=3"
                alt="Balenciaga" style="height:50px;">
            <img src="https://static.vecteezy.com/system/resources/previews/023/599/608/original/christian-dior-brand-logo-black-design-symbol-luxury-clothes-fashion-illustration-free-vector.jpg"
                alt="Dior" style="height:50px;">
        </div>
    </section>


    <!-- Counter Animation Script -->
    <script>
        // Show popup after 3 seconds
        setTimeout(function() {
            document.getElementById("autoMessage").style.display = "block";
        }, 1000);

        // Close popup function
        function closePopup() {
            document.getElementById("autoMessage").style.display = "none";
        }
        document.addEventListener("DOMContentLoaded", function() {
            const counters = document.querySelectorAll(".counter");

            counters.forEach(counter => {
                let target = +counter.getAttribute("data-target");
                let count = 0;
                let speed = target / 100; // Speed adjust karne ke liye

                function updateCounter() {
                    if (count < target) {
                        count += speed;
                        counter.innerText = Math.floor(count);
                        setTimeout(updateCounter, 10);
                    } else {
                        counter.innerText = target.toLocaleString() + "+"; // Formatting for large numbers
                    }
                }

                updateCounter();
            });
        });
    </script>
@endsection
