<div id="dashboard-updater" class="hidden">
    <!-- Real-time dashboard update component -->
</div>

<script>
class DashboardUpdater {
    constructor() {
        this.updateInterval = 30000; // 30 seconds
        this.isUpdating = false;
        this.init();
    }

    init() {
        // Start periodic updates
        this.startPeriodicUpdates();
        
        // Listen for user management events
        this.listenForUserEvents();
        
        // Listen for achievement events
        this.listenForAchievementEvents();
        
        // Listen for news events
        this.listenForNewsEvents();
    }

    startPeriodicUpdates() {
        setInterval(() => {
            if (!this.isUpdating) {
                this.updateDashboard();
            }
        }, this.updateInterval);
    }

    async updateDashboard() {
        try {
            this.isUpdating = true;
            
            const response = await fetch('/api/dashboard/data', {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (response.ok) {
                const data = await response.json();
                this.updateDashboardElements(data.data);
                this.showUpdateNotification('Dashboard diperbarui');
            }
        } catch (error) {
            console.error('Dashboard update failed:', error);
        } finally {
            this.isUpdating = false;
        }
    }

    updateDashboardElements(data) {
        // Update user statistics
        if (data.users) {
            this.updateUserStats(data.users);
        }

        // Update recent activities
        if (data.activities) {
            this.updateRecentActivities(data.activities);
        }

        // Update charts
        if (data.charts) {
            this.updateCharts(data.charts);
        }
    }

    updateUserStats(userStats) {
        // Update total users
        const totalUsersElement = document.querySelector('[data-stat="total_users"]');
        if (totalUsersElement) {
            totalUsersElement.textContent = userStats.total_users || 0;
        }

        // Update active users
        const activeUsersElement = document.querySelector('[data-stat="active_users"]');
        if (activeUsersElement) {
            activeUsersElement.textContent = userStats.active_users || 0;
        }

        // Update students count
        const studentsElement = document.querySelector('[data-stat="students"]');
        if (studentsElement) {
            studentsElement.textContent = userStats.students || 0;
        }

        // Update teachers count
        const teachersElement = document.querySelector('[data-stat="teachers"]');
        if (teachersElement) {
            teachersElement.textContent = userStats.teachers || 0;
        }

        // Update new users this month
        const newThisMonthElement = document.querySelector('[data-stat="new_this_month"]');
        if (newThisMonthElement) {
            newThisMonthElement.textContent = userStats.new_this_month || 0;
        }
    }

    updateRecentActivities(activities) {
        const activitiesContainer = document.querySelector('#recent-activities');
        if (!activitiesContainer) return;

        // Clear existing activities
        activitiesContainer.innerHTML = '';

        // Add new activities
        activities.forEach(activity => {
            const activityElement = this.createActivityElement(activity);
            activitiesContainer.appendChild(activityElement);
        });
    }

    createActivityElement(activity) {
        const div = document.createElement('div');
        div.className = `flex items-center p-3 border-l-4 border-${activity.color}-500 bg-${activity.color}-50`;
        
        div.innerHTML = `
            <div class="flex-shrink-0">
                <i class="${activity.icon} text-${activity.color}-600"></i>
            </div>
            <div class="ml-3">
                <p class="text-sm font-medium text-gray-900">${activity.title}</p>
                <p class="text-sm text-gray-500">${activity.description}</p>
                <p class="text-xs text-gray-400">${this.formatTime(activity.time)}</p>
            </div>
        `;

        return div;
    }

    updateCharts(chartData) {
        // Update monthly user chart
        if (chartData.monthly_users) {
            this.updateMonthlyUserChart(chartData.monthly_users);
        }

        // Update role distribution chart
        if (chartData.role_distribution) {
            this.updateRoleDistributionChart(chartData.role_distribution);
        }
    }

    updateMonthlyUserChart(data) {
        // This would update the chart if you're using a charting library
        console.log('Monthly user data updated:', data);
    }

    updateRoleDistributionChart(data) {
        // This would update the role distribution chart
        console.log('Role distribution updated:', data);
    }

    listenForUserEvents() {
        // Listen for user creation/update events
        document.addEventListener('userCreated', () => {
            this.updateDashboard();
        });

        document.addEventListener('userUpdated', () => {
            this.updateDashboard();
        });

        document.addEventListener('userDeleted', () => {
            this.updateDashboard();
        });
    }

    listenForAchievementEvents() {
        // Listen for achievement events
        document.addEventListener('achievementCreated', () => {
            this.updateDashboard();
        });

        document.addEventListener('achievementUpdated', () => {
            this.updateDashboard();
        });
    }

    listenForNewsEvents() {
        // Listen for news events
        document.addEventListener('newsCreated', () => {
            this.updateDashboard();
        });

        document.addEventListener('newsUpdated', () => {
            this.updateDashboard();
        });
    }

    formatTime(timeString) {
        const time = new Date(timeString);
        const now = new Date();
        const diff = now - time;

        if (diff < 60000) { // Less than 1 minute
            return 'Baru saja';
        } else if (diff < 3600000) { // Less than 1 hour
            const minutes = Math.floor(diff / 60000);
            return `${minutes} menit yang lalu`;
        } else if (diff < 86400000) { // Less than 1 day
            const hours = Math.floor(diff / 3600000);
            return `${hours} jam yang lalu`;
        } else {
            const days = Math.floor(diff / 86400000);
            return `${days} hari yang lalu`;
        }
    }

    showUpdateNotification(message) {
        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
        notification.textContent = message;

        document.body.appendChild(notification);

        // Remove notification after 3 seconds
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
}

// Initialize dashboard updater when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new DashboardUpdater();
});
</script>
