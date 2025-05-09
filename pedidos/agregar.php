<?php
require_once '../db.php';


$stmt = $pdo->query("SELECT * FROM tbl_productos WHERE stock_producto > 0");
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Agregar Pedido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .total-pedido {
            font-size: 1.5rem;
            font-weight: bold;
            text-align: right;
        }
    </style>
</head>

<body class="bg-light">
    <?php include '../../tienda_virtual_crud/navbar.php'; ?>
    <div class="container mt-5">
        <h2 class="fw-bold mb-4">Agregar Pedido</h2>
        <form method="post" action="procesar_pedido.php" id="formPedido">
            <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad</label>
                <input type="text" class="form-control" name="ciudad" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" name="direccion" required>
            </div>
            <div class="mb-3">
                <label for="zip" class="form-label">Código Postal</label>
                <input type="text" class="form-control" name="zip" required>
            </div>

            <h5 class="fw-bold mt-4">Seleccionar Productos</h5>
            <div id="productosContainer"></div>
            <button type="button" class="btn btn-outline-secondary my-3" onclick="agregarProducto()">+ Agregar otro
                producto</button>

            <p class="text-end total-pedido">Total del pedido: <span id="total">$0.00</span></p>

            <div class="d-flex justify-content-end">
                <a href="listar.php" class="btn btn-outline-secondary me-2">Cancelar</a>
                <button type="submit" class="btn btn-dark">Agregar Pedido</button>
            </div>
        </form>
    </div>

    <script>
        const productos = <?= json_encode($productos) ?>;
        let contador = 0;

        function agregarProducto() {
            const cont = document.getElementById("productosContainer");

            const row = document.createElement("div");
            row.classList.add("row", "mb-2", "align-items-end");
            row.dataset.index = contador;

            let select = `<select name="productos[${contador}][id_producto]" class="form-select producto-select" required onchange="actualizarPrecio(this)">`;
            select += `<option value="">Seleccione producto</option>`;
            productos.forEach(p => {
                select += `<option value="${p.id_producto}" data-precio="${p.precio_producto}" data-stock="${p.stock_producto}">
            ${p.nombre_producto} - $${parseInt(p.precio_producto).toLocaleString()} (Stock: ${p.stock_producto})
        </option>`;
            });
            select += `</select>`;

            row.innerHTML = `
        <div class="col-md-4">${select}</div>
        <div class="col-md-2">
            <input type="number" name="productos[${contador}][cantidad]" class="form-control cantidad" min="1" value="1" oninput="actualizarSubtotal(this)">
        </div>
        <div class="col-md-2">
            <input type="text" class="form-control precio" disabled>
        </div>
        <div class="col-md-2">
            <input type="text" name="productos[${contador}][subtotal]" class="form-control subtotal" readonly>
        </div>
        <div class="col-md-2">
            <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.row').remove(); actualizarTotal();">
                <i class="bi bi-trash"></i> Eliminar
            </button>
        </div>
    `;
            cont.appendChild(row);
            contador++;
        }

        function actualizarPrecio(select) {
            const precio = parseFloat(select.selectedOptions[0].dataset.precio);
            const stock = parseInt(select.selectedOptions[0].dataset.stock);
            const row = select.closest(".row");
            row.querySelector(".precio").value = `$${precio.toLocaleString()}`;
            const cantidadInput = row.querySelector(".cantidad");
            cantidadInput.max = stock;
            if (parseInt(cantidadInput.value) > stock) {
                cantidadInput.value = stock;
            }
            actualizarSubtotal(cantidadInput);
        }

        function actualizarSubtotal(input) {
            const row = input.closest(".row");
            const select = row.querySelector(".producto-select");
            const precio = parseFloat(select.selectedOptions[0].dataset.precio);
            const cantidad = parseInt(input.value);
            const subtotal = precio * cantidad;
            row.querySelector(".subtotal").value = subtotal.toFixed(2);
            actualizarTotal();
        }

        function actualizarTotal() {
            const subtotales = document.querySelectorAll(".subtotal");
            let total = 0;
            subtotales.forEach(s => total += parseFloat(s.value || 0));
            document.getElementById("total").innerText = `$${total.toLocaleString()}`;
        }

        document.addEventListener("DOMContentLoaded", agregarProducto);
    </script>
</body>

</html>