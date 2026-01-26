(function() {
    'use strict';

    function injectStyles() {
        if (document.getElementById('scroll-card-animation-styles')) {
            return;
        }

        const style = document.createElement('style');
        style.id = 'scroll-card-animation-styles';
        style.textContent = `
            .elementor-element.scroll-card-item,
            .elementor-element.elementor-element.scroll-card-item,
            .e-con.scroll-card-item,
            .e-con.e-child.scroll-card-item {
                position: relative !important;
                padding: 20px !important;
                margin-bottom: 15px !important;
                border: 1px solid #000 !important;
                border-radius: 8px !important;
                transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            
            .elementor-element.scroll-card-item:not(.scroll-card-active),
            .elementor-element.elementor-element.scroll-card-item:not(.scroll-card-active),
            .e-con.scroll-card-item:not(.scroll-card-active),
            .e-con.e-child.scroll-card-item:not(.scroll-card-active) {
                background-color: rgba(255, 154, 0, 0) !important;
                background: rgba(255, 154, 0, 0) !important;
            }
            
            .elementor-element.scroll-card-item:not(.scroll-card-active) .scroll-card-number,
            .elementor-element.scroll-card-item:not(.scroll-card-active) .elementor-heading-title.scroll-card-number,
            .elementor-element.scroll-card-item:not(.scroll-card-active) h2.scroll-card-number,
            .elementor-element.scroll-card-item:not(.scroll-card-active) h2.elementor-heading-title.scroll-card-number {
                color: rgba(247, 82, 0, 0.56) !important;
                transition: color 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            
            .elementor-element.scroll-card-item:not(.scroll-card-active) .scroll-card-text-mobile,
            .elementor-element.scroll-card-item:not(.scroll-card-active) .elementor-heading-title.scroll-card-text-mobile,
            .elementor-element.scroll-card-item:not(.scroll-card-active) h2.scroll-card-text-mobile,
            .elementor-element.scroll-card-item:not(.scroll-card-active) h2.elementor-heading-title.scroll-card-text-mobile {
                color: rgba(0, 0, 0, 0.56) !important;
                transition: color 0.4s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            
            .elementor-element.scroll-card-item.scroll-card-active,
            .elementor-element.elementor-element.scroll-card-item.scroll-card-active,
            .e-con.scroll-card-item.scroll-card-active,
            .e-con.e-child.scroll-card-item.scroll-card-active {
                background-color: rgba(255, 154, 0, 0.11) !important;
                background: rgba(255, 154, 0, 0.11) !important;
                border-color: rgba(0, 0, 0, 0.2) !important;
            }
            
            .elementor-element.scroll-card-item.scroll-card-active .scroll-card-number-mobile,
            .elementor-element.scroll-card-item.scroll-card-active .elementor-heading-title.scroll-card-number-mobile,
            .elementor-element.scroll-card-item.scroll-card-active h2.scroll-card-number-mobile,
            .elementor-element.scroll-card-item.scroll-card-active h2.elementor-heading-title.scroll-card-number-mobile {
                color: #F75200 !important;
            }
            
            .elementor-element.scroll-card-item.scroll-card-active .scroll-card-text,
            .elementor-element.scroll-card-item.scroll-card-active .elementor-heading-title.scroll-card-text,
            .elementor-element.scroll-card-item.scroll-card-active h2.scroll-card-text,
            .elementor-element.scroll-card-item.scroll-card-active h2.elementor-heading-title.scroll-card-text {
                color: #000000 !important;
            }
            
            .scroll-cards-container-mobile .scroll-card-item:first-child,
            .scroll-cards-container-mobile .elementor-element.scroll-card-item:first-child,
            .scroll-cards-container-mobile .e-con.scroll-card-item:first-child {
                background-color: rgba(255, 154, 0, 0.11) !important;
                background: rgba(255, 154, 0, 0.11) !important;
            }
            
            .scroll-cards-container-mobile .scroll-card-item:first-child .scroll-card-number-mobile,
            .scroll-cards-container-mobile .elementor-element.scroll-card-item:first-child .elementor-heading-title.scroll-card-number-mobile,
            .scroll-cards-container-mobile .scroll-card-item:first-child h2.scroll-card-number-mobile,
            .scroll-cards-container-mobile .scroll-card-item:first-child h2.elementor-heading-title.scroll-card-number-mobile {
                color: #F75200 !important;
            }
            
            .scroll-cards-container-mobile .scroll-card-item:first-child .scroll-card-text-mobile,
            .scroll-cards-container-mobile .elementor-element.scroll-card-item:first-child .elementor-heading-title.scroll-card-text-mobile,
            .scroll-cards-container-mobile .scroll-card-item:first-child h2.scroll-card-text-mobile,
            .scroll-cards-container-mobile .scroll-card-item:first-child h2.elementor-heading-title.scroll-card-text-mobile {
                color: #000000 !important;
            }
            
            html {
                scroll-behavior: smooth;
            }
        `;
        
        try {
            document.head.appendChild(style);
        } catch (error) {
            return;
        }
    }

    injectStyles();

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initScrollAnimation);
    } else {
        initScrollAnimation();
    }

    function initScrollAnimation() {
        let cardContainer = document.querySelector('.scroll-cards-container-mobile');
        
        if (cardContainer) {
            const potentialCards = cardContainer.querySelectorAll('.elementor-element[data-element_type="container"]');
            const hasMultipleCards = potentialCards.length > 1;
            const directHeadings1 = cardContainer.querySelectorAll(':scope > .elementor-widget-heading');
            const directHeadings2 = cardContainer.querySelectorAll(':scope > h2');
            const hasDirectHeadings = (directHeadings1.length > 0 || directHeadings2.length > 0);
            
            if (hasDirectHeadings && !hasMultipleCards) {
                let parent = cardContainer.parentElement;
                let foundParent = false;
                let attempts = 0;
                
                while (parent && attempts < 5) {
                    const siblings = parent.querySelectorAll('.elementor-element[data-element_type="container"]');
                    if (siblings.length >= 2) {
                        cardContainer = parent;
                        foundParent = true;
                        break;
                    }
                    parent = parent.parentElement;
                    attempts++;
                }
                
                if (!foundParent) {
                    const allContainers = document.querySelectorAll('.elementor-element[data-element_type="container"]');
                    for (let container of allContainers) {
                        const children = container.querySelectorAll(':scope > .elementor-element[data-element_type="container"]');
                        if (children.length >= 2) {
                            cardContainer = container;
                            foundParent = true;
                            break;
                        }
                    }
                }
            }
        }
        
        if (!cardContainer) {
            const allContainers = document.querySelectorAll('.elementor-element[data-element_type="container"]');
            
            for (let container of allContainers) {
                const children = container.querySelectorAll(':scope > .elementor-element[data-element_type="container"]');
                if (children.length >= 2) {
                    let cardsWithHeadings = 0;
                    children.forEach(child => {
                        if (child.querySelectorAll('h2').length >= 2) {
                            cardsWithHeadings++;
                        }
                    });
                    
                    if (cardsWithHeadings >= 2) {
                        cardContainer = container;
                        break;
                    }
                }
            }
            
            if (!cardContainer) {
                return;
            }
        }

        let cards = cardContainer.querySelectorAll('.scroll-card-item');
        if (cards.length === 0) {
            cards = document.querySelectorAll('.scroll-card-item');
        }
        
        if (cards.length === 0) {
            const directChildren = Array.from(cardContainer.children).filter(el => 
                el.classList.contains('elementor-element') && 
                el.getAttribute('data-element_type') === 'container'
            );
            
            const nestedContainers = cardContainer.querySelectorAll('.elementor-element[data-element_type="container"]');
            const allContainers = Array.from(new Set([...directChildren, ...Array.from(nestedContainers)]));
            
            const detectedCards = [];
            allContainers.forEach((el) => {
                if (el === cardContainer) {
                    return;
                }
                
                const numberHeading = el.querySelector('.scroll-card-number, h2.scroll-card-number');
                const textHeading = el.querySelector('.scroll-card-text, h2.scroll-card-text');
                const allHeadings = el.querySelectorAll('h2.elementor-heading-title');
                const hasBothHeadings = allHeadings.length >= 2;
                const hasNumberClass = !!numberHeading || Array.from(allHeadings).some(h => h.classList.contains('scroll-card-number'));
                const hasTextClass = !!textHeading || Array.from(allHeadings).some(h => h.classList.contains('scroll-card-text'));
                
                if (hasBothHeadings || (hasNumberClass && hasTextClass)) {
                    if (!el.classList.contains('scroll-card-item')) {
                        el.classList.add('scroll-card-item');
                    }
                    
                    if (allHeadings.length >= 2) {
                        const firstHeading = allHeadings[0];
                        const secondHeading = allHeadings[1];
                        
                        if (!firstHeading.classList.contains('scroll-card-number') && !firstHeading.classList.contains('scroll-card-text')) {
                            firstHeading.classList.add('scroll-card-number');
                        }
                        
                        if (!secondHeading.classList.contains('scroll-card-text') && !secondHeading.classList.contains('scroll-card-number')) {
                            secondHeading.classList.add('scroll-card-text');
                        }
                    }
                    
                    detectedCards.push(el);
                }
            });
            
            if (detectedCards.length > 0) {
                cards = detectedCards;
            } else {
                return;
            }
        }

        function applyCardStyles(card, isActive) {
            if (!card) return;
            
            const numberEl = card.querySelector('.scroll-card-number, h2.scroll-card-number, .elementor-heading-title.scroll-card-number');
            const textEl = card.querySelector('.scroll-card-text, h2.scroll-card-text, .elementor-heading-title.scroll-card-text');
            
            if (isActive) {
                card.style.setProperty('background-color', 'rgba(255, 154, 0, 0.11)', 'important');
                card.style.setProperty('background', 'rgba(255, 154, 0, 0.11)', 'important');
                
                if (numberEl) {
                    numberEl.style.setProperty('color', '#F75200', 'important');
                }
                if (textEl) {
                    textEl.style.setProperty('color', '#000000', 'important');
                }
            } else {
                card.style.setProperty('background-color', 'rgba(255, 154, 0, 0)', 'important');
                card.style.setProperty('background', 'rgba(255, 154, 0, 0)', 'important');
                
                if (numberEl) {
                    numberEl.style.setProperty('color', 'rgba(247, 82, 0, 0.56)', 'important');
                }
                if (textEl) {
                    textEl.style.setProperty('color', 'rgba(0, 0, 0, 0.56)', 'important');
                }
            }
        }
        
        function applyAllCardStyles() {
            cards.forEach((card) => {
                const isActive = card.classList.contains('scroll-card-active');
                applyCardStyles(card, isActive);
            });
        }
        
        if (cards.length > 0) {
            cards[0].classList.add('scroll-card-active');
            applyAllCardStyles();
        }

        const observerOptions = {
            root: null,
            rootMargin: '-20% 0px -20% 0px',
            threshold: [0, 0.25, 0.5, 0.75, 1]
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                const card = entry.target;
                const visibilityRatio = entry.intersectionRatio;
                
                if (visibilityRatio > 0.3) {
                    const activeCardIndex = Array.from(cards).indexOf(card);
                    
                    cards.forEach((c, index) => {
                        if (index <= activeCardIndex) {
                            c.classList.add('scroll-card-active');
                            applyCardStyles(c, true);
                        } else {
                            c.classList.remove('scroll-card-active');
                            applyCardStyles(c, false);
                        }
                    });
                }
            });
        }, observerOptions);

        cards.forEach((card) => {
            observer.observe(card);
        });

        let ticking = false;
        
        function updateActiveCard() {
            if (ticking) return;
            
            ticking = true;
            requestAnimationFrame(() => {
                const viewportHeight = window.innerHeight;
                const viewportCenter = window.scrollY + (viewportHeight / 2);
                
                let activeCard = null;
                let minDistance = Infinity;
                
                cards.forEach((card) => {
                    const cardRect = card.getBoundingClientRect();
                    const cardCenter = cardRect.top + (cardRect.height / 2) + window.scrollY;
                    const distance = Math.abs(viewportCenter - cardCenter);
                    
                    if (cardRect.top < viewportHeight && cardRect.bottom > 0) {
                        if (distance < minDistance) {
                            minDistance = distance;
                            activeCard = card;
                        }
                    }
                });
                
                let activeCardIndex = -1;
                
                if (activeCard) {
                    activeCardIndex = Array.from(cards).indexOf(activeCard);
                } else if (cards.length > 0) {
                    activeCardIndex = 0;
                }
                
                cards.forEach((card, index) => {
                    if (activeCardIndex >= 0 && index <= activeCardIndex) {
                        card.classList.add('scroll-card-active');
                        applyCardStyles(card, true);
                    } else {
                        card.classList.remove('scroll-card-active');
                        applyCardStyles(card, false);
                    }
                });
                
                ticking = false;
            });
        }

        window.addEventListener('scroll', updateActiveCard, { passive: true });
        updateActiveCard();
    }
})();
