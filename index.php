<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cars Table</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    
    <section>
        <!--for demo wrap-->
        <h1>Cars Table</h1>
        
      <div class="listForm">
      <form id="sortPriceForm" class="sortForm">
            <label for="sortPrice">Sort by Price:</label>
            <select name="sortPrice" id="sortPrice">
                <option value="asc">Low to High</option>
                <option value="desc">High to Low</option>
            </select>
            <button type="submit">Sort</button>
        </form>

        <form id="sortColorForm" class="sortForm">
            <label for="sortColor">Sort by Color:</label>
            <select name="sortColor" id="sortColor">
                <option value="asc">A to Z</option>
                <option value="desc">Z to A</option>
            </select>
            <button type="submit">Sort</button>
        </form>
      </div>
        <div class="tbl-header">
            <table cellpadding="0" cellspacing="0" id="carsTable">
                <thead>
                    <tr>
                        <th>Car Name</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Hand</th>
                        <th>Availability</th>
                        <th>Color</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="tbl-content">
            <table cellpadding="0" cellspacing="0" border="0">
                <tbody id="carsTableBody">
                 
                </tbody>
            </table>
        </div>
    </section>
    <?php
    include 'sort.php';

    // Load cars data
    $carsData = json_decode(file_get_contents('cars.json'), true);
    ?>

    <script>
        // Sort cars by price
        function sortCarsByPrice(cars, order) {
            return cars.sort((a, b) => {
                return order === 'asc' ? a.price - b.price : b.price - a.price;
            });
        }

        // Function to sort cars by color
        function sortCarsByColor(cars, order) {
            return cars.sort((a, b) => {
                const colorA = a.color.toLowerCase();
                const colorB = b.color.toLowerCase();
                if (order === 'asc') {
                    return colorA.localeCompare(colorB);
                } else {
                    return colorB.localeCompare(colorA);
                }
            });
        }

        // Function to render cars data in the table
        function renderCarsTable(cars) {
            const tableBody = document.getElementById('carsTableBody');
            tableBody.innerHTML = '';
            cars.forEach(car => {
                const row = document.createElement('tr');
                row.innerHTML = `
                <td>${car.car_name}</td>
                <td>${car.price}</td>
                <td>${car.discount || 'N/A'}</td>
                <td>${car.hand}</td>
                <td>${car.availability}</td>
                <td>${car.color}</td>
            `;
                tableBody.appendChild(row);
            });
        }

        // Form submission for sorting by price
        document.getElementById('sortPriceForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const sortOrder = document.getElementById('sortPrice').value;
            const sortedCars = sortCarsByPrice(<?php echo json_encode($carsData); ?>, sortOrder);
            renderCarsTable(sortedCars);
        });

        // Form submission for sorting by color
        document.getElementById('sortColorForm').addEventListener('submit', function (event) {
            event.preventDefault();
            const sortOrder = document.getElementById('sortColor').value;
            const sortedCars = sortCarsByColor(<?php echo json_encode($carsData); ?>, sortOrder);
            renderCarsTable(sortedCars);
        });

        // Initial rendering of cars table
        renderCarsTable(<?php echo json_encode($carsData); ?>);
    </script>

</body>

</html>