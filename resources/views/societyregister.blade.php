<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Society Registration Form</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }

        .card.dark-mode {
            background-color: #1e1e1e;
            color: #ffffff;
        }

        .form-control.dark-mode {
            background-color: #333333;
            color: #ffffff;
        }

        .btn.dark-mode {
            background-color: #444444;
            color: #ffffff;
        }
    </style>
</head>

<body>
    <div class="container mt-5 ">
        <div class="fixed-top text-right p-3">
            <i id="toggle-dark-mode" class="fas fa-moon" style="cursor: pointer; font-size: 1.5rem;"></i>
        </div>
        <h1 class="text-center">Society Registration Form</h1>
        <form id="society-form" action="{{ route('society.register') }}" method="POST" class="mt-4"
            enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="society_name">Society Name</label>
                <input type="text" id="society_name" name="society_name" class="form-control"
                    placeholder="Enter Society Name" required>
            </div>
            <div class="form-group">
                <label for="society_address">Society Address</label>
                <input type="text" id="society_address" name="society_address" class="form-control"
                    placeholder="Enter Society Address" required>
            </div>
            <div class="form-group">
                <label for="society_city">Society City</label>
                <input type="text" id="society_city" name="society_city" class="form-control"
                    placeholder="Enter Society City" required>
            </div>
            <div class="form-group">
                <label for="society_state">Society State</label>
                <input type="text" id="society_state" name="society_state" class="form-control"
                    placeholder="Enter Society State" required>
            </div>
            <div class="form-group">
                <label for="society_country">Society Country</label>
                <input type="text" id="society_country" name="society_country" class="form-control"
                    placeholder="Enter Society Country" required>
            </div>
            <div class="form-group">
                <label for="society_pincode">Society Pincode</label>
                <input type="text" id="society_pincode" name="society_pincode" class="form-control"
                    placeholder="Enter Society Pincode" required>
            </div>
            <div class="form-group">
                <label for="total_blocks">Total Blocks</label>
                <input type="number" id="total_blocks" name="total_blocks" class="form-control d-inline-block w-75"
                    placeholder="Enter Total Blocks" required>
                <button type="button" id="add_blocks" class="btn btn-primary d-inline-block w-20">Add Blocks</button>
            </div>
            <div id="blocks_container"></div>

            <!-- User Fields -->
            <h2 class="mt-5">Chairman Details</h2>
            <div class="form-group">
                <label for="block_number">Block Number</label>
                <input type="text" id="block_number" name="block_number" class="form-control"
                    placeholder="Enter Block Number" required>
            </div>
            <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" class="form-control"
                    placeholder="Enter First Name" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" class="form-control" placeholder="Enter Last Name"
                    required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile</label>
                <input type="text" id="mobile" name="mobile" class="form-control"
                    placeholder="Enter Mobile Number" required>
            </div>
            <div class="form-group">
                <label for="block">Block</label>
                <input type="text" id="block" name="block" class="form-control" placeholder="Enter Block"
                    required>
            </div>
            <div class="form-group">
                <label for="profile_photo">Profile Photo</label>
                <input type="file" id="profile_photo" name="profile_photo" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email"
                    required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control"
                    placeholder="Enter Password" required>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Register</button>
        </form>
    </div>

    <script>
        document.getElementById('toggle-dark-mode').addEventListener('click', function() {
            document.body.classList.toggle('dark-mode');
            document.querySelectorAll('.form-control').forEach(function(input) {
                input.classList.toggle('dark-mode');
            });
            document.querySelectorAll('.btn').forEach(function(button) {
                button.classList.toggle('dark-mode');
            });
        });

        document.getElementById('add_blocks').addEventListener('click', function() {
            const totalBlocks = parseInt(document.getElementById('total_blocks').value);
            const container = document.getElementById('blocks_container');
            container.innerHTML = '';

            for (let i = 0; i < totalBlocks; i++) {
                const blockDiv = document.createElement('div');
                blockDiv.classList.add('mt-4');
                blockDiv.innerHTML = `
                    <h3>Block ${i + 1}</h3>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Block Title</th>
                                <th>Total Houses</th>
                                <th>Houses</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="blocks[${i}][block_title]" class="form-control" placeholder="Block Title" oninput="this.value = this.value.toUpperCase();" required></td>
                                <td>
                                    <input type="number" class="form-control total_units d-inline-block w-75" data-block-index="${i}" placeholder="Total Houses" required>
                                    <button type="button" class="btn btn-primary add_units d-inline-block w-25" data-block-index="${i}">Add Houses</button>
                                </td>
                                <td><div id="units_container_${i}"></div></td>
                            </tr>
                        </tbody>
                    </table>
                `;
                container.appendChild(blockDiv);
            }

            document.querySelectorAll('.add_units').forEach(function(button) {
                button.addEventListener('click', function() {
                    const blockIndex = this.getAttribute('data-block-index');
                    const totalUnits = parseInt(document.querySelector(
                        `.total_units[data-block-index="${blockIndex}"]`).value);
                    const unitsContainer = document.getElementById(`units_container_${blockIndex}`);
                    unitsContainer.innerHTML = '';

                    for (let j = 0; j < totalUnits; j++) {
                        const unitDiv = document.createElement('div');
                        unitDiv.classList.add('form-group');
                        unitDiv.innerHTML = `
                            <input type="text" name="blocks[${blockIndex}][units][${j}][unit_title]" class="form-control mb-2" placeholder="House No" required>
                            <input type="number" name="blocks[${blockIndex}][units][${j}][floor_no]" class="form-control mb-2" placeholder="Floor No" required>
                        `;
                        unitsContainer.appendChild(unitDiv);
                    }
                });
            });
        });

        document.getElementById('society-form').addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });
    </script>
</body>

</html>
