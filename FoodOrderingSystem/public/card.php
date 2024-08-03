<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-euiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Card</title>
        <link rel="stylesheet" href="css/card.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
    <body>
        
        <div class="table">
            <div class="table_header">
                <p>Card Details</p>
                <div>
                    <input placeholder="Food"/>
                    <button class="search">Search</button>
                </div>
            </div>

            <div class="table_section">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Food</th>
                            <th>Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1.</td>
                            <td><img src="image/lasagna.webp"> </td>
                            <td>Lagsana</td>
                            <td>
                                <input type="number" id="quantity" name="quantity" min="1" max="10">
                            </td>
                            <td>Rm10</td>
                            <td>
                                <button><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td><img src="image/paste.jpg"> </td>
                            <td>Paste</td>
                            <td>
                                <input type="number" id="quantity" name="quantity" min="1" max="10">
                            </td>
                            <td>Rm10</td>
                            <td>
                                <button><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td><img src="image/salmonsteak.jpg"> </td>
                            <td>Salmon Steak</td>
                            <td>
                                <input type="number" id="quantity" name="quantity" min="1" max="10">
                            </td>
                            <td>Rm10</td>
                            <td>
                                <button><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                        <tr>
                            <td>4.</td>
                            <td><img src="image/sandwich.jpg"> </td>
                            <td>Sandwhich</td>
                            <td>
                                <input type="number" id="quantity" name="quantity" min="1" max="10">
                            </td>
                            <td>Rm10</td>
                            <td>
                                <button><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


               <div>
                <a href="#" class="checkout">Check Out</a>
               </div>
        </div>
    </body>
</html>