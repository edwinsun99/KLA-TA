@extends('master.layout.app')

@section('title', 'KLA Computer')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    :root {
        --primary-purple: #7d3cff;
        --soft-purple: #f3ebff;
        --accent-yellow: #ffc107;
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: rgba(255, 255, 255, 0.4);
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background-color: #f8f9fd;
    }

    .dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 25px;
        padding-bottom: 40px;
    }

    .welcome-text {
        font-weight: 800;
        color: #2d3436;
        letter-spacing: -0.5px;
        margin-bottom: 5px;
    }

    /* Stats Section with Glassmorphism */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border-radius: 20px;
        border: 1px solid var(--glass-border);
        box-shadow: 0 8px 32px rgba(125, 60, 255, 0.05);
        padding: 24px;
        transition: transform 0.3s ease;
    }

    .glass-card:hover {
        transform: translateY(-5px);
    }

    .stats-card {
        text-align: center;
        border-top: 4px solid var(--primary-purple);
    }

    .stats-card h5 {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--primary-purple);
        text-transform: uppercase;
        margin-bottom: 15px;
    }

    .circle-stat {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        border: 6px solid var(--soft-purple);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
    }

    /* Aksen kuning pada ring stat */
    .circle-stat::after {
        content: '';
        position: absolute;
        inset: -6px;
        border-radius: 50%;
        border: 6px solid transparent;
        border-top-color: var(--accent-yellow);
        transform: rotate(45deg);
    }

    .circle-stat span {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary-purple);
    }

    /* Charts Section Layout */
    .charts-main-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .chart-header h4 {
        font-weight: 700;
        font-size: 1.1rem;
        color: #2d3436;
    }

    .full-width-chart {
        grid-column: span 2;
    }

    @media (max-width: 1024px) {
        .charts-main-grid {
            grid-template-columns: 1fr;
        }
        .full-width-chart {
            grid-column: span 1;
        }
    }
</style>

<div class="dashboard-container">
    <h2 class="welcome-text">Welcome Back, {{ auth()->user()->username }} 👋</h2>
    
    <div class="stats-grid">
        <div class="glass-card stats-card">
            <h5>Total Cases</h5>
            <div class="circle-stat"><span>{{ $totalCases }}</span></div>
        </div>
        <div class="glass-card stats-card">
            <h5>Today's New</h5>
            <div class="circle-stat"><span>{{ $newCasesToday }}</span></div>
        </div>
        <div class="glass-card stats-card">
            <h5>Repair Progress</h5>
            <div class="circle-stat"><span>{{ $casesInProgress }}</span></div>
        </div>
        <div class="glass-card stats-card">
            <h5>Finished</h5>
            <div class="circle-stat"><span>{{ $finishedCases }}</span></div>
        </div>
    </div>

    <div class="glass-card">
        <div class="chart-header">
            <h4>Monthly Case Trends</h4>
        </div>
        <div style="height: 300px;">
            <canvas id="caseLineChart"></canvas>
        </div>
    </div>

    <div class="charts-main-grid">
        <div class="glass-card">
            <div class="chart-header">
                <h4>Status Distribution</h4>
            </div>
            <div style="height: 300px;">
                <canvas id="statusPieChart"></canvas>
            </div>
        </div>

        <div class="glass-card">
            <div class="chart-header">
                <h4>Cases per Branch</h4>
            </div>
            <div style="height: 300px;">
                <canvas id="branchBarChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // 1. Line Chart
    new Chart(document.getElementById('caseLineChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: {!! json_encode($chartMonths) !!},
            datasets: [{
                label: "Cases",
                data: {!! json_encode($chartData) !!},
                borderColor: "#7d3cff",
                backgroundColor: "rgba(125, 60, 255, 0.1)",
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: "#ffc107" // Aksen kuning di poin
            }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });

    // 2. Pie Chart
    new Chart(document.getElementById('statusPieChart').getContext('2d'), {
        type: 'doughnut', // Doughnut lebih modern daripada Pie biasa
        data: {
            labels: {!! json_encode($statusLabels) !!},
            datasets: [{
                data: {!! json_encode($statusData) !!},
                backgroundColor: ['#4CAF50', '#2196F3', '#FF9800', '#00BCD4', '#F44336', '#95a5a6', '#9C27B0']
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom', labels: { usePointStyle: true, font: { family: 'Plus Jakarta Sans' } } } }
        }
    });

    // 3. Bar Chart
    const barLabels = {!! json_encode($labels) !!};
    new Chart(document.getElementById('branchBarChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: barLabels,
            datasets: [{
                label: 'Total Cases',
                data: {!! json_encode($data) !!},
                backgroundColor: 'rgba(125, 60, 255, 0.8)',
                borderRadius: 8
            }]
        },
        options: { 
            responsive: true, 
            maintainAspectRatio: false,
            indexAxis: 'y', // Bar horizontal biar lebih rapi untuk nama cabang
            plugins: { legend: { display: false } }
        }
    });
});
</script>
@endsection