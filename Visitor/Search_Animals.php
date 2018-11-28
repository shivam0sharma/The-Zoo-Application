<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Search_Animals.css">
    <title>Search for Animals</title>
</head>
<body>
    <header>
        <h1>
            Zoo Atlanta Animals
        </h1>
    </header>
    <br>

    <form method="POST" id="search_params">
        Name: <input type="text" name="name" class="text">
        &emsp;&emsp;&emsp;Age: &ensp;Min
        <input type="number" min="0" name="min_animal_num" class="age_num">
        &ensp;Max 
        <input type="number" min="0" name="max_animal_num" class="age_num">
        <br>
        <br>
        Species:
        <input type="text" name="species" class="text">
        &emsp;&ensp;Type:
        <select name="select_type" id="type">
            <option value="fish">Fish</option>
        </select>
        &emsp;Exhibit:
        <select name="select_exhibit" id="exhibit">
            <option value="pacific">Pacific</option>
        </select>
        <br>
        <br>
        <input type="submit" name="search" value="Search">

    </form>
    <br>
    <br>
    <div>
        <table>
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Species</th>
                    <th scope="col">Exhibit</th>
                    <th scope="col">Age</th>
                    <th scope="col">Type</th>
                </tr>
            </thead>

        </table>
    
    </div>
</body>



</html>