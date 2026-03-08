<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
<title>RFID Dashboard</title>
<link rel="stylesheet" href="style.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="dashboard-page">

<div class="dashboard-container">

    <!-- SIDEBAR -->
    <div class="sidebar">

        <div class="sidebar-logo">
            <img src="bg3.jpg">
            <h2>Jaen National High School</h2>
        </div>

        <ul>
            <li class="active" onclick="showSection(event,'dashboard')">Dashboard</li>
            <li onclick="showSection(event,'analytics')">Analytics</li>
            <li onclick="showSection(event,'students')">Students</li>
            <li onclick="showSection(event,'reports')">Reports</li>
            <li onclick="showSection(event,'settings')">Settings</li>
        </ul>

        <a href="logout.php" class="logout-btn">Logout</a>

    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">

        <div class="topbar">
            <h3>
                Integrated RFID and SMS Tracking System for Student Attendance  
                <br>Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>
            </h3>
        </div>

        <!-- DASHBOARD -->
        <div id="dashboard" class="section">

            <div class="stats-row">
                <div class="stat-card blue">
                    <h4>New Students</h4>
                    <p id="newStudents">0</p>
                </div>

                <div class="stat-card red">
                    <h4>Total Absent</h4>
                    <p id="totalAbsent">0</p>
                </div>

                <div class="stat-card orange">
                    <h4>Total Present</h4>
                    <p id="totalPresent">0</p>
                </div>

                <div class="stat-card green">
                    <h4>RFID Logs</h4>
                    <p id="rfidLogs">0</p>
                </div>
            </div>

            <div class="content-row">
                <div class="chart-box">
                    <h4>Attendance Overview</h4>
                    <canvas id="attendanceChart"></canvas>
                </div>

                <div class="progress-box">
                    <h4>Attendance Rate</h4>
                    <div class="circle" id="attendanceCircle">
                        <span id="attendancePercent">0%</span>
                    </div>
                    <p class="progress-label">Monthly Attendance Target</p>
                </div>
            </div>

        </div>

        <!-- ANALYTICS -->
        <div id="analytics" class="section" style="display:none">
            <div class="content-row">
                <div class="chart-box">
                    <h4>Monthly Attendance Analytics</h4>
                    <canvas id="analyticsChart"></canvas>
                </div>

                <div class="progress-box">
                    <h4>Attendance Performance</h4>
                    <div class="circle">
                        <span>40</span>
                    </div>
                    <p class="progress-label">Overall School Attendance</p>
                </div>
            </div>
        </div>

        <!-- STUDENTS -->
        <div id="students" class="section" style="display:none">
            <div class="chart-box">
                <h4>Student List</h4>
                <table width="100%">
                    <tr>
                        <th>RFID</th>
                        <th>Name</th>
                        <th>Grade</th>
                        <th>Status</th>
                    </tr>
                    <tr>
                        <td>1001</td>
                        <td>Juan Dela Cruz</td>
                        <td>Grade 10</td>
                        <td>Present</td>
                    </tr>
                    <tr>
                        <td>1002</td>
                        <td>Maria Santos</td>
                        <td>Grade 9</td>
                        <td>Absent</td>
                    </tr>
                    <tr>
                        <td>1003</td>
                        <td>Pedro Reyes</td>
                        <td>Grade 8</td>
                        <td>Present</td>
                    </tr>
                </table>
            </div>
        </div>

        <!-- REPORTS -->
        <div id="reports" class="section" style="display:none">
            <div class="chart-box">
                <h4>Attendance Reports</h4>
                <p>Generate and download attendance reports.</p>
                <br>
                <button class="login-button">Download Daily Report</button>
                <br><br>
                <button class="login-button">Download Monthly Report</button>
            </div>
        </div>

        <!-- SETTINGS -->
        <div id="settings" class="section" style="display:none">
            <div class="chart-box">
                <h4>System Settings</h4>
                <br>
                <label>School Name</label>
                <br>
                <input type="text" value="Jaen National High School">
                <br><br>
                <label>SMS Notification</label>
                <br>
                <select>
                    <option>Enabled</option>
                    <option>Disabled</option>
                </select>
                <br><br>
                <button class="login-button">Save Settings</button>
            </div>
        </div>

    </div>
</div>

<script>
/* SIDEBAR NAVIGATION */
function showSection(event,sectionId){
    document.querySelectorAll('.section').forEach(sec => sec.style.display='none');
    document.getElementById(sectionId).style.display='block';
    document.querySelectorAll('.sidebar ul li').forEach(li => li.classList.remove('active'));
    event.target.classList.add('active');
}

/* SAMPLE DATA */
let present = 20;
let absent = 30;
let students = 50;
let logs = 20;

/* UPDATE STATS */
document.getElementById("newStudents").innerText = students;
document.getElementById("totalAbsent").innerText = absent;
document.getElementById("totalPresent").innerText = present;
document.getElementById("rfidLogs").innerText = logs;

/* ATTENDANCE RATE */
let rate = Math.round((present / students) * 100);
document.getElementById("attendancePercent").innerText = rate + "%";
document.getElementById("attendanceCircle").style.background =
"conic-gradient(#4e73df "+rate+"%, #e5e7eb 0%)";

/* DASHBOARD CHART */
const ctx = document.getElementById('attendanceChart');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sept','Oct','Nov','Dec'],
        datasets: [{
            label:'Present Students',
            data:[10,47,23,31,40],
            backgroundColor:'#4e73df'
        }]
    },
    options:{ responsive:true, plugins:{legend:{display:false}} }
});

/* ANALYTICS CHART */
const analytics = document.getElementById('analyticsChart');
new Chart(analytics, {
    type:'line',
    data:{
        labels:['Week1','Week2','Week3','Week4'],
        datasets:[{
            label:'Attendance Rate',
            data:[75,82,78,90],
            borderColor:'#4e73df',
            fill:false
        }]
    },
    options:{ responsive:true, plugins:{legend:{display:false}} }
});
</script>

</body>
</html>
