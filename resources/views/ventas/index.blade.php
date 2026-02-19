@extends('layouts.app')


@section('title', 'Ventas - Cafetería KFE')

@section('content')
    @push('styles')
        <style>
            .product-card {
                cursor: pointer;
                transition: all 0.2s;
                border: 2px solid transparent;
            }

            .product-card:hover {
                border-color: var(--kfe-naranja);
                transform: translateY(-3px);
                box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
            }

            .product-card .price-tag {
                background: var(--kfe-naranja);
                color: white;
                padding: 2px 10px;
                border-radius: 20px;
                font-weight: 700;
                font-size: 0.95rem;
            }

            .cart-section {
                background: white;
                border-radius: 12px;
                box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
                top: 80px;
            }

            .cart-header {
                background: linear-gradient(135deg, var(--kfe-cafe), var(--kfe-cafe-claro));
                color: white;
                border-radius: 12px 12px 0 0;
                padding: 1rem 1.5rem;
            }

            .cart-item {
                border-bottom: 1px solid #f0f0f0;
                padding: 0.75rem 1.5rem;
                transition: background 0.2s;
            }

            .cart-item:hover {
                background-color: #fafafa;
            }

            .cart-total {
                background: var(--kfe-crema);
                padding: 1rem 1.5rem;
                font-size: 1.3rem;
                font-weight: 700;
                color: var(--kfe-cafe);
            }

            .cart-empty {
                padding: 2rem;
                text-align: center;
                color: #aaa;

            }


            .qty-btn {
                width: 28px;
                height: 28px;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                font-size: 0.85rem;
            }

            .filter-btn.active {
                background-color: var(--kfe-cafe) !important;
                color: white !important;
                border-color: var(--kfe-cafe) !important;
            }

            .product-grid {
                max-height: 70vh;
                overflow-y: auto;
            }

            .stock-badge {
                font-size: 0.75rem;
            }
        </style>
    @endpush

    <div class="row">
        <div class="col-lg-7 col-xl-8">
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h2 class="mb-0"><i class="bi bi-cart text-muted"></i> Punto de Venta</h2>
                        <small class="text-muted">Selecciona productos para agregar a la venta</small>
                    </div>
                </div>


                <div class="d-flex flex-wrap gap-2">
                    <button class="btn btn-sm btn-outline-dark filter-btn active" data-categoria="all">
                        <i class="bi bi-grid"></i> Todos
                    </button>
                    @foreach ($categorias as $categoria)
                        <button class="btn btn-sm btn-outline-dark filter-btn" data-categoria="{{ $categoria->id }}">
                            {{ $categoria->nombre }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="mb-3">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="searchProduct" placeholder="Buscar producto...">
                </div>
            </div>


            <div class="product-grid">
                <div class="row g-3" id="productGrid">
                    @foreach ($productos as $producto)
                        <div class="col-6 col-md-4 col-xl-3 product-item" data-categoria="{{ $producto->categoria_id }}"
                            data-nombre="{{ strtolower($producto->nombre) }}">
                            <div class="card product-card h-100 text-center p-3"
                                onclick="addToCart({{ $producto->id }}, '{{ addslashes($producto->nombre) }}', {{ $producto->precio }}, {{ $producto->cantidad }})">
                                @if ($producto->imagen)
                                    <img src="{{ asset('storage/' . $producto->imagen) }}" alt="{{ $producto->nombre }}"
                                        class="rounded mx-auto" style="width:70px;height:70px;object-fit:cover;">
                                @else
                                    <div class="mx-auto bg-light rounded d-flex align-items-center justify-content-center"
                                        style="width:70px;height:70px;">
                                        <i class="bi bi-cup-hot" style="font-size:1.8rem;color:var(--kfe-cafe);"></i>
                                    </div>
                                @endif
                                <div class="mt-2">
                                    <h6 class="mb-1" style="font-size:0.85rem;">{{ $producto->nombre }}</h6>
                                    <span class="price-tag">${{ number_format($producto->precio, 2) }}</span>
                                    <div class="mt-1">
                                        <span
                                            class="badge stock-badge {{ $producto->cantidad <= 5 ? 'bg-danger' : 'bg-success' }}">
                                            Cantidad: {{ $producto->cantidad }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


        <div class="col-lg-5 col-xl-4">
            <div class="cart-section">
                <div class="cart-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-receipt"></i> Ticket de Venta</h5>
                    <button class="btn btn-sm btn-outline-light" onclick="clearCart()" title="Vaciar carrito">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>



                <div class="p-3 border-bottom">

                    <input type="text" class="form-control form-control-sm" id="customerName"
                        placeholder="Nombre del cliente (opcional)">
                </div>


                <div id="cartItems" style="max-height: 40vh; overflow-y: auto;">
                    <div class="cart-empty" id="cartEmpty">
                        <i class="bi bi-cart-x" style="font-size:2.5rem;"></i>
                        <p class="mt-2 mb-0">Carrito vacío</p>
                        <small>Selecciona productos para agregar</small>
                    </div>
                </div>


                <div class="cart-total d-flex justify-content-between align-items-center">
                    <span>TOTAL:</span>
                    <span id="cartTotal">$0.00</span>
                </div>


                <div class="p-3">
                    <button class="btn btn-naranja w-100 py-2" id="btnCheckout" onclick="checkout()" disabled>
                        <i class="bi bi-cash-coin"></i> Cobrar Venta
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="saleSuccessModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-check-circle-fill text-success" style="font-size:4rem;"></i>
                    </div>
                    <h3 class="text-success">Venta Registrada</h3>
                    <p class="text-muted" id="saleMessage"></p>
                    <h2 class="fw-bold" id="saleTotal" style="color:var(--kfe-cafe);"></h2>
                    <div class="mt-4 d-flex gap-2 justify-content-center">
                        <a href="#" id="btnReceipt" class="btn btn-kfe" target="_blank">
                            <i class="bi bi-printer"></i> Ver Ticket
                        </a>
                        <button class="btn btn-naranja" onclick="newSale()">
                            <i class="bi bi-plus-circle"></i> Nueva Venta
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            let cart = {};

            function addToCart(id, name, price, maxStock) {
                if (cart[id]) {
                    if (cart[id].quantity >= maxStock) {
                        alert('Cantidad insuficiente para ' + name);
                        return;
                    }
                    cart[id].quantity++;
                } else {
                    cart[id] = {
                        id: id,
                        name: name,
                        price: price,
                        quantity: 1,
                        maxStock: maxStock
                    };
                }
                renderCart();
            }

            function removeFromCart(id) {
                delete cart[id];
                renderCart();
            }

            function updateQuantity(id, delta) {
                if (!cart[id]) return;
                cart[id].quantity += delta;
                if (cart[id].quantity <= 0) {
                    delete cart[id];
                } else if (cart[id].quantity > cart[id].maxStock) {
                    cart[id].quantity = cart[id].maxStock;
                    alert('Cantidad máxima alcanzada');
                }
                renderCart();
            }

            function clearCart() {
                cart = {};
                renderCart();
            }

            function renderCart() {
                const container = document.getElementById('cartItems');
                const totalEl = document.getElementById('cartTotal');
                const btnCheckout = document.getElementById('btnCheckout');
                const items = Object.values(cart);

                if (items.length === 0) {
                    container.innerHTML = `<div class="cart-empty" id="cartEmpty">
                <i class="bi bi-cart-x" style="font-size:2.5rem;"></i>
                <p class="mt-2 mb-0">Carrito vacío</p>
                <small>Selecciona productos para agregar</small>
            </div>`;
                    totalEl.textContent = '$0.00';
                    btnCheckout.disabled = true;
                    return;
                }

                let html = '';
                let total = 0;

                items.forEach(item => {
                    const subtotal = item.price * item.quantity;
                    total += subtotal;
                    html += `
                <div class="cart-item d-flex justify-content-between align-items-center">
                    <div class="flex-grow-1">
                        <div class="fw-bold" style="font-size:0.9rem;">${item.name}</div>
                        <small class="text-muted">$${item.price.toFixed(2)} c/u</small>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button class="btn btn-outline-secondary qty-btn" onclick="updateQuantity(${item.id}, -1)">
                            <i class="bi bi-dash"></i>
                        </button>
                        <span class="fw-bold" style="min-width:25px;text-align:center;">${item.quantity}</span>
                        <button class="btn btn-outline-secondary qty-btn" onclick="updateQuantity(${item.id}, 1)">
                            <i class="bi bi-plus"></i>
                        </button>
                    </div>
                    <div class="ms-3 text-end" style="min-width:70px;">
                        <div class="fw-bold">$${subtotal.toFixed(2)}</div>
                        <button class="btn btn-sm text-danger p-0" onclick="removeFromCart(${item.id})" style="font-size:0.75rem;">
                            <i class="bi bi-x-circle"></i>
                        </button>
                    </div>
                </div>
            `;
                });

                container.innerHTML = html;
                totalEl.textContent = '$' + total.toFixed(2);
                btnCheckout.disabled = false;
            }

            function checkout() {
                const items = Object.values(cart);
                if (items.length === 0) return;

                const btnCheckout = document.getElementById('btnCheckout');
                btnCheckout.disabled = true;
                btnCheckout.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Procesando...';

                const data = {
                    nombre_cliente: document.getElementById('customerName').value,
                    detalles: items.map(item => ({
                        producto_id: item.id,
                        cantidad: item.quantity
                    }))
                };

                fetch('{{ route('ventas.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(data)
                    })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            document.getElementById('saleMessage').textContent = result.message;
                            document.getElementById('saleTotal').textContent = '$' + parseFloat(result.venta.total).toFixed(
                                2);
                            document.getElementById('btnReceipt').href = '/ventas/' + result.venta.id + '/recibo/';

                            const modal = new bootstrap.Modal(document.getElementById('saleSuccessModal'));
                            modal.show();

                            clearCart();
                            document.getElementById('customerName').value = '';
                        } else {
                            alert(result.message || 'Error al procesar la venta');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error al procesar la venta');
                    })
                    .finally(() => {
                        btnCheckout.disabled = false;
                        btnCheckout.innerHTML = '<i class="bi bi-cash-coin"></i> Cobrar Venta';
                    });
            }

            function newSale() {
                const modal = bootstrap.Modal.getInstance(document.getElementById('saleSuccessModal'));
                if (modal) modal.hide();
                location.reload();
            }



            document.querySelectorAll('.filter-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const category = this.dataset.categoria;
                    document.querySelectorAll('.product-item').forEach(item => {
                        if (category === 'all' || item.dataset.categoria === category) {
                            item.style.display = '';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });



            document.getElementById('searchProduct').addEventListener('input', function() {
                const search = this.value.toLowerCase();
                document.querySelectorAll('.product-item').forEach(item => {
                    if (item.dataset.nombre.includes(search)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });


                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                document.querySelector('.filter-btn[data-categoria="all"]').classList.add('active');
            });
        </script>
    @endpush
@endsection
