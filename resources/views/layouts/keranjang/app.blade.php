<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title></title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="lp/assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="lp/css/styles.css" rel="stylesheet" />
    @yield('css')
</head>
<body>
   
    @yield('content')

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="lp/js/scripts.js"></script>
    <!-- Custom JS untuk menangani keranjang -->
    <script>
    let cart = [];

    function addToCart() {
        const name = document.getElementById('product-name').innerText;
        const price = parseFloat(document.getElementById('product-price').innerText.replace('Rp. ', ''));
        const quantity = parseInt(document.getElementById('product-quantity').value);

        const item = {
            name,
            price,
            quantity,
            total: price * quantity
        };

        cart.push(item);
        updateCartUI();
        document.getElementById('productModal').querySelector('.btn-close').click();
    }

    function updateCartUI() {
        const cartItemsContainer = document.getElementById('cart-items');
        cartItemsContainer.innerHTML = '';

        cart.forEach((item, index) => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td><input type="checkbox"></td>
                <td>${item.name}</td>
                <td>Rp ${item.price.toFixed(2)}</td>
                <td>
                    <input type="number" class="form-control" value="${item.quantity}" min="1" onchange="updateQuantity(${index}, this.value)">
                </td>
                <td>Rp ${item.total.toFixed(2)}</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="removeFromCart(${index})">Hapus</button>
                </td>
            `;

            cartItemsContainer.appendChild(row);
        });
    }

    function updateQuantity(index, newQuantity) {
        cart[index].quantity = parseInt(newQuantity);
        cart[index].total = cart[index].price * cart[index].quantity;
        updateCartUI();
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        updateCartUI();
    }
    </script>
</body>
</html>
