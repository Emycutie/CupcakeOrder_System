<?php
include('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = isset($_POST["first-name"]) ? $_POST["first-name"] : "";
    $lastName = isset($_POST["last-name"]) ? $_POST["last-name"] : "";
    $day = isset($_POST["day"]) ? $_POST["day"] : "";
    $month = isset($_POST["month"]) ? $_POST["month"] : "";
    $year = isset($_POST["year"]) ? $_POST["year"] : "";
    $email = isset($_POST["email"]) ? $_POST["email"] : "";
    $areaCode = isset($_POST["area-code"]) ? $_POST["area-code"] : "";
    $phoneNumber = isset($_POST["phone-number"]) ? $_POST["phone-number"] : "";
    $cupcakeFlavors = isset($_POST["cupcake-flavors"]) ? implode(", ", $_POST["cupcake-flavors"]) : "";
    $cupcakeSize = isset($_POST["cupcake-size"]) ? $_POST["cupcake-size"] : "";
    $quantity = isset($_POST["quantity"]) ? $_POST["quantity"] : "";
    $frostingFlavors = isset($_POST["frosting-flavors"]) ? $_POST["frosting-flavors"] : "";
    $orderNumber = uniqid();

    try {
        // Establish database connection using config.php
        $conn = getConnection();

        if (!$conn) {
            throw new Exception("Connection failed: " . mysqli_connect_error());
        }

        // Insert data into the database
        $sql = "INSERT INTO orders (order_number, first_name, last_name, birth_date, email, area_code, phone_number, cupcake_flavor, cupcake_size, quantity, frosting_flavor)
                VALUES ('$orderNumber', '$firstName', '$lastName', '$year-$month-$day', '$email', '$areaCode', '$phoneNumber', '$cupcakeFlavors', '$cupcakeSize', '$quantity', '$frostingFlavors')";

        if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Order Form</title>
    <style>
        body {
            background-color: pink;
            font-family: Arial, sans-serif;
        }
        .submit-button {
            background-color: yellow;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: fixed;
            bottom: 20px;
            right: 20px;
        }
        .order-number {
            color: #888; /* Light gray color */
        }
    </style>
</head>
<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="return validateForm()">
        <h2>Order Number: <span class="order-number"><?php echo uniqid(); ?></span></h2>
        <label for="full-name">Full Name*</label><br>
        <input type="text" id="full-name" name="full-name" required><br><br>

        <label for="first-name">First Name*</label><br>
        <input type="text" id="first-name" name="first-name"><br><br>

        <label for="last-name">Last Name*</label><br>
        <input type="text" id="last-name" name="last-name"><br><br>

        <label for="birth-date">Birth Date*</label><br>
        <select id="day" name="day">
        </select>
        <select id="month" name="month">
        </select>
        <select id="year" name="year">
        </select><br><br>

        <label for="email">E-mail*</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="phone-number">Mobile/Phone Number*</label><br>
        <input type="text" id="area-code" name="area-code" placeholder="Area Code">
        <input type="text" id="phone-number" name="phone-number" placeholder="Phone Number"><br><br>

        <label for="cupcake-flavors">Cupcakes Flavors (1 doz. minimum)*</label><br>
        <div class="flavor-checkboxes">
            <input type="checkbox" id="red-velvet" name="cupcake-flavors[]" value="Red Velvet ($150.00 TTD)">
            <label for="red-velvet">Red Velvet ($150.00 TTD)</label><br>
            <input type="checkbox" id="vanilla" name="cupcake-flavors[]" value="Vanilla ($100.00 TTD)">
            <label for="vanilla">Vanilla ($100.00 TTD)</label><br>
            <input type="checkbox" id="chocolate" name="cupcake-flavors[]" value="Chocolate ($120.00 TTD)">
            <label for="chocolate">Chocolate ($120.00 TTD)</label><br>
            <input type="checkbox" id="guinness" name="cupcake-flavors[]" value="Guinness ($150.00 TTD)">
            <label for="guinness">Guinness ($150.00 TTD)</label><br>
            <input type="checkbox" id="lemon" name="cupcake-flavors[]" value="Lemon ($100.00 TTD)">
            <label for="lemon">Lemon ($100.00 TTD)</label><br>
        </div>
      
        <br>

        <label for="cupcake-size">Cupcake Size*</label><br>
        <select id="cupcake-size" name="cupcake-size" size="4" required>
            <option value="Regular/Standard (yield - 12 cupcakes)">Regular/Standard (yield - 12 cupcakes)</option>
            <!-- Add other cupcake size options here -->
        </select><br><br>

        <label for="quantity">Quantity*</label><br>
        <input type="number" id="quantity" name="quantity" min="1" required><br><br>

        <label for="frosting-flavors-1">Buttercream Frosting Flavors*</label><br>
        <select id="frosting-flavors-1" name="frosting-flavors-1" required>
            <option value="Chocolate">Chocolate</option>
            <option value="Cream Cheese add $30.00 TTD">Cream Cheese add $30.00 TTD</option>
            <option value="Salted Caramel">Salted Caramel</option>
        </select><br><br>

        <label for="frosting-flavors-2">Buttercream Frosting Flavors*</label><br>
        <select id="frosting-flavors-2" name="frosting-flavors-2" required>
            <option value="Chocolate">Chocolate</option>
            <option value="Cream Cheese add $30.00 TTD">Cream Cheese add $30.00 TTD</option>
            <option value="Salted Caramel">Salted Caramel</option>
            <option value="Guinness">Guinness</option>
            <option value="Almond">Almond</option>
            <option value="Coconut">Coconut</option>
        </select><br><br>

        <!-- Submit button -->
        <input type="submit" value="Submit" class="submit-button">
    </form>

    <script>
        // Function to validate email format
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Function to validate phone number fields (only numeric characters)
        function validatePhoneNumber(areaCode, phoneNumber) {
            const phoneNumberRegex = /^[0-9]+$/;
            return phoneNumberRegex.test(areaCode) && phoneNumberRegex.test(phoneNumber);
        }

        // Function to handle form submission
        function handleSubmit(event) {
            event.preventDefault(); // Prevents the form from being submitted by default

            // Retrieve form input values
            const email = document.getElementById("email").value;
            const areaCode = document.getElementById("area-code").value;
            const phoneNumber = document.getElementById("phone-number").value;

            // Validate email and phone number
            if (!validateEmail(email)) {
                alert("Please enter a valid email address.");
                return;
            }

            if (!validatePhoneNumber(areaCode, phoneNumber)) {
                alert("Please enter a valid phone number.");
                return;
            }

            // If all validations pass, submit the form
            event.target.submit();
        }

        // Add event listener for form submission
        document.addEventListener("DOMContentLoaded", function() {
            const form = document.querySelector("form");
            form.addEventListener("submit", handleSubmit);
        });
    </script>

    <script>
        // Function to populate day, month, and year dropdowns for the birth date
        function populateBirthDate() {
            // Get day, month, and year select elements
            var daySelect = document.getElementById("day");
            var monthSelect = document.getElementById("month");
            var yearSelect = document.getElementById("year");

            // Populate days (1 to 31)
            for (var i = 1; i <= 31; i++) {
                var option = document.createElement("option");
                option.text = i;
                daySelect.add(option);
            }

            // Populate months (January to December)
            var months = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];
            for (var i = 0; i < months.length; i++) {
                var option = document.createElement("option");
                option.text = months[i];
                monthSelect.add(option);
            }

            // Populate years (current year to 100 years back)
            var currentYear = new Date().getFullYear();
            for (var i = currentYear; i >= currentYear - 100; i--) {
                var option = document.createElement("option");
                option.text = i;
                yearSelect.add(option);
            }
        }

        // Function to validate the form fields
        function validateForm() {
            var fullName = document.getElementById("full-name").value;
            var email = document.getElementById("email").value;

            // Validate full name and email (Add additional validation as needed)
            if (fullName === "" || email === "") {
                alert("Full Name and Email are required fields");
                return false;
            }

            return true; // Form validated successfully
        }

        // Call the populateBirthDate function when the page loads
        window.onload = function() {
            populateBirthDate();
        };
    </script>
</body>
</html>
