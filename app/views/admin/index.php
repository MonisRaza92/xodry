<!DOCTYPE html>
<html lang="en">

<head>
	<?php include_once __DIR__ . '/../includes/Header.php' ?>
	<title>Xodry Admin Dashboard - Affordable Laundry & Dry Cleaning in Delhi</title>
</head>

<body>
	<?php include_once __DIR__ . '/../includes/Navbar.php' ?>
	<div class="container-fluid pb-5">
		<div class="container px-lg-0">
			<div class="row">
				<div class="col-lg-3 position-relative">
					<?php include_once __DIR__ . '/partials/adminSidebar.php' ?>
				</div>
				<div class="col-lg-9 col-12">
					<?php $pageName = "Dashboard";
					include_once __DIR__ . '/../includes/breadcrumb.php' ?>
					<?php include_once __DIR__ . '/partials/adminStats.php' ?>



				</div>
			</div>
		</div>
	</div>





	<?php include_once __DIR__ . '/../includes/Footer.php' ?>
	<script>
		const ctr = document.getElementById('myChart').getContext('2d');

		const myChart = new Chart(ctr, {
			type: 'line', // chart type
			data: {
				labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
				datasets: [{
						label: 'Orders',
						data: [3, 6, 2, 1, 6, 2, 1],
						backgroundColor: 'rgba(39, 91, 56, 0.8)',
						borderColor: '#fff',
						borderRadius: 5,
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
						borderRadius: 5,
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
							color: '#fff',
						},
						beginAtZero: true,
						grid: {
							color: 'grey',
						},
					},
					x: {
						ticks: {
							color: '#fff',
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
	</script>
</body>

</html>