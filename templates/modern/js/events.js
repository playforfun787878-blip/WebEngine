/**
 * WebEngine CMS - Modern Template Events
 * https://webenginecms.org/
 * 
 * @version 1.2.6
 * @author WebEngine CMS Team
 * @copyright (c) 2013-2025 Lautaro Angelico, All Rights Reserved
 * 
 * Licensed under the MIT license
 * http://opensource.org/licenses/MIT
 */

(function() {
    'use strict';

    // Initialize events when DOM is loaded
    document.addEventListener('DOMContentLoaded', function() {
        initializeAjaxForms();
        initializeServerStatusUpdates();
        initializeNotifications();
        initializeCharacterProfiles();
        initializeGuildProfiles();
        initializeDynamicContent();
    });

    /**
     * AJAX form handling
     */
    function initializeAjaxForms() {
        // Handle AJAX forms
        document.addEventListener('submit', function(e) {
            const form = e.target;
            if (!form.classList.contains('ajax-form')) return;

            e.preventDefault();
            
            const formData = new FormData(form);
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn ? submitBtn.innerHTML : '';
            
            // Show loading state
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Processing...';
                submitBtn.disabled = true;
            }

            fetch(form.action || window.location.href, {
                method: form.method || 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification(data.message || 'Operation completed successfully', 'success');
                    if (data.redirect) {
                        setTimeout(() => {
                            window.location.href = data.redirect;
                        }, 1500);
                    }
                    if (data.reload) {
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    }
                } else {
                    showNotification(data.message || 'An error occurred', 'error');
                }
            })
            .catch(error => {
                console.error('Ajax form error:', error);
                showNotification('An unexpected error occurred', 'error');
            })
            .finally(() => {
                // Reset button state
                if (submitBtn) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            });
        });
    }

    /**
     * Server status updates
     */
    function initializeServerStatusUpdates() {
        // Update server status every 30 seconds
        setInterval(updateServerStatus, 30000);
        
        // Initial update
        updateServerStatus();
    }

    function updateServerStatus() {
        fetch(baseUrl + 'api/server-status.php', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            updateOnlineCount(data.online_players || 0);
            updateServerStatusIndicator(data.server_online || false);
        })
        .catch(error => {
            console.log('Server status update failed:', error);
        });
    }

    function updateOnlineCount(count) {
        const onlineCountElements = document.querySelectorAll('.online-count .count, .count');
        onlineCountElements.forEach(element => {
            if (element.classList.contains('count')) {
                element.textContent = formatNumber(count);
            }
        });

        // Update progress bar
        const maxOnline = parseInt(document.querySelector('[data-max-online]')?.dataset.maxOnline) || 1000;
        const percentage = Math.min((count / maxOnline) * 100, 100);
        const progressBars = document.querySelectorAll('.progress-bar');
        progressBars.forEach(bar => {
            bar.style.width = percentage + '%';
            bar.setAttribute('aria-valuenow', percentage);
        });
    }

    function updateServerStatusIndicator(isOnline) {
        const indicators = document.querySelectorAll('.status-indicator');
        indicators.forEach(indicator => {
            indicator.classList.remove('online', 'offline');
            indicator.classList.add(isOnline ? 'online' : 'offline');
        });

        const statusTexts = document.querySelectorAll('.status-text');
        statusTexts.forEach(text => {
            text.textContent = isOnline ? 'Server Online' : 'Server Offline';
        });
    }

    /**
     * Notifications system
     */
    function initializeNotifications() {
        // Create notification container if it doesn't exist
        if (!document.getElementById('notifications-container')) {
            const container = document.createElement('div');
            container.id = 'notifications-container';
            container.style.cssText = `
                position: fixed;
                top: 80px;
                right: 20px;
                z-index: 10000;
                max-width: 400px;
            `;
            document.body.appendChild(container);
        }
    }

    function showNotification(message, type = 'info', duration = 5000) {
        const container = document.getElementById('notifications-container');
        if (!container) return;

        const notification = document.createElement('div');
        notification.className = `alert alert-${type} notification fade-in`;
        notification.style.cssText = `
            margin-bottom: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            opacity: 0;
            transform: translateX(100%);
            transition: all 0.3s ease;
        `;

        const iconMap = {
            success: 'fas fa-check-circle',
            error: 'fas fa-exclamation-circle', 
            warning: 'fas fa-exclamation-triangle',
            info: 'fas fa-info-circle'
        };

        notification.innerHTML = `
            <div class="alert-icon">
                <i class="${iconMap[type] || iconMap.info}"></i>
            </div>
            <div class="alert-content">
                <div class="alert-message">${message}</div>
            </div>
            <button type="button" class="btn-close" onclick="this.parentElement.remove()">
                <i class="fas fa-times"></i>
            </button>
        `;

        container.appendChild(notification);

        // Animate in
        setTimeout(() => {
            notification.style.opacity = '1';
            notification.style.transform = 'translateX(0)';
        }, 10);

        // Auto remove
        setTimeout(() => {
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 300);
        }, duration);
    }

    /**
     * Character profiles
     */
    function initializeCharacterProfiles() {
        // Handle character profile links
        document.addEventListener('click', function(e) {
            const profileLink = e.target.closest('[data-character-profile]');
            if (!profileLink) return;

            e.preventDefault();
            const characterName = profileLink.dataset.characterProfile;
            loadCharacterProfile(characterName);
        });
    }

    function loadCharacterProfile(characterName) {
        // Show loading modal
        showProfileModal('Loading...', '<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');

        fetch(baseUrl + 'api/character-profile.php?character=' + encodeURIComponent(characterName), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const profileHtml = generateCharacterProfileHtml(data.character);
                showProfileModal(characterName + ' - Character Profile', profileHtml);
            } else {
                showNotification('Character profile not found', 'error');
            }
        })
        .catch(error => {
            console.error('Character profile error:', error);
            showNotification('Failed to load character profile', 'error');
        });
    }

    function generateCharacterProfileHtml(character) {
        return `
            <div class="character-profile">
                <div class="row">
                    <div class="col-md-6">
                        <div class="profile-section">
                            <h6><i class="fas fa-user me-2"></i>Character Info</h6>
                            <div class="profile-stats">
                                <div class="stat-row">
                                    <span class="stat-label">Name:</span>
                                    <span class="stat-value">${character.name || 'Unknown'}</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Level:</span>
                                    <span class="stat-value">${character.level || 0}</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Class:</span>
                                    <span class="stat-value">${character.class || 'Unknown'}</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Guild:</span>
                                    <span class="stat-value">${character.guild || 'None'}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-section">
                            <h6><i class="fas fa-chart-bar me-2"></i>Statistics</h6>
                            <div class="profile-stats">
                                <div class="stat-row">
                                    <span class="stat-label">Strength:</span>
                                    <span class="stat-value">${character.strength || 0}</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Agility:</span>
                                    <span class="stat-value">${character.agility || 0}</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Vitality:</span>
                                    <span class="stat-value">${character.vitality || 0}</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Energy:</span>
                                    <span class="stat-value">${character.energy || 0}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    /**
     * Guild profiles
     */
    function initializeGuildProfiles() {
        // Handle guild profile links
        document.addEventListener('click', function(e) {
            const guildLink = e.target.closest('[data-guild-profile]');
            if (!guildLink) return;

            e.preventDefault();
            const guildName = guildLink.dataset.guildProfile;
            loadGuildProfile(guildName);
        });
    }

    function loadGuildProfile(guildName) {
        // Show loading modal
        showProfileModal('Loading...', '<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');

        fetch(baseUrl + 'api/guild-profile.php?guild=' + encodeURIComponent(guildName), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const profileHtml = generateGuildProfileHtml(data.guild);
                showProfileModal(guildName + ' - Guild Profile', profileHtml);
            } else {
                showNotification('Guild profile not found', 'error');
            }
        })
        .catch(error => {
            console.error('Guild profile error:', error);
            showNotification('Failed to load guild profile', 'error');
        });
    }

    function generateGuildProfileHtml(guild) {
        return `
            <div class="guild-profile">
                <div class="row">
                    <div class="col-md-12">
                        <div class="profile-section">
                            <h6><i class="fas fa-shield-alt me-2"></i>Guild Information</h6>
                            <div class="profile-stats">
                                <div class="stat-row">
                                    <span class="stat-label">Name:</span>
                                    <span class="stat-value">${guild.name || 'Unknown'}</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Master:</span>
                                    <span class="stat-value">${guild.master || 'Unknown'}</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Members:</span>
                                    <span class="stat-value">${guild.members || 0}</span>
                                </div>
                                <div class="stat-row">
                                    <span class="stat-label">Score:</span>
                                    <span class="stat-value">${guild.score || 0}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ${guild.memberList ? `
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="profile-section">
                            <h6><i class="fas fa-users me-2"></i>Members</h6>
                            <div class="guild-members">
                                ${guild.memberList.map(member => `
                                    <div class="member-item">
                                        <span class="member-name">${member.name}</span>
                                        <span class="member-level">Level ${member.level}</span>
                                    </div>
                                `).join('')}
                            </div>
                        </div>
                    </div>
                </div>
                ` : ''}
            </div>
        `;
    }

    /**
     * Profile modal
     */
    function showProfileModal(title, content) {
        // Remove existing modal
        const existingModal = document.getElementById('profile-modal');
        if (existingModal) {
            existingModal.remove();
        }

        // Create modal
        const modal = document.createElement('div');
        modal.id = 'profile-modal';
        modal.className = 'modal-backdrop';
        modal.innerHTML = `
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">${title}</h5>
                    <button type="button" class="modal-close" onclick="this.closest('.modal-backdrop').remove()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body">
                    ${content}
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Close on backdrop click
        modal.addEventListener('click', function(e) {
            if (e.target === modal) {
                modal.remove();
            }
        });

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && document.getElementById('profile-modal')) {
                modal.remove();
            }
        });
    }

    /**
     * Dynamic content loading
     */
    function initializeDynamicContent() {
        // Load content with AJAX for specific links
        document.addEventListener('click', function(e) {
            const dynamicLink = e.target.closest('[data-dynamic-load]');
            if (!dynamicLink) return;

            e.preventDefault();
            const target = dynamicLink.dataset.dynamicLoad;
            const url = dynamicLink.href;
            
            loadDynamicContent(url, target);
        });
    }

    function loadDynamicContent(url, target) {
        const targetElement = document.querySelector(target);
        if (!targetElement) return;

        // Show loading state
        const originalContent = targetElement.innerHTML;
        targetElement.innerHTML = '<div class="text-center p-4"><i class="fas fa-spinner fa-spin fa-2x"></i></div>';

        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            targetElement.innerHTML = html;
            // Trigger any necessary reinitialization
            initializeTooltips();
        })
        .catch(error => {
            console.error('Dynamic content loading error:', error);
            targetElement.innerHTML = originalContent;
            showNotification('Failed to load content', 'error');
        });
    }

    /**
     * Utility functions
     */
    function formatNumber(num) {
        if (num >= 1000000) {
            return Math.round(num / 100000) / 10 + 'M';
        } else if (num >= 1000) {
            return Math.round(num / 100) / 10 + 'K';
        }
        return num.toString();
    }

    function initializeTooltips() {
        // Re-initialize tooltips for dynamically loaded content
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Expose functions globally for external use
    window.WebEngineEvents = {
        showNotification: showNotification,
        updateServerStatus: updateServerStatus,
        loadCharacterProfile: loadCharacterProfile,
        loadGuildProfile: loadGuildProfile,
        formatNumber: formatNumber
    };

})();