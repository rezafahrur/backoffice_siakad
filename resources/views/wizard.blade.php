<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Wizard with Progress Bar</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .tab {
            display: none;
        }

        .step {
            width: 33.33%;
            float: left;
            text-align: center;
            font-size: 18px;
            padding: 10px 0;
            color: #6c757d;
        }

        .step.active {
            color: #007bff;
            font-weight: bold;
        }

        .progress-bar {
            transition: width 0.3s;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <h2 class="text-center">Form Wizard with Progress Bar</h2>
        <div class="progress mt-4">
            <div class="progress-bar" role="progressbar" style="width: 33.33%;" id="progressBar"></div>
        </div>
        <div class="row mt-3">
            <div class="col step active">Step 1</div>
            <div class="col step">Step 2</div>
            <div class="col step">Step 3</div>
        </div>
        <form id="formWizard" class="mt-5">
            <!-- Step 1 -->
            <div class="tab">
                <h3>Step 1</h3>
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="name" required>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="tab">
                <h3>Step 2</h3>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" required>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="tab">
                <h3>Step 3</h3>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" class="form-control" id="phone" required>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div style="overflow:auto;" class="mt-4">
                <div style="float:right;">
                    <button type="button" class="btn btn-secondary" id="prevBtn"
                        onclick="nextPrev(-1)">Previous</button>
                    <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Next</button>
                </div>
            </div>
        </form>
    </div>

    <!-- Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        var currentTab = 0;
        showTab(currentTab);

        function showTab(n) {
            var x = document.getElementsByClassName("tab");
            x[n].style.display = "block";
            document.getElementById("prevBtn").style.display = n == 0 ? "none" : "inline";
            document.getElementById("nextBtn").innerHTML = n == (x.length - 1) ? "Submit" : "Next";
            updateProgressBar(n);
        }

        function nextPrev(n) {
            var x = document.getElementsByClassName("tab");
            if (n == 1 && !validateForm()) return false;
            x[currentTab].style.display = "none";
            currentTab = currentTab + n;
            if (currentTab >= x.length) {
                document.getElementById("formWizard").submit();
                return false;
            }
            showTab(currentTab);
        }

        function validateForm() {
            var x, y, i, valid = true;
            x = document.getElementsByClassName("tab");
            y = x[currentTab].getElementsByTagName("input");
            for (i = 0; i < y.length; i++) {
                if (y[i].value == "") {
                    y[i].className += " is-invalid";
                    valid = false;
                }
            }
            return valid;
        }

        function updateProgressBar(n) {
            var steps = document.getElementsByClassName("step");
            var progressBar = document.getElementById("progressBar");
            for (var i = 0; i < steps.length; i++) {
                steps[i].className = steps[i].className.replace(" active", "");
            }
            steps[n].className += " active";
            progressBar.style.width = ((n + 1) / steps.length) * 100 + "%";
        }
    </script>

</body>

</html>
