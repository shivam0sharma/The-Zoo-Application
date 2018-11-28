<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="Search_Exhibits.css">
    <title>Search for Exhibits</title>
</head>
<body>
    <header>
        <h1>
            Zoo Atlanta Exhibits
        </h1>
    </header>
    <br>

    <form method="POST" id="search_params">
        Name: <input type="text" name="name">
        &emsp;&emsp;&emsp;Number of Animals: &ensp;Min
        <input type="number" min="0" name="min_animal_num" class="animal_num">
        &ensp;Max 
        <input type="number" min="0" name="max_animal_num" class="animal_num">
        <br>
        <br>
        Exhibit Size: &ensp;Min
        <input type="number" min="0" step="10" name="min_exhibit_num" class="exhibit_num">
        &ensp;Max
        <input type="number" min="0" step="10" name="max_exhibit_num" class="exhibit_num">
        &emsp;&emsp;&emsp;&emsp;&emsp;&emsp;Water Feature:
        <input type="checkbox" name="wfeat_checkbox">
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
                    <th scope="col">Size</th>
                    <th scope="col">NumAnimals</th>
                    <th scope="col">Water</th>
                </tr>
            </thead>

        </table>
    
    </div>
</body>
</html>