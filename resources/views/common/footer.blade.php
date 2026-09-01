<footer class="footer">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>
                &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
            </span>
        </div>
    </div>
</footer>

<!-- Scroll to top button -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<style>
.footer {
    background: rgba(26, 42, 58, 0.9);
    border-top: 1px solid rgba(255,255,255,0.08);
    padding: 15px 0;
    position: relative;
    width: 100%;
    flex-shrink: 0;
    text-align: center;
}

.footer .copyright span {
    font-size: 14px;
    color: #a0aec0;
}

/* Scroll to top button */
.scroll-to-top {
    position: fixed; /* Keep button visible */
    right: 20px;
    bottom: 20px;
    width: 45px;
    height: 45px;
    text-align: center;
    color: #fff;
    background: linear-gradient(135deg, #e8c7a1 0%, #d4ae86 100%);
    line-height: 45px;
    border-radius: 50%;
    z-index: 9999; /* Keep button on top */
    font-size: 20px;
    box-shadow: 0 4px 10px rgba(0,0,0,0.3);
    cursor: pointer;
    transition: all 0.3s;
}
.scroll-to-top:hover {
    transform: translateY(-3px);
    background: linear-gradient(135deg, #d4ae86 0%, #e8c7a1 100%);
}
</style>
