<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JoseGasam</title>

    <script src="https://www.paypal.com/sdk/js?client-id=AfgcIvbyFA77gpncLxTquAj7HfaWviLr7EFuJfg34EyDEE4ZYfvCXbGttB5LxEsgDL9m8jlhFLa9qfkH&currency=USD"></script>

    
</head>
<body>
    <div id="paypal-button-container"></div>

    <script>
        paypal.Buttons({
            style: {
                layout: 'vertical',
                color:  'blue',
                shape:  'pill',
                label:  'paypal'
            },
            createOrder: function(data, actions){
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: 100
                        }
                    }]
                });
            },

            onApprove:function(data, actions){
                actions.order.capture().then(function(detalles){
                    window.location.href="completado.html"
                });

            },

            onCancel:function(data){
                alert("Pago cancelado")
                console.log(data);
            }

        }).render('#paypal-button-container');
    </script>
</body>
</html>