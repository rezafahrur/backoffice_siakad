@extends('layouts.custom')

@section('title', 'Form Wizard')

@section('content')
    {{-- Start logo and back --}}
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href=""><i class="bi bi-chevron-left"></i></a>
            <a class="navbar-brand ms-4" href="">
                <img style="height: 50px" src="{{ asset('assets/img/logo/logo.png') }}">
            </a>
        </div>
    </nav>
    {{-- End logo and back --}}

    <div class="card-header">
        <h4 class="card-title">Form Wizard</h4>
    </div>
    <div class="card-body">
        <!-- Progress Bar -->
        <div class="row text-center">
            <div class="col step active" id="step1">
                <div class="step-icon">1</div>
                <div class="step-title">Step 1</div>
            </div>
            <div class="col step" id="step2">
                <div class="step-icon">2</div>
                <div class="step-title">Step 2</div>
            </div>
            <div class="col step" id="step3">
                <div class="step-icon">3</div>
                <div class="step-title">Step 3</div>
            </div>
        </div>

        <form id="formWizard" class="mt-4">
            <!-- Step 1 -->
            <div class="tab">
                <h3>Step 1</h3>
                <div class="mb-3">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="tab">
                <h3>Step 2</h3>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="tab">
                <h3>Step 3</h3>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone:</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="navigation-buttons mt-4">
                <button type="button" class="btn btn-secondary" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                <button type="button" class="btn btn-primary" id="nextBtn" onclick="nextPrev(1)">Next</button>
            </div>
        </form>
    </div>
@endsection

@push('styles')
    <style>
        .step {
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
        }

        .step-icon {
            background-color: #1e1e2d;
            border-radius: 50%;
            padding: 10px;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .step-title {
            margin-top: 5px;
        }

        .step::after {
            content: '';
            position: absolute;
            top: 15px;
            width: 100%;
            height: 2px;
            background-color: #c2c2d9;
            z-index: -1;
            left: 50%;
            transform: translateX(-50%);
        }

        .step:last-child::after {
            display: none;
        }

        .step.active::after {
            background-color: #c2c2d9;
        }

        .step.active .step-icon {
            background-color: #c2c2d9;
            color: #1e1e2d;
        }

        .tab {
            display: none;
        }

        .tab.active {
            display: block;
        }
    </style>
@endpush

@push('scripts')
    <script>
        var currentTab = 0;
        showTab(currentTab);

        function showTab(n) {
            var tabs = document.getElementsByClassName("tab");
            var steps = document.getElementsByClassName("step");

            // Hide all tabs
            for (var i = 0; i < tabs.length; i++) {
                tabs[i].style.display = "none";
            }

            // Remove active class from all steps
            for (var i = 0; i < steps.length; i++) {
                steps[i].classList.remove("active");
            }

            // Show the current tab
            tabs[n].style.display = "block";

            // Add active class to the current step
            steps[n].classList.add("active");

            // Update navigation buttons
            document.getElementById("prevBtn").style.display = n == 0 ? "none" : "inline";
            document.getElementById("nextBtn").innerHTML = n == (tabs.length - 1) ? "Submit" : "Next";
        }

        function nextPrev(n) {
            var tabs = document.getElementsByClassName("tab");

            // Validate the current form
            if (n == 1 && !validateForm()) return false;

            // Hide the current tab
            tabs[currentTab].style.display = "none";

            // Move to the next or previous tab
            currentTab = currentTab + n;

            // If at the end, submit the form
            if (currentTab >= tabs.length) {
                document.getElementById("formWizard").submit();
                return false;
            }

            // Show the new tab
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
                } else {
                    y[i].classList.remove("is-invalid");
                }
            }
            return valid;
        }
    </script>
@endpush
