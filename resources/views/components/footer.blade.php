<style>
    :root {
        --footer-height: 150px;
        /* Default tinggi footer */
    }

    /* Subscription Section */
    .subscription-section {
        background-color: #b9e4d8;
        padding: 40px;
        border-radius: 0 0 20px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        width: 75%;
        margin: 0 auto;
        margin-top: 50px;
        margin-bottom: calc(-1 * var(--footer-height) / 1.3);
        /* Overlap 50% tinggi footer */
        z-index: 2;
        /* Pastikan lebih tinggi dari footer */
        position: relative;
    }

    .subscription-section h1 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .subscription-section p {
        margin-bottom: 20px;
        color: #555;
    }

    .subscription-section .input-group {
        display: flex;
        margin-top: 10px;
    }

    .subscription-section input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px 0 0 5px;
        flex: 1;
    }

    .subscription-section button {
        padding: 10px 20px;
        background-color: #333;
        color: white;
        border: none;
        border-radius: 0 5px 5px 0;
        cursor: pointer;
    }

    .subscription-section button:hover {
        background-color: #555;
    }

    .subscription-section img {
        max-width: 200px;
    }

    footer {
        background-color: #8dd3bb;
        padding: var(--footer-height) 20px 0px 0px;
        /* Gunakan variabel tinggi footer */
        width: 100%;
        margin: 0 auto;
        position: relative;
        /* top: -1%; */
        z-index: 1;
        /* Pastikan lebih rendah dari subscription section */
    }

    footer .social-icons {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }

    footer .social-icons a {
        color: #333;
        font-size: 20px;
        text-decoration: none;
    }

    footer .social-icons a:hover {
        color: #555;
    }

    footer .footer-columns {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    footer .footer-column {
        margin-bottom: 20px;
    }

    footer .footer-column h3 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 10px;
    }

    footer .footer-column ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    footer .footer-column ul li {
        margin-bottom: 8px;
    }

    footer .footer-column ul li a {
        color: #333;
        text-decoration: none;
    }

    footer .footer-column ul li a:hover {
        text-decoration: underline;
    }
</style>

<!-- Subscription Section -->
<div class="subscription-section rounded-5">
    <div class="pe-5">
        <h1>The Travel</h1>
        <p>Get inspired! Receive travel discounts, tips and behind the scenes stories.</p>
        <div class="input-group">
            <input type="email" placeholder="Your email address">
            <button>Subscribe</button>
        </div>
    </div>
    <img src="{{ asset('/storage/mailbox.png') }}" alt="Illustration of a mailbox with a letter inside">
</div>

<!-- Footer Section -->
<footer class="text-dark">
    <div class="container">
        <div class="row w-100">
            <!-- Social Media Icons -->
            <div class="col-md-2 mb-4">
                <div class="d-flex">
                    <a class="text-dark me-3 fs-4" href="#"><i class="fab fa-facebook"></i></a>
                    <a class="text-dark me-3 fs-4" href="#"><i class="fab fa-twitter"></i></a>
                    <a class="text-dark me-3 fs-4" href="#"><i class="fab fa-youtube"></i></a>
                    <a class="text-dark fs-4" href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <!-- Footer Navigation Links -->
            <div class="col-md-2 mb-4">
                <h5 class="fw-bold mb-4">Destinasi</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Borobudur</a></li>
                    <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Pandawa</a></li>
                    <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Tebing Keraton</a></li>
                    <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Monas</a></li>
                </ul>
            </div>
            <div class="col-md-2 mb-4">
                <h5 class="fw-bold mb-4">Aktivitas</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Selancar</a></li>
                    <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Trekking</a></li>
                    <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Multi-aktivitas</a></li>
                    <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Outbound</a></li>
                </ul>
            </div>
            <div class="col-md-2 mb-4">
                <h5 class="fw-bold mb-4">Travel Blogs</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Bali Travel Guide</a></li>
                </ul>
            </div>
            <div class="col-md-2 mb-4">
                <h5 class="fw-bold mb-4">Tentang Kita</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Our Story</a></li>
                    <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Work with us</a></li>
                </ul>
            </div>
            <div class="col-md-2 mb-4">
                <h5 class="fw-bold mb-4">Kontak</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Our Story</a></li>
                    <li class="mb-2"><a class="text-dark text-decoration-none" href="#">Work with us</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
