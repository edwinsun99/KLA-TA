@extends('cs.layout.app')

@section('title', 'Home')

@section('content')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* Dashboard Container */
    .dashboard-wrapper {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }

    /* Welcome Text */
    .welcome-header {
        margin-bottom: 20px;
        font-weight: 700;
        color: #333;
    }

    /* Stats Cards - Gradient Style */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 20px;
        width: 100%;
    }

    .stats-card {
        background: #fff;
        padding: 20px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 10px 20px rgba(106, 13, 173, 0.05);
        border: 1px solid #f0f0f0;
        transition: transform 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-5px);
    }

    .stats-card::before {
        content: "";
        position: absolute;
        top: 0; left: 0; width: 100%; height: 5px;
        background: linear-gradient(90deg, #6a0dad, #ff8c00);
    }

    .stats-title {
        font-size: 0.85rem;
        font-weight: 600;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
    }

    .circle-progress {
        width: 85px;
        height: 85px;
        border-radius: 50%;
        border: 6px solid #f3e5f5; /* Light purple track */
        border-top: 6px solid #6a0dad; /* Purple indicator */
        margin: 10px auto 0;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 0 0 10px rgba(0,0,0,0.02);
    }

    .circle-progress span {
        font-size: 24px;
        font-weight: 800;
        color: #6a0dad;
    }

    /* Charts Section */
    .charts-row {
        display: flex;
        flex-wrap: wrap;
        gap: 25px;
        margin-top: 10px;
    }

    .chart-box {
        background: #fff;
        padding: 25px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        flex: 1;
        min-width: 400px;
    }

    .chart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .chart-header h5 {
        font-weight: 700;
        color: #333;
        margin: 0;
    }
</style>

<h2 class="welcome-header">
    Welcome Back, {{ auth()->user()->username }} 👋
</h2>

<div class="dashboard-wrapper">
    <!-- CARD SUMMARY -->
    <div class="stats-container">
        <div class="stats-card">
            <div class="stats-title">Total Cases</div>
            <div class="circle-progress">
                <span>{{ $totalCases }}</span>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-title">Today's New</div>
            <div class="circle-progress" style="border-top-color: #ff8c00;">
                <span style="color: #ff8c00;">{{ $newCasesToday }}</span>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-title">Repair Progress</div>
            <div class="circle-progress">
                <span>{{ $casesInProgress }}</span>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-title">Finished</div>
            <div class="circle-progress" style="border-top-color: #4CAF50;">
                <span style="color: #4CAF50;">{{ $finishedCases }}</span>
            </div>
        </div>
    </div>

    <!-- LINE CHART -->
    <div class="charts-row">
        <div class="chart-box" style="flex: 2;">
            <div class="chart-header">
                <h5>Monthly Case Trends</h5>
                <i class="bi bi-graph-up text-muted"></i>
            </div>
            <div style="height: 300px;">
                <canvas id="caseLineChart"></canvas>
            </div>
        </div>

        <!-- PIE CHART -->
        <div class="chart-box" style="flex: 1;">
            <div class="chart-header">
                <h5>Status Distribution</h5>
                <i class="bi bi-pie-chart text-muted"></i>
            </div>
            <div style="height: 300px;">
                <canvas id="statusDoughnutChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // --- Line Chart Configuration ---
        const lineCtx = document.getElementById('caseLineChart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartMonths) !!},
                datasets: [{
                    label: "Cases",
                    data: {!! json_encode($chartData) !!},
                    borderWidth: 4,
                    borderColor: "#6a0dad",
                    backgroundColor: (context) => {
                        const chart = context.chart;
                        const {ctx, chartArea} = chart;
                        if (!chartArea) return null;
                        const gradient = ctx.createLinearGradient(0, chartArea.bottom, 0, chartArea.top);
                        gradient.addColorStop(0, "rgba(106, 13, 173, 0)");
                        gradient.addColorStop(1, "rgba(106, 13, 173, 0.2)");
                        return gradient;
                    },
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: "#fff",
                    pointBorderColor: "#6a0dad",
                    pointBorderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { grid: { display: false }, beginAtZero: true },
                    x: { grid: { display: false } }
                }
            }
        });

        // --- Doughnut Chart Configuration (The "Keren" Version) ---
        const statusLabels = {!! json_encode($statusLabels) !!};
        const statusData   = {!! json_encode($statusData) !!};
        const pieCtx = document.getElementById('statusDoughnutChart').getContext('2d');

        new Chart(pieCtx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusData,
                    backgroundColor: [
                        '#6a0dad', // Ungu (New)
                        '#ff8c00', // Orange (Progress)
                        '#9c27b0', // Light Purple
                        '#ffd700', // Gold
                        '#f44336', // Red
                        '#b0bec5', // Grey
                        '#4CAF50'  // Green
                    ],
                    hoverOffset: 20,
                    borderWidth: 5,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '70%', // Membuat lubang di tengah lebih besar (Modern)
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 12 }
                        }
                    }
                }
            }
        });
    });
</script>

@endsection