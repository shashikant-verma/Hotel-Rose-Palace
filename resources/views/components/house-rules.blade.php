@php
    $rulesConfig = config('hotel_rules');
    $categories = $rulesConfig['categories'] ?? [];
    $mainHeading = $rulesConfig['heading'] ?? 'House Rules & Information';
    $subtitle = $rulesConfig['subtitle'] ?? null;
@endphp

<section class="hrp-house-rules-section" aria-labelledby="house-rules-heading">
    <div class="hrp-rules-card">
        {{-- Header Area --}}
        <div class="hrp-rules-header">
            <div class="d-flex align-items-center gap-2 mb-1">
                <span class="hrp-rules-tag">
                    <i class="fas fa-hotel"></i> Stay Policies
                </span>
            </div>
            <h2 id="house-rules-heading" class="hrp-rules-title">{{ $mainHeading }}</h2>
            @if(!empty($subtitle))
                <p class="hrp-rules-subtitle">{{ $subtitle }}</p>
            @endif
        </div>

        {{-- Horizontally Scrollable Tab Navigation --}}
        <div class="hrp-tabs-wrapper">
            <nav class="hrp-tabs-nav" role="tablist" aria-label="House Rules Categories" id="hrpRulesTabList">
                @foreach($categories as $index => $cat)
                    <button type="button"
                            class="hrp-tab-btn {{ $index === 0 ? 'active' : '' }}"
                            role="tab"
                            id="tab-{{ $cat['id'] }}"
                            aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                            aria-controls="panel-{{ $cat['id'] }}"
                            data-target="{{ $cat['id'] }}">
                        {{ $cat['tab_title'] }}
                    </button>
                @endforeach
            </nav>
        </div>

        {{-- Policy Categories Content Stack --}}
        <div class="hrp-rules-content-stack" id="hrpRulesContentStack">
            @foreach($categories as $index => $cat)
                <article class="hrp-category-card"
                         id="{{ $cat['id'] }}"
                         role="tabpanel"
                         aria-labelledby="tab-{{ $cat['id'] }}"
                         tabindex="0">
                    <header class="hrp-category-header">
                        <span class="hrp-category-icon" aria-hidden="true">
                            <i class="{{ $cat['icon'] ?? 'fas fa-circle-info' }}"></i>
                        </span>
                        <h3 class="hrp-category-title">{{ $cat['heading'] }}</h3>
                    </header>

                    <ul class="hrp-category-list">
                        @foreach($cat['rules'] as $rule)
                            <li class="hrp-category-item">
                                <span class="hrp-bullet-dot" aria-hidden="true"></span>
                                <span class="hrp-rule-text">{{ $rule }}</span>
                            </li>
                        @endforeach
                    </ul>
                </article>
            @endforeach
        </div>
    </div>
</section>

<style>
/* ── Hotel Rose Palace House Rules & Information Design System ─────── */
.hrp-house-rules-section {
    background-color: #EDE4D8; /* Sandstone Canvas */
    border-radius: 12px;
    margin: 28px 0;
    box-sizing: border-box;
}

.hrp-rules-card {
    background-color: #F7F1E8; /* Champagne Parchment */
    border: 1px solid #DCD0C0; /* Muted Border */
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 4px 16px rgba(46, 31, 34, 0.05);
}

@media (max-width: 767.98px) {
    .hrp-rules-card {
        padding: 18px 14px;
        border-radius: 8px;
    }
}

/* Header */
.hrp-rules-header {
    margin-bottom: 20px;
    padding-bottom: 12px;
    border-bottom: 1px solid #DCD0C0;
}

.hrp-rules-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #B88A44; /* Muted Gold */
    background: rgba(184, 138, 68, 0.12);
    padding: 4px 10px;
    border-radius: 50px;
    border: 1px solid rgba(184, 138, 68, 0.25);
}

.hrp-rules-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 26px;
    font-weight: 700;
    color: #6E2C3A; /* Burgundy Rose */
    margin: 6px 0 0 0;
    letter-spacing: -0.01em;
    line-height: 1.3;
}

@media (max-width: 767.98px) {
    .hrp-rules-title {
        font-size: 21px;
    }
}

.hrp-rules-subtitle {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 13.5px;
    color: #5E4B4E;
    margin: 6px 0 0 0;
    line-height: 1.5;
}

/* Tab Navigation Strip */
.hrp-tabs-wrapper {
    position: relative;
    border-bottom: 2px solid #DCD0C0;
    margin-bottom: 24px;
    background: #F7F1E8;
    /* Soft sticky under main navbar if needed */
    position: sticky;
    top: 76px;
    z-index: 20;
    padding-top: 4px;
}

.hrp-tabs-nav {
    display: flex;
    gap: 20px;
    overflow-x: auto;
    overflow-y: hidden;
    white-space: nowrap;
    -webkit-overflow-scrolling: touch;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none;  /* IE and Edge */
    padding: 0 4px;
}

.hrp-tabs-nav::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
}

.hrp-tab-btn {
    background: transparent;
    border: none;
    outline: none;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 12.5px;
    font-weight: 600;
    letter-spacing: 0.4px;
    text-transform: uppercase;
    color: #5E4B4E;
    padding: 10px 4px 12px;
    cursor: pointer;
    position: relative;
    white-space: nowrap;
    flex-shrink: 0;
    border-bottom: 3px solid transparent;
    margin-bottom: -2px; /* Overlap wrapper border */
    transition: color 0.2s ease, border-color 0.2s ease;
}

.hrp-tab-btn:hover {
    color: #B88A44; /* Muted Gold Hover */
}

.hrp-tab-btn.active {
    color: #6E2C3A; /* Burgundy Rose */
    font-weight: 700;
    border-bottom: 3px solid #6E2C3A; /* Royal Burgundy 3px indicator */
}

.hrp-tab-btn:focus-visible {
    outline: 2px solid #B88A44;
    outline-offset: 2px;
    border-radius: 4px;
}

/* Category Content Stack */
.hrp-rules-content-stack {
    display: flex;
    flex-direction: column;
    gap: 22px;
}

.hrp-category-card {
    background: #F7F1E8; /* Champagne Parchment */
    border: 1px solid #DCD0C0; /* Muted Border */
    border-radius: 8px;
    padding: 18px 20px;
    /* Offset scroll so header doesn't cover category title */
    scroll-margin-top: 135px;
    transition: background 0.25s ease, border-color 0.25s ease, box-shadow 0.25s ease;
}

.hrp-category-card.is-active-target {
    border-color: #B88A44;
    box-shadow: 0 2px 12px rgba(184, 138, 68, 0.12);
}

.hrp-category-header {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px dashed #DCD0C0;
}

.hrp-category-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 26px;
    height: 26px;
    border-radius: 6px;
    background: rgba(184, 138, 68, 0.15);
    color: #B88A44; /* Muted Gold */
    font-size: 13px;
    flex-shrink: 0;
}

.hrp-category-title {
    font-family: 'Playfair Display', Georgia, serif;
    font-size: 17px;
    font-weight: 700;
    color: #2C2523; /* Warm Dark Charcoal */
    margin: 0;
    letter-spacing: -0.01em;
}

/* Policy Rules List */
.hrp-category-list {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.hrp-category-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14.5px;
    color: #2C2523; /* Warm Dark Charcoal */
    line-height: 1.55;
}

.hrp-bullet-dot {
    display: inline-block;
    width: 6px;
    height: 6px;
    background-color: #B88A44; /* Muted Gold */
    border-radius: 50%;
    margin-top: 8px;
    flex-shrink: 0;
}

.hrp-rule-text {
    flex: 1;
}

@media (max-width: 575.98px) {
    .hrp-category-card {
        padding: 14px 14px;
    }
    .hrp-category-item {
        font-size: 13.5px;
    }
    .hrp-tab-btn {
        font-size: 11.5px;
        padding: 8px 2px 10px;
    }
    .hrp-tabs-nav {
        gap: 16px;
    }
}
</style>

<script>
(function() {
    'use strict';

    function initHouseRulesComponent() {
        const tabList = document.getElementById('hrpRulesTabList');
        const contentStack = document.getElementById('hrpRulesContentStack');
        if (!tabList || !contentStack) return;

        const tabs = Array.from(tabList.querySelectorAll('.hrp-tab-btn'));
        const cards = Array.from(contentStack.querySelectorAll('.hrp-category-card'));
        if (tabs.length === 0 || cards.length === 0) return;

        let isProgrammaticScroll = false;
        let scrollTimeout = null;

        // Auto-center active tab in horizontal scrollable strip
        function centerActiveTab(activeTab) {
            if (!activeTab || !tabList) return;
            const tabLeft = activeTab.offsetLeft;
            const tabWidth = activeTab.offsetWidth;
            const listWidth = tabList.clientWidth;
            const targetScrollLeft = tabLeft - (listWidth / 2) + (tabWidth / 2);
            tabList.scrollTo({
                left: targetScrollLeft,
                behavior: 'smooth'
            });
        }

        // Activate Tab UI
        function activateTab(targetId, shouldCenter = true) {
            tabs.forEach(tab => {
                const isActive = (tab.getAttribute('data-target') === targetId);
                tab.classList.toggle('active', isActive);
                tab.setAttribute('aria-selected', isActive ? 'true' : 'false');
                if (isActive && shouldCenter) {
                    centerActiveTab(tab);
                }
            });

            cards.forEach(card => {
                card.classList.toggle('is-active-target', card.id === targetId);
            });
        }

        // Click Handler for Tabs
        tabs.forEach((tab, index) => {
            tab.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('data-target');
                const targetCard = document.getElementById(targetId);
                if (!targetCard) return;

                isProgrammaticScroll = true;
                activateTab(targetId, true);

                // Smoothly scroll to the target category card
                targetCard.scrollIntoView({ behavior: 'smooth', block: 'start' });

                clearTimeout(scrollTimeout);
                scrollTimeout = setTimeout(() => {
                    isProgrammaticScroll = false;
                }, 800);
            });

            // Keyboard Navigation (Arrow Keys)
            tab.addEventListener('keydown', function(e) {
                let newIndex = null;
                if (e.key === 'ArrowRight') {
                    newIndex = (index + 1) % tabs.length;
                } else if (e.key === 'ArrowLeft') {
                    newIndex = (index - 1 + tabs.length) % tabs.length;
                } else if (e.key === 'Home') {
                    newIndex = 0;
                } else if (e.key === 'End') {
                    newIndex = tabs.length - 1;
                }

                if (newIndex !== null) {
                    e.preventDefault();
                    tabs[newIndex].focus();
                    tabs[newIndex].click();
                }
            });
        });

        // Scroll-Spy with IntersectionObserver
        if ('IntersectionObserver' in window) {
            const intersectingMap = new Set();
            const observerOptions = {
                root: null,
                rootMargin: '-120px 0px -50% 0px',
                threshold: [0, 0.2]
            };

            const observer = new IntersectionObserver((entries) => {
                if (isProgrammaticScroll) return;

                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        intersectingMap.add(entry.target.id);
                    } else {
                        intersectingMap.delete(entry.target.id);
                    }
                });

                if (intersectingMap.size > 0) {
                    // Pick first card in DOM order that is currently intersecting
                    const visibleCard = cards.find(card => intersectingMap.has(card.id));
                    if (visibleCard) {
                        activateTab(visibleCard.id, true);
                    }
                }
            }, observerOptions);

            cards.forEach(card => observer.observe(card));
        } else {
            // Fallback for browsers without IntersectionObserver
            window.addEventListener('scroll', function() {
                if (isProgrammaticScroll) return;
                const scrollPos = window.scrollY + 140;
                for (let i = cards.length - 1; i >= 0; i--) {
                    if (cards[i].offsetTop <= scrollPos) {
                        activateTab(cards[i].id, true);
                        break;
                    }
                }
            }, { passive: true });
        }
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initHouseRulesComponent);
    } else {
        initHouseRulesComponent();
    }
})();
</script>
