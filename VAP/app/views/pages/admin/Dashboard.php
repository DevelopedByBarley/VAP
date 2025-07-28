<?php
$usersData = $params["usersData"];;
$countOfUsers = $usersData["countOfUsers"] ?? 0;
?>

<div class="container" style="margin-top: 80px;">
	<div class="row">
		<div class="col-12 shadow p-lg-5 rounded" style="margin-bottom: 60px;">
			<h1 class="display-5 pr-color text-light p-4 rounded rounded-pill">
				Hello admin!
			</h1>
			<div class="my-3">
				<b>Üdvözöllek a vezérlőpultban. Ezen az oldalon napra kész lehetsz a weboldalt érintő adatokkal, többek között a profilok számával, hogy melyik hónapban hányan regisztráltak, ebből hányan jelentkeztek valamely eseményre stb.</b>
			</div>
		</div>

		<div class="bg-info text-light p-5 rounded shadow">
			<h1 class="display-6 text-center">Regisztrált profilok száma: <b><span style="font-size: 3.2rem"><?= $usersData["countOfUsers"] ?></span></b></h1>
		</div>

		<div class="col-12 my-5" data-users='<?= json_encode($usersData) ?>'>
			<h3 class="text-center">
				<b>Ebből az alábbi hónapokban <span class="text-danger">profilnak</span> regisztráltak:</b>
			</h3>
			<hr>
			<canvas id="monthChart"></canvas>
		</div>
	</div>
	<div class="row">
		
		<div class="offset-1 col-10 col-sm-4 offset-sm-1 text-center mt-sm-5">
			<h3 class="mt-5">
				<b>Az összes <span class="text-danger">regisztrált profil</span>
					<span class="text-info" style="font-size: 1.5rem">
						<?= $countOfUsers > 0 ? number_format(($usersData["userWithSub"] / $usersData["countOfUsers"]) * 100, 2) : '' ?> %
					</span>-a jelentkezett már valamely eseményre</b>
			</h3>
			<hr>
			<canvas id="eventMonthChart"></canvas>
		</div>
		<div class="offset-1 col-10 col-sm-4  offset-sm-1 text-center mt-5">
			<h3 class="mt-5">
				<b>Ebben a hónapban <span class="text-danger">profilt regisztráltak</span> száma
					<span class="text-info" style="font-size: 1.5rem">
						<?= $countOfUsers > 0 ? number_format(($usersData["currentMonthReg"] / $usersData["countOfUsers"]) * 100, 2) : '' ?> %
					</span>-a az összes profilnak.</b>
			</h3>
			<hr>
			<canvas id="currentMonthChart"></canvas>
		</div>
		<div class="col-12 offset-sm-0 text-center mt-sm-5">
			<h3 class="mt-5">
				<b><span class="text-danger">User</span> statisztikák</b>
			</h3>
			<hr>
			<canvas id="profileRatioChart"></canvas>
		</div>

		<div class="col-12 col-sm-7 offset-lg-2 mt-5 ">
			<h3 class="mt-5 text-center">
				<b>Összes felhasználó eseményenkénti regisztrációja</b>
				</p>
				<canvas id="eventSubsChart" class="w-100"></canvas>
		</div>
	</div>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
	const profileRatioChart = document.getElementById('profileRatioChart');

	const ctx = document.getElementById('monthChart');


	const usersData = JSON.parse(ctx.parentElement.getAttribute('data-users'));
	const months = usersData.months;
	const usersWithSub = usersData.userWithSub;
	const usersWithoutSub = usersData.userWithoutSub;
	const currentMonthReg = usersData.currentMonthReg;
	const notCurrentMonthReg = usersData.notCurrentMonthReg;




	new Chart(profileRatioChart, {
		type: 'bar',
		data: {
			labels: [
				'Összes user',
				'Profil nélküli userek',
				'Profillal rendelkező userek'
			],
			datasets: [{
				label: '',
				data: [
					usersData.profileRatio.eventRegWithoutProfile + usersData.countOfUsers,
					usersData.profileRatio.eventRegWithoutProfile,
					usersData.countOfUsers
				],
				backgroundColor: [
					'rgb(10, 70, 100)',
					'rgb(102, 255, 153)',
					'rgb(255, 102, 255)',
				],
				hoverOffset: 4
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});







	new Chart(ctx, {
		type: 'line',
		data: {
			labels: ['Január', 'Február', 'Március', 'Április', 'Május', 'Júnus', 'Július', 'Augusztus', 'Szeptember', 'Október', 'November', 'December'],
			datasets: [{
				label: 'Regisztrált',
				data: [months.Jan, months.Feb, months.Mar, months.Apr, months.May, months.Jun, months.Aug, months.Sep, months.Oct, months.Nov, months.Dec],
				borderWidth: 1
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});

	const eventMonthChart = document.getElementById('eventMonthChart');


	new Chart(eventMonthChart, {
		type: 'doughnut',
		data: {
			labels: [
				'Eseményre regisztrált profilok',
				'Eseményre regisztrálatlan profilok'
			],
			datasets: [{
				label: 'Regisztráltak száma:',
				data: [usersWithoutSub, usersWithSub],
				backgroundColor: [
					'rgb(102, 255, 153)',
					'rgb(255, 102, 255)',
				],
				hoverOffset: 4
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});

	const currentMonthChart = document.getElementById('currentMonthChart');
	const eventsWithSubs = usersData.eventSubs;



	new Chart(currentMonthChart, {
		type: 'doughnut',
		data: {
			labels: [
				'Más hónapban regisztráltak',
				'Ebben a hónapban regisztrált profilok'
			],
			datasets: [{
				label: 'Regisztráltak száma:',
				data: [notCurrentMonthReg, currentMonthReg],
				backgroundColor: [
					'rgb(102, 102, 255)',
					'rgb(255, 102, 0)',
				],
				hoverOffset: 4
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});


	const eventSubsChart = document.getElementById('eventSubsChart');
	const labels = [];
	const data = [];

	usersData.eventSubs.forEach(event => {
		labels.push(event.nameInHu)
		data.push(event.registrationCount)
	});

	if(usersData.userWithoutSub !== 0) {
		labels.unshift('Userek akik még nem regisztráltak eseményre');
		data.unshift(usersData.userWithoutSub);
	}


	new Chart(eventSubsChart, {
		type: 'polarArea',
		data: {
			labels: labels,
			datasets: [{
				label: 'Feliratkozások',
				data: data,
				backgroundColor: [
					usersData.userWithoutSub !== 0 ? 'rgb(201, 203, 207)' : 'rgb(255, 99, 132)',
					'rgb(255, 99, 132)',
					'rgb(75, 192, 192)',
					'rgb(255, 205, 86)',
					'rgb(204, 51, 255)',
					'rgb(0, 153, 204)',
					'rgb(255, 153, 51)',
				]
			}]
		},
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>