// User Growth Chart
document.addEventListener('DOMContentLoaded', () => {
    const userGrowthElement = document.getElementById('userGrowthChart');
    if (userGrowthElement) {
        const userGrowthCtx = userGrowthElement.getContext('2d');
        new Chart(userGrowthCtx, {
            type: 'line',
            data: window.chartData.userGrowth,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // Expenses Category Chart
    const expensesElement = document.getElementById('expensesCategoryChart');
    if (expensesElement) {
        const expensesCtx = expensesElement.getContext('2d');
        new Chart(expensesCtx, {
            type: 'doughnut',
            data: window.chartData.expenses,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    }

    // Habits Chart
    const habitsElement = document.getElementById('habitsChart');
    if (habitsElement) {
        const habitsCtx = habitsElement.getContext('2d');
        new Chart(habitsCtx, {
            type: 'bar',
            data: window.chartData.habits,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
});
