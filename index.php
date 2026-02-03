<?php
session_start();

// connect database
require 'db_connect.php'; 

// searching jobs from database
$sql = "SELECT * FROM jobs WHERE 1=1";

// select keyword
if (isset($_GET['keyword']) && !empty($_GET['keyword'])) {
    $keyword = mysqli_real_escape_string($conn, $_GET['keyword']); // prevent SQL injection
    $sql .= " AND title LIKE '%$keyword%'";
}

// select location
if (isset($_GET['location']) && !empty($_GET['location'])) {
    $location = mysqli_real_escape_string($conn, $_GET['location']);
    $sql .= " AND location = '$location'";
}

$sql .= " ORDER BY created_at DESC"; // latest time at front
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JobSeeker - Home</title>
    <link rel="stylesheet" href="system.css">
</head>
<body>

    <nav>
        <div class="container">
            <h1>JobSeeker</h1>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about_us.php">About Us</a></li>

                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="dashboard.php?logout=true" style="color: #ff6b6b;">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="register.php">Sign Up</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="search-bar-container">
        <form action="index.php" method="GET">
            <input type="text" name="keyword" class="search-input" placeholder="Enter keywords (e.g. Software Engineer)" value="<?php echo isset($_GET['keyword']) ? $_GET['keyword'] : ''; ?>">
            
            <select name="location" class="search-input" style="width: 200px; margin-left: 10px;">
                <option value="">All Locations</option>
                <optgroup label="Federal Territories">
                    <option value="Kuala Lumpur">Kuala Lumpur</option>
                    <option value="Putrajaya">Putrajaya</option>
                    <option value="Labuan">Labuan</option>
                </optgroup>
                <optgroup label="States">
                    <option value="Johor">Johor</option>
                    <option value="Kedah">Kedah</option>
                    <option value="Kelantan">Kelantan</option>
                    <option value="Melaka">Melaka</option>
                    <option value="Negeri Sembilan">Negeri Sembilan</option>
                    <option value="Pahang">Pahang</option>
                    <option value="Perak">Perak</option>
                    <option value="Perlis">Perlis</option>
                    <option value="Pulau Pinang">Pulau Pinang</option>
                    <option value="Sabah">Sabah</option>
                    <option value="Sarawak">Sarawak</option>
                    <option value="Selangor">Selangor</option>
                    <option value="Terengganu">Terengganu</option>
                </optgroup>
            </select>
            <button type="submit" class="search-btn">Search</button>
        </form>
    </div>

    <div class="main-layout">
        <div class="job-list-column">
            
            <?php
            // check if there are results
            if (mysqli_num_rows($result) > 0) {
                // have data start loop
                while($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="job-card" onclick="showJob('job<?php echo $row['id']; ?>', this)">
                    <h4><?php echo $row['title']; ?></h4>
                    <div class="company"><?php echo $row['company']; ?></div>
                    <div class="location">📍 <?php echo $row['location']; ?></div>
                    <p style="font-size: 0.9em; color: #666;">
                        <?php echo substr($row['description'], 0, 80) . '...'; ?>
                    </p>
                    <small style="color: #999;">Posted recently</small>
                </div>

            <?php 
                }
            } else {
                // if no data
                echo "<div style='text-align:center; padding:20px;'>No jobs found. Try another search!</div>";
            }
            ?>

        </div>

        <div class="job-preview-column" id="preview-panel">
            <div id="placeholder" class="placeholder-content">
                <img src="https://via.placeholder.com/100" style="opacity: 0.5; margin-bottom: 20px;">
                <h3>Select a job to view details</h3>
                <p>Click on any job card from the left to see full details here.</p>
            </div>

            <?php
            // show detailed job descriptions
            mysqli_data_seek($result, 0);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
            ?>
                <div id="job<?php echo $row['id']; ?>" class="detail-content">
                    <h2 style="color: #333;"><?php echo $row['title']; ?></h2>
                    <h4 style="color: #666;"><?php echo $row['company']; ?></h4>
                    <div class="location">📍 <?php echo $row['location']; ?></div>
                    <hr style="border: 0; border-top: 1px solid #eee; margin: 20px 0;">
                    
                    <p><strong>Job Description:</strong></p>
                    <p><?php echo nl2br($row['description']); ?></p>
                    
                    <br>
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <button class="search-btn" style="width: 100%;" onclick="alert('Applied successfully!')">Apply Now</button>
                    <?php else: ?>
                        <a href="login.php" class="search-btn" style="display:block; text-align:center; width: 100%;">Login to Apply</a>
                    <?php endif; ?>
                </div>
            <?php
                }
            }
            ?>

        </div>
    </div>

    <script>
        function showJob(jobId, cardElement) {
            var contents = document.getElementsByClassName('detail-content');
            for (var i = 0; i < contents.length; i++) {
                contents[i].classList.remove('active');
            }
            document.getElementById('placeholder').style.display = 'none';
            var selectedJob = document.getElementById(jobId);
            if(selectedJob) {
                selectedJob.classList.add('active');
            }
            var cards = document.getElementsByClassName('job-card');
            for (var j = 0; j < cards.length; j++) {
                cards[j].classList.remove('active');
            }
            cardElement.classList.add('active');
        }
    </script>

</body>
</html>
