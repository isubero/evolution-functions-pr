window.addEventListener('evolution_add_to_cart_clicked', event => {
    let value = parseFloat( document.getElementById('product_price').value );

    console.log("Sending AddToCart event to Facebook", {
        currency: "USD",
        value: value,
    });

    fbq('track', 'AddToCart', {currency: "USD", value: value});
});