<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Bar Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
</head>

<body>
    <canvas id="myChart"></canvas>
    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {

            type: 'bar',
            data: {
                labels: ['Entertainment', 'Talk', 'Seminar', 'Workshop'],
                datasets: [{
                    label: 'Total Attendance According to The Events Category',
                    <?php
                        require 'Connection.php';
                        $conn = new Connection('uitmeas');
                        $entertainment = $conn->query("SELECT count(attid) FROM attendance a JOIN event b ON a.eventid=b.eventid WHERE b.category = 'entertainment'", []);
                        $talk = $conn->query("SELECT count(attid) FROM attendance a JOIN event b ON a.eventid=b.eventid WHERE b.category = 'talk'", []);
                        $seminar = $conn->query("SELECT count(attid) FROM attendance a JOIN event b ON a.eventid=b.eventid WHERE b.category = 'seminar'", []);
                        $workshop = $conn->query("SELECT count(attid) FROM attendance a JOIN event b ON a.eventid=b.eventid WHERE b.category = 'workshop'", []);
                        print_r('data: ['.$entertainment[0][0].','.$talk[0][0].', '.$seminar[0][0].','.$workshop[0][0].'],');
                    ?>
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    </script>
</body>

</html>