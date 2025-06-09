const ctr = document.getElementById('myChart').getContext('2d');

const myChart = new Chart(ctr, {
    type: 'line', // chart type
    data: {
        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
        datasets: [
            {
                label: 'Orders',
                data: [3, 6, 2, 1, 6, 2, 1],
                backgroundColor: 'rgba(39, 91, 56, 0.8)',
                borderColor: '#fff',
                borderRadius:5,
                borderWidth: 2,
                color: '#fff',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#1F7D53'
            },
            {
                label: 'Page Views',
                data: [12, 19, 8, 11, 9, 15, 9],
                backgroundColor: 'rgba(39, 91, 56, 0.4)',
                borderColor: '#fff',
                borderRadius:5,
                borderWidth: 2,
                color: '#fff',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#1F7D53'
            },
        ],
    },
    options: {
        animation: {
            duration: 1200,
            easing: 'easeInOutQuart'
          },
        scales: {
            y: {
                ticks: {
                  color:'#fff',  
                },
                beginAtZero: true,
                grid: {
                    color:'grey',
                },
            },
            x: {
                ticks: {
                  color:'#fff',  
                },
                beginAtZero: true,
                grid: {
                    color: 'grey',
                },
            },
        },
        responsive: true,
        plugins: {
            legend: {
                display: true,
                position: 'top',
                labels: {
                    color: '#fff'
                }
            },
            tooltip: {
                enabled: true,
                bodyColor: '#fff',
                backgroundColor: '#000',
                titleColor: '#fff'
            }
        }
    }
});
