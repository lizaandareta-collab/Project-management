<div class="nk-footer nk-auth-footer-full">
    <div class="text-center">
        <p class="text-soft">&copy; {{ date('Y') }} 4.0 PAKO All Rights Reserved.</p>
    </div>
</div>

<script>
    // Sidebar functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Sidebar menu switching
        const menuSwitches = document.querySelectorAll('.nk-menu-switch');
        menuSwitches.forEach(switchEl => {
            switchEl.addEventListener('click', function(e) {
                e.preventDefault();
                const target = this.getAttribute('data-target');
                const menuContents = document.querySelectorAll('.nk-menu-content');
                
                menuContents.forEach(content => {
                    content.classList.remove('menu-active');
                });
                
                const targetContent = document.querySelector(`[data-content="${target}"]`);
                if (targetContent) {
                    targetContent.classList.add('menu-active');
                }
            });
        });
    });
</script>