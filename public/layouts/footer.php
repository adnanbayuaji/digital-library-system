        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <?php
    // Determine correct path to assets based on current location
    $current_dir = basename(dirname($_SERVER['PHP_SELF']));
    $assets_path = in_array($current_dir, ['books', 'visitors', 'reports', 'borrowings']) ? '../assets' : 'assets';
    ?>
    <script src="<?php echo $assets_path; ?>/js/responsive.js"></script>
    <script>
        // Mobile Menu Toggle - Prioritas Tertinggi
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM Loaded - Initializing mobile menu');
            
            var menuToggle = document.getElementById('mobileMenuToggle');
            var mobileMenu = document.getElementById('mobileMenu');
            
            console.log('Toggle button:', menuToggle);
            console.log('Mobile menu:', mobileMenu);
            
            if (menuToggle && mobileMenu) {
                menuToggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    console.log('Hamburger clicked!');
                    
                    if (mobileMenu.classList.contains('show')) {
                        mobileMenu.classList.remove('show');
                        document.body.classList.remove('menu-open');
                        console.log('Menu closed');
                    } else {
                        mobileMenu.classList.add('show');
                        document.body.classList.add('menu-open');
                        console.log('Menu opened');
                    }
                });
                
                // Close on outside click
                document.addEventListener('click', function(e) {
                    if (mobileMenu.classList.contains('show') && 
                        !mobileMenu.contains(e.target) && 
                        !menuToggle.contains(e.target)) {
                        mobileMenu.classList.remove('show');
                        document.body.classList.remove('menu-open');
                        console.log('Menu closed by outside click');
                    }
                });
                
                // Close on link click
                var menuLinks = mobileMenu.querySelectorAll('.nav-link');
                menuLinks.forEach(function(link) {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.remove('show');
                        document.body.classList.remove('menu-open');
                        console.log('Menu closed by link click');
                    });
                });
                
                console.log('Mobile menu initialized successfully');
            } else {
                console.error('Mobile menu elements not found!');
            }
        });
        
        // jQuery fallback
        $(document).ready(function() {
            console.log('jQuery ready');
            
            // Mobile menu toggle with jQuery
            $('#mobileMenuToggle').off('click').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                console.log('jQuery: Hamburger clicked');
                $('#mobileMenu').toggleClass('show');
                $('body').toggleClass('menu-open');
            });
            
            // Close mobile menu when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.mobile-menu, #mobileMenuToggle').length) {
                    $('#mobileMenu').removeClass('show');
                    $('body').removeClass('menu-open');
                }
            });
            
            // Close mobile menu when clicking a link
            $('.mobile-menu .nav-link').on('click', function() {
                $('#mobileMenu').removeClass('show');
                $('body').removeClass('menu-open');
            });
            
            // Initialize DataTables with dynamic language
            if ($('.datatable').length) {
                var currentLang = '<?php echo current_lang(); ?>';
                var dtLang = currentLang === 'id' ? 
                    "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json" : 
                    "//cdn.datatables.net/plug-ins/1.13.7/i18n/en-GB.json";
                
                $('.datatable').DataTable({
                    "language": {
                        "url": dtLang
                    },
                    "responsive": true,
                    "scrollX": true
                });
            }
            
            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });
    </script>
</body>
</html>
