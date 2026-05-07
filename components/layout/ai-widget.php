<style>

.pulse-scale {
    animation: pulse-scale 2s ease-in-out infinite;
}

.ai-list-enter {
    animation: slideUp 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

.ai-list-exit {
    animation: slideDown 0.3s cubic-bezier(0.4, 0, 0.2, 1) forwards;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes slideDown {
    from {
        opacity: 1;
        transform: translateY(0);
    }

    to {
        opacity: 0;
        transform: translateY(10px);
    }
}

.ai-tool-btn {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.ai-tool-btn:hover {
    transform: translateX(-4px) scale(1.02);
}

.shimmer {
    position: absolute;
    inset: 0;
    background: linear-gradient(90deg,
            transparent,
            rgba(152, 196, 65, 0.1),
            transparent);
    transform: translateX(-100%);
    transition: transform 0.6s;
}

.ai-tool-btn:hover .shimmer {
    transform: translateX(100%);
}

/* Ensure proper stacking */
#aiShare {
    z-index: 9999;
}

#aiList {
    pointer-events: none;
}

#aiList.active {
    pointer-events: auto;
}

#aiList.active .ai-tool-btn {
    pointer-events: auto;
}
</style>
<!-- AI Share Widget -->
<div id="aiShare" class="fixed bottom-0 right-0 z-[9999] flex flex-col items-end pointer-events-none">

    <!-- AI Tools List -->
    <div id="aiList" role="menu" aria-label="AI Tools Menu"
        class="flex flex-col mb-2 px-3 gap-2.5 opacity-0 pointer-events-none transform translate-y-4 transition-all duration-300 absolute bottom-full right-0">

        <!-- ChatGPT -->
        <a href="#" id="chatgptBtn" role="menuitem"
            class="ai-tool-btn group relative px-5 py-3.5 bg-white text-[#1F3131] border-2 border-gray-200 rounded-[4px] text-sm font-semibold shadow-md hover:shadow-xl hover:border-[#ed3437] hover:bg-[#F9F8F6] flex items-center gap-3 overflow-hidden min-w-[200px]">
            <div class="shimmer"></div>
           
            <svg width="20" height="20" viewBox="0 0 20 20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"
                class="icon-lg">
                <path
                    d="M11.2475 18.25C10.6975 18.25 10.175 18.1455 9.67999 17.9365C9.18499 17.7275 8.74499 17.436 8.35999 17.062C7.94199 17.205 7.50749 17.2765 7.05649 17.2765C6.31949 17.2765 5.63749 17.095 5.01049 16.732C4.38349 16.369 3.87749 15.874 3.49249 15.247C3.11849 14.62 2.93149 13.9215 2.93149 13.1515C2.93149 12.8325 2.97549 12.486 3.06349 12.112C2.62349 11.705 2.28249 11.2375 2.04049 10.7095C1.79849 10.1705 1.67749 9.6095 1.67749 9.0265C1.67749 8.4325 1.80399 7.8605 2.05699 7.3105C2.30999 6.7605 2.66199 6.2875 3.11299 5.8915C3.57499 5.4845 4.10849 5.204 4.71349 5.05C4.83449 4.423 5.08749 3.862 5.47249 3.367C5.86849 2.861 6.35249 2.465 6.92449 2.179C7.49649 1.893 8.10699 1.75 8.75599 1.75C9.30599 1.75 9.82849 1.8545 10.3235 2.0635C10.8185 2.2725 11.2585 2.564 11.6435 2.938C12.0615 2.795 12.496 2.7235 12.947 2.7235C13.684 2.7235 14.366 2.905 14.993 3.268C15.62 3.631 16.1205 4.126 16.4945 4.753C16.8795 5.38 17.072 6.0785 17.072 6.8485C17.072 7.1675 17.028 7.514 16.94 7.888C17.38 8.295 17.721 8.768 17.963 9.307C18.205 9.835 18.326 10.3905 18.326 10.9735C18.326 11.5675 18.1995 12.1395 17.9465 12.6895C17.6935 13.2395 17.336 13.718 16.874 14.125C16.423 14.521 15.895 14.796 15.29 14.95C15.169 15.577 14.9105 16.138 14.5145 16.633C14.1295 17.139 13.651 17.535 13.079 17.821C12.507 18.107 11.8965 18.25 11.2475 18.25ZM7.17199 16.1875C7.72199 16.1875 8.20049 16.072 8.60749 15.841L11.7095 14.059C11.8195 13.982 11.8745 13.8775 11.8745 13.7455V12.3265L7.88149 14.62C7.63949 14.763 7.39749 14.763 7.15549 14.62L4.03699 12.8215C4.03699 12.8545 4.03149 12.893 4.02049 12.937C4.02049 12.981 4.02049 13.047 4.02049 13.135C4.02049 13.696 4.15249 14.213 4.41649 14.686C4.69149 15.148 5.07099 15.511 5.55499 15.775C6.03899 16.05 6.57799 16.1875 7.17199 16.1875ZM7.33699 13.498C7.40299 13.531 7.46349 13.5475 7.51849 13.5475C7.57349 13.5475 7.62849 13.531 7.68349 13.498L8.92099 12.7885L4.94449 10.4785C4.70249 10.3355 4.58149 10.121 4.58149 9.835V6.2545C4.03149 6.4965 3.59149 6.8705 3.26149 7.3765C2.93149 7.8715 2.76649 8.4215 2.76649 9.0265C2.76649 9.5655 2.90399 10.0825 3.17899 10.5775C3.45399 11.0725 3.81149 11.4465 4.25149 11.6995L7.33699 13.498ZM11.2475 17.161C11.8305 17.161 12.3585 17.029 12.8315 16.765C13.3045 16.501 13.6785 16.138 13.9535 15.676C14.2285 15.214 14.366 14.697 14.366 14.125V10.561C14.366 10.429 14.311 10.33 14.201 10.264L12.947 9.538V14.1415C12.947 14.4275 12.826 14.642 12.584 14.785L9.46549 16.5835C10.0045 16.9685 10.5985 17.161 11.2475 17.161ZM11.8745 11.122V8.878L10.01 7.822L8.12899 8.878V11.122L10.01 12.178L11.8745 11.122ZM7.05649 5.8585C7.05649 5.5725 7.17749 5.358 7.41949 5.215L10.538 3.4165C9.99899 3.0315 9.40499 2.839 8.75599 2.839C8.17299 2.839 7.64499 2.971 7.17199 3.235C6.69899 3.499 6.32499 3.862 6.04999 4.324C5.78599 4.786 5.65399 5.303 5.65399 5.875V9.4225C5.65399 9.5545 5.70899 9.659 5.81899 9.736L7.05649 10.462V5.8585ZM15.4385 13.7455C15.9885 13.5035 16.423 13.1295 16.742 12.6235C17.072 12.1175 17.237 11.5675 17.237 10.9735C17.237 10.4345 17.0995 9.9175 16.8245 9.4225C16.5495 8.9275 16.192 8.5535 15.752 8.3005L12.6665 6.5185C12.6005 6.4745 12.54 6.458 12.485 6.469C12.43 6.469 12.375 6.4855 12.32 6.5185L11.0825 7.2115L15.0755 9.538C15.1965 9.604 15.2845 9.692 15.3395 9.802C15.4055 9.901 15.4385 10.022 15.4385 10.165V13.7455ZM12.122 5.3635C12.364 5.2095 12.606 5.2095 12.848 5.3635L15.983 7.195C15.983 7.118 15.983 7.019 15.983 6.898C15.983 6.37 15.851 5.8695 15.587 5.3965C15.334 4.9125 14.9655 4.5275 14.4815 4.2415C14.0085 3.9555 13.4585 3.8125 12.8315 3.8125C12.2815 3.8125 11.803 3.928 11.396 4.159L8.29399 5.941C8.18399 6.018 8.12899 6.1225 8.12899 6.2545V7.6735L12.122 5.3635Z">
                </path>
            </svg>
            <span class="flex-1 relative z-10">ChatGPT</span>
            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#ed3437] transition-colors duration-300 flex-shrink-0"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>

        <!-- Perplexity -->
        <a href="#" id="perplexityBtn" role="menuitem"
            class="ai-tool-btn group relative px-5 py-3.5 bg-white text-[#1F3131] border-2 border-gray-200 rounded-[4px] text-sm font-semibold shadow-md hover:shadow-xl hover:border-[#ed3437] hover:bg-[#F9F8F6] flex items-center gap-3 overflow-hidden min-w-[200px]">
            <div class="shimmer"></div>
            <svg width="20" height="20" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                    d="M101.008 42L190.99 124.905V124.886V42.1913H208.506V125.276L298.891 42V136.524H336V272.866H299.005V357.035L208.506 277.525V357.948H190.99V278.836L101.11 358V272.866H64V136.524H101.008V42ZM177.785 153.826H81.5159V255.564H101.088V223.472L177.785 153.826ZM118.625 231.149V319.392L190.99 255.655V165.421L118.625 231.149ZM209.01 254.812V165.336L281.396 231.068V272.866H281.489V318.491L209.01 254.812ZM299.005 255.564H318.484V153.826H222.932L299.005 222.751V255.564ZM281.375 136.524V81.7983L221.977 136.524H281.375ZM177.921 136.524H118.524V81.7983L177.921 136.524Z"
                    fill="black" />
            </svg>

            <span class="flex-1 relative z-10">Perplexity</span>
            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#ed3437] transition-colors duration-300 flex-shrink-0"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>

        <!-- Claude -->
        <a href="#" id="claudeBtn" role="menuitem"
            class="ai-tool-btn group relative px-5 py-3.5 bg-white text-[#1F3131] border-2 border-gray-200 rounded-[4px] text-sm font-semibold shadow-md hover:shadow-xl hover:border-[#ed3437] hover:bg-[#F9F8F6] flex items-center gap-3 overflow-hidden min-w-[200px]">
            <div class="shimmer"></div>
            <img class="w-5 h-5 flex-shrink-0" src="<?=get_template_directory_uri()?>/assets/icons/claude.svg"
            alt="Claude">
            <span class="flex-1 relative z-10">Claude</span>
            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#ed3437] transition-colors duration-300 flex-shrink-0"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>

        <!-- Google AI -->
        <a href="#" id="googleBtn" role="menuitem"
            class="ai-tool-btn group relative px-5 py-3.5 bg-white text-[#1F3131] border-2 border-gray-200 rounded-[4px] text-sm font-semibold shadow-md hover:shadow-xl hover:border-[#ed3437] hover:bg-[#F9F8F6] flex items-center gap-3 overflow-hidden min-w-[200px]">
            <div class="shimmer"></div>
            <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none">
                <path
                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                    fill="#4285F4" />
                <path
                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                    fill="#34A853" />
                <path
                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"
                    fill="#FBBC05" />
                <path
                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                    fill="#EA4335" />
            </svg>
            <span class="flex-1 relative z-10">Google AI</span>
            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#ed3437] transition-colors duration-300 flex-shrink-0"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>

        <!-- Grok -->
        <a href="#" id="grokBtn" role="menuitem"
            class="ai-tool-btn group relative px-5 py-3.5 bg-white text-[#1F3131] border-2 border-gray-200 rounded-[4px] text-sm font-semibold shadow-md hover:shadow-xl hover:border-[#ed3437] hover:bg-[#F9F8F6] flex items-center gap-3 overflow-hidden min-w-[200px]">
            <div class="shimmer"></div>
            <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24" fill="none">
                <path
                    d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"
                    fill="#000000" />
            </svg>
            <span class="flex-1 relative z-10">Grok</span>
            <svg class="w-4 h-4 text-gray-400 group-hover:text-[#ed3437] transition-colors duration-300 flex-shrink-0"
                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    </div>

    <!-- Trigger Button -->
    <button id="aiTrigger" type="button" aria-label="Open AI tools menu" aria-expanded="false" aria-haspopup="menu"
        class="group pulse-scale relative px-4 py-3 lg:px-5 lg:py-3.5 bg-gray-800 text-white text-sm font-semibold  shadow-lg hover:shadow-2xl hover:bg-[#ed3437] transition-all duration-300 flex items-center gap-2 pointer-events-auto">
        <svg class="w-6 h-6 lg:w-9 lg:h-9 transition-transform duration-300" viewBox="0 0 512 512" fill="currentColor">
            <path
                d="M320,64 L320,320 L64,320 L64,64 L320,64 Z M171.749388,128 L146.817842,128 L99.4840387,256 L121.976629,256 L130.913039,230.977 L187.575039,230.977 L196.319607,256 L220.167172,256 L171.749388,128 Z M260.093778,128 L237.691519,128 L237.691519,256 L260.093778,256 L260.093778,128 Z M159.094727,149.47526 L181.409039,213.333 L137.135039,213.333 L159.094727,149.47526 Z M341.333333,256 L384,256 L384,298.666667 L341.333333,298.666667 L341.333333,256 Z M85.3333333,341.333333 L128,341.333333 L128,384 L85.3333333,384 L85.3333333,341.333333 Z M170.666667,341.333333 L213.333333,341.333333 L213.333333,384 L170.666667,384 L170.666667,341.333333 Z M85.3333333,0 L128,0 L128,42.6666667 L85.3333333,42.6666667 L85.3333333,0 Z M256,341.333333 L298.666667,341.333333 L298.666667,384 L256,384 L256,341.333333 Z M170.666667,0 L213.333333,0 L213.333333,42.6666667 L170.666667,42.6666667 L170.666667,0 Z M256,0 L298.666667,0 L298.666667,42.6666667 L256,42.6666667 L256,0 Z M341.333333,170.666667 L384,170.666667 L384,213.333333 L341.333333,213.333333 L341.333333,170.666667 Z M0,256 L42.6666667,256 L42.6666667,298.666667 L0,298.666667 L0,256 Z M341.333333,85.3333333 L384,85.3333333 L384,128 L341.333333,128 L341.333333,85.3333333 Z M0,170.666667 L42.6666667,170.666667 L42.6666667,213.333333 L0,213.333333 L0,170.666667 Z M0,85.3333333 L42.6666667,85.3333333 L42.6666667,128 L0,128 L0,85.3333333 Z" />
        </svg>
        <span class="hidden lg:inline whitespace-nowrap transition-all duration-300">Summarize with AI</span>
        <svg id="aiTriggerIcon" class="w-4 h-4 transition-transform duration-300" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>
    </button>
</div>

<script>
// Configuration
const HOVER_DELAY = 150;
const HIDE_DELAY = 300;

// State management
let isOpen = false;
let hideTimeout = null;
let hoverTimeout = null;

// DOM elements
const trigger = document.getElementById('aiTrigger');
const triggerIcon = document.getElementById('aiTriggerIcon');
const list = document.getElementById('aiList');
const toolButtons = document.querySelectorAll('.ai-tool-btn');

// URL and prompt configuration
const url = encodeURIComponent(window.location.href);
const prompt = encodeURIComponent(
    `Summarize and analyze the key insights from ${window.location.href}`
);

// Set up AI tool URLs
const mapping = {
    chatgptBtn: `https://chat.openai.com/?q=${prompt}`,
    perplexityBtn: `https://www.perplexity.ai/search/new?q=${prompt}`,
    claudeBtn: `https://claude.ai/new?q=${prompt}`,
    googleBtn: `https://aistudio.google.com/prompts/new_chat?q=${prompt}`,
    grokBtn: `https://x.com/i/grok?text=${prompt}`
};

Object.keys(mapping).forEach(id => {
    const element = document.getElementById(id);
    if (element) {
        element.href = mapping[id];
		element.target = '_blank';
        element.rel = 'noopener noreferrer';
    }
});

// Clear all timeouts
function clearAllTimeouts() {
    if (hideTimeout) {
        clearTimeout(hideTimeout);
        hideTimeout = null;
    }
    if (hoverTimeout) {
        clearTimeout(hoverTimeout);
        hoverTimeout = null;
    }
}

// Show menu
function showMenu() {
    clearAllTimeouts();

    if (isOpen) return;

    isOpen = true;
    trigger.setAttribute('aria-expanded', 'true');

    // Show list container
    list.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
    list.classList.add('opacity-100', 'translate-y-0', 'active');
    triggerIcon.style.transform = 'rotate(180deg)';

    // Staggered animation for buttons (bottom to top)
    toolButtons.forEach((btn, index) => {
        btn.style.opacity = '0';
        btn.style.transform = 'translateY(10px)';

        setTimeout(() => {
            btn.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            btn.style.opacity = '1';
            btn.style.transform = 'translateY(0)';
        }, (toolButtons.length - 1 - index) * 60);
    });
}

// Hide menu
function hideMenu() {
    clearAllTimeouts();

    if (!isOpen) return;

    isOpen = false;
    trigger.setAttribute('aria-expanded', 'false');

    // Hide list container
    list.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
    list.classList.remove('opacity-100', 'translate-y-0', 'active');
    triggerIcon.style.transform = 'rotate(0deg)';

    // Reset button styles
    toolButtons.forEach(btn => {
        btn.style.opacity = '';
        btn.style.transform = '';
        btn.style.transition = '';
    });
}

// Schedule show with delay
function scheduleShow() {
    clearAllTimeouts();
    hoverTimeout = setTimeout(showMenu, HOVER_DELAY);
}

// Schedule hide with delay
function scheduleHide() {
    clearAllTimeouts();
    hideTimeout = setTimeout(hideMenu, HIDE_DELAY);
}

// Toggle menu (for click)
function toggleMenu() {
    if (isOpen) {
        hideMenu();
    } else {
        showMenu();
    }
}

// Event Listeners

// Click to toggle
trigger.addEventListener('click', (e) => {
    e.preventDefault();
    toggleMenu();
});

// Keyboard support
trigger.addEventListener('keydown', (e) => {
    if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        toggleMenu();
    }
    if (e.key === 'Escape' && isOpen) {
        hideMenu();
    }
});

// Hover on trigger
trigger.addEventListener('mouseenter', () => {
    scheduleShow();
});

trigger.addEventListener('mouseleave', () => {
    scheduleHide();
});

// Hover on list
list.addEventListener('mouseenter', () => {
    clearAllTimeouts();
    if (!isOpen) {
        showMenu();
    }
});

list.addEventListener('mouseleave', () => {
    scheduleHide();
});

// Click outside to close
document.addEventListener('click', (e) => {
    if (isOpen && !list.contains(e.target) && !trigger.contains(e.target)) {
        hideMenu();
    }
});

// Escape key to close
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && isOpen) {
        hideMenu();
        trigger.focus();
    }
});

// Prevent menu items from closing menu on hover
toolButtons.forEach(btn => {
    btn.addEventListener('mouseenter', () => {
        clearAllTimeouts();
    });
});
</script>