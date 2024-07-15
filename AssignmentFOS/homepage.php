<!DOCTYPE html>

<style>
body{
    width: 100%;
    position: absolute;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.image-slider{
    width: 84%;
    height: 700px;
    margin-top: 10px;
}

.slide img{
    margin: auto;
    padding: 50px;
    width: 90%;
    position: relative;
}

.slide{
    display: block;
}

.description{
    padding: 50px;
    margin: auto;
    height: auto;
}

.product-category{
    width: 500px;
    display: flex;
    flex-flow: column;
    justify-content: space-around;
    align-items: center;
    padding: 20px;
    margin: auto;

}

.product-category .card{
    position: relative;
    display: flex;
    flex-direction: row;
    padding: 10px;
    margin: auto;
}

.product-category .card .interfece{
    width: 300px;
    height: 200px;
    transition:.4s;
    border-radius: 30px 30px;
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.7);
}

.product-category .card .interfece.interface-1{
    position: relative;
    background: whitesmoke;
    display: flex;
    justify-content: center;
    align-content: left;
    align-items: center;
    z-index: 1;
    transform: translateX(-300px);
}

.product-category .card .interfece.interface-1 .content{
    opacity: .2;
    transition: 0.5s;
    justify-content: center;
}

.product-category .card:hover .interfece.interface-1 .content {
    opacity: 1;
}

.product-category .card:hover .interfece.interface-1{
    border-radius: 30px 0px 0px 30px;
    box-shadow: 0px 0px 0px rgba(0, 0, 0, 0.7);
}

.content img{
    width: 75%;
    position: relative;
    display: block;
    margin-left: auto;
    margin-right: auto;
    border-radius: 30px 30px 0px 0px;
}

h2{
    text-align: center;
    font-size: 2em;
    font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.product-category .card .interfece.interface-2{
    position: relative;
    background: whitesmoke;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
    display: flex;
    transform: translateX(-600px);
}

.product-category .card:hover .interfece.interface-2{
    transform: translateX(-300px);
    border-radius: 0px 30px 30px 0px;
    box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.7);
    width: 800px;
}

.row h1, h2, h3 {
    color: #333;
}

.row h3 {
    margin: 0px;
}

.row {
    margin: auto;
    padding: 35px;
    position: relative;
    height: auto;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th, td {
    text-align: center;
    padding: 8px;
    border-bottom: 2px solid #ddd;
}

button.btn{
    width: 200px;
    height: 50px;
    margin: auto;
    padding: 10px;
    border: none;
    box-shadow: 2px 2px  rgba(0, 0, 0, 0.3);
}

.btn.b1{
    background-color: aqua;
}

.btn.b2{
    background-color: #FFBB40;
}

footer {
    width: 99%;
    height: 100px;
    background-color: #FFBB40;
    color: #fff;
    padding: 10px;
    text-align: center;
    margin-top: 20px;
    position: relative;
}
</style>

<?php include "default-nav.php"; ?>

<html>
    <title>Home</title>

    <body>

        <div class="image-slider">
            <div class="slide">
            <img src="images/Ragdoll-Cat.jpg" alt="">
            </div>
        </div>

        <div class="product-category">
                <div class="card">
                    <div class="interfece interface-1">
                        <div class="content">
                            <img src="category1.jpg" ID="men-shoe" />
                        </div>
                    </div>
                    <div class="interfece interface-2">
                        <div class="content">
                            <h3>Men Shoes</h3>
                        </div>
                    </div>
                    
                </div>

                <div class="card">
                    <div class="interfece interface-1">
                        <div class="content">
                            <img src="category1.jpg" ID="men-shoe" />
                        </div>
                    </div>
                    <div class="interfece interface-2">
                        <div class="content">
                            <h3>Men Shoes</h3>
                        </div>
                    </div>
                    
                </div>
        </div>

        <div class="description">
            <h3>Table Design</h3>

            <div class="row">
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        
                    </tr>
                </thead>
                
                <tbody>
        <tr>
            <td>
                <img src="images/ourM2.jpg" alt="" style="width: 30%;" />
            </td>
            <td>
                <h3>Sample</h3>
            </td>
            <td>
                <h3>Sample</h3>
            </td>
            <td>

            </td>
            <td>
                
            <td>

            </td>
        </tr>

        <tr>
            <td>
                <img src="images/ourM2.jpg" alt="" style="width: 30%;" />
            </td>
            <td>
                <h3>Sample</h3>
            </td>
            <td>
                <h3>Sample</h3>
            </td>
            <td>

            </td>
            <td>
                
            <td>

            </td>
        </tr>


                </tbody>
            </table>
            </div>

            <button type="button" class="btn b1" >Button 1</button>
            <button type="button" class="btn b2">Button 2</button>

        </div>

        <footer>
            <h2>&copy; 2024 Food Ordering System</h2>
        </footer>
    </body>
</html>