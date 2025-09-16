<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>vsofts solutions</title>
  
    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet"href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>


    <!-- Libraries Stylesheet -->
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/projects.css" rel="stylesheet">
 
   
</head>
<body>
    <!-- Navbar Start -->
     <?php include 'navbar.php'; ?>

     <!-- Navbar End -->
<script>
        function updateDomains() {
            const branch = document.getElementById("branch").value;
            const domainSelect = document.getElementById("domain");

            // Clear old options
            domainSelect.innerHTML = "<option value=''>Select Domain</option>";

            let domains = [];

            if(branch === "CSE"){
                domains = ["AI", "Web Development", "Data Science"];
            } else if(branch === "ECE"){
                domains = ["Embedded Systems", "IoT", "VLSI",];
            } else if(branch === "EEE"){
                domains = ["Power Systems", "Control Systems", "IoT"];
            } else if(branch === "Civil"){
                domains = ["Structural Engineering", "Construction", "GIS"];
            } else if(branch === "Mech"){
                domains = ["CAD/CAM", "Robotics", "Thermal Engineering"];
            } else if(branch === "MBA"){
                domains = ["Finance", "Marketing", "HR"];
            }

            domains.forEach(function(domain){
                let opt = document.createElement("option");
                opt.value = domain;
                opt.textContent = domain;
                domainSelect.appendChild(opt);
            });
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>PROJECTS</h2>
        <form method="POST">
            <select name="degree" required>
                <option value="">Select Degree</option>
                <option value="BTech">BTech</option>
                <option value="MTech">MTech</option>
                <option value="MCA">MCA</option>
                <option value="MBA">MBA</option>
            </select>

            <select name="branch" id="branch" onchange="updateDomains()" required>
                <option value="">Select Branch</option>
                <option value="CSE">CSE</option>
                <option value="ECE">ECE</option>
                <option value="EEE">EEE</option>
                <option value="Civil">Civil</option>
                <option value="Mech">Mech</option>

            </select>

            <select name="project_type" required>
                <option value="">Select Project Type</option>
                <option value="Mini">Mini Project</option>
                <option value="Major">Major Project</option>
            </select>

            <select name="domain" id="domain" required>
                <option value="">Select Domain</option>
            </select>

            <button type="submit" name="submit">Submit</button>
        </form>

        <?php
        if(isset($_POST['submit'])){
            echo "<table>
                    <tr>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Technologies</th>
                        <th>File Path</th>
                    </tr>";

            // Example data set (this can come from DB later)
            $projects = [
                ["AI Based Chatbot", "Smart chatbot using AI", "Python, ML, NLP", "files/chatbot.zip"],
                ["Web Portal", "Responsive web app", "PHP, MySQL, JS", "files/webportal.zip"],
                ["IoT Automation", "Home automation using IoT", "Arduino, Sensors", "files/iot.zip"],
                ["Structural Analysis", "Civil engineering project", "AutoCAD, STAAD Pro", "files/structural.zip"],
                ["Robotics Arm", "Mechanical arm prototype", "SolidWorks, C++", "files/robotics.zip"],
            ];

            foreach($projects as $p){
                echo "<tr>
                        <td>".$p[0]."</td>
                        <td>".$p[1]."</td>
                        <td>".$p[2]."</td>
                        <td>".$p[3]."</td>
                      </tr>";
            }

            echo "</table>";
        }
        ?>
    </div>
    <!-- Footer Start -->
    
    <?php include 'footer.php'; ?>

    <!-- Footer End -->

</body>
</html>