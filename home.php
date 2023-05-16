<?php 
include 'admin/db_connect.php'; 
?>
<style>
    #portfolio .img-fluid{
        width:100%
    }

    /* Style the accordion panels */

    .panel {
    border-bottom: 1px solid #ccc;
    }

    .panel-header {
    cursor: pointer;
    padding: 10px;
    background-color: #f7f7f7;
    display: flex;
    align-items: center;
    }

    .panel-header:hover {
    background-color: #e7e7e7;
    }

    .panel-title {
    margin-left: 10px;
    }

    .panel-content {
    display: none;
    padding: 10px;
    background-color: #ffffff;
    }

    #menu{
        margin-top:-80px;
    }

    #menu img{
        width: 50px;
        height: 50px;
    }

    #portfolio{
        margin-top:-80px;
    }

</style>

        <header class="masthead">
            <div class="container h-100">
                <div class="row h-100 align-items-center justify-content-center text-center">
                    <div class="col-lg-10 align-self-end mb-4 page-title">
                    	<h3 class="text-white">Welcome to <?php echo $_SESSION['setting_name']; ?></h3>
                        <hr class="divider my-4" />
                        <a class="btn btn-primary btn-xl js-scroll-trigger" href="index.php?page=doctors">Find a Doctor</a>
                    </div>
                </div>
            </div>
        </header>

        <section class="page-section" id="menu">
            <div class="accordion">
                <div class="row">
                    <div class="col-lg-12 text-center">
                    <h2 class="mb-4">Medical Specialties</h2>
                    <hr class="divider">
                    </div>
                </div>
                <?php
                // Query the medical_specialty table to fetch the specialties
                $query = "SELECT * FROM medical_specialty";
                $result = mysqli_query($conn, $query);

                // Generate an accordion panel for each specialty
                while ($row = mysqli_fetch_assoc($result)) {
                    $specialtyId = $row['id'];
                    $specialtyName = $row['name'];
                    $specialtyImagePath = $row['img_path'];
                    $specialtyDescription = $row['description'];

                    echo '<div class="panel">';
                    echo '<div class="panel-header" onclick="togglePanel(event, ' . $specialtyId . ')">';
                    echo '<img src="assets/img/' . $specialtyImagePath . '" alt="' . $specialtyName . '">';
                    echo '<span class="panel-title">' . $specialtyName . '</span>';
                    echo '</div>';
                    echo '<div class="panel-content" id="panel-content-' . $specialtyId . '">';
                    // Display a loading message while fetching the description
                    echo '<p id="loading-' . $specialtyId . '">' . $specialtyDescription . '</p>';
                    echo '</div>';
                    echo '</div>';
                }
                ?> 
            </div>
        </section>




    <div id="portfolio" class="container">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-lg-12 text-center">
                    <h2 class="mb-4">Make Your Appointment</h2>
                    <hr class="divider">
                    </div>
                </div>
                <div class="row no-gutters">
                    <?php
                    $cats = $conn->query("SELECT * FROM medical_specialty order by id asc");
                                while($row=$cats->fetch_assoc()):
                    ?>
                    <div class="col-lg-4 col-sm-6">
                        <a class="portfolio-box" href="index.php?page=doctors&sid=<?php echo $row['id'] ?>">
                            <img class="img-fluid" src="assets/img/<?php echo $row['img_path'] ?>" alt="" />
                            <div class="portfolio-box-caption">
                                <div class="project-name"><?php echo $row['name'] ?></div>
                                <div class="project-category text-white">Find Doctor</div>
                            </div>
                        </a>
                    </div>
                    <?php endwhile; ?>
                    
                </div>
            </div>
    </div>
    
    
    <script>
        function togglePanel(event, specialtyId) {
    const panelContent = document.getElementById('panel-content-' + specialtyId);
    const loadingMessage = document.getElementById('loading-' + specialtyId);

    // If the panel is already open, close it
    if (panelContent.style.display === 'block') {
        panelContent.style.display = 'none';
    } else {
        // If the panel is closed, fetch the description and display it
        panelContent.style.display = 'block';
        loadingMessage.style.display = 'block';

        // Make an AJAX request to fetch the description
        const xhr = new XMLHttpRequest();
        xhr.open('GET', 'fetch_description.php?specialtyId=' + specialtyId, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Update the panel content with the fetched description
                loadingMessage.style.display = 'none';
                panelContent.innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }
}
    </script>
	
